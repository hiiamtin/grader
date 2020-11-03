<script>
    function studentPreview(seatNum) {
        document.getElementById("modal-title").innerHTML = seatNum;
        jQuery.post("<?php echo site_url('supervisor/exam_room_ajax_stu_preview'); ?>",
            {
                seatNum: seatNum,
                roomNum: <?php echo $room_number; ?>
            },
            function(data, status) {
                console.log(data);
                let stuPreview = JSON.parse(data);
                document.getElementById("modal-title").innerHTML = "" + stuPreview.stuId + " : " + stuPreview.stuFullname;
                // WORK IN PROGRESS JAA
            }
        );
    }
</script>

<div class="modal fade bd-example-modal-lg" id="modalStuPreview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="modal-title">Loading</h4>
            </div>
            <div class="modal-body">
                <p>Some text in the modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>