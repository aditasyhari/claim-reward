<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Auth;

class GenerateController extends Controller
{
    public function certificate(Request $request)
    {
        $nama = strtolower(Auth::user()->user_firstname);
        $nama = ucwords($nama);
        $img_name = time().'.jpg';
        $img = Image::make(public_path('img/certificate-neso.jpg'));  
        $img->text($nama, 1700, 1100, function($font) {  
            $font->file(public_path('font/great-vibes-regular.ttf'));  
            $font->size(230);  
            $font->color('#093F6D');  
            $font->align('center');  
            $font->valign('center');  
        });  

        $img->save(public_path('img/certificate/'.$img_name)); 

        return back()->with(['img_name' => $img_name]);
    }
}
