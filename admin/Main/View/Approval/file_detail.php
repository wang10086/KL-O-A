<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_pagetitle_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Approval/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12" style="padding-bottom:200px;">

                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green mr20">文件状态：</span></h3>

                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">文件名称</div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批：{$op.showstatus}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>上传人：{$op.show_user}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>上传时间：{$op.show_time}</p>
                                        </div>
                                        <?php  if($op['show_reason']){ ?>
                                        <div class="form-group col-md-4 viwe">
                                            <p>文件说明：{$op.show_reason}</p>
                                        </div>
                                        <?php  } ?>

                                        <div class="form-group col-md-12" style="margin-top:20px;">
                                            <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">文件说明</label>
                                            <div style="width:100%; margin-top:10px;">{$op.remark}</div>
                                        </div>
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />


     


