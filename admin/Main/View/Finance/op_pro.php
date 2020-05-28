<div class="form-group col-md-4">
    <label>项目名称：</label>{$op.project}
</div>

<div class="form-group col-md-4">
    <label>项目类型：</label><?php echo $kinds[$op['kind']]; ?>
</div>

<div class="form-group col-md-4">
    <label>递交客户时间：{$op.time|date='Y-m-d',###}</label>
</div>

<div class="form-group col-md-4">
    <label>适合人群：{$apply_to[$op['apply_to']]}</label>
</div>

<div class="form-group col-md-4">
    <label>预计人数：{$op.number}人</label>
</div>

<div class="form-group col-md-4">
    <label>计划出团日期：{$op.departure}</label>
</div>

<div class="form-group col-md-4">
    <label>行程天数：{$op.days}天</label>
</div>

<div class="form-group col-md-4">
    <label>目的地省份：{$provinces[$op['province']]}</label>
</div>

<div class="form-group col-md-4">
    <label>详细地址：{$op.destination}</label>
</div>

<div class="form-group col-md-4">
    <label>客户单位：{$op.customer}</label>
</div>

<div class="form-group col-md-4">
    <label>接待实施部门：{$departments[$op['dijie_department_id']]}</label>
</div>

<div class="form-group col-md-4">
    <label>线控负责人：{$op.line_blame_name}</label>
</div>

<div class="form-group col-md-4">
    <label>客户预算：{$op.cost}</label>
</div>

<div class="form-group col-md-4">
    <label>业务人员：{$op.sale_user}</label>
</div>

<div class="form-group col-md-4">
    <label>业务部门：{$departments[$op['create_user_department_id']]}</label>
</div>

<div class="form-group col-md-12"  style="margin-top:20px;">
    <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">项目背景</label>
    <div style="width:100%; margin-top:10px;">{$op.context}</div>
</div>

<div class="form-group col-md-12" style="margin-top:20px;">
    <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">项目说明</label>
    <div style="width:100%; margin-top:10px;">{$op.remark}</div>
</div>

