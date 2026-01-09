<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\AskanPraAnastesi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AskanPraAnastesiController extends Controller
{
    /**
     * ================= VALIDATOR =================
     */
    protected function validateRequest(Request $request): array
    {
        return $request->validate(
            [
                'noreg' => 'required|string',

                'asuhan_pra_anestesi' => 'nullable|array',

                'asuhan_pra_anestesi.*.data' => 'nullable|string',
                'asuhan_pra_anestesi.*.masalah_kesehatan_anestesi' => 'nullable|string',
                'asuhan_pra_anestesi.*.waktu' => 'nullable|string',
                'asuhan_pra_anestesi.*.intervensi' => 'nullable|string',
                'asuhan_pra_anestesi.*.implementasi' => 'nullable|string',

                'asuhan_pra_anestesi.*.evaluasi' => 'nullable|array',
                'asuhan_pra_anestesi.*.evaluasi.s' => 'nullable|string',
                'asuhan_pra_anestesi.*.evaluasi.o' => 'nullable|string',
                'asuhan_pra_anestesi.*.evaluasi.a' => 'nullable|string',
                'asuhan_pra_anestesi.*.evaluasi.p' => 'nullable|string',

                'asuhan_pra_anestesi.*.nama_ttd' => 'nullable|string',
            ],
            [
                'noreg.required' => 'No registrasi wajib diisi.',
                'noreg.string' => 'No registrasi harus berupa teks.',
                'asuhan_pra_anestesi.array' => 'Data asuhan pra anestesi harus berupa array.',
            ]
        );
    }

    /**
     * ================= SIMPAN / UPDATE =================
     */
    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->validateRequest($request);

            $result = AskanPraAnastesi::updateOrCreate(
                ['noreg' => $data['noreg']],
                ['asuhan_pra_anestesi' => $data['asuhan_pra_anestesi'] ?? null]
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Asuhan pra anestesi berhasil disimpan.',
                'data' => $result,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ================= HAPUS (HARD DELETE) =================
     */
    public function hapus(Request $request)
    {
        try {
            $request->validate(
                ['noreg' => 'required|string'],
                ['noreg.required' => 'No registrasi wajib diisi.']
            );

            $data = AskanPraAnastesi::where('noreg', $request->noreg)->first();

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
