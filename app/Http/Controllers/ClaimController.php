<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CbtTesUser;
use App\Models\ClaimUser;
use App\Models\ClaimUserDetail;
use Validator;
use Auth;

class ClaimController extends Controller
{
    public function dashboard()
    {
        $user_id = Auth::user()->user_id;
        $tes = CbtTesUser::gettest($user_id);

        return view('claim.dashboard', compact('tes'));
    }

    public function claim(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'nama'      => 'required',
            'alamat'    => 'required',
            'email'     => 'required|email',
            'wa'        => 'required|numeric',
            'bukti'     => 'required|max:2048',
            'item_val'      => 'required',
            'ongkir_val'    => 'nullable',
            'total_val'     => 'required',
            'detail_paket'  => 'required',
            'note'      => 'nullable',
        ]);

        if ($validateData->fails()) {
            return back()->with('error', 'Pastikan semua terisi dengan benar.');
        }

        $detail_paket = json_decode($request->detail_paket, true);

        $fileName = time().'.'.$request->bukti->extension();  
   
        $request->bukti->move(public_path('uploads'), $fileName);

        $claim = ClaimUser::insertGetId([
            'user_id' => Auth::user()->user_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'wa' => $request->wa,
            'alamat' => $request->alamat,
            'item' => $request->item_val,
            'ongkir' => $request->ongkir_val,
            'total' => $request->total_val,
            'bukti' => $fileName,
            'note' => $request->note
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
