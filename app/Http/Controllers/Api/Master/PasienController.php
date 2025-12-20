<?php

namespace App\Http\Controllers\Api\Master;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Master\Pasien;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    //
    public function index()
    {
        $req = [
            'order_by' => request('order_by') ?? 'created_at',
            'sort' => request('sort') ?? 'asc',
            'page' => request('page') ?? 1,
            'per_page' => request('per_page') ?? 10,
        ];
        $raw = Pasien::query();
        $raw->when(request('q'), function ($q) {
            $q->where('nama', 'like', '%' . request('q') . '%')
                ->orWhere('norm', 'like', '%' . request('q') . '%')
                ->orWhere('nomor_asuransi', 'like', '%' . request('q') . '%')
                ->orWhere('nama_asuransi', 'like', '%' . request('q') . '%')
                ->orWhere('nik', 'like', '%' . request('q') . '%');
        })
            ->whereNull('hidden')
            ->orderBy($req['order_by'], $req['sort']);
        $totalCount = (clone $raw)->count();
        $data = $raw->simplePaginate($req['per_page']);


        $resp = ResponseHelper::responseGetSimplePaginate($data, $req, $totalCount);
        return new JsonResponse($resp);
    }
    public function registerPasien(Request $request)
    {
        $norm = $request->norm ?? null;
        $validateData = $request->validate([
            'nama' => 'required|string',
            'nik' => 'required|unique:pasiens',
            'pendidikan' => 'nullable',
            'kelamin' => 'nullable',
            'agama' => 'nullable',
            'pekerjaan' => 'nullable',
            'suku' => 'nullable',
            'status_perkawinan' => 'nullable',
            'tlp' => 'nullable',
            'tgl_lahir' => 'nullable',
            'nama_asuransi' => 'nullable',
            'nomor_asuransi' => 'nullable',
            'alamat' => 'nullable',
            'desa' => 'nullable',
            'kecamatan' => 'nullable',
            'kabupaten' => 'nullable',
            'provinsi' => 'nullable',
            'negara' => 'nullable',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',

            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah digunakan.',
        ]);
        try {
            DB::beginTransaction();

            if (!$norm) {
                DB::statement('CALL norm(@nomor)');
                $nomor = DB::selectOne('SELECT @nomor AS norm')->norm;
                $hasil = str_pad($nomor, 6, '0', STR_PAD_LEFT);
                $norm =  $hasil . 'PS';
            }

            $result = self::store($norm, $validateData);
            DB::commit();
            return new JsonResponse([
                'message' => $result['message'],
                'data' => $result['data']
            ], $result['status']);
        } catch (\Throwable  $e) {
            DB::rollBack();
            return new JsonResponse([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),

            ], 410);
        }
    }
    public static function store(string $norm, array $data): array
    {

        $result = Pasien::updateOrCreate(
            ['norm' => $norm],
            $data
        );
        return ['data' => $result, 'message' => 'Data Berhasil Disimpan', 'status' => 200];
    }
    public function hapus(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = Pasien::find($request->id);
            if (!$data) {
                throw new Exception('Data Pasien tidak ditemukan');
            }
            $data->update(['hidden' => '1']);
            DB::commit();
            return new JsonResponse([
                'message' => 'Data pasiens sudah dihapus',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return new JsonResponse([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user' => Auth::user(),
                'trace' => $e->getTrace()
            ], 410);
        }
    }
}
