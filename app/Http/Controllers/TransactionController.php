<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showPurchaseForm()
    {
        return view('purchase');
    }
    public function purchase(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet || $wallet->balance < $request->amount) {
            return redirect('/purchase')->with('error', 'Saldo tidak mencukupi');
        }

        // Kurangi saldo
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Logika untuk menyimpan detail transaksi

        return redirect('/purchase')->with('success', 'Transaksi berhasil');
    }
}
