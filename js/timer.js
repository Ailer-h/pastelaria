function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function timer(startDate, id){

    while(true){
        let time = Math.abs(new Date() - new Date(startDate.replace(/-/g, '/')))
    
        time = Math.floor(time/1000);

        let h = Math.floor(time/3600);
        let m = Math.floor((time%3600)/60);
        let s = time%60;

        let formatedTimer = h.toString().padStart(2,"0") + ":" +
                            m.toString().padStart(2,"0") + ":" +
                            s.toString().padStart(2,"0");
    

        document.getElementById("timer"+id).innerHTML = formatedTimer;

        await timeout(1000);

    }

}