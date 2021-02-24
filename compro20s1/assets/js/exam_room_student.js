function roomCheckOut() {
    if (confirm("นักศึกษาต้องการ Check-out ออกจากห้องสอบใช่หรือไม่?")) {
        window.location.assign(baseurl+"index.php/student/exam_room_check_out");
    }
}
