<div class="form-group col-md-12" style="margin-top:20px;">
    <label>项目名称：</label>{$op.project}
</div>

<div class="form-group col-md-4">
    <label>项目类型：</label><?php echo $kinds[$op['kind']]; ?>
</div>

<div class="form-group col-md-4">
    <label>预计人数：</label>{$op.number}人
</div>

<div class="form-group col-md-4">
    <label>出团日期：</label>{$op.departure}
</div>

<div class="form-group col-md-4">
    <label>行程天数：</label>{$op.days}天
</div>

<div class="form-group col-md-4">
    <label>目的地：</label>{$op.destination}
</div>

<div class="form-group col-md-4">
    <label>立项时间：</label>{$op.op_create_date}
</div>

<div class="form-group col-md-4">
    <label>业务部门：</label>{$op.op_create_user}
</div>

<div class="form-group col-md-4">
    <label>销售人员：</label>{$op.sale_user}
</div>

<div class="form-group col-md-4">
    <label>客户单位：</label>{$op.customer}
</div>

<?php if($op_expert){ ?>
    <div class="form-group col-md-12">
        <label>协助销售实施专家：</label>
        <foreach name="op_expert" item="v">
            {:username($v)} &emsp;
        </foreach>
    </div>
<?php } ?>

<?php if ($is_dijie){ ?> <!--内部地接-->
    <div class="form-group col-md-8">
        <div class="form-group col-md-12"  style="margin-top:20px; margin-left: -15px;">
            <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">项目背景</label>
            <div style="width:100%; margin-top:10px;">{$op.context}</div>
        </div>

        <div class="form-group col-md-12" style="margin-top:20px;margin-left: -15px;">
            <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">项目说明</label>
            <div style="width:100%; margin-top:10px;">{$op.remark}</div>
        </div>
    </div>

    <div class="form-group col-md-4">
        <div class="form-group col-md-12" style="margin-top:20px;margin-left: -15px;">
            <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">内部满意度评分二维码&emsp;<span class="red">(请发送给组团方：{$is_dijie.create_user_name})</span></label>
            <div style="width:100%; margin-top:10px;">
                <div id="code"></div>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="form-group col-md-12"  style="margin-top:20px;">
        <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">项目背景</label>
        <div style="width:100%; margin-top:10px;">{$op.context}</div>
    </div>

    <div class="form-group col-md-12" style="margin-top:20px;">
        <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">项目说明</label>
        <div style="width:100%; margin-top:10px;">{$op.remark}</div>
    </div>
<?php } ?>
