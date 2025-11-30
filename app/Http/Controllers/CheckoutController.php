<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Halaman checkout (Buy Now Page)
     */
    public function paymentPage(Request $request)
    {
        $product  = Product::findOrFail($request->product_id);
        $quantity = $request->quantity ?? 1;

        return view('user.payment', compact('product', 'quantity'));
    }

    /**
     * Proses checkout & simpan transaksi
     */
    public function checkoutConfirm(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product  = Product::findOrFail($request->product_id);
        $quantity = (int) $request->quantity;

        /** 
         * Cek stok cukup
         */
        if ($product->stock < $quantity) {
            return back()->with('error', 'Stock tidak mencukupi.');
        }

        /**
         * Hitung total
         */
        $subtotal = $product->price * $quantity;

        /**
         * Simpan transaksi utama
         */
        $transaction = Transaction::create([
            'user_id'      => Auth::id(),
            'total_price'  => $subtotal,
            'subtotal'     => $subtotal,
            'status'       => 'pending',
        ]);

        /**
         * Simpan detail transaksi
         */
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'quantity'       => $quantity,
            'price_per_item' => $product->price,
            'subtotal'       => $subtotal,
        ]);

        /**
         * Kurangi stok produk
         */
        $product->decrement('stock', $quantity);

        /**
         * Redirect ke halaman upload bukti bayar
         */
        return redirect()
            ->route('user.checkout.confirm_payment', $transaction->id)
            ->with('success', 'Transaksi berhasil dibuat. Silakan upload bukti pembayaran.');
    }

    /**
     * Halaman upload bukti pembayaran
     */
    public function confirmPayment(Transaction $transaction)
    {
    return view('user.transactions.confirm_payment', compact('transaction'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadPayment(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        $file = $request->file('payment_proof')->store('payment_proofs', 'public');

        $transaction->update([
            'payment_proof' => $file,
            'status'        => 'pending',
        ]);

        return redirect()->route('user.transactions.index')
                         ->with('success', 'Bukti pembayaran berhasil diunggah!');
    }
}
