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
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">产品模块介绍</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">

                                        <div class="form-group col-md-12 viwe">
                                            <p>标准模块名称：{$row.title}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>适用项目：{$row.dept}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>适用年龄：{$row['ages']}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>核算模式：{$reckon_mode[$row['reckon_mode']]}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>参考成本价：<span class="red">&yen; {$row.sales_price}</span></p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>科学领域：{$subject_fields[$row[subject_field]]}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>研发专家：{$row.input_uname}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>审批状态：{$audit_status[$row['audit_status']]}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批人：{$row.audit_uname}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批时间：{$row.audit_time}</p>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="lit-title">产品模块内容</label>
                                            <div class="form-group viwe"><?php echo htmlspecialchars_decode($row['content']); ?></div>
                                        </div>
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">包含产品模块</h3>
                                </div>
                                <div class="box-body">
                                    <?php if($module_lists){ ?>
                                        <table class="table table-bordered dataTable fontmini" id="tablelist">
                                            <tr role="row" class="orders" >
                                                <th style="width: 50px">编号</th>
                                                <th>产品名称</th>
                                                <th>活动时长</th>
                                                <th>模块内容</th>
                                                <th>实施要求</th>
                                                <th>配套资料</th>
                                                <th>备注</th>
                                            </tr>
                                            <foreach name="module_lists" key="k" item="row">
                                                <tr>
                                                    <td><?php echo $k+1; ?></td>
                                                    <td>{$row.title}</td>
                                                    <td>{$row.length} 小时</td>
                                                    <td>{$row.content}</td>
                                                    <td><a href="{$files[$row['implement_fid']]}" title="{$row.implement_fname}" target="_blank">{$row.implement_fname}</a></td>
                                                    <td>
                                                        <!--<a href="{$files[$row['res_fid']]}" title="{$row.res_fname}" target="_blank">{$row.res_fname}</a>-->
                                                        <?php foreach ($row['resFiles'] as $file){ ?>
                                                            <span style="display: block"><a href="{$file.file_path}" target="_blank">{$file.file_name}</a></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>{$row.remark}</td>
                                                </tr>
                                            </foreach>
                                        </table>
                                    <?php }else{ echo '<div style="padding:25px;">暂未添加任何产品</div>'; } ?>
                                </div>
                            </div>
                            
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">模块成本核算</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($material_lists){ ?>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    	<tr role="row" class="orders" >
                                            <th style="width: 50px">编号</th>
                                            <th>费用项</th>
                                            <th>规格</th>
                                            <th>单价</th>
                                            <th>数量</th>
                                            <th>合计价格</th>
                                            <th>类型</th>
                                            <th>供方</th>
                                            <th>备注</th>
                                        </tr>
                                        <foreach name="material_lists" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.material}</td>
                                            <td>{$row.spec}</td>
                                            <td>{$row.unitprice}</td>
                                            <td>{$row.amount}</td>
                                            <td>&yen;{$row.total}</td>
                                            <td>{$row.type}</td>
                                            <td>{$row.supplierRes_id}</td>
                                            <td>{$row.remarks}</td>
                                        </tr>
                                        </foreach>
                                    </table>
                                    <?php }else{ echo '<div style="padding:25px;">暂未添加任何资源</div>'; } ?>
                                </div>
                            </div>

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">相关附件</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($atts){ ?>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    	<tr role="row" class="orders" >
                                            <th style="width: 50px">编号</th>
                                            <th>文件名</th>
                                            <th>文件种类</th>
                                            <th>文件大小</th>
                                            <th style="width: 80px">下载</th>
                                        </tr>
                                        <foreach name="atts" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.filename}</td>
                                            <td>{$row.fileext}</td>
                                            <td><?php echo sprintf("%.1f", $row['filesize']/1024); ?>K</td>
                                            <td><a href="{$row.filepath}" class="badge bg-red" target="_blank">下载</a></td>
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

