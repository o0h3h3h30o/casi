<?php
$userId = $userInfo->id;
$username = $userInfo->username;
$nickname = $userInfo->nickname;
$gold = $userInfo->gold;
$store_title = $userInfo->store_title;
$phone = $userInfo->phone;
$roleId = $userInfo->user_type;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Nạp thẻ điện thoại
        <small>Giá trị dương là cộng, âm là trừ</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Nạp thẻ điện thoại</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo base_url() ?>request_recharge" method="post" id="editUser" role="form">
                        <div class="box-body">
                            <div class="row hide">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="username">Tên đăng nhập</label>
                                        <input type="text" class="form-control" id="username" readonly="true" placeholder="Tên đăng nhập" name="username" value="<?php echo $username; ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />    
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nickname">Tên hiển thị</label>
                                        <input type="text" class="form-control" id="nickname" readonly="true" placeholder="Enter nickname" name="nickname" value="<?php echo $nickname; ?>" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Mã thẻ</label>
                                        <input type="text" class="form-control" id="code" placeholder="" name="code" value="" maxlength="128">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname">Seri thẻ</label>
                                        <input type="text" class="form-control" id="serial" placeholder="" name="serial" value="" maxlength="128">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname">Loại thẻ</label>
                                         <select class="form-control" id="type" name="type">
                                            <option value="vt">Viettel</option>
                                            <option value="vn">Vina</option>
                                            <option value="mb">Mobi</option>
                                            
                                        </select>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="fname">Mệnh giá</label>
                                        <select class="form-control" id="menhGia" name="menhGia">
                                            <option value="10000">10.000</option>
                                            <option value="20000">20.000</option>
                                            <option value="50000">50.000</option>
                                            <option value="100000">100.000</option>
                                            <option value="200000">200.000</option>
                                            <option value="500000">500.000</option>
                                        </select>
                                        
                                        
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

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>