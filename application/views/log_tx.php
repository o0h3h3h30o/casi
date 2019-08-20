<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Giá trị hũ tài xỉu hiện tại: <b class="red"><?php echo number_format($dw_tx); ?></b>
        <small></small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-right">
                
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quản lý thay đổi giá trị hũ tài xỉu (bơm vào và rút ra của admin) - Báo cáo lãi lỗ</h3>
                    <div class="box-tools">
                        
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Thời gian</th>
                        <th>Giá trị thay đổi</th>
                        <th>Giá trị hũ trước thay đổi</th>
                        <th>Giá trị hũ sau khi thay đổi</th>
                        
                      
                    </tr>
                    <?php
                    if(!empty($rs_tai))
                    {
                        foreach($rs_tai as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->username ?></td>
                        <td><?php echo number_format($record->tai_real); ?></td>
                        <td><?php echo $record->log_time; ?></td>
                        
                    </tr>
                    <?php
                        }
                    }
                    ?>
                   
                  </table>
                  
                </div>

                <div class="box-footer clearfix">
                    
                </div>
              </div><!-- /.box -->
            </div>
             
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();            
            var link = jQuery(this).get(0).href;            
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "userListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>
