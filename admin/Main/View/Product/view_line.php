<include file="Index:header2" />


			<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$row.title}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/line')}"><i class="fa fa-gift"></i> 线路管理</a></li>
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
                                    <h3 class="box-title">行程方案描述</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" style=" padding-top:30px; padding-bottom:0px;">
                                   
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-3">
                                        <label>目的地：{$row.dest}</label>
                                       
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>行程天数：{$row.days}天</label>
                                        
                                    </div>
                                    
                                    <div class="form-group col-md-3">
                                        <label>类型：{$row.kind_name}</label>
                                        
                                    </div>
                                    
                                   
                                    
                                    <div class="form-group col-md-3">
                                        <label>参考价格：&yen; {$row.sales_price}</label>
                                       
                                    </div>
                                    
                                    <!--
                                    <div class="form-group col-md-4">
                                        <label>同行价格：&yen; {$row.peer_price}</label>
                                        
                                    </div>
                                    -->
                                    
                                    
                                    <div class="form-group col-md-12">
                                        <label>备注：{$row.remarks}</label>
                                       
                                    </div>
                                    
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                           
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                    
                    <div class="row">
                        <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">产品模块</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th width="80">ID</th>
                                        <th>模块名称</th>
                                        <th width="120">专家</th>
                                    </tr>
                                    <?php 
									foreach($pro_list as $row){
										echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td></tr>';
									}
									?>
                                </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                           
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                    
                    
                    <div class="row">
                        <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">产品模板</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th width="80">ID</th>
                                        <th>模板名称</th>
                                        <th width="120">专家</th>
                                    </tr>
                                    <?php 
									foreach($pro_model_list as $row){
										echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/model_view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td></tr>';
									}
									?>
                                </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                           
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                    
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">附件下载</h3>
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
                    
                    
                    <div class="row">
                    	<div class="col-md-12">
                        		<div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">日程安排</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div id="task_timu">
                                    <?php 
									foreach($days_list as $k=>$row){
										echo '<div class="tasklist" style="border-bottom:1px solid #dedede;"><div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">'.($k+1).'</span>天&nbsp;&nbsp;&nbsp;&nbsp;'.$row['citys'].'</strong></label><div class="input-group pads">'.$row['content'].'</div><div class="input-group">'.$row['remarks'].'</div></div></div>';
									}
									?>
                                    </div>
                                    
                                   
                                    
                                    
                                    
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div>
                            
                        </div>
                       
                            
                        
                    </div>   <!-- /.row -->
                    
                    
                  
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />

		
     


