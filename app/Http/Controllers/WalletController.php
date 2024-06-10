<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function showTopUpForm()
    {
        $wallet = Auth::user()->wallet;
        $balance = $wallet ? $wallet->balance : 0;
        return view('pages.topup', compact('balance'));
    }

    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        if (!$wallet) {
            $wallet = Wallet::create([
                'user_id' => $user->id,
                'balance' => 0
            ]);
        }

        $wallet->balance += $request->amount;
        $wallet->save();

        return redirect('/top-up')->with(['success' => 'Saldo berhasil ditambahkan', 'balance' => $wallet->balance]);
    }
}

