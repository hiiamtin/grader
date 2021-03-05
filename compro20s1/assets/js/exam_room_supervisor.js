// code_preview

function switchSourceCode(id) {
    let container = document.getElementById("codemirror-container");
    let child = container.getElementsByClassName("CodeMirror")[0];
    container.removeChild(child);
    showSourceCode(id);
}

function showSourceCode(id) {
    let textArea = document.getElementById(id);
    CodeMirror.fromTextArea(textArea, {
        lineNumbers: true,
        readOnly: true
    });
}


// panel

function ajaxSetAllowCheckIn(needToAllow, roomNumber) {
    jQuery.post(baseurl+"index.php/ExamSupervisor/ajax_allow_check_in",
        {
            roomNumber: roomNumber,
            needToAllow: needToAllow
        },
        setTimeout(function () {
            window.location = window.location
        }, 800)
    );
}

function ajaxSetSocialDistancing(value, roomNumber) {
    jQuery.post(baseurl+"index.php/ExamSupervisor/ajax_social_distancing",
        {
            roomNumber: roomNumber,
            value: value
        },
        setTimeout(function () {
            window.location = window.location
        }, 800)
    );
}

function toggleAllowCheckIn(id) {
    let toggleSwitch = document.getElementById(id);
    let roomNumber = id.substr(0, 3);
    if (toggleSwitch.checked) {
        if (confirm(roomNumber + " : อนุญาตให้นักศึกษา Check in ใช่หรือไม่?")) {
            ajaxSetAllowCheckIn("checked", roomNumber);
        } else {
            toggleSwitch.checked = false;
        }
    } else {
        if (confirm(roomNumber + " : ห้ามนักศึกษา Check in ใช่หรือไม่?")) {
            ajaxSetAllowCheckIn("unchecked", roomNumber);
        } else {
            toggleSwitch.checked = true;
        }
    }
}

function toggleSocialDistancing(id) {
    let toggleSwitch = document.getElementById(id);
    let roomNumber = id.substr(0, 3);
    if (toggleSwitch.checked) {
        ajaxSetSocialDistancing("checked", roomNumber);
    } else {
        ajaxSetSocialDistancing("unchecked", roomNumber);
    }
}

function createNewRoom() {
    var num = prompt("ใส่เลขห้อง:", "");
    if (num == null || num == "") {
        return 0;
    } else {
        window.location.href = baseurl+"index.php/ExamSupervisor/create_room/"+num;
    }
    return 1;
}


// popup_group_selector

function ajaxSetAllowAccess(needToAllow, classId) {
    let roomNumber = document.getElementById("room-number").getAttribute("value");
    jQuery.post(baseurl+"index.php/ExamSupervisor/ajax_allow_access",
        {
            roomNumber: roomNumber,
            needToAllow: needToAllow,
            classId: classId
        },
        setTimeout(function () {
            window.location = window.location
        }, 800)
    );
}

function toggleAllowAccess(id) {
    let toggleSwitch = document.getElementById(id);
    let roomNumber = id.substr(0, 3);
    document.getElementById("room-number").setAttribute("value", roomNumber);
    if (toggleSwitch.checked) {
        toggleSwitch.checked = false;
        jQuery("#modalGroupSelector").modal("show");
    } else {
        if (confirm(roomNumber + " : ห้ามนักศึกษาเข้าถึง ใช่หรือไม่?")) {
            ajaxSetAllowAccess("unchecked", "");
        } else {
            toggleSwitch.checked = true;
        }
    }
}


// popup_setting1

function change_chapter_NOT_WORK(jsonGroupPermission){
    let x = document.getElementById("selecter").value;
    let row = jsonGroupPermission[x];
    console.log(x,row);
    let time_start = row["time_start"].substring(0,10)+"T"+row["time_start"].substring(11,16);
    let time_end = row["time_end"].substring(0,10)+"T"+row["time_end"].substring(11,16);
    document.getElementById("time_start").value = time_start;
    document.getElementById("time_end").value = time_end;
    //stop_time = true;
    //time_counter = set_time_counter(Date.parse(row["time_start"])/10000,Date.parse(row["time_end"])/10000,"time_chapter","time_server_bar");
    //time_counter_main = set_time_counter(Date.parse(row["time_start"])/10000,Date.parse(row["time_end"])/10000,"time_chapter_main","time_server_bar");
}


// popup_stu_preview

function studentPreview(roomNum, seatNum) {
    document.getElementById("info-seatnum").innerHTML = seatNum;
    jQuery.post(baseurl+"index.php/ExamSupervisor/ajax_stu_preview",
        {
            seatNum: seatNum,
            roomNum: roomNum
        },
        function (data, status) {
            console.log("Fetching data: "+status);
            console.log(data);
            let stuInfo = JSON.parse(data);
            document.getElementById("info-name").innerHTML = "&#128512; " + stuInfo.stuId + " : " + stuInfo.stuFullname;
            for (let i = 1; i <= 5; i++) {
                let btn = document.getElementById("btn-level" + i);
                let problemName = document.getElementById("info-level" + i);
                if (stuInfo.examItems.length === 0) {
                    btn.setAttribute("class", "btn");
                    problemName.innerHTML = "<i>~ No Assignment</i>";
                } else if (stuInfo.examItems[0].item_id == i) {
                    switch (stuInfo.examItems[0].marking) {
                        case "2": {
                            btn.setAttribute("class", "btn btn-success");
                            btn.setAttribute("onclick", "codePreview("+stuInfo.stuId+","+stuInfo.examItems[0].exercise_id+")");
                            break;
                        }
                        default: {
                            btn.setAttribute("class", "btn btn-danger");
                            btn.setAttribute("onclick", "codePreview("+stuInfo.stuId+","+stuInfo.examItems[0].exercise_id+")");
                            break;
                        }
                    }
                    problemName.innerHTML = stuInfo.examItems[0].name;
                    stuInfo.examItems.shift();
                } else {
                    btn.setAttribute("class", "btn");
                    problemName.innerHTML = "<i>~ No Assignment</i>";
                }
            }
            let imgUrl = stuInfo.stuAvatar;
            document.getElementById("info-img").setAttribute("src", baseurl+"student_data/avatar/"+imgUrl);
            document.getElementById("info-progress").innerHTML = stuInfo.progress+'%';
        }
    );
}

function codePreview(stuId, problemId) {
    window.open(baseurl+"index.php/ExamSupervisor/stu_code_preview/"+stuId+"/"+problemId,"winname","directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,width=1200,height=700");
}

