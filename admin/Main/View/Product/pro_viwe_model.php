<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span style="color:#333333">{$row.title}</span>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Project/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    <h3 class="box-title">产品模板介绍</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">

                                        <div class="form-group col-md-12 viwe">
                                            <p>模板名称：{$row.title}</p>
                                        </div>
                                        <div class="form-group col-md-12 viwe">
                                            <p>适用项目：{$row.dept}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-12 viwe">
                                            <p>适用年龄：{$row.ages}</p>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-12 viwe">
                                            <p>研发专家：{$row.input_uname}</p>
                                        </div>
										
                                        <!--
                                        <div class="form-group col-md-4 viwe">
                                            <p>发布时间：{$row.input_time|date='Y-m-d H:i:s',###}</p>
                                        </div>
                                        -->

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
                            
                            <?php if($row['content']){ ?>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">产品模板介绍</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="margin-top:10px;">
                                    	<div class="form-group col-md-12 viwe">{$row.content}</div>
                                    </div>
                                   
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <?php } ?>
                            
                            
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">模板附件</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($atts){ ?>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    	<tr role="row" class="orders" >
                                            <th style="width: 50px">编号</th>
                                            <th>文件名</th>
                                            <th>文件类型</th>
                                            <th>文件大小</th>
                                            <th style="width: 80px">下载</th>
                                        </tr>
                                        <foreach name="atts" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.filename}</td>
                                            <td>{$row.fileext}</td>
                                            <td><?php echo sprintf("%.1f", $row['filesize']/1024); ?>K</td>
                                            <td><a href="{$row.filepath}" class="badge bg-red">下载</a></td>
                                        </tr>
                                        </foreach>
                                    </table>
                                    <?php }else{ echo '<div style="padding:25px;">暂未上传任何附件</div>';} ?>
                                </div>
                            </div>
                            

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />