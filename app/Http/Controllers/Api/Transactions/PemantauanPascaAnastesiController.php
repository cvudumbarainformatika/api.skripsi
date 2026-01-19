<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\PemantauanPascaAnastesi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemantauanPascaAnastesiController extends Controller
{
    protected function rules(): array
    {
        return [
            'noreg' => 'required|string',

            'tanggal' => 'nullable|string',
            'jam_masuk_rr' => 'nullable|string',
            'jam_keluar_rr' => 'nullable|string',

            // kondisi pasien (STRING, bukan array)
            'jalan_napas' => 'nullable|string',
            'alat_bantu_napas' => 'nullable|string',
            'pernapasan' => 'nullable|string',
            'bila_spontan' => 'nullable|string',
            'kesadaran' => 'nullable|string',

            // tabel pemantauan
            'pemantauan_vital' => 'nullable|array',

            // instruksi pasca bedah
            'posisi_pasien' => 'nullable|string',
            'makan_minum' => 'nullable|string',
            'infus_transfusi' => 'nullable|string',
            'obat_obatan' => 'nullable|string',
            'pemantauan_ttv' => 'nullable|string',
            'lain_lain' => 'nullable|string',
        ];
    }


    protected function messages(): array
    {
        return [
            'noreg.required' => 'No registrasi wajib diisi.',
            'noreg.string'   => 'No registrasi harus berupa teks.',

            'tanggal.string' => 'Tanggal harus berupa teks.',
            'jam_masuk_rr.string' => 'Jam masuk RR harus berupa teks.',
            'jam_keluar_rr.string' => 'Jam keluar RR harus berupa teks.',

            'jalan_napas.string' => 'Jalan napas harus berupa teks.',
            'alat_bantu_napas.string' => 'Alat bantu napas harus berupa teks.',
            'pernapasan.string' => 'Pernapasan harus berupa teks.',
            'bila_spontan.string' => 'Keterangan pernapasan spontan harus berupa teks.',
            'kesadaran.string' => 'Kesadaran harus berupa teks.',

            'pemantauan_vital.array' => 'Data pemantauan vital harus berupa array.',

            'posisi_pasien.string' => 'Posisi pasien harus berupa teks.',
            'makan_minum.string' => 'Instruksi makan/minum harus berupa teks.',
            'infus_transfusi.string' => 'Infus atau transfusi harus berupa teks.',
            'obat_obatan.string' => 'Obat-obatan harus berupa teks.',
            'pemantauan_ttv.string' => 'Pemantauan tanda vital harus berupa teks.',
            'lain_lain.string' => 'Keterangan lain-lain harus berupa teks.',
        ];
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validate(
                $this->rules(),
                $this->messages()
            );

            $result = PemantauanPascaAnastesi::updateOrCreate(
                ['noreg' => $data['noreg']],
                collect($data)->except('noreg')->toArray()
            );

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Pemantauan pasca anestesi berhasil disimpan.',
                'data' => $result,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function hapus(Request $request)
    {
        $data = $request->validate(
            ['noreg' => 'required|string'],
            ['noreg.required' => 'No registrasi wajib diisi.']
        );

        $model = PemantauanPascaAnastesi::where('noreg', $data['noreg'])->first();

        if (!$model) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        $model->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }
}
