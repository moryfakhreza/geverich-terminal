<?php require_once __DIR__ . '/../includes/header.php'; ?>
<?php require_once __DIR__ . '/../includes/navbar.php'; ?>

<div class="dashboard-layout">

    <section class="chart-card">

        <div class="panel-title">
            GT> MARKET NEWS STREAM
        </div>

        <div class="panel-content">

            <div class="tradingview-widget-container">

                <div class="tradingview-widget-container__widget"></div>

                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
                    {
                        "feedMode": "all_symbols",
                        "colorTheme": "dark",
                        "isTransparent": false,
                        "displayMode": "compact",
                        "width": "100%",
                        "height": 650,
                        "locale": "en"
                    }
                </script>

            </div>

        </div>

    </section>

    <aside class="sidebar">

        <div class="card">

            <div class="panel-title">
                GT> QUICK INFO
            </div>

            <div class="panel-content">

                <div class="news-terminal">
                    GT> Live market sentiment active<br>
                    GT> Monitoring global assets<br>
                    GT> Feed: TradingView Timeline
                </div>

            </div>

        </div>

    </aside>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>