<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Http\Repositories\TransactionRepository;
use Illuminate\Support\Facades\Storage;

class LatihanTransactionController extends Controller
{

    protected $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = $this->transactionRepo->getTransactionsForUser($user);

        return TransactionResource::collection($transactions);
    }


    public function store(Request $request)
    {

    }

    public function show(string $id)
    {

    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
