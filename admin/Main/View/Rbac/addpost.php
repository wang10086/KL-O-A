<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>编辑岗位</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/post')}"><i class="fa fa-gift"></i>编辑岗位</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Rbac/addpost')}" name="myform" id="myform">   
                            <input type="hidden" name="dosubmit" value="1" />
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                            <input type="hidden" name="editid" value="{$row.id}" />
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑岗位</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" id="tab_1">
                                    
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>岗位名称</label>
                                        <input class="form-control"  type="text" name="info[post_name]"  value="{$row.post_name}"/>
                                    </div>
                                    
                                    
                                    <div class="form-group">&nbsp;</div>
                                        

                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                            </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>


<include file="Index:footer2" />
 