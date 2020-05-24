<include file="Index:header2" />


			<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$list.project}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/public_scheme')}"><i class="fa fa-gift"></i> 项目方案管理</a></li>
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
                                    <h3 class="box-title">产品方案需求基本信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" style=" padding-top:30px; padding-bottom:0px;">

                                    <div class="form-group col-md-6">
                                        <label>项目名称：{$list.project}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>项目类型：{$list.kind}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>适合人群：{$list.apply_to}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>预计人数：{$list.number}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>计划出团日期：{$list.deperture}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>行程天数：{$list.days} 天</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>目的地：{$list.destination}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>客户单位：{$list.customer}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>接待实施部门：{$list.dijie_department}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>线控负责人：{$list.line_blame_name}</label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>客户预算：&yen; {$list.cost}</label>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>备注：{$list.remark}</label>

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
									foreach($pro_lists as $row){
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
                                    <h3 class="box-title">产品实施方案模板</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th width="80">ID</th>
                                        <th>模板名称</th>
                                        <th width="120">专家</th>
                                    </tr>
                                    <?php
									foreach($pro_model_lists as $row){
										echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/model_view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td></tr>';
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
                                    <h3 class="box-title">参考产品实施方案</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="80">ID</th>
                                            <th>方案名称</th>
                                            <th width="120">专家</th>
                                        </tr>
                                        <?php
                                        foreach($line_lists as $row){
                                            echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/view_line', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td></tr>';
                                        }
                                        ?>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->

                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">附件下载</h3>
                        </div>
                        <div class="box-body">
                            <?php if($atta_lists){ ?>
                            <table class="table table-bordered dataTable fontmini" id="tablelist">
                                <tr role="row" class="orders" >
                                    <th style="width: 50px">编号</th>
                                    <th>文件名</th>
                                    <th>文件类型</th>
                                    <th>文件大小</th>
                                    <th style="width: 80px">下载</th>
                                </tr>
                                <foreach name="atta_lists" key="k" item="row">
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

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />





