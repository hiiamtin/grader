function roomCheckOut() {
    if (confirm("นักศึกษาต้องการ Check-out ออกจากห้องสอบใช่หรือไม่?")) {
        window.location.assign(baseurl+"index.php/student/exam_room_check_out");
    }
}

document.addEventListener("DOMContentLoaded", function() {
    let status = document.getElementById("status-btn");
    let word = status.innerText
    console.log(word);
    if(word != "Closed : ยังไม่เริ่มสอบ") {
        document.getElementById("check-in-btn").setAttribute("disabled", "true");
    }
});