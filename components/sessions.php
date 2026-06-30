<?php

date_default_timezone_set("Asia/Jakarta");

$now = time();
$day = date("N");
$isWeekend = ($day >= 6);

// SESSION ORDER FLOW
$order = ["Sydney", "Tokyo", "London", "New York"];

// SESSION DATA
$sessions = [
    "Sydney" => ["start" => "04:00", "end" => "13:00"],
    "Tokyo"  => ["start" => "06:00", "end" => "15:00"],
    "London" => ["start" => "14:00", "end" => "23:00"],
    "New York" => ["start" => "19:00", "end" => "04:00"]
];

// CHECK SESSION OPEN
function isOpenSession($start, $end, $now)
{
    $startTS = strtotime(date("Y-m-d") . " " . $start);
    $endTS   = strtotime(date("Y-m-d") . " " . $end);

    // overnight session (NY)
    if ($endTS < $startTS) {
        return ($now >= $startTS || $now < $endTS);
    }

    return ($now >= $startTS && $now < $endTS);
}

// ==========================
// CURRENT SESSION DETECTION
// ==========================
$current = "None";

foreach ($order as $name) {

    if (!$isWeekend && isOpenSession($sessions[$name]['start'], $sessions[$name]['end'], $now)) {
        $current = $name;
        break;
    }
}

// ==========================
// NEXT SESSION DETECTION (FIXED)
// ==========================
$nextSession = null;
$nextTime = null;

// cari session berikutnya di hari ini
foreach ($order as $name) {

    $start = $sessions[$name]['start'];
    $ts = strtotime(date("Y-m-d") . " " . $start);

    if ($ts > $now) {
        $nextSession = $name;
        $nextTime = $ts;
        break;
    }
}

// kalau tidak ada → berarti besok cycle pertama
if ($nextSession === null) {
    $nextSession = "Sydney";
    $nextTime = strtotime("tomorrow " . $sessions["Sydney"]["start"]);
}

// ==========================
// COUNTDOWN
// ==========================
$diff = $nextTime - $now;

$hours = floor($diff / 3600);
$minutes = floor(($diff % 3600) / 60);
$seconds = $diff % 60;

// market status
$marketStatus = $isWeekend ? "CLOSED" : "OPEN";

?>

<div class="card">

    <div class="panel-title">
        MARKET SESSIONS (WIB)
    </div>

    <div class="panel-content">

        <?php foreach ($sessions as $name => $s): ?>

            <?php
            $status = "CLOSED";
            $class = "session-close";
            $icon = "🔴";

            if ($isWeekend) {

                $status = "WEEKEND";
                $class = "session-weekend";
                $icon = "⚫";
            } else {

                if (isOpenSession($s['start'], $s['end'], $now)) {
                    $status = "OPEN";
                    $class = "session-open";
                    $icon = "🟢";
                }
            }
            ?>

            <div class="session-row">

                <div>
                    <?= $icon ?>
                    <strong><?= $name ?></strong>

                    <div class="session-time">
                        <?= $s['start'] ?> - <?= $s['end'] ?> WIB
                    </div>
                </div>

                <div class="<?= $class ?>">
                    <?= $status ?>
                </div>

            </div>

        <?php endforeach; ?>

        <hr>

        <!-- CURRENT SESSION -->
        <div class="session-footer">
            <div>Current Session</div>
            <strong><?= $current ?></strong>
        </div>

        <!-- NEXT SESSION (NEW FEATURE) -->
        <div class="session-footer">
            <div>Next Session</div>
            <strong><?= $nextSession ?></strong>
        </div>

        <!-- MARKET STATUS -->
        <div class="session-footer">
            <div>Market Status</div>
            <strong class="<?= $isWeekend ? 'session-weekend' : 'session-open' ?>">
                <?= $marketStatus ?>
            </strong>
        </div>

        <!-- COUNTDOWN -->
        <div class="session-footer">
            <div>Countdown</div>
            <strong id="countdown">
                <?= sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds) ?>
            </strong>
        </div>

    </div>

</div>
<script>
    const nextTime = <?= $nextTime * 1000 ?>;

    function updateCountdown() {

        const now = new Date().getTime();
        const diff = nextTime - now;

        if (diff <= 0) {
            document.getElementById("countdown").innerText = "00:00:00";
            return;
        }

        const h = Math.floor(diff / (1000 * 60 * 60));
        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((diff % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerText =
            `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();
</script>