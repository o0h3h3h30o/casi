<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Danh sách giao dịch
        <small></small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>user/giftcode"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quản lý giao dịch</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>userListing" method="POST" id="searchList">
                            <div class="input-group">
                             
                              
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                        
                        <th>User chuyển</th>
                        <th>User nhận</th>
                        <th>Gold</th>
                        <th>Thời gian</th>
                        <th>Lý do chuyển</th>
                        <th>Trạng thái</th>
                        
                    </tr>
                    <?php
                    if (!empty($rs))
                    {
                        foreach($rs as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->user_send->nickname; ?></td>
                        <td><?php echo $record->user_recived->nickname; ?></td>
                      
                        
                        <td><?php echo number_format($record->amount); ?></td>
                        
                        <td><?php echo $record->time; ?></td>
                        </td>
                        <td><?php echo $record->note; ?></td>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                   
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php // echo $this->pagination->create_links(); ?>
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
