<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userAccount = User::all();
        $countUser = count($userAccount);
        
        $countStock = Produk::sum('stock');

        $countProduct = count(Produk::all()); 

        return view("pages.home", compact("countUser", "countStock", "countProduct"));
    }
}
