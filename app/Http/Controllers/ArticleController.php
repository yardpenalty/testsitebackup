<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use DB;
use resources\views;
class ArticleController extends Controller
{
	public function __construct() {
      //  $this->middleware('auth');
    }
	function index($id){
		$article = Article::where('user_id', '=',  $id)->firstOrFail();
		//dd($article);
    return view('article.show', compact('article'));
	}
}
