<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\LaporanAnastesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class LaporanAnastesiController extends Controller
{
    /**
     * ================= VALIDATOR =================
     */
    protected function validator(Request $request)
    {
        return $request->valdate(

            $this->rules(),
            $this->messages()
        );
    }

    protected function rules(): array
    {
        return [
            'noreg' => 'required|string',

            // ARRAY (checkbox / multi pilihan)
            'posisi_pasien' => 'nullable|array',
            'premedikasi' => 'nullable|array',
            'induksi' => 'nullable|array',
            'klasifikasi_asa' => 'nullable|array',
            'tata_laksana_jalan_napas' => 'nullable|array',
            'intubasi' => 'nullable|array',
            'ventilasi' => 'nullable|array',
            'regional_anestesi' => 'nullable|array',

            // STRING
            'infus' => 'nullable|string',
            'obat' => 'nullable|string',
            'waktu_mulai' => 'nullable|string',
            'waktu_selesai' => 'nullable|string',
            'lama_anestesi' => 'nullable|string',
            'lama_operasi' => 'nullable|string',

            'jumlah_cairan' => 'nullable|string',
            'jumlah_perdarahan' => 'nullable|string',
            'urin' => 'nullable|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'noreg.required' => 'No registrasi wajib diisi.',
            'noreg.string'   => 'No registrasi harus berupa teks.',

            'posisi_pasien.array' => 'Posisi pasien harus berupa array.',
            'premedikasi.array' => 'Premedikasi harus berupa array.',
            'induksi.array' => 'Induksi harus berupa array.',
            'klasifikasi_asa.array' => 'Klasifikasi ASA harus berupa array.',
            'tata_laksana_jalan_napas.array' => 'Tata laksana jalan napas harus berupa array.',
            'intubasi.array' => 'Data intubasi harus berupa array.',
            'ventilasi.array' => 'Data ventilasi harus berupa array.',
            'regional_anestesi.array' => 'Regional anestesi harus berupa array.',
        ];
    }

    /**
     * ================= SIMPAN / UPDATE =================
     */
    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $this->validator($request);


            $data = LaporanAnastesi::updateOrCreate(
                ['noreg' => $validated->noreg],
                $validated->except('noreg')
            );

            DB::commit();

            return response()->json([
                'message' => 'Laporan anestesi berhasil disimpan.',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan anestesi.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ================= HAPUS =================
     */
    public function hapus(Request $request)
    {
        try {
            $validated =  $request->validate(
                ['noreg' => 'required|string'],
                ['noreg.required' => 'No registrasi wajib diisi.']
            );

            $data = LaporanAnastesi::where('noreg', $validated['noreg'])->first();

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.',
                ], 404);
            }

            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
