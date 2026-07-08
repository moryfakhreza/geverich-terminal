<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../helpers/TradeCalculator.php';
require_once __DIR__ . '/../repositories/TradeRepository.php';

class TradeService
{
    private TradeRepository $repository;

    public function __construct()
    {
        $this->repository = new TradeRepository();
    }

    public function create(array $post): bool
    {
        $result = TradeCalculator::calculateResult(
            $post['direction'],
            $post['entry_price'],
            $post['exit_price']
        );

        $rr = TradeCalculator::calculateRR(
            $post['direction'],
            $post['entry_price'],
            $post['sl'],
            $post['tp']
        );

        $data = [
            ":user_id" => $_SESSION['user_id'],

            ":tanggal" => $post["tanggal"],

            ":pair" => $post["pair"],

            ":direction" => $post["direction"],

            ":entry_price" =>
                $post["entry_price"] !== ""
                ? $post["entry_price"]
                : null,

            ":sl" =>
                $post["sl"] !== ""
                ? $post["sl"]
                : null,

            ":tp" =>
                $post["tp"] !== ""
                ? $post["tp"]
                : null,

            ":exit_price" =>
                $post["exit_price"] !== ""
                ? $post["exit_price"]
                : null,

            ":lot" =>
                $post["lot"] !== ""
                ? $post["lot"]
                : null,

            ":profit_usd" =>
                $post["profit_usd"] !== ""
                ? $post["profit_usd"]
                : 0,

            ":hasil" => $result,

            ":emotion" => $post["emotion"],

            ":strategy" => $post["strategy"],

            ":rr" => $rr,

            ":note" => $post["note"]

        ];

        return $this->repository->create($data);
    }
    
    public function update(array $post): bool
{
    $result = TradeCalculator::calculateResult(
        $post['direction'],
        $post['entry_price'],
        $post['exit_price']
    );

    $rr = TradeCalculator::calculateRR(
        $post['direction'],
        $post['entry_price'],
        $post['sl'],
        $post['tp']
    );

    $data = [

        ":id" => $post["id"],

            ":user_id" => $_SESSION['user_id'],

        ":tanggal" => $post["tanggal"],

        ":pair" => $post["pair"],

        ":direction" => $post["direction"],

        ":entry_price" =>
            $post["entry_price"] !== ""
            ? $post["entry_price"]
            : null,

        ":sl" =>
            $post["sl"] !== ""
            ? $post["sl"]
            : null,

        ":tp" =>
            $post["tp"] !== ""
            ? $post["tp"]
            : null,

        ":exit_price" =>
            $post["exit_price"] !== ""
            ? $post["exit_price"]
            : null,

        ":lot" =>
            $post["lot"] !== ""
            ? $post["lot"]
            : null,

        ":profit_usd" =>
            $post["profit_usd"] !== ""
            ? $post["profit_usd"]
            : 0,

        ":hasil" => $result,

        ":emotion" => $post["emotion"],

        ":strategy" => $post["strategy"],

        ":rr" => $rr,

        ":note" => $post["note"]

    ];

    return $this->repository->update($data);
}

}