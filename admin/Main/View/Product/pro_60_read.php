<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-8">
                    <label>课程名称：{$detail.title}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>上课地址：{$detail.addr}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>是否标准化：<?php echo $list['standard']==1 ? '标准化' : '非标准化'; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>标准化产品：{$producted_list.title}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>开课时间(第一次上课时间)：{$detail.lession_time|date='Y-m-d',###}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>课程时间：星期{$detail.week}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>具体时间段：{$detail.st_time|date='H:i:s',###} - {$detail.et_time|date='H:i:s',###}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：{$detail.menber}人</label>
                </div>
                <div class="form-group col-md-4">
                    <label>上课次数：{$detail.lession_num}次</label>
                </div>
                <div class="form-group col-md-4">
                    <label>是否设置动手实践：{$detail['hands_on']==1 ? '是' : '否'}</label>
                </div>
                <div class="form-group col-md-4">
                    <label>材料预算：{$detail.material_cost}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>教师数量：{$detail.teacher_num}人</label>
                </div>

                <div class="form-group col-md-4">
                    <label>教师级别：{$detail.teacher_level}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>教师费用：{$detail.teacher_cost}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>教师要求：{$detail.teacher_condition}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>其他资源需求：{$detail.other_res_condition}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>其他需求：{$detail.remark}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>