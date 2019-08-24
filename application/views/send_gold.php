<?php
$userId = $userInfo->id;
$username = $userInfo->username;
$nickname = $userInfo->nickname;
$store_title = $userInfo->store_title;
$phone = $userInfo->phone;
$gold = $userInfo->gold;
$roleId = $userInfo->user_type;
$location = $userInfo->location;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Chuyển tiền cho người chơi
        <small></small>
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
                    
                    <form role="form" action="<?php echo base_url() ?>addTransactions" method="post" id="editUser" role="form">
                        <div class="box-body">
                            
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="username">Tên hiển thị người nhận</label>
                                        <input type="text" class="form-control" id="recived_name" readonly="true" placeholder="Tên đăng nhập" name="reciven_name" value="<?php echo $recived->nickname; ?>" maxlength="128">                                          
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="username">Gold hiện tại</label>
                                        <input type="text" class="form-control" id="user_gold" readonly="true" placeholder="Tên đăng nhập" name="gold_sender" value="<?php echo number_format($gold); ?>" maxlength="128">
                                        <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />    
                                        <input type="hidden" value="<?php echo $recived->id; ?>" name="recived" id="recived" />    
                                    </div>
                                    
                                </div>
                               
                            </div>
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nickname">Gold muốn chuyển</label>
                                       <input type="text" class="form-control" name="amount" id="currency-field1"  value="" data-type="currency" placeholder="">
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nickname">Lý do chuyển</label>
                                        <input type="text" class="form-control" id="note"  placeholder="" name="note" value="" maxlength="128">
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