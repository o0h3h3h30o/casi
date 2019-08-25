<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
      </h1>
    </section>
    
    <section class="content">
        <div class="row">
           

           
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>Gold người chơi: <br></h3>
                  <h4 style="color: red;font-weight: bold;"><?php echo number_format($gold_user); ?></h4>
                  <!-- <p>New Tasks</p> -->
                </div>
                
                <div class="icon">
                  <!-- <i class="ion ion-bag"></i> -->
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>Gold đại lý: <br></h3>
                  <h4 style="color: red;font-weight: bold;"><?php echo number_format($gold_daily); ?></h4>
                  <!-- <p>New Tasks</p> -->
                </div>
                
                <div class="icon">
                  <!-- <i class="ion ion-bag"></i> -->
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>Rương người chơi: <br></h3>
                  <h4 style="color: red;font-weight: bold;"><?php echo number_format($gold_user_deposit); ?></h4>
                  <!-- <p>New Tasks</p> -->
                </div>
                
                <div class="icon">
                  <!-- <i class="ion ion-bag"></i> -->
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>Rương đại lý: <br></h3>
                  <h4 style="color: red;font-weight: bold;"><?php echo number_format($gold_daily_deposit); ?></h4>
                  <!-- <p>New Tasks</p> -->
                </div>
                
                <div class="icon">
                  <!-- <i class="ion ion-bag"></i> -->
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
             <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>Gold hiện có: <br></h3>
                  <h4 style="color: red;font-weight: bold;"><?php echo number_format($userInfo->gold); ?></h4>
                  <!-- <p>New Tasks</p> -->
                </div>

                <div class="icon">
                  <!-- <i class="ion ion-bag"></i> -->
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
    </section>
</div>