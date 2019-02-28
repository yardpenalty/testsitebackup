<?php

namespace App\Http\Composers;

use App\User;
use App\Active_role;
use App\Role;
use App\Creditunion;
use Auth;
use Illuminate\Contracts\View\View;

class DefaultData{
    public function compose(View $view){
    /*    $active_cu = [];
        if (!Auth::check()){
            $view->with('active_cu', $active_cu);
            return;
        }
        
        if (session()->has('active_cu')){
            $view->with('active_cu', session()->get('active_cu'));
            return;
        }
        
        if (Auth::user()->isAdmin() || Auth::user()->isCSR()){
            $active_cu = Creditunion::where('CUAHB', Auth::user()->default_credit_union)->first();
            session()->put('active_cu', $active_cu);
            $view->with('active_cu', $active_cu);
            return;
        }
        
        if ($creditunion = Auth::user()->firstCreditunion()){
            session()->put('active_cu', $creditunion);
            $view->with('active_cu', $creditunion);
            return;
        }
        
        $view->with('active_cu', $active_cu);*/
        return;
    }
    
}