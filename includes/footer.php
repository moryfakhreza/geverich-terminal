<script src="https://s3.tradingview.com/tv.js"></script>

<script>

window.addEventListener("load",function(){

    if(typeof TradingView==="undefined"){

        console.log("TradingView gagal dimuat");

        return;

    }

    new TradingView.widget({

        container_id:"tv_chart",

        autosize:true,

        symbol:"OANDA:XAUUSD",

        interval:"5",

        timezone:"Asia/Jakarta",

        theme:"dark",

        style:"1",

        locale:"id",

        hide_top_toolbar:false,

        hide_side_toolbar:false,

        allow_symbol_change:true

    });

});

</script>

<footer class="terminal-status">

    <div class="ticker">

        <div class="ticker-content">

            <span class="gt">GT&gt;</span>

            <span class="ready">READY</span>

            <span class="sep">│</span>

            <span>USER: FAHRY FAKHREZA</span>

            <span class="sep">│</span>

            <span>DB: SQLITE</span>

            <span class="sep">│</span>

            <span>ENGINE: PHP 8</span>

            <span class="sep">│</span>

            <span>BUILD: v1.0.0</span>

            <span class="sep">│</span>

            <span>LOCAL</span>

            <span class="sep">│</span>

            <span>GEVERICH TERMINAL</span>

            <span class="sep">│</span>

            <span>TRADE • PLAN • EXECUTE • REPEAT</span>

            <span class="sep">│</span>

            <span class="gt">GT&gt;</span>

            <span class="ready">READY</span>

            <span class="sep">│</span>

            <span>USER: FAHRY FAKHREZA</span>

            <span class="sep">│</span>

            <span>DB: SQLITE</span>

            <span class="sep">│</span>

            <span>ENGINE: PHP 8</span>

            <span class="sep">│</span>

            <span>BUILD: v1.0.0</span>

            <span class="sep">│</span>

            <span>LOCAL</span>

        </div>

    </div>

</footer>
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>