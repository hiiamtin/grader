
 <!-- Central Modal Medium Info -->
 <div class="modal" id="change_time_model" tabindex="-1" role="dialog" aria-labelledby="change_time"
   aria-hidden="true">
   <div class="modal-dialog modal-notify modal-info" role="document">
     <!--Content-->
     <div class="modal-content">
       <!--Header-->
       <div class="modal-header">
         <p class="heading lead">เปลี่ยนเวลา</p>
         </button>
       </div>
       
       <form action="<?php echo site_url('ExamSupervisor/change_time'); ?>" id="change_time" method="post">
       <!--Body-->
       <div class="modal-body">
         <div class="text-center">
           <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
              <div class="form-group container-fluid">
                <?php
                  if($chapter_data['allow_access']=='yes'){
                    if($chapter_data['allow_submit']=='yes'){
                      ?>
                      <button>open now</button>
                      <?php
                    }
                    else{
                      ?>
                      <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><a href="#" role="button" class="btn btn-info" style="width:100%;margin-bottom:10px;">เปิดอีกครั้งทันที</a></div>
                      </div>
                      <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><a href="#" role="button" class="btn btn-info" style="width:100%;">เปิดอีกครั้งใน</a></div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 "><input type="number" class="form-control" style="width:100%;margin-left:0;"></input></div>
                        
                      </div>
                      <?php
                    }
                  }
                ?>
              </div>
         </div>
       </div>

       <!--Footer-->
       <div class="modal-footer justify-content-center">
         <input type="submit" class="btn btn-primary" value="Save">
         <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
       </div>
       </form>

     </div>
     <!--/.Content-->
   </div>
 </div>
 <!-- Central Modal Medium Info-->