<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Enums\TransactionStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Halaman daftar transaksi (Admin & User)
     */
    public function index()
    {
        // Admin route
        if (request()->is('admin/*')) {
            $transactions = Transaction::with('details', 'user')
                ->latest()
                ->paginate(10);

            return view('admin.transactions.transaction_index', compact('transactions'));
        }

        // User route
        $transactions = Transaction::with('details')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.transactions.transaction_index', compact('transactions'));
    }

    /**
     * Halaman create transaksi (Admin)
     */
    public function create()
    {
        $users = User::all();
        return view('admin.transactions.transaction_create', compact('users'));
    }

    /**
     * Simpan transaksi (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status'      => ['required', new Enum(TransactionStatus::class)],
        ]);

        Transaction::create([
            'user_id'     => $request->user_id,
            'total_price' => $request->total_price,
            'status'      => TransactionStatus::from($request->status),
        ]);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    /**
     * Halaman edit transaksi (Admin)
     */
    public function edit(Transaction $transaction)
    {
        $users = User::all();
        return view('admin.transactions.transaction_edit', compact('transaction', 'users'));
    }

    /**
     * Update transaksi (Admin)
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status'      => ['required', new Enum(TransactionStatus::class)],
        ]);

        $transaction->update([
            'user_id'     => $request->user_id,
            'total_price' => $request->total_price,
            'status'      => TransactionStatus::from($request->status),
        ]);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    /**
     * Update status transaksi (Admin)
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => ['required', new Enum(TransactionStatus::class)],
        ]);

        $transaction->update([
            'status' => TransactionStatus::from($request->status),
        ]);

        return back()->with('success', 'Status transaksi diperbarui.');
    }

    /**
     * Delete transaksi (Admin)
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    /**
     * Halaman upload bukti pembayaran (User)
     */
    public function confirmPayment(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('user.transactions.confirm_payment', compact('transaction'));
    }

    /**
     * Upload bukti pembayaran (User)
     */
    public function uploadPayment(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('payment_proof');
        $path = $file->store('payment_proofs', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status'        => TransactionStatus::PENDING,
        ]);

        return redirect()
            ->route('user.transactions.index')
            ->with('success', 'Payment proof uploaded successfully! Waiting for verification.');
    }

    /**
     * Detail transaksi (Admin)
     */
    public function productDetail(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');

        return view('admin.transactions.transaction_detail', compact('transaction'));
    }

    /**
     * Detail transaksi (User)
     */
    public function productDetailUser(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');

        return view('user.transactions.transaction_detail', compact('transaction'));
    }
}
