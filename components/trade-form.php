<div class="card">

    <div class="panel-title">

        <?= $mode == "create" ? "NEW TRADE" : "EDIT TRADE" ?>

    </div>

    <div class="panel-content">

        <form
            action="<?= $mode == "create"
                ? "pages/save-trade.php"
                : "pages/update-trade.php" ?>"
            method="POST">

            <?php if($mode=="edit"): ?>

                <input
                    type="hidden"
                    name="id"
                    value="<?= $trade['id'] ?>">

            <?php endif; ?>
            
            <div class="form-group">

    <label>Date</label>

    <input
        type="date"
        name="tanggal"
        value="<?= $trade['tanggal'] ?>"
        required>

</div>

<div class="form-group">

<label>Pair</label>

<select name="pair">

<?php

$pairs=[
"XAU/USD",
"XAG/USD",
"EUR/USD",
"GBP/USD",
"USD/JPY"
];

foreach($pairs as $pair):

?>

<option
value="<?= $pair ?>"
<?= $trade['pair']==$pair ? 'selected' : '' ?>>

<?= $pair ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="form-group">

<label>Direction</label>

<select name="direction">

<option
value="BUY"
<?= $trade['direction']=="BUY" ? "selected":"" ?>>

BUY

</option>

<option
value="SELL"
<?= $trade['direction']=="SELL" ? "selected":"" ?>>

SELL

</option>

</select>

</div>

<div class="form-group">

<label>Entry</label>

<input
type="number"
step="0.01"
name="entry_price"
value="<?= $trade['entry_price'] ?>">

</div>

<div class="form-group">

<label>Stop Loss</label>

<input
type="number"
step="0.01"
name="sl"
value="<?= $trade['sl'] ?>">

</div>

<div class="form-group">

<label>Take Profit</label>

<input
type="number"
step="0.01"
name="tp"
value="<?= $trade['tp'] ?>">

</div>

<div class="form-group">

<label>Exit Price</label>

<input
type="number"
step="0.01"
name="exit_price"
value="<?= $trade['exit_price'] ?>">

</div>

<div class="form-group">

<label>Lot</label>

<input
type="number"
step="0.01"
name="lot"
value="<?= $trade['lot'] ?>">

</div>

<div class="form-group">

<label>Profit (USD)</label>

<input
type="number"
step="0.01"
name="profit_usd"
value="<?= $trade['profit_usd'] ?>">

</div>

<div class="form-group">

<label>Result</label>

<select name="hasil">

<?php

$list=["WIN","LOSS","BE"];

foreach($list as $h):

?>

<option
value="<?= $h ?>"
<?= $trade['hasil']==$h ? "selected":"" ?>>

<?= $h ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="form-group">

<label>Emotion</label>

<select name="emotion">

<?php

$list=[
"Calm",
"Confident",
"Neutral",
"Fear",
"FOMO",
"Revenge Trade",
"Greedy",
"Frustrated",
"Overconfident",
"Tired"
];

foreach($list as $e):

?>

<option
value="<?= $e ?>"
<?= $trade['emotion']==$e ? "selected":"" ?>>

<?= $e ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="form-group">

<label>Strategy</label>

<select name="strategy">

<?php

$list=[
"Price Action",
"SMC",
"ICT",
"Breakout",
"Trend Following",
"Support & Resistance",
"Supply & Demand",
"Scalping",
"Swing",
"News Trading"
];

foreach($list as $s):

?>

<option
value="<?= $s ?>"
<?= ($trade['strategy'] ?? 'Price Action')==$s ? 'selected' : '' ?>>

<?= $s ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="form-group">

<label>Note</label>

<textarea
name="note"
rows="5"><?= htmlspecialchars($trade['note']) ?></textarea>

</div>

<div style="display:flex;gap:10px;">

<button class="btn btn-primary">

<?= $mode=="create"
? "SAVE TRADE"
: "UPDATE TRADE" ?>

</button>

<a href="?page=journal" class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>