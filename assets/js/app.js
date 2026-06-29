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

function updateCountdown(){

    const now=new Date();

    const london=new Date();

    london.setHours(14,0,0,0);

    let diff=london-now;

    if(diff<0){
        diff+=24*60*60*1000;
    }

    const h=Math.floor(diff/3600000);

    const m=Math.floor((diff%3600000)/60000);

    const s=Math.floor((diff%60000)/1000);

    const el=document.getElementById("countdown");

    if(el){

        el.innerHTML=

        String(h).padStart(2,"0")+":"+

        String(m).padStart(2,"0")+":"+

        String(s).padStart(2,"0");

    }

}

updateCountdown();

setInterval(updateCountdown,1000);

function riskCalculator(){

    const balance=parseFloat(document.getElementById("balance").value)||0;

    const risk=parseFloat(document.getElementById("risk").value)||0;

    const entry=parseFloat(document.getElementById("entry").value)||0;

    const sl=parseFloat(document.getElementById("sl").value)||0;

    const tp=parseFloat(document.getElementById("tp").value)||0;

    const riskMoney=balance*risk/100;

    document.getElementById("riskAmount").textContent="$"+riskMoney.toFixed(2);

    const stopDistance=Math.abs(entry-sl);

    if(stopDistance<=0){

        document.getElementById("lotSize").textContent="0.00";
        document.getElementById("rr").textContent="-";
        document.getElementById("profit").textContent="$0.00";
        document.getElementById("loss").textContent="$0.00";

        return;
    }

    const lot=riskMoney/(stopDistance*100);

    document.getElementById("lotSize").textContent=lot.toFixed(2);

    const reward=Math.abs(tp-entry);

    const rr=reward/stopDistance;

    document.getElementById("rr").textContent="1 : "+rr.toFixed(2);

    document.getElementById("profit").textContent="$"+(riskMoney*rr).toFixed(2);

    document.getElementById("loss").textContent="$"+riskMoney.toFixed(2);

}

const inputs=[
    "balance",
    "risk",
    "entry",
    "sl",
    "tp"
];

inputs.forEach(id=>{

    const el=document.getElementById(id);

    if(el){

        el.addEventListener("input",riskCalculator);

    }

});

const riskButtons=document.querySelectorAll(".risk-btn");

riskButtons.forEach(btn=>{

    btn.addEventListener("click",()=>{

        document.getElementById("risk").value=btn.dataset.risk;

        riskCalculator();

    });

});

riskCalculator();