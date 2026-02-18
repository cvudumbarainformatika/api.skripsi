<?php

namespace App\Http\Controllers\Api\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transactions\PemakaianObatAlkes;
use Illuminate\Http\Request;

class PemakaianObatAlkesController extends Controller
{
    public function simpan(Request $request)
    {
        // VALIDASI RINGAN (SESUAI KESEPAKATAN)
        $request->validate([
            'noreg' => 'required|string',
            'cairan' => 'nullable|array',
            'alkes'  => 'nullable|array',
            'obat'   => 'nullable|array',
            'obat'   => 'nullable|array',
            'gasanastesi'   => 'nullable|array',
        ]);

        $data = PemakaianObatAlkes::updateOrCreate(
            ['noreg' => $request->noreg],
            [
                'cairan' => $request->cairan,
                'alkes'  => $request->alkes,
                'obat'   => $request->obat,
                'gasanastesi'   => $request->gasanastesi,
            ]
        );

        return response()->json([
            'message' => 'Pemakaian obat dan alkes berhasil disimpan',
            'data' => $data
        ]);
    }
    public function hapus(Request $request)
    {
        PemakaianObatAlkes::where('noreg', $request->noreg)->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
