<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>PLMS Supervisor</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap-3.3.7/css/bootstrap.min.css') ?>" >
        <link href="<?php echo base_url('assets/summernote/summernote.css') ?>" rel="stylesheet" >
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/lib/codemirror.css')?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/codemirror-5.22.0/theme/monokai.css')?>">
        
        <script src="<?php echo base_url('assets/jquery/jquery-3.1.1.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/jquery/jquery.dataTables.min.js') ?>"></script>
        <script src="<?php echo base_url('assets/jquery/dataTables.bootstrap.min.js') ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/dataTables.bootstrap.min.css')?>"/>
    </head>
    <body>
        <table id="student_list_table" class="table table-striped table-bordered" style="width: 100%;">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Name Surname</th>
                    <th style="width:60px;">Nick Name</th>
                    <th style="width:60px;">Reset Password</th>
                    <th>Avatar</th>
                    <th>Status</th>
                    <th>Check in</th>
                    <?php
                    for ($x = 1; $x <= $no_items; $x++) {
                        echo "<th>Level ".$x."</th>";
                      }
                    ?>
                    
                </tr>
            </thead>

            <tbody>
                <?php
                    foreach($students_data as $data){
                        echo "<tr>";
                        echo "<td>".$data['stu_id']."</td>";
                        echo "<td>".$data['stu_firstname']." ".$data['stu_lastname']."</td>";
                        echo "<td>".$data['stu_nickname']."</td>";
                        ?>
                        <td>
                            <button class="btn btn-sm" onclick="reset_password(
                                <?php echo $data['stu_id'].','.$room_num; ?>)">reset<br />password</button>
                        </td>
                        <td>
                            <img src="<?php echo $data['stu_avatar'] ? base_url(STUDENT_AVATAR_FOLDER.$data['stu_avatar']) : base_url(STUDENT_AVATAR_FOLDER.'user.png'); ?>"
                                style="width:90px;height:108px;" onerror="this.onerror=null;this.src='<?php echo base_url(STUDENT_AVATAR_FOLDER.'user.png'); ?>';" >
                        </td>
                        <?php
                            echo '<td><div style="width:100%;" class="btn ';
							        if($data['status']=='online')
										echo 'btn-success"> online'; 
									else
										echo 'btn-danger"> offline'; 
									echo '</div></td>';
                        
                            echo '<td><div style="width:100%;" class="btn ';
                                    if(in_array($data['stu_id'],$check_in_list))
                                        echo 'btn-success"> yes';
                                    else
										echo 'btn-danger"> no'; 
									echo '</div></td>';
                        
                            for ($x = 0; $x < $no_items; $x++) {
                                if (empty($data['list_item'])){
                                    echo "<th>-</th>";
                                }
                                else{
                                    echo "<th>".$data['list_item'][$x]."</th>";
                                }
                                    
                                }
                        
                        echo "</tr>";
                    }
                ?>
            </tbody>

        </table>
        <script>
            $(document).ready(function () {
                $("#student_list_table").DataTable(
                    {
                        "columnDefs": [
                            { "width": "10%", "targets": 0 },
                            { "width": "15%", "targets": 1 },
                            { "width": "5%", "targets": 2 },
                            { "width": "8%", "targets": 4 },
                            { "width": "5%", "targets": 5 },
                            { "width": "9%", "targets": 6 }
                        ]
                    } 
                );
            });
            var baseurl = "<?php echo base_url(); ?>";
            function ajaxResetPassword(stu_id, roomNumber) {
                jQuery.post(baseurl + "index.php/ExamSupervisor/exam_student_password_reset",
                    {
                        roomNumber: roomNumber,
                        stu_id: stu_id
                    },
                    setTimeout(function () {
                        window.location = window.location
                    }, 800)
                );
            }

            function reset_password(id,roomNumber){
                if (confirm(id + " : คุณต้องการ 'รีเซ็ตรหัสผ่าน' ใช่หรือไม่?")) {
                    ajaxResetPassword(id, roomNumber);
                }
            }
        </script>
    </body>
    
</html>