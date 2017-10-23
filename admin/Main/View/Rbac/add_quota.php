<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>编辑KPI指标</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/kpi_quota')}"><i class="fa fa-gift"></i> KPI指标管理</a></li>
                        <li class="active">用户管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Rbac/add_quota')}" name="myform" id="myform">   
                            <input type="hidden" name="dosubmit" value="1" />
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                            <input type="hidden" name="editid" value="{$row.id}" />
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">编辑指标</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" id="tab_1">
                                    
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>指标名称</label>
                                        <input class="form-control"  type="text" name="info[quota_title]"  value="{$row.quota_title}"/>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label>指标内容</label>
                                        <textarea class="form-control" name="info[quota_content]" >{$row.quota_content}</textarea>
                                    </div>
                                    
                                    <!--
                                    <div class="form-group col-md-4">
                                        <label>指标值</label>
                                        <input class="form-control"  type="text" name="info[quota_value]"  value="{$row.quota_value}"/>
                                    </div>
                                    -->
                                    
                                    <div class="form-group col-md-6">
                                        <label>权重</label>
                                        <input class="form-control"  type="text" name="info[weight]"  value="{$row.weight}"/>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label>考核周期</label>
                                        <input class="form-control"  type="text" name="info[cycle]"  value="{$row.cycle}"/>
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>衡量方法</label>
                                        <textarea class="form-control" name="info[method]" >{$row.method}</textarea>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label>实际得分计算</label>
                                        <textarea class="form-control" name="info[calculate]" style="height:120px;" >{$row.calculate}</textarea>
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
 