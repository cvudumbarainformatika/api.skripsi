<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\JsonResponse;

class LaboratoriumController extends Controller
{
    public function simpan(Request $request)
    {
        $validateData = $request->validate(
            [
                'noreg' => 'required',
                'norm' => 'required',
                'imuno_serologi' => 'nullable',
                'hbsag' => 'nullable',
                'hemostatika' => 'nullable',
                'pt' => 'nullable',
                'appt' => 'nullable',
                'hematologi' => 'nullable',
                'monosit' => 'nullable',
                'eosinofil' => 'nullable',
                'limfosit' => 'nullable',
                'basofil' => 'nullable',
                'trombosit' => 'nullable',
                'eritrosit' => 'nullable',
                'hemoglobin' => 'nullable',
                'hematokrit' => 'nullable',
                'lainnya' => 'nullable|array',
                'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            ],
            [
                'noreg.required' => 'Nomor Registrasi Harus di isi ',
                'norm.required' => 'Nomor Rekam Medis Harus di isi ',
            ]
        );
        try {
            DB::beginTransaction();
            if ($request->hasFile('dokumen')) {
                $files = $request->file('dokumen');
                if (!empty($files)) {
                    $penamaan = date('YmdHis') . '-emars-' . $request->norm . '.' . $files->getClientOriginalExtension();
                    $path = $files->storeAs('emars/dokumen-lab', $penamaan, 'sftp_storage');
                }
            }
            $result = Laboratorium::updateOrCreate([
                'noreg' => $request->noreg
            ], [
                'imuno_serologi' => $request->imuno_serologi,
                'hbsag' => $request->hbsag,
                'hemostatika' => $request->hemostatika,
                'pt' => $request->pt,
                'appt' => $request->appt,
                'hematologi' => $request->hematologi,
                'monosit' => $request->monosit,
                'eosinofil' => $request->eosinofil,
                'limfosit' => $request->limfosit,
                'basofil' => $request->basofil,
                'trombosit' => $request->trombosit,
                'eritrosit' => $request->eritrosit,
                'hemoglobin' => $request->hemoglobin,
                'hematokrit' => $request->hematokrit,
                'lainnya' => $request->lainnya,
                'path' => $path ?? null,
            ]);
            DB::commit();
            $data = $request->append('dokumen_url');
            return new JsonResponse($data);
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
                'id.required' => 'Id Data Laboratorium harus ada',
            ]
        );
        $data = Laboratorium::find($validatedData['id']);
        if (!$data) {
            return new JsonResponse([
                'message' => 'Gagal Hapus Data Laboratorium. Data tidak ditemukan'
            ], 410);
        }
        Storage::disk('sftp_storage')->delete($data->path);
        $data->delete();
        return new JsonResponse([
            'message' => 'Data Data Laboratorium sudah dihapus'
        ], 200);
    }


    public function dokumen($id)
    {

        $data = Laboratorium::findOrFail($id);

        $path = $data->path; // 👈 INI JAWABANNYA

        if (!$path) {
            abort(404, 'Dokumen belum diupload');
        }

        if (!Storage::disk('sftp_storage')->exists($path)) {
            abort(404, 'File tidak ditemukan');
        }
        return Storage::disk('sftp_storage')->response($path);
    }
}
