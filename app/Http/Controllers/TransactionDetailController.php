<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Enums\TransactionStatus;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionDetailController extends Controller
{
    public function index()
    {
        $details = TransactionDetail::with('transaction.user','product')->paginate(10);
        return view('transaction_details.index', compact('details'));
    }

    public function create()
    {
        $transactions = Transaction::all();
        $products = Product::all();
        return view('transaction_details.create', compact('transactions','products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id'=>'required|exists:transactions,id',
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer',
            'price_per_item'=>'required|numeric',
            'subtotal'=>'required|numeric',
        ]);

        TransactionDetail::create($request->all());
        return redirect()->route('transaction-details.index')->with('success','Detail transaksi berhasil ditambahkan');
    }

    public function edit(TransactionDetail $transactionDetail)
    {
        $transactions = Transaction::all();
        $products = Product::all();
        return view('transaction_details.edit', compact('transactionDetail','transactions','products'));
    }

    public function update(Request $request, TransactionDetail $transactionDetail)
    {
        $request->validate([
            'transaction_id'=>'required|exists:transactions,id',
            'product_id'=>'required|exists:products,id',
            'quantity'=>'required|integer',
            'price_per_item'=>'required|numeric',
            'subtotal'=>'required|numeric',
        ]);

        $transactionDetail->update($request->all());
        return redirect()->route('transaction-details.index')->with('success','Detail transaksi berhasil diperbarui');
    }

    public function destroy(TransactionDetail $transactionDetail)
    {
        $transactionDetail->delete();
        return redirect()->route('transaction-details.index')->with('success','Detail transaksi berhasil dihapus');
    }
}
