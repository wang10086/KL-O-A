		<include file="Index:header2" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>消息详情</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Message/index')}">消息列表</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        
                        <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title" id="bigtit">{$row.title}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" id="courapp" style="padding-top:20px;">
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>消息正文</label>
                                        <div class="fonttextms">
                                        <?php if($row['content']){ echo nl2br($row['content']); }else{ echo '无';}?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="fonttextms">
                                        <a href="{$row.msg_url}" target="_blank">查看详情</a>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-md-12" style="margin-bottom:0; color:#999999;">
                                        发送时间：{$row.send_time|date='Y-m-d H:i',###}
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                        
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
        
        <include file="footer2" />
        
       
        