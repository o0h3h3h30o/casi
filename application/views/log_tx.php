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
            <div class="col-xs-4">
                <form action="<?php echo base_url() ?>config_bottx" method="POST">
                    <div class="form-group">
                    <label for="exampleInputEmail1">Giá trị hũ cập nhật</label>
                    <input type="number" class="form-control" id="dw_tx" name="dw_tx" placeholder="Nhập giá trị mới của hũ ảo tài xỉu">

                    </div>
                    <div class="form-group">
                    <label for="exampleInputEmail1">Lý do cập nhật</label>
                    <input type="text" class="form-control" id="note" name="note" placeholder="Lý do thay đổi">

                    </div>
                 
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <hr>
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
                        <th>Lý do thay đổi</th>
                        
                      
                    </tr>
                    <?php
                    if(!empty($logsRecords))
                    {
                        foreach($logsRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->time_change_2 ?></td>
                        <td><?php echo number_format($record->gold_after - $record->gold_before); ?></td>
                        <td><?php echo number_format($record->gold_before); ?></td>
                        <td><?php echo number_format($record->gold_after); ?></td>
                        <td><?php echo $recode->note; ?></td>
                      
                        
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
             <div class="col-md-4">
                <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
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
