<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
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

            // Admin melihat semua transaksi
            $transactions = Transaction::with('details', 'user')
                ->latest()
                ->paginate(10);

            return view('admin.transactions.transaction_index', compact('transactions'));
        }

        // User route
        $transactions = Transaction::with('details')
            ->where('user_id', Auth::id())   // hanya transaksi user login
            ->latest()
            ->paginate(12);

        return view('user.transactions.transaction_index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.transactions.transaction_create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status'      => 'required|in:pending,paid,cancelled',
        ]);

        Transaction::create($request->all());

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function edit(Transaction $transaction)
    {
        $users = User::all();
        return view('admin.transactions.transaction_edit', compact('transaction', 'users'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'status'      => 'required|in:pending,paid,cancelled,waiting_verification',
        ]);

        $transaction->update($request->all());

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,waiting_verification,paid,cancelled'
        ]);

        $transaction->update(['status' => $request->status]);

        return back()->with('success', 'Status transaksi diperbarui.');
    }

    /**
     * Admin delete
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }
}
