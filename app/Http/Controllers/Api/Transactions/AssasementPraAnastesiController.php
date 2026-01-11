<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\AssasementPraAnastesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class AssasementPraAnastesiController extends Controller
{
    public function simpan(Request $request)
    {
        $validateData = $request->validate(
            [
                'noreg' => 'required',
                'klassifikasi_asa' => 'nullable',
                'keterangan_klassifikasi_asa' => 'nullable',
                'jenis_anastesi' => 'nullable',
                'hemostatika' => 'nullable',
                'teknik_anastesi' => 'nullable',
                'appt' => 'nullable',
                'indikasi' => 'nullable',
                'kode_user' => 'nullable',
                'nama_pelaksana' => 'nullable',
            ],
            [
                'noreg.required' => 'Nomor Registrasi Harus di isi ',
            ]
        );

        try {
            DB::beginTransaction();
            $result = AssasementPraAnastesi::updateOrCreate(
                ['noreg' => $validateData['noreg']],
                $validateData
            );
            DB::commit();
            return new JsonResponse($result);
        } catch (\Throwable $e) {
            DB::rollBack();
            return new JsonResponse([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
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
                'id.required' => 'Id Data harus ada',
            ]
        );
        $data = AssasementPraAnastesi::find($validatedData['id']);
        if (!$data) {
            return new JsonResponse([
                'message' => 'Gagal Hapus Data Assasement Pra Anastesi. Data tidak ditemukan'
            ], 410);
        }
        $data->delete();
        return new JsonResponse([
            'message' => 'Data Assasement Pra Anastesi sudah dihapus'
        ], 200);
    }
}
