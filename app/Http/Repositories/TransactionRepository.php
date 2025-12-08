<?php

namespace App\Http\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    // Ambil semua transaksi (untuk admin)
    public function allWithDetails()
    {
        return Transaction::with(['details.product', 'user'])->get();
    }

    // Ambil transaksi untuk user tertentu
    public function getTransactionsForUser($user, $filters = [])
    {
        $query = Transaction::with('details.product');

        // Jika bukan admin, batasi hanya transaksi miliknya
        if (!$user instanceof \App\Models\Admin) {
            $query->where('user_id', $user->id);
        }

        // Terapkan filter
        $query = $this->applyFilters($query, $filters);

        return $query->get();
    }

    // Temukan transaksi berdasarkan id
    public function find($id)
    {
        return Transaction::findOrFail($id);
    }

    // Hapus transaksi
    public function delete($transaction)
    {
        return $transaction->delete();
    }

    private function applyFilters($query, array $filters)
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('transaction_code', 'LIKE', "%{$search}%")
                  ->orWhereHas('details.product', function ($p) use ($search) {
                      $p->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }
        
    }

}
