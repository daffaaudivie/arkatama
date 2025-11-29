<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        return view('transactions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'total_price'=>'required|numeric',
            'status'=>'required|in:pending,paid,cancelled',
        ]);

        Transaction::create($request->all());
        return redirect()->route('transactions.index')->with('success','Transaksi berhasil ditambahkan');
    }

    public function edit(Transaction $transaction)
    {
        $users = User::all();
        return view('transactions.edit', compact('transaction','users'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id'=>'required|exists:users,id',
            'total_price'=>'required|numeric',
            'status'=>'required|in:pending,paid,cancelled',
        ]);

        $transaction->update($request->all());
        return redirect()->route('transactions.index')->with('success','Transaksi berhasil diperbarui');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success','Transaksi berhasil dihapus');
    }
}
