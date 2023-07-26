<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\KafkaService;
use App\Http\Resources\TransactionResource;
use RdKafka\Conf;
use RdKafka\Producer;

class TransactionController extends Controller
{
    protected $kafka;

    public function __construct(KafkaService $kafka)
    {
        $this->kafka = $kafka;
    }
    
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    public function store(Request $request)
    {
        $transaction = new Transaction;
        $transaction->payer = $request->payer;
        $transaction->payee = $request->payee;
        $transaction->amount = $request->amount;
        $transaction->save();

        $message = json_encode($transaction->toArray());
        $this->kafka->send($message);

        return response()->json(new TransactionResource($transaction), 201);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->payer = $request->payer;
        $transaction->payee = $request->payee;
        $transaction->amount = $request->amount;
        $transaction->save();

        $conf = new Conf();
        $producer = new Producer($conf);
        $topic = $producer->newTopic("transactions");

        $message = json_encode($transaction->toArray());
        $topic->produce(\RD_KAFKA_PARTITION_UA, 0, $message);

        return response()->json($transaction);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        $conf = new Conf();
        $producer = new Producer($conf);
        $topic = $producer->newTopic("transactions");

        $message = json_encode(['transaction_id' => $id, 'status' => 'deleted']);
        $topic->produce(\RD_KAFKA_PARTITION_UA, 0, $message);

        return response()->json(null, 204);
    }
}



