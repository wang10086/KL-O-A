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
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">

                                        <div class="form-group col-md-12 viwe">
                                            <p>产品名称：{$row.title}</p>
                                        </div>

                                        <div class="form-group col-md-12 viwe">
                                            <p>适用项目：{$row.dept}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-12 viwe">
                                            <p>适用年龄：{$apply[$row['age']]}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>核算模式：{$reckon_mode[$row['reckon_mode']]}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>参考成本价：<span class="red">&yen; {$row.sales_price}</span></p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>是否标准化：{$standard[$row['standard']]}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>科学领域：{$subject_fields[$row[subject_field]]}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>产品来源：{$product_from[$row['from']]}</p>
                                        </div>

                                        <div class="form-group col-md-4 viwe">
                                            <p>研发专家：{$row.input_uname}</p>
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
                                    <?php if($product_use_list){ ?>
                                        <table class="table table-bordered dataTable fontmini" id="tablelist">
                                            <tr role="row" class="orders" >
                                                <th style="width: 50px">编号</th>
                                                <th>产品名称</th>
                                                <th>数量</th>
                                                <th>参考单价</th>
                                                <th>总价</th>
                                            </tr>
                                            <foreach name="product_use_list" key="k" item="row">
                                                <tr>
                                                    <td><?php echo $k+1; ?></td>
                                                    <td>{$row.title}</td>
                                                    <td>{$row.amount}</td>
                                                    <td>&yen;{$row.unitcost}</td>
                                                    <td>&yen;{$row.total}</td>
                                                </tr>
                                            </foreach>
                                        </table>
                                    <?php }else{ echo '<div style="padding:25px;">暂未添加任何产品</div>'; } ?>
                                </div>
                            </div>
                            
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">包含资源模块</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($cas_list){ ?>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    	<tr role="row" class="orders" >
                                            <th style="width: 50px">编号</th>
                                            <th>资源名称</th>
                                            <th>性质</th>
                                            <th>所在地区</th>
                                        </tr>
                                        <foreach name="cas_list" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.title}</td>
                                            <td>{$in_cas[$row[in_cas]]}</td>
                                            <td>{$row.diqu}</td>
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

