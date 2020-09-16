<style>
    #exam-room-gate {
        margin-left: 200px;
        margin-top: 150px;
        display: flex;
        flex-wrap: wrap;
    }
    #exam-room-gate > form > * {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        margin: 12px;
    }

    #exam-room-gate > form > .btn {
        width: 400px;
    }

    #exam-room-gate img {
        margin-left: 10px;
        padding: 5px;
        width: 75%;
    }

    .alert-success {
        width: 400px;
    }


</style>

<script>

</script>

<div id="exam-room-gate">
    <form name="check_in" method="post" accept-charset="utf-8" action="<?php echo site_url('student/exam_room_check_in'); ?>">
        <h2>Exam Room Check in</h2>
        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2">ROOM NUMBER</span>
            <input type="text" class="form-control" placeholder="704 or 706" name="room_number" aria-describedby="sizing-addon2" required>
        </div>
        <div class="input-group">
            <span class="input-group-addon" id="sizing-addon2">SEAT NUMBER</span>
            <input type="text" class="form-control" placeholder="1 ~ 40" name="seat_number" aria-describedby="sizing-addon2" required>
        </div>
        <input type="submit" value="CHECK IN" class="btn btn-primary">
        <div class="alert alert-success" role="alert">
            <p>&#128073; ROOM NUMBER ให้กรอกเลขห้องนี้ เป็นเลข 3 หลัก</p>
            <p>&#128073; SEAT NUMBER ให้กรอกเลขที่นั่งสอบอยู่ในขณะนี้</p>
            <p>&#10060; ไม่อนุญาติให้นำเอกสารใดๆ เข้าห้องสอบ</p>
            <p>&#10060; ห้ามทุจริตในการสอบเด็ดขาด หากฝ่าฝืนจะโดนฟาดที่กลางหลัง 1250 ที และหมดสิทธิ์สอบปลายภาควิชา Computer Programming ในภาคการศึกษานี้</p>
        </div>
    </form>

    <div>
        <img src="https://i.redd.it/es9fpe3llr3z.jpg">
    </div>


</div>