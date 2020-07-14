

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
                            if ($scheme_list['new_model']==1){ //标准化
                                echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/standard_producted_detail', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td></tr>';
                            }else{ //飞标准化
                                echo '<tr id="tpl_'.$tpl.$row['id'].'"><td><input type="hidden" name="pro[]" value="'.$row['id'].'">'.$row['id'].'</td><td><a href="'.U('Product/view', array('id'=>$row['id'])).'" target="_blank">'.$row['title'].'</a></td><td>'.$row['input_uname'].'</td></tr>';
                            }
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

        <?php if ($scheme_list['audit_status'] == 3 && in_array(cookie('userid'),array(1,11,$scheme_list['audit_user_id']))){ ?>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">审核</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="content">
                    <form method="post" action="{:U('Product/public_save')}" id="audit_form">
                        <input type="hidden" name="dosubmit" value="1">
                        <input type="hidden" name="savetype" value="21">
                        <input type="hidden" name="id" value="{$scheme_list.id}">

                        <div class="form-group box-float-12">
                            <label class="">审核意见：</label>
                            <input type="radio" name="status" value="1"> &#8194;审核通过 &#12288;&#12288;&#12288;
                            <input type="radio" name="status" value="2"> &#8194;审核不通过
                        </div>

                        <div class="form-group box-float-12">
                            <label>备注</label>
                            <textarea class="form-control" name="audit_remark"></textarea>
                        </div>

                        <div id="formsbtn">
                            <button type="button" class="btn btn-info btn-sm" onclick="$('#audit_form').submit()">保存</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.box-body -->
        </div>
        <?php } ?>





