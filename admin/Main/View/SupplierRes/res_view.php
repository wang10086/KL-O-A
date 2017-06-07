<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span class="green">合格供方</span> - <span style="color:#333333">{$row.name}</span>
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
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">供方属性</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">
                                		
                                        
                                        <div class="form-group col-md-8 viwe">
                                            <p>供方名称：{$row.name}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>供方类型：{$reskind[$row[kind]]}</p>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>所在国家：{$row.country}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>所在省份：{$row.prov}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>所在城市：{$row.city}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>发布时间：{$row.input_time|date='Y-m-d H:i:s',###}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>联系人：{$row.contact}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>联系电话：{$row.tel}</p>
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
                         
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">供方介绍</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    
                                    <div class="content" style="margin-top:10px;">
                                    	<div class="form-group col-md-12 viwe">{$row.desc}</div>
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