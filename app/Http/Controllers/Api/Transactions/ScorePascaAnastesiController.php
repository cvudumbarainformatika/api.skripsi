<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\ScorePascaAnastesi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class ScorePascaAnastesiController extends Controller
{
    public function index()
    {
        $data = ScorePascaAnastesi::where('noreg', request('noreg'))->first();
        return new JsonResponse($data);
    }
    /**
     * ================= RULES =================
     */
    protected function rules(): array
    {
        return [
            'noreg' => 'required|string',

            'aldrete_score' => 'nullable|array',
            'bromage_score' => 'nullable|array',
            'steward_score' => 'nullable|array',
        ];
    }

    protected function messages(): array
    {
        return [
            'noreg.required' => 'No registrasi wajib diisi.',
            'noreg.string'   => 'No registrasi harus berupa teks.',

            'aldrete_score.array' => 'Aldrete score harus berupa array.',
            'bromage_score.array' => 'Bromage score harus berupa array.',
            'steward_score.array' => 'Steward score harus berupa array.',
        ];
    }

    /**
     * ================= SIMPAN / UPDATE =================
     */
    public function simpan(Request $request)
    {
        DB::beginTransaction();

        try {
            // ✅ VALIDASI KONSISTEN
            $data = $request->validate(
                $this->rules(),
                $this->messages()
            );

            $result = ScorePascaAnastesi::updateOrCreate(
                ['noreg' => $data['noreg']],
                collect($data)->except('noreg')->toArray()
            );

            DB::commit();

            return response()->json([
                'message' => 'Score pasca anastesi berhasil disimpan.',
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
        $data = $request->validate(
            ['noreg' => 'required|string'],
            ['noreg.required' => 'No registrasi wajib diisi.']
        );

        $model = ScorePascaAnastesi::where('noreg', $data['noreg'])->first();

        if (!$model) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ], 404);
        }

        $model->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }
}
