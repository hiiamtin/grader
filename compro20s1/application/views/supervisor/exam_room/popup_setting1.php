
 <!-- Central Modal Medium Info -->
 <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-info" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead">Setting</p>

         </button>
       </div>

       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
           <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
            <form>
                <div class="form-group">
                    <label for="sel1">Select Chapter (select one):</label>
                    <select class="form-control" id="sel1">
                    <?php
						foreach ($group_permission as $row) {
                            echo '<option';
                            if($chapter_id==$row["chapter_id"]){
                                echo ' selected';
                            }
                            echo '>'.$row['chapter_id'].') '.$row['chapter_name']."</option>";
                        }
                    ?>
                    </select>
                </div>
            </form>
         </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <a type="button" class="btn btn-primary">Save<i class="far fa-gem ml-1 text-white"></i></a>
         <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancle</a>
       </div>
     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Info-->