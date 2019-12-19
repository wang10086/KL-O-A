<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span class="green">集中采购</span> - <span style="color:#333333">{$list.title}</span>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('SupplierRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">
                                        <div class="form-group col-md-4 viwe">
                                            <p>采购事项：{$list.title}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>供方名称：{$list.supplier_name}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>所属分类：{$list.type}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>集采年份：{$list.year} 年</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>业务季：{$list.}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>计价规则：{$list.rule}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>计价单位：{$list.unit}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>集采单价：{$list.unitcost}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>市场价格：{$list.business_unitcost}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>审批状态：{$row.showstatus}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批人：{$row.show_user}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批时间：{$row.show_time}</p>
                                        </div>

                                        <div class="form-group col-md-12">
                                            备注：{$list.remark}
                                        </div>
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />