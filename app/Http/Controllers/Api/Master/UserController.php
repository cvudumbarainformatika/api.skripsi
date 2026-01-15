<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function index()
    {
        $req = [
            'order_by' => request('order_by') ?? 'created_at',
            'sort' => request('sort') ?? 'asc',
            'page' => request('page') ?? 1,
            'per_page' => request('per_page') ?? 10,
        ];

        $raw = User::query();
        $raw->when(request('q'), function ($q) {
            $q->where(function ($query) {
                $query->where('nama', 'like', '%' . request('q') . '%')
                    ->orWhere('username', 'like', '%' . request('q') . '%')
                    ->orWhere('email', 'like', '%' . request('q') . '%')
                    ->orWhere('kode', 'like', '%' . request('q') . '%');
            });

        })->where('kode_jabatan', '!=', 'root')
        ->whereNull('hidden')
            ->orderBy($req['order_by'], $req['sort']);
        $totalCount = (clone $raw)->count();
        $data = $raw->simplePaginate($req['per_page']);

        $resp = ResponseHelper::responseGetSimplePaginate($data, $req, $totalCount);
        return new JsonResponse($resp);
    }
}
