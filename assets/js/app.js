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