<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>报销单信息</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Finance/baoxiaodan_lists')}"><i class="fa fa-gift"></i> 报销单信息</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">非团支出报销单信息</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <span class="green">报销单编号：{$baoxiao['bxd_id']}</span>
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if ($baoxiao['audit_status'] == 0){ ?>
                                        <include file="progress_bx" />
                                    <?php } ?>
                                    <include file="nop_baoxiaodan" />
                                </div>
                            </div>

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />


     


