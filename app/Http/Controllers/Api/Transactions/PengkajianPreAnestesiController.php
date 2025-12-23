<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\PengkajianPreAnastesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class PengkajianPreAnestesiController extends Controller
{
    public function simpan(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'noreg' => 'required|string',
                'anamnesis' => 'nullable|array',
                'pemeriksaan_fisik_umum' => 'nullable|array',
                'pemeriksaan_jalan_napas' => 'nullable|array',
            ], [
                'noreg.required' => 'Nomor registrasi wajib diisi.',
            ]);

            $data = PengkajianPreAnastesi::updateOrCreate(
                [
                    'noreg' => $validated['noreg'],
                ],
                [
                    'anamnesis' => $validated['anamnesis'] ?? null,
                    'pemeriksaan_fisik_umum' => $validated['pemeriksaan_fisik_umum'] ?? null,
                    'pemeriksaan_jalan_napas' => $validated['pemeriksaan_jalan_napas'] ?? null,
                ]
            );
            DB::commit();
            return new JsonResponse([
                'data' => $data,
                'message' => 'Pengkajian Pre Anestesi berhasil disimpan',
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return new JsonResponse([
                'message' => 'Gagal menyimpan Pengkajian Pre Anestesi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function hapus(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = PengkajianPreAnastesi::where('noreg', $request->noreg)->first();

            if (!$data) {
                return new JsonResponse([
                    'message' => 'Data Pengkajian Pre Anestesi tidak ditemukan',
                ], 410);
            }

            $data->delete(); // Soft delete
            DB::commit();
            return new JsonResponse([
                'data' => $data,
                'message' => 'Pengkajian Pre Anestesi berhasil dihapus',
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return new JsonResponse([
                'message' => 'Gagal menghapus Pengkajian Pre Anestesi',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
