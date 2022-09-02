<?php

namespace App\Http\Controllers;

use App\Dto\ErrorResponse;
use App\Http\Resources\BalanceResource;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\UserWalletResource;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    private $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'currency' => [
                'required',
                Rule::in(config('enums.currencies'))
            ],
        ]);

        if ($this->walletService->canCreateWallet($request->user()->id)) {
            $error = new ErrorResponse();
            $error->setMessage('Можно создать не более одного кошелька');

            return new ResponseResource($error);
        }

        $wallet = $this->walletService->createWallet($request->user()->id, $validatedData['currency']);

        return new UserWalletResource($wallet);
    }

    public function get($wallet_id = null)
    {
        $wallet = $this->walletService->getWalletById($wallet_id);

        if (!$wallet) {
            $error = new ErrorResponse();
            $error->setMessage('Кошелёк не найден');

            return new ResponseResource($error);
        }

        return new BalanceResource($wallet);
    }

    public function update(Request $request, $wallet_id = null)
    {
        if (
            !$wallet_id ||
            !$wallet = $this->walletService->getWalletById($wallet_id)
        ) {
            $error = new ErrorResponse();
            $error->setMessage('Кошелёк не найден');

            return new ResponseResource($error);
        }

        $validatedData = $request->validate([
            'operation_type' => [
                'required',
                Rule::in(config('enums.operation_types'))
            ],
            'currency' => [
                'required',
                Rule::in(config('enums.currencies'))
            ],
            'amount' => [
                'required',
                'numeric',
                'min:0.1'
            ],
            'reason' => [
                'required',
                Rule::in(config('enums.reasons'))
            ]
        ]);

        $validatedData['amount'] = $this->walletService->convertAmountByCurrency((float) $validatedData['amount'], $validatedData['currency'], $wallet->currency);

        if ($validatedData['operation_type'] === 'credit' && $wallet->amount < $validatedData['amount']) {
            $error = new ErrorResponse();
            $error->setMessage('На балансе недостаточно средств для списания!');

            return new ResponseResource($error);
        }

        $this->walletService->updateWallet($wallet, $validatedData);

        return new UserWalletResource(
            $this->walletService->getWalletById($wallet->id)
        );
    }
}
