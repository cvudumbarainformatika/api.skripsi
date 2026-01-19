<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\AskanAnastesi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AskanAnastesiController extends Controller
{
    /**
     * ================= VALIDATOR =================
     */
    protected function validateRequest(Request $request): array
    {
        return $request->validate(
            [
                'noreg' => 'required|string',
                'fase' => 'nullable|string',

                'askan_data' => 'nullable|array',

                'askan_data.*.data' => 'nullable|string',
                'askan_data.*.masalah_kesehatan_anestesi' => 'nullable|string',
                'askan_data.*.waktu' => 'nullable|string',
                'askan_data.*.intervensi' => 'nullable|string',
                'askan_data.*.implementasi' => 'nullable|string',

                'askan_data.*.evaluasi' => 'nullable|array',
                'askan_data.*.evaluasi.s' => 'nullable|string',
                'askan_data.*.evaluasi.o' => 'nullable|string',
                'askan_data.*.evaluasi.a' => 'nullable|string',
                'askan_data.*.evaluasi.p' => 'nullable|string',

                'askan_data.*.nama_ttd' => 'nullable|string',
            ],
            [
                'noreg.required' => 'No registrasi wajib diisi.',
                'noreg.string' => 'No registrasi harus berupa teks.',
                'askan_data.array' => 'Data asuhan pra anestesi harus berupa array.',
            ]
        );
    }

    /**
     * ================= SIMPAN / UPDATE =================
     */
    public function simpan(Request $request)
    {
        DB::beginTransaction();
        $user = Auth::user();
        try {
            $data = $this->validateRequest($request);

            $result = AskanAnastesi::updateOrCreate(
                [
                    'noreg' => $data['noreg'],
                    'fase'  => $data['fase'],
                ],
                [
                    'askan_data' => $data['askan_data'] ?? null,
                    'user_id' => $user->id
                ]
            );

            DB::commit();

            return response()->json([
                'message' => 'Askan anestesi berhasil disimpan.',
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
                [
                    'noreg' => 'required|string',
                    'fase'  => 'required|string',
                ],
                [
                    'noreg.required' => 'No registrasi wajib diisi.',
                    'fase.required' => 'Fase wajib diisi.',
                ]
            );

            $data = AskanAnastesi::where('noreg', $request->noreg)
                ->where('fase', $request->fase)
                ->first();


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
