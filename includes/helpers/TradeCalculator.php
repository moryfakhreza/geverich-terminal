<?php

class TradeCalculator
{
    /**
     * Menghitung hasil trade
     */
    public static function calculateResult($direction, $entry, $exit)
    {
        if ($entry == "" || $exit == "") {
            return "";
        }

        $entry = (float)$entry;
        $exit  = (float)$exit;

        if ($direction === "BUY") {

            if ($exit > $entry) {
                return "WIN";
            }

            if ($exit < $entry) {
                return "LOSS";
            }

            return "BE";
        }

        if ($direction === "SELL") {

            if ($exit < $entry) {
                return "WIN";
            }

            if ($exit > $entry) {
                return "LOSS";
            }

            return "BE";
        }

        return "";
    }

    /**
     * Menghitung Risk Reward
     */
    public static function calculateRR($direction, $entry, $sl, $tp)
    {
        if (
            $entry == "" ||
            $sl == "" ||
            $tp == ""
        ) {
            return 0;
        }

        $entry = (float)$entry;
        $sl    = (float)$sl;
        $tp    = (float)$tp;

        if ($direction === "BUY") {

            $risk = abs($entry - $sl);

            $reward = abs($tp - $entry);

        } else {

            $risk = abs($sl - $entry);

            $reward = abs($entry - $tp);

        }

        if ($risk <= 0) {
            return 0;
        }

        return round($reward / $risk, 2);
    }
    
    
}