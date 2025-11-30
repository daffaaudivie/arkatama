<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            $transactionData = [];

            // ✅ UBAH: $request->products → $request->items
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                
                if (!$product) {
                    throw new \Exception("Produk dengan ID {$item['product_id']} tidak ditemukan");
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock {$product->name} tidak mencukupi. Stock tersedia: {$product->stock}");
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

            // Handle upload payment proof
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $file = $request->file('payment_proof');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $paymentProofPath = $file->storeAs('payment_proofs', $filename, 'public');
            }

            // Buat transaksi
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_proof' => $paymentProofPath
            ]);

            // Buat detail transaksi dan update stock
            foreach ($transactionData as $item) {
                // Buat transaction detail
                $transaction->details()->create([
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price_per_item' => $item['price_per_item'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update stock produk
                $item['product']->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Load relationship untuk response
            $transaction->load(['details.product', 'user']);

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat',
                'data' => [
                    'transaction_id' => $transaction->id,
                    'total_price' => $transaction->total_price,
                    'status' => $transaction->status,
                    'payment_proof' => $transaction->payment_proof ? asset('storage/' . $transaction->payment_proof) : null,
                    'created_at' => $transaction->created_at->format('d M Y H:i'),
                    'items' => $transaction->details->map(function ($detail) {
                        return [
                            'product_name' => $detail->product->name,
                            'quantity' => $detail->quantity,
                            'price_per_item' => $detail->price_per_item,
                            'subtotal' => $detail->subtotal
                        ];
                    })
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Transaction store error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi',
                'error' => $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }
    // GET /transactions/my → tampilkan transaksi user yang sedang login
    public function myTransactions()
    {
        $userId = auth()->id();
        
        $transactions = Transaction::with(['user', 'details.product'])
                                ->where('user_id', $userId)
                                ->orderBy('created_at', 'desc') // tambahan untuk urutan terbaru
                                ->get();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi saya',
            'data' => $transactions
        ], 200);
    }

    // GET /transactions/status/{status} → filter berdasarkan status
    public function getByStatus($status)
    {
        $validStatus = ['pending', 'paid', 'cancelled'];
        
        if (!in_array($status, $validStatus)) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid. Gunakan: pending, paid, atau cancelled'
            ], 400);
        }

        $transactions = Transaction::with(['user', 'transactionDetails.product'])
                                 ->where('status', $status)
                                 ->get();

        return response()->json([
            'success' => true,
            'message' => "List transaksi dengan status {$status}",
            'data' => $transactions
        ], 200);
    }
}