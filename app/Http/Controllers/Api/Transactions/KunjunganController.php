<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Api\Master\PasienController;
use App\Http\Controllers\Controller;
use App\Models\Master\Pasien;
use App\Models\Transactions\Kunjungan;
use App\Models\Transactions\PenanggungJawabPasien;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KunjunganController extends Controller
{
    public function index()
    {
        $req = [
            'order_by' => 'kunjungans.' . (request('order_by') ?? 'created_at'),
            'sort' => request('sort') ?? 'asc',
            'page' => request('page') ?? 1,
            'per_page' => request('per_page') ?? 10,
            'from' => request('from') . ' 00:00:00' ?? date('Y-m-d') . ' 00:00:00',
            'to' => request('to') . ' 23:59:59' ?? date('Y-m-d') . ' 23:59:59',
        ];
        $raw = Kunjungan::query();
        $raw->select('kunjungans.*', 'pasiens.*')->leftJoin('pasiens', 'pasiens.norm', '=', 'kunjungans.norm');
        $raw->when(request('q'), function ($k) {
            $k->where(function ($q) {
                $q->where('pasiens.nama', 'like', '%' . request('q') . '%')
                    ->orWhere('pasiens.norm', 'like', '%' . request('q') . '%')
                    ->orWhere('pasiens.nomor_asuransi', 'like', '%' . request('q') . '%')
                    ->orWhere('pasiens.nik', 'like', '%' . request('q') . '%')
                    ->orWhere('kunjungans.noreg', 'like', '%' . request('q') . '%');
            })->whereNull('kunjungans.deleted_at');
        })
            ->whereBetween('tgl_mrs', [$req['from'], $req['to']])
            ->orderBy($req['order_by'], $req['sort']);
        $totalCount = (clone $raw)->count();
        $data = $raw->simplePaginate($req['per_page']);


        $resp = ResponseHelper::responseGetSimplePaginate($data, $req, $totalCount);
        return new JsonResponse($resp);
    }
    public function terima()
    {
        $data = Kunjungan::find(request('id'));
        if (!$data) return new JsonResponse(['message' => 'Data paseian tidak ditemukan']);
        if ($data) {
            $data->load([
                'pj',
                'sertipreop',
                'pengkajian_pre_anastesi',
                'laboratorium',
                'radiologi',
                'assasement_pra_anastesi',
                'asessement_pra_induksi',
                'check_list_keselamatan_operasi',
                'askan_anastesi',
                'serah_terima_pasca_op',
                'score_pasca_anastesi',
                'pemantauan_pasca_anastesi',
                'pemakaian_obat_alkes',
            ]);
        }
        return new JsonResponse($data);
    }
    public function store(Request $request)
    {
        $noreg = $request->noreg ?? null;
        $norm = $request->norm ?? null;
        if ($norm) {
            $cekPasien = Pasien::where('norm', $norm)->whereNull('hidden')->first();
            if (!$cekPasien) return new JsonResponse(['message' => 'Data pasien dengan nomor Rekam Medik ' . $norm . ' tidak ditemukan'], 410);
        }
        $kunjungan = $request->input('kunjungan', []);

        if (empty($kunjungan['tgl_mrs'])) {
            $kunjungan['tgl_mrs'] = now()->format('Y-m-d H:i:s');
        }

        $request->merge([
            'kunjungan' => $kunjungan
        ]);
        $validateData = $request->validate(
            [
                'norm' => 'nullable',

                'pasien' => 'nullable|array',
                'kunjungan' => 'required|array',
                'pendamping' => 'required|array',

                'pasien.nama' => 'required_without:norm',
                'pasien.nik' => ['required_without:norm', Rule::unique('pasiens', 'nik')],
                'pasien.pendidikan' => 'nullable',
                'pasien.kelamin' => 'nullable',
                'pasien.agama' => 'nullable',
                'pasien.pekerjaan' => 'nullable',
                'pasien.suku' => 'nullable',
                'pasien.status_perkawinan' => 'nullable',
                'pasien.tlp' => 'nullable',
                'pasien.tgl_lahir' => 'nullable',
                'pasien.nama_asuransi' => 'nullable',
                'pasien.nomor_asuransi' => 'nullable',
                'pasien.alamat' => 'nullable',
                'pasien.desa' => 'nullable',
                'pasien.kecamatan' => 'nullable',
                'pasien.kabupaten' => 'nullable',
                'pasien.provinsi' => 'nullable',
                'pasien.negara' => 'nullable',

                'kunjungan.tgl_mrs' => 'date|date_format:Y-m-d H:i:s',
                'kunjungan.tgl_pengkajian' => 'nullable',
                'kunjungan.jam_pengkajian' => 'nullable',
                'kunjungan.diagnosa' => 'nullable',
                'kunjungan.rencana_tindakan' => 'nullable',
                'kunjungan.ruang_ranap' => 'nullable',
                'kunjungan.kelas' => 'nullable',
                'kunjungan.cara_masuk' => 'nullable',
                'kunjungan.pintu_masuk' => 'nullable',
                'kunjungan.alergi' => 'nullable',
                'kunjungan.rs' => 'nullable',
                'kunjungan.ruang_tindakan' => 'nullable',
                'kunjungan.tindakan_operasi' => 'nullable',
                'kunjungan.dokter_operator' => 'nullable',
                'kunjungan.dokter_anastesi' => 'nullable',
                'kunjungan.penata_anastesi' => 'nullable',

                'pendamping.nama' => 'required',
                'pendamping.tgl_lahir' => 'nullable',
                'pendamping.kelamin' => 'nullable',
                'pendamping.tlp' => 'nullable',
                'pendamping.agama' => 'nullable',
                'pendamping.pendidikan' => 'nullable',
                'pendamping.pekerjaan' => 'nullable',
                'pendamping.suku' => 'nullable',
                'pendamping.hubungan_dengan_pasien' => 'nullable',
                'pendamping.alamat' => 'nullable',
            ],
            [
                'pasien.nama.required_without' => 'Nama Pasien Wajib di isi',
                'pasien.nik.required_without' => 'NIK Pasien Wajib di isi',
                'pendamping.nama.required' => 'Nama Penangung Jawab Pasien harus di isi ',
            ]
        );
        $result = null;
        $kunjungan = $validateData['kunjungan'];
        $pendamping = $validateData['pendamping'];
        try {
            DB::beginTransaction();
            if (!$norm) {
                $pasien = $validateData['pasien'];
                DB::statement('CALL norm(@nomor)');
                $noNorm = DB::selectOne('SELECT @nomor AS norm')->norm;
                $hasil = str_pad($noNorm, 6, '0', STR_PAD_LEFT);
                $norm =  $hasil . 'PS';
                $result['pasien'] = PasienController::store($norm, $pasien);
            }
            if (!$noreg) {
                DB::statement('CALL noreg(@nomor)');
                $noNoreg = DB::selectOne('SELECT @nomor AS noreg')->noreg;
                $hasilNo = str_pad($noNoreg, 6, '0', STR_PAD_LEFT);
                $noreg =  $hasilNo . date('/d/m/y') . '/REG';
            }
            $result['kunjungan'] = Kunjungan::updateOrCreate(['norm' => $norm, 'noreg' => $noreg], $kunjungan);
            $result['pendamping'] = PenanggungJawabPasien::updateOrCreate(['noreg' => $noreg], $pendamping);
            $result['message'] = 'Data sudah berhasil disimpan';

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
                'alasan' => 'required|string|max:255',
            ],
            [
                'id.required' => 'Id kunjungan harus ada',
                'alasan.required' => 'Alasan hapus kunjungan harus di isi',
            ]
        );
        $data = Kunjungan::find($validatedData['id']);
        if (!$data) {
            return new JsonResponse([
                'message' => 'Gagal Hapus kunjungan. Data tidak ditemukan'
            ], 410);
        }
        $data->update(['alasan_hapus' => $validatedData['alasan']]);
        $data->delete();
        return new JsonResponse([
            'message' => 'Data kunjungan sudah dihapus'
        ], 200);
    }
}
