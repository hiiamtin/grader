<script>
    setTimeout(function () {
        let url = "<?php echo site_url($_SESSION['role'].'/exam_room_problem_select'); ?>";
        window.location.href = url+"/"+<?php echo $chapter_id;?>+"/"+<?php echo $level;?>;
    }, 2000);
</script>

<h2>เสียใจด้วย คุณใช้ตัวช่วยหมดแล้ว</h2>