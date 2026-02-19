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
                'hasil_bacaan' => 'nullable',
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
                            'hasil_bacaan' => $request->hasil_bacaan,
                            'path' => $path,
                        ]);
                    } else {
                        $ada->update([
                            'nama_pemeriksaan' => $request->nama_pemeriksaan,
                            'hasil_bacaan' => $request->hasil_bacaan,
                            'path' => $path,
                        ]);
                        $result = $ada;
                    }
                } else if ($request->nama_pemeriksaan != null && $ada) {
                    $ada->update([
                        'nama_pemeriksaan' => $request->nama_pemeriksaan,
                        'hasil_bacaan' => $request->hasil_bacaan,
                    ]);
                    $result = $ada;
                }
            } else {
                $result = Radiologi::updateOrCreate([
                    'noreg' => $request->noreg
                ], [
                    'nama_pemeriksaan' => $request->nama_pemeriksaan,
                    'hasil_bacaan' => $request->hasil_bacaan
                ]);
            }
            DB::commit();
            $data = $result->append('dokumen_url');
            return new JsonResponse([
                'message' => 'Checklist keselamatan operasi berhasil disimpan.',
                'data'    => $data
            ]);
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
            abort(410, 'Dokumen belum diupload');
        }
        $disk = Storage::disk('sftp_storage');
        if (!Storage::disk('sftp_storage')->exists($path)) {
            abort(410, 'File tidak ditemukan');
        }
        // ambil isi file mentah
        $stream = $disk->readStream($path);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $disk->mimeType($path),
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
        // $fullPath = Storage::disk('sftp_storage')->path($path);

        // return response()->file($fullPath);
    }
}
