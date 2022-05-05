<?php

namespace App\Http\Controllers;
use App\Repositories\Interfaces\TransactionLogRepository;

use Illuminate\Http\Request;

class TransactionLogController extends Controller
{
    protected $transactionLogRepository;

    public function __construct(TransactionLogRepository $transactionLogRepository)
    {
        // $this->middleware('auth:api');
        $this->transactionLogRepository = $transactionLogRepository;
    }

    public function index()
    {
        $transactions = $this->transactionLogRepository->all();
        return response()->json($transactions, 200);
    }

    public function show($id)
    {
        $transaction = $this->transactionLogRepository->findById($id);
        $statusCode = 200;
        if (!$transaction)
            $statusCode = 404;

        return response()->json($transaction, $statusCode);
    }

    public function delete($id)
    {
        $transaction = $this->transactionLogRepository->findById($id);

        $statusCode = 404;
        $message = "Transaction not found!";
        if ($transaction) {
            $this->transactionLogRepository->destroy($id);
            $statusCode = 200;
            $message = "Delete transaction successful!";
        }

        return response()->json($message, $statusCode);
    }

    public function create(Request $request)
    {
        $params = [
            'from' => $request->from ?? null,
            'to' => $request->to ?? null,
            'action' => $request->action ?? null,
            'ethPrice' => $request->ethPrice ?? null,
            'usdPrice' => $request->usdPrice ?? null,
            'tokenId' => (int) $request->tokenId ?? null,
        ];
        $transaction = $this->transactionLogRepository->create($params);
        $statusCode = 200;
        if (!$transaction && !$params)
            $statusCode = 404;
        return response()->json($transaction, $statusCode);
    }

    public function update($id, Request $request)
    {
        $transaction = $this->transactionLogRepository->findById($id);
        if (!$transaction) {
            $statusCode = 404;
            return response()->json('Transaction not found!', $statusCode);
        }
        $params = [
            'from' => $request->from ?? null,
            'to' => $request->to ?? null,
            'action' => $request->action ?? null,
            'ethPrice' => $request->ethPrice ?? null,
            'usdPrice' => $request->usdPrice ?? null,
            'tokenId' => (int) $request->name ?? null,
        ];
        $transaction = $this->transactionLogRepository->update($params, $id);
        $statusCode = 200;
        if (!$transaction && !$params)
            $statusCode = 404;
        $transaction = $this->transactionLogRepository->findById($id);
        return response()->json($transaction, $statusCode);
    }

    public function getByTokenId($tokenId)
    {
        $transaction = $this->transactionLogRepository->getTransactionByTokenId($tokenId);
        return response()->json($transaction, 200);
    }

    public function getByAddress($address)
    {
        $transaction = $this->transactionLogRepository->getTransactionByAddress($address);
        return response()->json($transaction, 200);
    }
}
