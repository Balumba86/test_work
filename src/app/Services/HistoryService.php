<?php

namespace App\Services;

use App\Models\WalletHistory;
use Carbon\Carbon;

class HistoryService
{
    public function getHistory(string $reason):float
    {
        $query = WalletHistory::query();
        $query->where('reason', $reason);
        $query->where('operation_type', 'debit');
        $query->whereDate('created_at','>=' , Carbon::now()->subDays(7));

        return $query->sum('amount');
    }
}
