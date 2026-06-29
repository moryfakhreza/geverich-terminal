<?php

date_default_timezone_set("Asia/Jakarta");

$day = date("N"); // 1=Senin ... 7=Minggu
$isWeekend = ($day >= 6);

$sessions = [
    [
        "name" => "Sydney",
        "start" => "04:00",
        "end" => "13:00"
    ],
    [
        "name" => "Tokyo",
        "start" => "06:00",
        "end" => "15:00"
    ],
    [
        "name" => "London",
        "start" => "14:00",
        "end" => "23:00"
    ],
    [
        "name" => "New York",
        "start" => "19:00",
        "end" => "04:00"
    ]
];

function isOpen($start,$end){

    $now = strtotime(date("H:i"));

    $s = strtotime($start);
    $e = strtotime($end);

    if($e < $s){
        return ($now >= $s || $now < $e);
    }

    return ($now >= $s && $now < $e);
}

$current="None";

?>

<div class="card">

<div class="panel-title">

MARKET SESSIONS (WIB)

</div>

<div class="panel-content">

<?php foreach($sessions as $s):

$status="CLOSED";
$class="session-close";
$icon="🔴";

if($isWeekend){

    $status="WEEKEND";
    $class="session-weekend";
    $icon="⚫";

}else{

    if(isOpen($s['start'],$s['end'])){

        $status="OPEN";
        $class="session-open";
        $icon="🟢";

        if($current=="None"){
            $current=$s['name'];
        }

    }

}

?>

<div class="session-row">

<div>

<?= $icon ?>

<strong><?= $s['name'] ?></strong>

<div class="session-time">

<?= $s['start'] ?> - <?= $s['end'] ?> WIB

</div>

</div>

<div class="<?= $class ?>">

<?= $status ?>

</div>

</div>

<?php endforeach;?>

<hr>

<div class="session-footer">

<div>

Current Session

</div>

<strong>

<?= $current ?>

</strong>

</div>

<div class="session-footer">

<div>

Market Status

</div>

<strong class="<?= $isWeekend?'session-weekend':'session-open' ?>">

<?= $isWeekend?'CLOSED':'OPEN' ?>

</strong>

</div>

<div class="session-footer">

<div>

Countdown

</div>

<strong id="countdown">

--:--:--

</strong>

</div>

</div>

</div>