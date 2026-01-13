<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\SerahTerimaPreOperasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class SerahTerimaPreOperasiController extends Controller
{
    public function index() {}
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'noreg' => 'required|string',
                'kesadaran' => 'nullable|array',
                'riwayat_penyakit' => 'nullable|array',
                'riwayat_penyakit_lain' => 'nullable|string',
                'riwayat_alergi_obat' => 'nullable|string',
                'jenis_alergi_obat' => 'nullable|string',
                'reaksi_alergi_obat' => 'nullable|string',
                'persiapan_operasi' => 'nullable|array',
                'mulai_puasa' => 'nullable|string',
                'hasil_pemeriksaan' => 'nullable|string',
                'alat_kesehatan' => 'nullable|array',
                'alat_kesehatan_lainnya' => 'nullable|string',
                'jenis_darah' => 'nullable|array',
                'jumlah_darah' => 'nullable|string',
                'vital_td' => 'nullable|string',
                'vital_n' => 'nullable|string',
                'vital_s' => 'nullable|string',
                'vital_rr' => 'nullable|string',
            ],
            [
                'noreg.required' => 'Nomor Registrasi Pasien harus ada',
                'kesadaran.array' => 'Kesadaran bukan array, hubungi tim IT untuk perbaikan',
                'riwayat_penyakit.array' => 'Riwayat Penyakit bukan array, hubungi tim IT untuk perbaikan',
                'persiapan_operasi.array' => 'Persiapan Oerasi bukan array, hubungi tim IT untuk perbaikan',
                'alat_kesehatan.array' => 'Alat Kesehatan bukan array, hubungi tim IT untuk perbaikan',
                'jenis_darah.array' => 'Jenis Darah bukan array, hubungi tim IT untuk perbaikan',
            ]
        );
        try {
            DB::beginTransaction();
            $result = SerahTerimaPreOperasi::updateOrCreate(
                ['noreg' => $validatedData['noreg']],
                $validatedData
            );

            if (!$result) throw new Exception('Data gagal di simpan');
            DB::commit();
            return new JsonResponse($result);
        } catch (\Throwable $e) {
            DB::rollBack();
            return new JsonResponse([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage() . ' line ' . $e->getLine(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),

            ], 410);
        }
    }
    public function hapus(Request $request)
    {
        $validatedData = $request->validate(
            [
                'id' => 'required',
            ],
            [
                'id.required' => 'Id Serah Terima harus ada',
            ]
        );
        $data = SerahTerimaPreOperasi::find($validatedData['id']);
        if (!$data) {
            return new JsonResponse([
                'message' => 'Gagal Hapus Serah Terima. Data tidak ditemukan'
            ], 410);
        }
        $data->update(['alasan_hapus' => $validatedData['alasan']]);
        $data->delete();
        return new JsonResponse([
            'message' => 'Data Serah Terima sudah dihapus'
        ], 200);
    }
}
