<?php
$userId = $userInfo->id;
$username = $userInfo->username;
$nickname = $userInfo->nickname;
$store_title = $userInfo->store_title;
$phone = $userInfo->phone;
$roleId = $userInfo->user_type;
$location = $userInfo->location;
$facebook_url = $userInfo->facebook_url;
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Thông tin người dùng
        <small>Add / Edit User</small>
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
                    
                    <form role="form" action="<?php echo base_url() ?>editUser" method="post" id="editUser" role="form">
                        <div class="box-body">
                            <div class="row">
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
                                        <input type="text" class="form-control" id="nickname" placeholder="Enter nickname" name="nickname" value="<?php echo $nickname; ?>" maxlength="128">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Tên đại lý</label>
                                        <input type="text" class="form-control" id="store_title"  placeholder="Hiển thị đại lý" name="store_title" value="<?php echo $store_title; ?>" maxlength="128">
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Khu vực</label>
                                        <input type="text" class="form-control" id="location"  placeholder="Khu vực" name="location" value="<?php echo $location; ?>" maxlength="128">
                                        
                                    </div>
                                    
                                </div>
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Facebook</label>
                                        <input type="text" class="form-control" id="facebook_url"  placeholder="Link facebook" name="facebook_url" value="<?php echo $facebook_url; ?>" maxlength="128">
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Mật khẩu</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpassword">Confirm Password</label>
                                        <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" maxlength="20">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Mobile Number</label>
                                        <input type="text" class="form-control" id="phone" placeholder="Mobile Number" name="phone" value="<?php echo $phone; ?>" maxlength="10">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="0">Select Role</option>
                                            <?php
                                            if(!empty($roles))
                                            {
                                                foreach ($roles as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->roleId ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
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