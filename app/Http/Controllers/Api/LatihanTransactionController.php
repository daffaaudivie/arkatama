<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Http\Repositories\TransactionRepository;
Use App\Http\Services\TransactionService;
use Illuminate\Http\Request;

class LatihanTransactionController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(TransactionRepository $repository, TransactionService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    // Create → hanya user
    public function store(TransactionRequest $request)
    {
        $user = $request->user();
        if ($user instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Admin tidak bisa membuat transaksi'], 403);
        }

        $transaction = $this->service->createTransaction($user, $request->items, $request->file('payment_proof'));
        return new TransactionResource($transaction->load('details.product'));
    }

    // Index → user lihat miliknya, admin lihat semua
    public function index(Request $request)
    {
        $filters = $request->only(['search']);

        $user = $request->user();
        $transactions = $this->repository->getTransactionsForUser($user, $filters);
        return TransactionResource::collection($transactions);
    }

    public function show($id)
    {
        $transaction = $this->repository->find($id);

        return new TransactionResource($transaction->load('details.product'));
    }


    // Update → hanya admin
    public function update(Request $request, $id)
    {
        $user = $request->user();
        if (!$user instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Hanya admin yang bisa mengubah transaksi'], 403);
        }

        $transaction = $this->repository->find($id);
        $updated = $this->service->updateTransaction($transaction, $request->all());
        return response()->json($updated);
    }

    // Delete → hanya admin
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        if (!$user instanceof \App\Models\Admin) {
            return response()->json(['message' => 'Hanya admin yang bisa menghapus transaksi'], 403);
        }

        $transaction = $this->repository->find($id);
        $this->repository->delete($transaction);

        return response()->json(['message' => 'Transaksi berhasil dihapus']);
    }
}
