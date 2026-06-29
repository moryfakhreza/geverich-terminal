<div class="card">

<div class="panel-title">

RISK CALCULATOR

</div>

<div class="panel-content">

<div class="form-group">

<label>Balance (USD)</label>

<input id="balance" type="number" value="10000">

</div>

<div class="form-group">

<label>Risk %</label>

<input id="risk" type="number" value="1">

</div>

<div class="form-group">

<label>Entry Price</label>

<input id="entry" type="number" step="0.01">

</div>

<div class="form-group">

<label>Stop Loss</label>

<input id="sl" type="number" step="0.01">

</div>

<div class="form-group">

<label>Take Profit</label>

<input id="tp" type="number" step="0.01">

</div>

<hr>

<div class="calc-row">

<span>Risk Amount</span>

<strong id="riskAmount">$0</strong>

</div>

<div class="calc-row">

<span>Suggested Lot</span>

<strong id="lotSize">0.00</strong>

</div>

<div class="calc-row">

<span>Risk Reward</span>

<strong id="rr">-</strong>

</div>

<div class="calc-row">

<span>Potential Profit</span>

<strong id="profit">$0</strong>

</div>

<div class="calc-row">

<span>Potential Loss</span>

<strong id="loss">$0</strong>

</div>

</div>

</div>

<div class="risk-buttons">

    <button type="button" class="risk-btn" data-risk="0.5">0.5%</button>

    <button type="button" class="risk-btn" data-risk="1">1%</button>

    <button type="button" class="risk-btn" data-risk="2">2%</button>

    <button type="button" class="risk-btn" data-risk="3">3%</button>

</div>