<?php

namespace App\Http\Repositories;

use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionRepository
{
    public function getTransactionsForUser($user)
    {
        $query = Transaction::with('details.product');

        if (!$user instanceof \App\Models\Admin) {
            $query->where('user_id', $user->id);
        }

        return $query->get();
    }
}
