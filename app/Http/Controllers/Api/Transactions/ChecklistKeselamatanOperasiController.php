<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\CheckListKeselamatanOperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class ChecklistKeselamatanOperasiController extends Controller
{
    /**
     * SIMPAN / UPDATE (BERDASARKAN NOREG)
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->validateRequest($request);

            $result = CheckListKeselamatanOperasi::updateOrCreate(
                ['noreg' => $data['noreg']],
                $data
            );

            DB::commit();

            return response()->json([
                'message' => 'Checklist keselamatan operasi berhasil disimpan.',
                'data'    => $result
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan checklist keselamatan operasi.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * HAPUS (BERDASARKAN NOREG)
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate(
                [
                    'noreg' => 'required|string'
                ],
                [
                    'noreg.required' => 'Nomor registrasi wajib diisi.',
                    'noreg.string'   => 'Nomor registrasi harus berupa teks.'
                ]
            );

            $data = ChecklistKeselamatanOperasi::where('noreg', $request->noreg)->first();

            if (!$data) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data checklist tidak ditemukan.'
                ], 404);
            }

            $data->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Checklist keselamatan operasi berhasil dihapus.'
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus checklist keselamatan operasi.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * VALIDASI REQUEST
     */
    private function validateRequest(Request $request): array
    {
        return $request->validate(
            [
                'noreg' => 'required|string',

                // SIGN IN
                'konfirmasi_pasien' => 'nullable|array',
                'lokasi_operasi_ditandai' => 'nullable|string',
                'mesin_anestesi_lengkap' => 'nullable|string',
                'pulse_oxymeter_berfungsi' => 'nullable|string',

                'riwayat_alergi' => 'nullable|string',
                'keterangan_alergi' => 'nullable|string',

                'resiko_jalan_napas' => 'nullable|string',
                'ketersediaan_alat_bantuan' => 'nullable|string',

                'resiko_kehilangan_darah' => 'nullable|string',
                'dua_akses_iv' => 'nullable|string',
                'rencana_terapi_cairan' => 'nullable|string',

                // TIME OUT
                'konfirmasi_tim' => 'nullable|string',
                'konfirmasi_pasien_prosedur_lokasi' => 'nullable|string',

                'antibiotik_profilaksis' => 'nullable|string',
                'nama_antibiotik' => 'nullable|string',
                'jam_antibiotik' => 'nullable|string',
                'dosis_antibiotik' => 'nullable|string',

                // ANTISIPASI KRITIS
                'langkah_kondisi_kritis' => 'nullable|string',
                'estimasi_lama_operasi' => 'nullable|string',
                'antisipasi_kehilangan_darah' => 'nullable|string',

                'catatan_tim_anestesi' => 'nullable|string',

                'peralatan_steril' => 'nullable|string',
                'alat_perlu_perubahan_khusus' => 'nullable|string',
                'foto_penunjang' => 'nullable|string',

                // SIGN OUT
                'konfirmasi_verbal' => 'nullable|array',
                'review_masalah_utama' => 'nullable|string',

                'jenis_implan' => 'nullable|string',
                'kode_implan' => 'nullable|string',
            ],
            [
                'noreg.required' => 'Nomor registrasi wajib diisi.',
                'noreg.string'   => 'Nomor registrasi harus berupa teks.',

                'konfirmasi_pasien.array' =>
                'Konfirmasi pasien harus berupa data array.',

                'konfirmasi_verbal.array' =>
                'Konfirmasi verbal harus berupa data array.',
            ],
            [
                // alias field biar error lebih manusiawi
                'noreg' => 'Nomor Registrasi',
                'konfirmasi_pasien' => 'Konfirmasi Pasien (Sign In)',
                'konfirmasi_verbal' => 'Konfirmasi Verbal (Sign Out)',
            ]
        );
    }
}
