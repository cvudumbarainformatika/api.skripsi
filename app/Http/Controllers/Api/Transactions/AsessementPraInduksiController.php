<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\AsessementPraInduksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AsessementPraInduksiController extends Controller
{
    /**
     * Store
     */
    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $this->validateRequest($request);

            $data = AsessementPraInduksi::updateOrCreate(['noreg' => $validated['noreg']], $validated);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil disimpan',
                'data'    => $data
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update ga digawe
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $validated = $this->validateRequest($request);

            $data = AsessementPraInduksi::findOrFail($id);
            $data->update($validated);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diperbarui',
                'data'    => $data
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Delete
     */
    public function hapus($id)
    {
        DB::beginTransaction();

        try {
            $data = AsessementPraInduksi::findOrFail($id);
            $data->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     * Validasi Request
     */
    private function validateRequest(Request $request)
    {
        return $request->validate(
            [
                'noreg' => 'required|string|max:50',
                'tanggal' => 'nullable|date',

                'kesadaran' => 'nullable|string',
                'td' => 'nullable|string',
                'n' => 'nullable|string',
                'rr' => 'nullable|string',
                'suhu' => 'nullable|string',
                'saturasi' => 'nullable|string',

                'ekg' => 'nullable|string',
                'iv_line' => 'nullable|string',
                'infus_darah' => 'nullable|string',
                'jenis_infus_darah' => 'nullable|string',
                'mesin_anastesi' => 'nullable|string',

                'ga' => 'nullable|string',
                'ga_array' => 'nullable|array',

                'ra' => 'nullable|string',
                'ra_array' => 'nullable|array',

                'obat_anastesi' => 'nullable|string',
                'obat_anastesi_array' => 'nullable|array',

                'obat_emergensi' => 'nullable|string',
                'obat_emergensi_array' => 'nullable|array',

                'penyakit' => 'nullable|string',
                'nama_penyakit' => 'nullable|string',
                'alergi' => 'nullable|string',
                'nama_alergi' => 'nullable|string',

                'lensa_kontak' => 'nullable|string',
                'obat_sebelum' => 'nullable|string',
                'nama_obat_sebelum' => 'nullable|string',

                'catatan_lain' => 'nullable|string',
            ],
            [
                'noreg.required' => 'Nomor registrasi wajib diisi.',
                'noreg.string'   => 'Nomor registrasi harus berupa teks.',
                'noreg.max'      => 'Nomor registrasi maksimal 50 karakter.',

                'tanggal.date' => 'Format tanggal tidak valid.',

                'ga_array.array' => 'Data General Anestesi harus berupa array.',
                'ra_array.array' => 'Data Regional Anestesi harus berupa array.',

                'obat_anastesi_array.array' =>
                'Data obat anestesi harus berupa array.',

                'obat_emergensi_array.array' =>
                'Data obat emergensi harus berupa array.',
            ],
            [
                // alias nama field (biar error lebih manusiawi)
                'noreg' => 'Nomor Registrasi',
                'td' => 'Tekanan Darah',
                'rr' => 'Respirasi',
                'n' => 'Nadi',
                'ga_array' => 'General Anestesi',
                'ra_array' => 'Regional Anestesi',
                'obat_anastesi_array' => 'Obat Anestesi',
                'obat_emergensi_array' => 'Obat Emergensi',
            ]
        );
    }
}
