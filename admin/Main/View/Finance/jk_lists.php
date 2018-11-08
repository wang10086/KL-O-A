<div class="box-body">
    <?php if ($jk_lists){ ?>
    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
        <tr role="row" class="orders" >
            <th class="sorting" width="80" data="id">ID</th>
            <th class="sorting" width="150" data="jk_user">借款人</th>
            <th class="sorting" width="150" data="rolename">借款部门</th>
            <th class="sorting" data="sum">借款金额</th>
            <th class="sorting" data="">审核信息</th>
            <if condition="rolemenu(array('Finance/aaa'))">
                <th class="taskOptions" width="80" data="">详情</th>
            </if>

        </tr>
        <foreach name="jk_lists" item="row">
            <tr>
                <td>{$row.id}</td>
                <td>{$row.jk_user}</td>
                <td>{$row.rolename}</td>
                <td>{$row.sum}</td>
                <td>{$row.auditstatus}</td>
                <if condition="rolemenu(array('Finance/aaa'))">
                    <td class="taskOptions">
                        <a href="{:U('Finance/aaa',array('opid'=>$row['op_id']))}" title="借款" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                    </td>
                </if>
            </tr>
        </foreach>
    </table>
    <?php }else{ ?>
        <div class="content" style="margin-left:15px;">暂无借款信息！</div>
    <?php } ?>
</div><!-- /.box-body -->
<div class="box-footer clearfix">
    <div class="pagestyle">{$pages}</div>
</div>