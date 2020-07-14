<div class="row">
    <!-- right column -->
    <div class="col-md-12">
        <!-- general form elements disabled -->
        <div class="box box-warning mt20">
            <div class="box-header">
                <h3 class="box-title">产品方案需求基本信息
                    <?php echo $oplist['group_id'] ? "<span style='font-weight:normal; color:#ff3300;'>（团号：".$oplist['group_id']."）</span>" : ' <span style=" color:#999999;">(该项目暂未成团)</span>'; ?>
                </h3>
                <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">审核状态：<?php echo $scheme_list['audit_status'] ? $audit_status[$scheme_list['audit_status']] : '未提交'; ?>&emsp;</h3>
            </div><!-- /.box-header -->
            <div class="box-body" style=" padding-top:30px; padding-bottom:0px;">

                <div class="form-group col-md-12">
                    <label>项目名称：{$oplist.project}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>项目类型：{$oplist.kind}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>适合人群：{$oplist.apply_to}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>预计人数：{$oplist.number}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>计划出团日期：{$oplist.deperture}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>行程天数：{$oplist.days} 天</label>
                </div>

                <div class="form-group col-md-4">
                    <label>目的地：{$oplist.destination}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>接待实施部门：{$oplist.dijie_department}</label>
                </div>

                <div class="form-group col-md-8">
                    <label>客户单位：{$oplist.customer}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>线控负责人：{$oplist.line_blame_name}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>客户预算：&yen; {$oplist.cost}</label>
                </div>

                <div class="form-group col-md-4">
                    <label><!--是否请研发部研发新模块-->是否标准化模块: <?php echo $oplist['new_model']==1 ? '是' : '否'; ?></label>
                </div>

                <div class="form-group col-md-12">
                    <label>备注：{$oplist.remark}</label>
                </div>

                <div class="form-group">&nbsp;</div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </div><!--/.col (right) -->
</div>   <!-- /.row -->





