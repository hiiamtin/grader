function rotateScreen(angle) {
    document.getElementById("room-container").style.transform = "rotate(" + angle + ")";
    document.getElementById("white-board").style.transform = "rotate(" + angle + ")";
    for (let desk of document.getElementsByClassName("grid-seat")) {
        desk.style.transform = "rotate(" + angle + ")";
    }
    if (angle == "0deg") {
        document.getElementById("btn-rotate").setAttribute("value", "180deg");
    } else {
        document.getElementById("btn-rotate").setAttribute("value", "0deg");
    }
}

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
        document.getElementById("timer").innerHTML = "Server time is : " + date.toLocaleString('en-US') +
            " (Last sync : " + new Date(expected).toLocaleString('en-US') + ")";
        //console.log(nextInterval, dt); //Click away to another tab and check the logs after a while
        now = performance.now('en-US');
        setTimeout(step, Math.max(0, nextInterval)); // take into account drift
    }
}

function get_time_server() {
    var x = document.getElementById("timer").innerHTML;
    //console.log(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
    return Date.parse(x.split(" (Last sync : ")[0].split("Server time is : ")[1]);
}

function set_time_counter(a, b, c, d) {
    var localTime = get_time_server();
    var now = performance.now();
    var then = now;
    var dt = 0;
    var nextInterval = interval = 1000;
    var distance, open_or_close;
    var time_update = "";
    var timetotol = (300)*1000;
    var stop_time = false;
    //console.log(c);

    function step() {
        then = now;
        now = performance.now();
        dt = now - then - nextInterval;
        nextInterval = interval - dt;
        localTime = get_time_server();
        var process_bar_color;
        //console.log(a,b,localTime);
        if (a > b) {
            open_or_close = "ERROR";
            distance = -1;
            stop_time = true;
        } else if (localTime < a * 1000) {
            distance = a * 1000 - localTime;
            open_or_close = "Open in : ";
            if (time_update == "") {
                time_update = open_or_close;
                timetotol = (300)*1000;
            }
            
        } else if (localTime < b * 1000 && localTime > a * 1000){
            distance = b * 1000 - localTime;
            open_or_close = "Close in : ";
            if (time_update == "") {
                time_update = open_or_close;
                timetotol = (b-a)*1000;
            }
        }else{
            distance = -1;
            open_or_close = "EXPIRED";
            if (time_update == "") {
                time_update = open_or_close;
            }
        }
        if (time_update != open_or_close) {
            time_update = open_or_close;
            if(!stop_time){
                window.location.reload(false);
            }
        }
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        var progressBarWidth = (distance*100/timetotol);
        //console.log(progressBarWidth)
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
        if(document.getElementById(d).className!=process_bar_color){
            document.getElementById(d).className = process_bar_color;
        }

        // Output
        document.getElementById(c).innerHTML = open_or_close + days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";

            
        document.getElementById(d).style.width = progressBarWidth+"%";


        now = performance.now();
        if (distance < 0) {
            time_update = open_or_close;
            if (a > b) {
                document.getElementById(c).innerHTML = "TIME ERROR,This lab will close.";
            } else {
                document.getElementById(c).innerHTML = "EXPIRED";
            }
        } else {
            if (!stop_time) {
                //console.log(d,stop_time);
                setTimeout(step, Math.max(0, nextInterval)); // take into account drift
            } else {
                //console.log(d,stop_time);
                time_update = open_or_close;
                stop_time = false;
            }
        }
    }

    return setTimeout(step, interval);
}

function update_online_student_exam() {
    let URL_ = baseurl+"index.php/plms_json/get_online_student_exam/"+roomNum;
    //console.log(URL_);
    fetch(URL_)
    .then( (res) => res.json() )
    .then( (data) => {
        //console.log(data);
        let online_students = 0;
        for( row of data['online_student']) {
            online_students += 1;
        }
        let check_in__students = 0;
        for( row of data['check_in']) {
            check_in__students += 1;
        }
        //console.log("online students : "+ online_students+" "+ (new Date()));
        document.querySelector("#online_students").innerHTML = `${check_in__students}/${num_of_student} (online:${online_students}คน)`;
    });
   

}

document.addEventListener("DOMContentLoaded", function() {
    //setTimeout(update_online_student,1000);
    //setInterval(update_online_student,60000);
    update_online_student_exam();
    if (user_role == "student") {
        setInterval(update_online_student_exam,300000);
    } else if (user_role == "supervisor") { 
        setInterval(update_online_student_exam,5000);
    } else {
        setInterval(update_online_student_exam,100000);
    }
    
});

//<?php echo sizeof($seat_list);?> / <?php echo $num_of_student;?>