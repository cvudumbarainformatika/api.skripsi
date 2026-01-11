<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\Radiologi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RadiologiController extends Controller
{
    //
    public function simpan(Request $request)
    {
        $validateData = $request->validate(
            [
                'noreg' => 'required',
                'norm' => 'required',
                'nama_pemeriksaan' => 'nullable',
                'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:1024',
            ],
            [
                'noreg.required' => 'Nomor Registrasi Harus di isi ',
            ]
        );
        try {
            DB::beginTransaction();
            if ($request->hasFile('dokumen')) {
                $files = $request->file('dokumen');
                $ada = Radiologi::where('noreg', $validateData['noreg'])->first();
                if (!empty($files)) {
                    $penamaan = date('YmdHis') . '-emars-' . $request->norm . '.' . $files->getClientOriginalExtension();
                    $path = $files->storeAs('emars/dokumen-lab', $penamaan, 'sftp_storage');

                    if (!$ada) {
                        $result = Radiologi::create([
                            'noreg' => $request->noreg,
                            'nama_pemeriksaan' => $request->nama_pemeriksaan,
                            'path' => $path,
                        ]);
                    } else {
                        $ada->update([
                            'nama_pemeriksaan' => $request->nama_pemeriksaan,
                            'path' => $path,
                        ]);
                        $result = $ada;
                    }
                } else if ($request->nama_pemeriksaan != null && $ada) {
                    $ada->update([
                        'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    ]);
                    $result = $ada;
                }
            } else {
                $result = Radiologi::updateOrCreate([
                    'noreg' => $request->noreg
                ], [
                    'nama_pemeriksaan' => $request->nama_pemeriksaan
                ]);
            }
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
                'id.required' => 'Id Data Radiologi harus ada',
            ]
        );
        $data = Radiologi::find($validatedData['id']);
        if (!$data) {
            return new JsonResponse([
                'message' => 'Gagal Hapus Data Radiologi. Data tidak ditemukan'
            ], 410);
        }
        Storage::disk('sftp_storage')->delete($data->path);
        $data->delete();
        return new JsonResponse([
            'message' => 'Data Data Radiologi sudah dihapus'
        ], 200);
    }
    public function dokumen($id)
    {

        $data = Radiologi::findOrFail($id);

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
