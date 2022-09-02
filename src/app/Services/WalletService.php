<?php

namespace App\Services;

use App\Models\UserWallet;
use App\Models\WalletHistory;

class WalletService
{
    public function canCreateWallet(int $user_id)
    {
        $wallet = UserWallet::query();
        $wallet->where('user_id', $user_id);

        return $wallet->get()->count();
    }

    public function createWallet(int $user_id, string $currency)
    {
        $wallet = UserWallet::create([
            'user_id'  => $user_id,
            'currency' => $currency
        ]);

        return $wallet;
    }

    public function getWalletById($wallet_id)
    {
        return UserWallet::find($wallet_id);
    }

    public function updateWallet(UserWallet $wallet, array $update_data):void
    {
        $wallet->update([
            'amount' => $update_data['operation_type'] === 'debit' ?
                $wallet->amount + $update_data['amount'] :
                $wallet->amount - $update_data['amount']
        ]);

        $this->createHistoryEntity($wallet->id, $update_data);
    }

    public function convertAmountByCurrency(float $sum, $sum_currency, $wallet_currency)
    {
        if ($sum_currency === $wallet_currency) return round($sum, 3);

        if ($sum_currency === 'RUB' && $wallet_currency === 'USD') {
            $result = $sum / config('enums.currency_rate_usd.buy');
        } else {
            $result = $sum * config('enums.currency_rate_usd.sell');
        }

        return round($result, 2);
    }

    private function createHistoryEntity(int $wallet_id, array $data):void
    {
        $entity = new WalletHistory();
        $entity->reason = $data['reason'];
        $entity->operation_type = $data['operation_type'];
        $entity->amount = $data['amount'];
        $entity->wallet_id = $wallet_id;

        $entity->save();
    }
}
