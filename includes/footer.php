<script src="assets/js/app.js"></script>
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

<footer class="terminal-strip">

    <div class="terminal-strip-inner">

        <span>GEVERICH TERMINAL</span>

        <span class="divider"></span>

        <span>TRADE • PLAN • EXECUTE • REPEAT</span>

        <span class="divider"></span>

        <span>BUILD v1.0.0</span>

    </div>

</footer>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>