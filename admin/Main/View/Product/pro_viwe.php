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
                                            <p>适用年龄：{$row.ages}</p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>科学领域：{$subject_fields[$row[subject_field]]}</p>
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>参考成本价：<span class="red">&yen; {$row.sales_price}</span></p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
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

                                        <div class="form-group col-md-12 viwe">
                                            <p style="display: inline-block;">相关图片：</p>
                                            <?php if($pic){ ?>
                                            <div style=" height: 120px; ">
                                                <foreach name="pic" item="v">
                                                    <a href="/{$v['filepath']}" target="_blank"> <img src="/{$v['filepath']}" height="100" width="100" style="margin: 10px 0 0 15px;"></a>
                                                </foreach>
                                            </div>
                                            <?php }else{ ?>
                                                <div style="height: 80px;line-height: 80px;margin-left: 20px;">暂无图片信息!</div>
                                            <?php } ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            <?php if($row['content']){ ?>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">产品模块介绍</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="margin-top:10px;">
                                    	<div class="form-group col-md-12 viwe">{$row.content}</div>
                                        
                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <?php } ?>
                            
                            
                            <?php if($row['supplier']){ ?>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">关联科普资源</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="margin-top:-10px;">
                                    	
                                        <table class="table table-striped" id="supplierlist" >
                                            <thead>
                                                <tr role="row">
                                                    <th>资源名称</th>
                                                    <th width="100">资源类型</th>
                                                    <th width="200">所在地</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <foreach name="supplier" key="k" item="v">
                                                <tr id="supplier_{$v.id}">
                                                    <td><input type="hidden" name="res[]" value="{$v.id}"><a href="{:U('ScienceRes/res_view',array('id'=>$v['id']))}" target="_blank">{$v.title}</a></td>
                                                    <td><?php echo $reskind[$v['kind']]; ?></td>
                                                    <td>{$v.diqu}</td>
                                                    
                                                </tr>
                                                </foreach>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                   
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <?php } ?>
                            
                            <?php if(cookie('roleid') !=16 && cookie('roleid')!=17 && cookie('roleid') !=18 && cookie('roleid')!=19 && cookie('roleid')!=33 && cookie('roleid')!=35 ){ ?>
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">模块物资清单</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($material){ ?>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    	<tr role="row" class="orders" >
                                            <th style="width: 50px">编号</th>
                                            <th>物资名称</th>
                                            <th>物资规格</th>
                                            <th>数量</th>
                                            <th>参考单价</th>
                                            <th>购买途径</th>
                                            <th>备注</th>
                                        </tr>
                                        <foreach name="material" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.material}</td>
                                            <td>{$row.spec}</td>
                                            <td>{$row.amount}</td>
                                            <td>&yen;{$row.unitprice}</td>
                                            <td>{$row.channel}</td>
                                            <td>{$row.remarks}</td>
                                        </tr>
                                        </foreach>
                                    </table>
                                    <?php }else{ echo '<div style="padding:25px;">暂未添加任何物资</div>'; } ?>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">产品文案附件</h3>
                                </div>
                                <div class="box-body">
                                	<?php if($atts){ ?>
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                    	<tr role="row" class="orders" >
                                            <th style="width: 50px">编号</th>
                                            <th>文件名</th>
                                            <th>文件类型</th>
                                            <th>文件种类</th>
                                            <th>文件大小</th>
                                            <th style="width: 80px">下载</th>
                                        </tr>
                                        <foreach name="atts" key="k" item="row">
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.filename}</td>
                                            <td>{$row.type}</td>
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
<script type="text/javascript">
$(document).ready(function(e) {
    $('#supplierlist').show();
});
</script>