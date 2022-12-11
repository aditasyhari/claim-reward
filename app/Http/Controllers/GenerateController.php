<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CbtTesUser;
use Image;
use Auth;

class GenerateController extends Controller
{
    public function certificate(Request $request)
    {
        $user_id = Auth::user()->user_id;
        $tes = CbtTesUser::gettest($user_id);
        $nama = strtolower($request->nama_lengkap);
        $nama = ucwords($nama);
        $certificate = [];
        foreach($tes as $data) {
            $olimpiade = strtoupper($data->mapel_en);
            $img_name = $olimpiade.' - '.$nama.' - '.time().'.jpg';
            $img = Image::make(public_path('img/certificate.jpg'));  
            $img->text($nama, 1930, 1250, function($font) {  
                $font->file(public_path('font/brush-regular.ttf'));  
                $font->size(230);  
                $font->color('#000000');  
                $font->align('center');  
                $font->valign('center');  
            });  
            $img->text($olimpiade, 1950, 1570, function($font) {  
                $font->file(public_path('font/arial-bold.ttf'));  
                $font->size(60);  
                $font->color('#000000');  
                $font->align('center');  
                $font->valign('center');  
            }); 
    
            $img->save(public_path('img/certificate/'.$img_name)); 
            array_push($certificate, $img_name);
        }

        return back()->with(['image' => $certificate]);
    }
}
