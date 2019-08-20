<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Quản lý người chơi
        <small>Add, Edit, Delete</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addNew"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Danh sách người chơi</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                            <div class="input-group">
                              <input type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        <th>Tên đăng nhập</th>
                        <th>Tên Hiển thị</th>
                        <th>Phone</th>
                        <th>Gold</th>
                        <th>Phân loại</th>
                        
                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->username ?></td>
                        <td><?php echo $record->nickname ?></td>
                        <td><?php echo $record->phone ?></td>
                        <td><?php echo number_format($record->gold); ?></td>
                        <td><?php 
                        if($record->user_type ==1){
                            echo "Member";    
                        }
                        if($record->user_type ==2){
                            echo "Đại lý cấp 1"; 
                        }
                        if($record->user_type ==3){
                            echo "Admin"; 
                        }
                        ?>
                        </td>
                        
                        <td class="text-center">
                            <a class="btn btn-sm btn-primary" href="<?= base_url().'login-history/'.$record->id; ?>" title="Login history"><i class="fa fa-history"></i></a>
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'editOld/'.$record->id; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a class="btn btn-sm btn-danger deleteUser" href="#" data-userid="<?php echo $record->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php echo $this->pagination->create_links(); ?>
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
