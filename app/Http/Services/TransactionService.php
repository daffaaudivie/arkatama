<?php

namespace App\Http\Services;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    // Buat transaksi
    public function createTransaction($user, $items, $paymentProof = null)
    {
        DB::beginTransaction();
        try {
            $totalPrice = 0;
            $transactionData = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock {$product->name} tidak mencukupi");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalPrice += $subtotal;

                $transactionData[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price_per_item' => $product->price,
                    'subtotal' => $subtotal
                ];
            }

            $paymentProofPath = null;
            if ($paymentProof) {
                $paymentProofPath = $paymentProof->store('payment_proofs', 'public');
            }

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_proof' => $paymentProofPath
            ]);

            foreach ($transactionData as $item) {
                $transaction->details()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price_per_item' => $item['price_per_item'],
                    'subtotal' => $item['subtotal']
                ]);

                $item['product']->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return $transaction;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // Update transaksi (misal status)
    public function updateTransaction($transaction, $data)
    {
        $transaction->update($data);
        return $transaction;
    }
}
