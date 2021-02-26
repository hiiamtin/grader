var xmlHttp;

function srvTime() {
    try {
        //FF, Opera, Safari, Chrome
        xmlHttp = new XMLHttpRequest();
    } catch (err1) {
        //IE
        try {
            xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (err2) {
            try {
                xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
            } catch (eerr3) {
                //AJAX not supported, use CPU time.
                alert("AJAX not supported");
            }
        }
    }
    xmlHttp.open('HEAD', window.location.href.toString(), false);
    xmlHttp.setRequestHeader("Content-Type", "text/html");
    xmlHttp.send('');
    return xmlHttp.getResponseHeader("Date");
}

var serverTime = new Date(srvTime()).getTime();

function set_time_server() {
    //var serverTime  = new Date(srvTime()).getTime();
    var expected = serverTime;
    var now = performance.now();
    var then = now;
    var dt = 0;
    var nextInterval = interval = 1000;
    var date, hours, minutes, seconds;
    setTimeout(step, interval);

    function step() {
        then = now;
        now = performance.now();
        dt = now - then - nextInterval;
        nextInterval = interval - dt;
        //console.log(serverTime);
        serverTime += interval;
        //console.log(serverTime);
        date = new Date(serverTime);

        hours = date.getHours();
        minutes = date.getUTCMinutes();
        seconds = date.getUTCSeconds();
        //document.getElementById("timer").innerHTML = "Server time is : " + hours + ':' + minutes + ':' + seconds;
        document.getElementById("timer_server").innerHTML = "Server time is : " + date.toLocaleString('en-US') +
            " (Last sync : " + new Date(expected).toLocaleString('en-US') + ")";
        //console.log(nextInterval, dt); //Click away to another tab and check the logs after a while
        now = performance.now();
        setTimeout(step, Math.max(0, nextInterval)); // take into account drift
    }
}

function get_time_server() {
    var x = document.getElementById("timer_server").innerHTML;
    //console.log(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
    return Date.parse(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
}

var time_update = "";

function set_time_counter(a, b, c) {
    var localTime = get_time_server();
    var now = performance.now();
    var then = now;
    var dt = 0;
    var nextInterval = interval = 1000;
    var distance, open_or_close;
    setTimeout(step, interval);

    function step() {
        then = now;
        now = performance.now();
        dt = now - then - nextInterval;
        nextInterval = interval - dt;
        localTime = get_time_server();
        var process_bar_color;
        //console.log(b,localTime);
        if (a > b) {
            distance = -1;
        } else if (localTime < a * 1000) {
            distance = a * 1000 - localTime;
            open_or_close = "Open in : ";
            if (time_update == "") {
                time_update = open_or_close;
            }
        } else {
            distance = b * 1000 - localTime;
            open_or_close = "Close in : ";
            if (time_update == "") {
                time_update = open_or_close;
            }
        }
        if (time_update != open_or_close) {
            time_update = open_or_close;
            window.location.reload(false);
        }
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        var timetotol = (b-a)*1000;
        var progressBarWidth = (distance*100/timetotol);
     
        // check color progress bar
        if(progressBarWidth>80){
            process_bar_color = "progress-bar progress-bar-striped active";
        }else if(progressBarWidth>60){
            process_bar_color = "progress-bar progress-bar-info \
            progress-bar-striped active";
        }else if(progressBarWidth>40){
            process_bar_color = "progress-bar progress-bar-success \
            progress-bar-striped active";
        }else if(progressBarWidth>20){
            process_bar_color = "progress-bar progress-bar-warning \
            progress-bar-striped active";
        }else{
            process_bar_color = "progress-bar progress-bar-danger \
            progress-bar-striped active";
        }
        if(document.getElementById("timer_server_bar").className!=process_bar_color){
            document.getElementById("timer_server_bar").className = process_bar_color;
        }

        // Output
        document.getElementById(c).innerHTML = open_or_close + days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";

            
        document.getElementById("timer_server_bar").style.width = progressBarWidth+"%";


        now = performance.now();
        if (distance < 0) {
            if (a > b) {
                document.getElementById(c).innerHTML = "TIME ERROR,This lab will close.";
            } else {
                document.getElementById(c).innerHTML = "EXPIRED";
            }
        } else {
            setTimeout(step, Math.max(0, nextInterval)); // take into account drift
        }
    }
}

set_time_server();

function move(a,b) {
    var i = 0;
      if (i == 0) {
        i = 1;
        var elem = document.getElementById("timer_server_bar");
        var width = 1;
        var id = setInterval(frame, 10);
        function frame() {
              if (width >= 100) {
                clearInterval(id);
                i = 0;
              } else {
                width++;
                elem.style.width = width + "%";
              }
        }
      }
}