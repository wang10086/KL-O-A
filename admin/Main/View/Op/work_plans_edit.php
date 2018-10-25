
    <div id="plans">
        <div class="userlist">
            <div class="unitbox">需计调操作具体内容</div>
            <div class="unitbox">标准</div>
            <div class="unitbox">备注</div>
        </div>
        <?php if($plans){ ?>
        <foreach name="plans" key="k" item="v">
        <div class="userlist cost_expense" id="plans_id_c_{$k}">
            <span class="title"><?php echo $k+1; ?></span>
            <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" >
            <input type="text" class="form-control" name="plans[888{$k}][content]" value="{$v.content}">
            <input type="text" class="form-control totalval" name="plans[888{$k}][standard]" value="{$v.standard}">
            <input type="text" class="form-control" name="plans[888{$k}][remark]" value="{$v.remark}">
            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('plans_id_c_{$k}')">删除</a>
        </div>
        </foreach>
        <?php } ?>
    </div>

    <div id="plans_val">1</div>
    <div class="form-group col-md-12" id="useraddbtns" style="margin-left:15px;">
        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_plans()"><i class="fa fa-fw fa-plus"></i> 新增内容</a>
    </div>
    <div class="form-group">&nbsp;</div>

