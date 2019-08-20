<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Lịch sử game
        <small>Báo cáo</small>
      </h1>
    </section>
    <section class="content">
        <div class="row">
            
        </div>
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Danh sách logs</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>logs" method="POST" id="searchList">
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
                        <th>Tiền bid</th>
                        <th>Tiền win</th>
                        <th>Game</th>
                        <th>Thời gian cuợc</th>

                        <th class="text-center">Actions</th>
                    </tr>
                    <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $record->userName ?></td>
                        
                        <td><?php echo number_format($record->bid); ?></td>
                        <td><?php echo number_format($record->win); ?></td>
                        <td><?php 
                        if($record->gameId ==1){
                            echo "Minipoker";    
                        }
                        if($record->gameId ==2){
                            echo "Cao thâp"; 
                        }
                        if($record->gameId ==3){
                            echo "Slot 3x3"; 
                        }
                        if($record->gameId ==4){
                            echo "Vương quốc hũ"; 
                        }
                        if($record->gameId ==5){
                            echo "Zombie"; 
                        }
                        if($record->gameId ==6){
                            echo "Tài xỉu"; 
                        }
                        ?>
                        </td>
                        <td><?php echo $record->logTime ?></td>
                        <td class="text-center">
                            <?php echo $record->extendContent ?>
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
    // jQuery(document).ready(function(){
    //     jQuery('ul.pagination li a').click(function (e) {
    //         e.preventDefault();            
    //         var link = jQuery(this).get(0).href;            
    //         var value = link.substring(link.lastIndexOf('/') + 1);
    //         jQuery("#searchList").attr("action", baseURL + "logs/" + value);
    //         jQuery("#searchList").submit();
    //     });
    // });
</script>
