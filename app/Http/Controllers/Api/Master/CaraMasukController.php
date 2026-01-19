<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\CaraMasuk;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CaraMasukController extends Controller
{
    public function index()
    {
        $req = [
            'order_by' => request('order_by') ?? 'created_at',
            'sort' => request('sort') ?? 'asc',
            'page' => request('page') ?? 1,
            'per_page' => request('per_page') ?? 10,
        ];

        $raw = CaraMasuk::query();

        $raw->when(request('q'), function ($q) {
            $q->where(function ($query) {
                $query->where('nama', 'like', '%' . request('q') . '%')
                    ->orWhere('kode', 'like', '%' . request('q') . '%');
            });
        })->whereNull('hidden')
            ->orderBy($req['order_by'], $req['sort']);
        $totalCount = (clone $raw)->count();
        $data = $raw->simplePaginate($req['per_page']);

        $resp = ResponseHelper::responseGetSimplePaginate($data, $req, $totalCount);
        return new JsonResponse($resp);
    }

    public function simpan(Request $request)
    {
        $kode = $request->kode ?? null;
        $validated = $request->validate([
            'nama' => 'required',
            'kode' => 'nullable',
        ], [
            'nama.required' => 'Nama wajib diisi.',
        ]);


        $data = CaraMasuk::updateOrCreate(
            [
                'kode' => $kode
            ],
            $validated
        );
        if (!$kode) {
            $newKode = str_pad($data->id, 4, '0', STR_PAD_LEFT) . 'CM';
            $data->update(['kode' => $newKode]);
        }
        return new JsonResponse([
            'data' => $data,
            'message' => 'Data Cara Masuk berhasil disimpan'
        ]);
    }

    public function hapus(Request $request)
    {
        $data = CaraMasuk::find($request->id);
        if (!$data) {
            return new JsonResponse([
                'message' => 'Data Cara Masuk tidak ditemukan'
            ], 410);
        }
        $data->update(['hidden' => '1']);
        return new JsonResponse([
            'data' => $data,
            'message' => 'Data Cara Masuk berhasil dihapus'
        ]);
    }
}
