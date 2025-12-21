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
                'noreg' => 'required',
                'kesadaran' => 'nullable',
                'riwayat_penyakit' => 'nullable',
                'riwayat_penyakit_lain' => 'nullable',
                'jenis_alergi_obat' => 'nullable',
                'reaksi_alergi_obat' => 'nullable',
                'surat_persetujuan_operasi' => 'nullable',
                'surat_persetujuan_anastesi' => 'nullable',
                'mulai_puasa' => 'nullable',
                'pengosongan_kandung_kemih' => 'nullable',
                'gigi_palsu' => 'nullable',
                'perhisan' => 'nullable',
                'kosmetik' => 'nullable',
                'cukur_daerah_operasi' => 'nullable',
                'penandaan' => 'nullable',
                'hasil_pemeriksaan' => 'nullable',
                'alat_kesehatan' => 'nullable',
                'alat_kesehatan_lainnya' => 'nullable',
                'jenis_darah' => 'nullable',
                'jumlah_darah' => 'nullable',
                'vital_td' => 'nullable',
                'vital_n' => 'nullable',
                'vital_s' => 'nullable',
                'vital_rr' => 'nullable',
            ],
            [
                'noreg.required' => 'Nomor Registrasi Pasien harus ada',
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
