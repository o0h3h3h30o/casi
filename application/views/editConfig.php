<?php
$config_id = $config_info->id;
$xkey = $config_info->xkey;
$game_id = $config_info->game_id;
$value = $config_info->value;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Cập nhật giá trị cài đặt
        <small>Hỏi Hoàng Anh cái này trước khi muốn Update</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter User Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>updateConfig" method="post" id="editUser" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="xkey">Key Config</label>
                                        <input type="text" class="form-control" id="xkey" readonly="true" placeholder="Tên đăng nhập" name="xkey" value="<?php echo $xkey; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $config_id; ?>" name="config_id" id="config_id" />    
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nickname">Game ID</label>
                                        <input type="text" class="form-control" id="game_id" readonly="true" placeholder="Enter game_id" name="game_id" value="<?php echo $game_id; ?>" maxlength="128">
                                    </div>
                                </div>
                            </div>
                           <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="xkey">Value</label>
                                       
                                        <textarea class="form-control" id="value" name="value"><?php echo $value; ?></textarea>  
                                    </div>
                                    
                                </div>
                               
                            </div>
                            
                         
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>
                </div>
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