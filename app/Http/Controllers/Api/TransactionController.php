<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    // GET /Transaction  → tampilkan semua Transaction
    public function index()
    {
        $transactions = Transaction::all();

        return response()->json([
            'success' => true,
            'message' => 'List all transaction',
            'data' => $transactions
        ], 200);
    }

    // GET /product/{id} → tampilkan 1 product berdasarkan ID
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Transaction',
            'data' => $transaction
        ], 200);
    }
}
