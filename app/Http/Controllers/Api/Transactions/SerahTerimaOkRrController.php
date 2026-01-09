<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\SerahTerimaOkRr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SerahTerimaOkRrController extends Controller
{
    /**
     * ================= VALIDATOR =================
     */
    protected function rules(): array
    {
        return [
            'noreg' => 'required|string',

            'situation' => 'nullable|string',
            'background' => 'nullable|string',
            'assessment' => 'nullable|string',
            'recommendation' => 'nullable|string',

            'penyerah_nama' => 'nullable|string',
            'penerima_nama' => 'nullable|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'noreg.required' => 'No registrasi wajib diisi.',
            'noreg.string'   => 'No registrasi harus berupa teks.',
        ];
    }

    protected function validateRequest(Request $request): array
    {
        return $request->validate(
            $this->rules(),
            $this->messages()
        );
    }

    /**
     * ================= SIMPAN / UPDATE =================
     */
    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $this->validateRequest($request);

            $result = SerahTerimaOkRr::updateOrCreate(
                ['noreg' => $data['noreg']],
                collect($data)->except('noreg')->toArray()
            );

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Serah terima OK ke RR berhasil disimpan.',
                'data'    => $result,
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ================= HAPUS (HARD DELETE) =================
     */
    public function hapus(Request $request)
    {
        $request->validate(
            ['noreg' => 'required|string'],
            ['noreg.required' => 'No registrasi wajib diisi.']
        );

        $data = SerahTerimaOkRr::where('noreg', $request->noreg)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }
}
