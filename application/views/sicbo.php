<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Phiên tài xỉu hiện tại #<?php echo $session; ?>
        <small></small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-6 text-right">
                
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tài : <b style="color: red;"><?= number_format($total_tai[0]->total_tai); ?></b></h3>
                    <div class="box-tools">
                        
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Tên đăng nhập</th>
                        
                        
                        <th>Gold</th>
                        <th>Thời gian đặt</th>
                        
                      
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
             <div class="col-xs-6">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Xiủ : <b style="color: green;"><?= number_format($total_xiu[0]->total_xiu); ?></b></h3>
                    <div class="box-tools">
                        
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Tên đăng nhập</th>
                        
                        
                        <th>Gold</th>
                        <th>Thời gian đặt</th>
                        
                      
                    </tr>
                    <?php
                    if(!empty($rs_xiu))
                    {
                        foreach($rs_xiu as $record)
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
