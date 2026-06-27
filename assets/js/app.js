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

async function loadMarket() {
  try {
    const res = await fetch("api/market.php");
    const data = await res.json();

    const gold = data.gold;
    const dxy = data.dxy;
    const usdjpy = data.usdjpy;
    const us10y = data.us10y;

    document.getElementById("marketTicker").innerHTML = `
      🟡 ${gold.symbol} <strong>${gold.price}</strong> 
      <span class="${gold.change >= 0 ? 'up' : 'down'}">
        ${gold.change >= 0 ? '▲' : '▼'} ${Math.abs(gold.change)}%
      </span>

      &nbsp;&nbsp; | &nbsp;&nbsp;

      🇺🇸 ${dxy.symbol} <strong>${dxy.price}</strong> 
      <span class="${dxy.change >= 0 ? 'up' : 'down'}">
        ${dxy.change >= 0 ? '▲' : '▼'} ${Math.abs(dxy.change)}%
      </span>

      &nbsp;&nbsp; | &nbsp;&nbsp;

      💴 ${usdjpy.symbol} <strong>${usdjpy.price}</strong> 
      <span class="${usdjpy.change >= 0 ? 'up' : 'down'}">
        ${usdjpy.change >= 0 ? '▲' : '▼'} ${Math.abs(usdjpy.change)}%
      </span>

      &nbsp;&nbsp; | &nbsp;&nbsp;

      📈 ${us10y.symbol} <strong>${us10y.price}</strong> 
      <span class="${us10y.change >= 0 ? 'up' : 'down'}">
        ${us10y.change >= 0 ? '▲' : '▼'} ${Math.abs(us10y.change)}%
      </span>
    `;

  } catch (e) {
    document.getElementById("marketTicker").innerHTML =
      "❌ Market data unavailable";
  }
}

loadMarket();
setInterval(loadMarket, 5000);