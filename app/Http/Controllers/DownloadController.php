<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download(Request $request){
		
		  return response()->download("/assets/images/","0.jpg");
	}
	
	
}
