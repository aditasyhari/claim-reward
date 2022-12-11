<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CbtTesUser;
use App\Models\ClaimUser;
use App\Models\ClaimUserDetail;
use Validator;
use Auth;
use DB;

class ClaimController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::user()->user_id;
        $tes = CbtTesUser::gettest($user_id);
        $paket = DB::table('tm_paket')->where('flag', 1)->get();
        $propinsi = DB::table('tm_propinsi')->where('flag_status', 1)->get();

        return view('claim.dashboard', compact(['tes', 'paket', 'propinsi']));
    }

    public function claim(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'nama'      => 'required',
            'id_propinsi'    => 'required',
            'id_kotakab'    => 'required',
            'id_kecamatan'    => 'required',
            'alamat'    => 'required',
            'email'     => 'required|email',
            'wa'        => 'required|numeric',
            'bukti'     => 'required|max:2048',
            'item_val'      => 'required',
            'ongkir_val'    => 'required',
            'total_val'     => 'required',
            'detail_paket'  => 'required',
            'note'      => 'nullable',
        ]);

        if ($validateData->fails()) {
            return back()->with('error', 'Pastikan semua terisi dengan benar.');
        }

        $olimpiade = DB::table('cbt_konfigurasi')->where('konfigurasi_kode', 'olimpiade_aktif')->pluck('konfigurasi_isi')->first();
        $detail_paket = json_decode($request->detail_paket, true);
        $fileName = time().'.'.$request->bukti->extension();  
        $request->bukti->move(public_path('uploads'), $fileName);

        $claim = ClaimUser::insertGetId([
            'user_id' => Auth::user()->user_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'wa' => $request->wa,
            'id_propinsi' => $request->id_propinsi,
            'id_kotakab' => $request->id_kotakab,
            'id_kecamatan' => $request->id_kecamatan,
            'alamat' => $request->alamat,
            'item' => $request->item_val,
            'ongkir' => $request->ongkir_val,
            'discount_claim' => Auth::user()->discount_claim,
            'total' => $request->total_val,
            'bukti' => $fileName,
            'note' => $request->note,
            'olimpiade' => $olimpiade,
        ]);

        foreach($detail_paket as $detail) {
            ClaimUserDetail::create([
                'claim_id' => $claim,
                'nama_tes' => $detail['nama_tes'],
                'paket' => $detail['paket'],
                'harga' => $detail['harga']
            ]);
        }

        return back()->with('success', 'Klaim sukses, tunggu validasi dari admin, jika sudah divalidasi akan dihubungi oleh admin.');
    }
}
