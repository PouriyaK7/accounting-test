<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
    private ?Transaction $transaction;

    public function setTransaction($transaction): bool
    {
        if (filter_var($transaction, FILTER_VALIDATE_INT))
            $this->transaction = Transaction::find($transaction);
        else
            $this->transaction = $transaction;
        return (bool)$this->transaction;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function create(
        int    $personID,
        int    $methodID,
        int    $cash,
        int    $borrow,
        int    $userID = null,
        string $title = null,
        string $description = null
    ): bool
    {
        $transaction = Transaction::create([
            'person_id'         => $personID,
            'payment_method_id' => $methodID,
            'amount'            => $cash + $borrow,
            'cash'              => $cash,
            'borrow'            => $borrow,
            'user_id'           => $userID ?? Auth::id(),
            'title'             => $title,
            'description'       => $description
        ]);
        if (!$transaction) return false;
        $this->setTransaction($transaction);
        return true;
    }

    public function update(
        int    $personID,
        int    $methodID,
        int    $cash,
        int    $borrow,
        int    $userID = null,
        string $title = null,
        string $description = null
    ): bool
    {
        return $this->getTransaction()->update([
            'person_id'         => $personID,
            'payment_method_id' => $methodID,
            'amount'            => $cash + $borrow,
            'cash'              => $cash,
            'borrow'            => $borrow,
            'title'             => $title,
            'description'       => $description
        ]);
    }

    public function delete(): bool
    {
        return $this->getTransaction()->delete();
    }
}
