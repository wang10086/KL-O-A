<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">综合评分
            <if condition="$op['group_id']">
                <span style="font-weight:normal; color:#ff3300;">（团号：{$op.group_id}）</span>
                <else />
                <span style="font-weight:normal; color:#ff3300;">（团号：未成团)</span>
            </if>
        </h3>
        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
    </div>
    <div class="box-body">
        <div class="content" style="margin-left:15px;">该项目尚未评分！</div>
    </div>

</div><!--/.col (right) -->