<div class="form-group col-md-12">
    <div class="form-group col-md-12">
        <label>客户名称：{$list.project}</label>
    </div>

    <div class="form-group col-md-4">
        <label>项目类型：{$kinds[$list['kind']]}</label>
    </div>

    <div class="form-group col-md-4">
        <label>递交客户时间：{$list.time|date='Y-m-d',###}</label>
    </div>

    <div class="form-group col-md-4">
        <label>适合人群：{$apply_to[$list['apply_to']]}</label>
    </div>

    <div class="form-group col-md-4">
        <label>预计人数：{$list.number}人</label>
    </div>

    <div class="form-group col-md-4">
        <label>计划出团日期：{$list.departure}</label>
    </div>

    <div class="form-group col-md-4">
        <label>行程天数：{$list.days}天</label>
    </div>

    <div class="form-group col-md-4">
        <label>目的地省份：{$provinces[$list['province']]}</label>
    </div>

    <div class="form-group col-md-4">
        <label>详细地址：{$list.destination}</label>
    </div>

    <div class="form-group col-md-4">
        <label>客户单位：{$list.customer}</label>
    </div>

    <div class="form-group col-md-4">
        <label>接待实施部门：{$departments[$list['dijie_department_id']]}</label>
    </div>

    <div class="form-group col-md-4">
        <label>线控负责人：{$list.line_blame_name}</label>
    </div>

    <div class="form-group col-md-4">
        <label>客户预算：{$list.cost}</label>
    </div>

    <div class="form-group col-md-4">
        <label>业务人员：{$list.sale_user}</label>
    </div>

    <div class="form-group col-md-8">
        <label>业务部门：<?php echo $departments[$list['create_user_department_id']] ?></label>
    </div>

    <div class="form-group col-md-12">
        <label>备注：{$list.remark}</label>
    </div>
</div>