<?php

namespace App\Http\Controllers;

use App\Dto\SumHistoryResponse;
use App\Http\Resources\ResponseResource;
use App\Services\HistoryService;
use Illuminate\Http\Request;

class WalletHistoryController extends Controller
{
    private $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function getHistory($reason = null)
    {
        if (!$reason) $reason = 'refund';

        $response = new SumHistoryResponse();
        $response->setReason($reason);
        $response->setSum($this->historyService->getHistory($reason));

        return new ResponseResource($response);
    }
}
