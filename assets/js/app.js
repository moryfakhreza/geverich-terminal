function updateClock(){

    const now = new Date();

    const date = now.toLocaleDateString("id-ID",{

        day:"2-digit",

        month:"short",

        year:"numeric"

    });

    const time = now.toLocaleTimeString("id-ID",{

        hour:"2-digit",

        minute:"2-digit",

        second:"2-digit"

    });

    document.getElementById("todayDate").innerHTML=date;

    document.getElementById("clock").innerHTML=time+" WIB";

}

updateClock();

setInterval(updateClock,1000);

async function loadMarket(){

    try{

        const res = await fetch("api/market.php");

        const data = await res.json();

        document.getElementById("marketTicker").innerHTML = `

🟡 <strong>${data.gold.symbol}</strong>
${data.gold.price}
<span class="${data.gold.change>=0?'up':'down'}">
${data.gold.change>=0?'▲':'▼'}
${Math.abs(data.gold.change)}%
</span>

&nbsp;&nbsp;&nbsp;&nbsp;

🇺🇸 <strong>${data.dxy.symbol}</strong>
${data.dxy.price}
<span class="${data.dxy.change>=0?'up':'down'}">
${data.dxy.change>=0?'▲':'▼'}
${Math.abs(data.dxy.change)}%
</span>

&nbsp;&nbsp;&nbsp;&nbsp;

📈 <strong>${data.us10y.symbol}</strong>
${data.us10y.price}
<span class="${data.us10y.change>=0?'up':'down'}">
${data.us10y.change>=0?'▲':'▼'}
${Math.abs(data.us10y.change)}%
</span>

&nbsp;&nbsp;&nbsp;&nbsp;

💴 <strong>${data.usdjpy.symbol}</strong>
${data.usdjpy.price}
<span class="${data.usdjpy.change>=0?'up':'down'}">
${data.usdjpy.change>=0?'▲':'▼'}
${Math.abs(data.usdjpy.change)}%
</span>

&nbsp;&nbsp;&nbsp;&nbsp;

🔴 <span class="news-high">
${data.news.title}
(${data.news.time})
</span>

`;

    }catch(e){

        document.getElementById("marketTicker").innerHTML =
        "❌ Market data unavailable";

    }

}

loadMarket();

setInterval(loadMarket,30000);