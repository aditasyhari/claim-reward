<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class LokasiController extends Controller
{
    public function ongkirProvinsi(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('tm_propinsi')->where("id_propinsi", $request->provID)->pluck('ongkir')->first();

            return response()->json([
				'success' => true,
				'message' => 'success',
				'data' => $data
			], 200);
        }
    }

    public function getKab(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('tm_kotakab')->where("id_propinsi", $request->provID)->pluck('id_kotakab', 'kotakab');

            return response()->json([
				'success' => true,
				'message' => 'success',
				'data' => $data
			], 200);
        }
    }

    public function getKec(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('tm_kecamatan')->where("id_kotakab", $request->kabID)->pluck('id_kecamatan', 'nama_kecamatan');
            
            return response()->json([
				'success' => true,
				'message' => 'success',
				'data' => $data
			], 200);
        }
    }

    public function getKel(Request $request)
    {
        if($request->ajax()) {
            $data = DB::table('tm_kelurahan')->where("id_kecamatan", $request->kecID)->pluck('id_kelurahan', 'nama_kelurahan');
            
            return response()->json([
				'success' => true,
				'message' => 'success',
				'data' => $data
			], 200);
        }
    }
}
