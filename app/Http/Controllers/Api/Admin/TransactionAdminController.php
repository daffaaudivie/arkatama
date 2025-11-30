<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionAdminController extends Controller
{
    public function index()
    {
        // ✅ UBAH transactionDetails menjadi details
        $transactions = Transaction::with(['user', 'details.product'])->get();

        return response()->json([
            'success' => true,
            'message' => 'List semua transaksi',
            'data' => $transactions
        ], 200);
    }

    public function show($id)
    {
        // ✅ UBAH transactionDetails menjadi details
        $transaction = Transaction::with(['user', 'details.product'])->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi',
            'data' => $transaction
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            if ($request->hasFile('payment_proof')) {
                if ($transaction->payment_proof) {
                    Storage::disk('public')->delete($transaction->payment_proof);
                }
                
                $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
                $transaction->payment_proof = $paymentProofPath;
            }

            $transaction->status = $request->status;
            $transaction->save();

            $transaction->load(['user', 'details.product']);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil diperbarui',
                'data' => $transaction
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui transaksi',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }

        try {
            DB::beginTransaction();

            // ✅ UBAH transactionDetails menjadi details
            foreach ($transaction->details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->increment('stock', $detail->quantity);
                }
            }

            if ($transaction->payment_proof) {
                Storage::disk('public')->delete($transaction->payment_proof);
            }

            $transaction->details()->delete();
            $transaction->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
{
    $transaction = Transaction::find($id);

    if (!$transaction) {
        return response()->json([
            'success' => false,
            'message' => 'Transaksi tidak ditemukan'
        ], 404);
    }

    // Ambil status dari semua source: JSON, form-data, query
    $status = $request->get('status') ?? $request->input('status');

    // Validasi manual
    $validator = \Validator::make(['status' => $status], [
        'status' => 'required|in:pending,paid,cancelled',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $validator->errors()
        ], 422);
    }

    $transaction->update(['status' => $status]);

    $transaction->load(['user', 'details.product']);

    return response()->json([
        'success' => true,
        'message' => 'Status transaksi berhasil diperbarui',
        'data' => $transaction
    ], 200);
}



    public function getByUser($userId)
    {
        $transactions = Transaction::with(['user', 'details.product'])
                                 ->where('user_id', $userId)
                                 ->get();

        return response()->json([
            'success' => true,
            'message' => 'List transaksi user',
            'data' => $transactions
        ], 200);
    }
}