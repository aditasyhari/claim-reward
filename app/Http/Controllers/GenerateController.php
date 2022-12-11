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
        $img = Image::make(public_path('img/certificate-osn.jpg'));  
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

        return back()->with(['img_name' => $img_name]);
    }
}
