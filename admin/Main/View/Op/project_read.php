<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">业务实施方案</h3>
        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">  审核状态：{$audit_status[$project_list['audit_status']]}</h3>
    </div>
    <div class="box-body">

        <?php if($atta_lists){ ?>
            <div class="form-group ">
                <label>方案说明：</label>  {$project_list.remark}
            </div>

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
        <?php }else{ echo '<div style="padding:25px;">暂未制定业务实施方案</div>';} ?>
    </div>
</div>