<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-8">
                    <label>课程名称：{$need['title'] ? $need['title'] : $detail['title']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>上课地址：{$need['addr'] ? $need['addr'] : $detail['addr']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>是否标准化：{$need ? ($need['standard']==1 ? '标准化' : '非标准化') : ($detail['standard']==1 ? '标准化' : '非标准化')}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>标准化产品：{$producted_list.title}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>开课时间(第一次上课时间)：<?php echo $need['lession_time'] ? date('Y-m-d',$need['lession_time']) :($detail['lession_time'] ? date('Y-m-d',$detail['lession_time']) :''); ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>课程时间：星期{$need['week'] ? $need['week'] : $detail['week']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>具体时间段：
                        <?php echo $need['st_time'] ? date('H:i:s',$need['st_time']).' - '.date('H:i:s',$need['et_time']) : ($detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：{$need['menber'] ? $need['menber'] : $detail['menber']}人</label>
                </div>
                <div class="form-group col-md-4">
                    <label>上课次数：{$need['lession_num'] ? $need['lession_num'] : $detail['lession_num']}次</label>
                </div>
                <div class="form-group col-md-4">
                    <label>是否设置动手实践：{$need ? ($need['hands_on']==1 ? '是' : '否') : ($detail['hands_on']==1 ? '是' : '否')}</label>
                </div>
                <div class="form-group col-md-4">
                    <label>材料预算：{$need['material_cost'] ? $need['material_cost'] : $detail['material_cost']}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>教师数量：{$need['teacher_num'] ? $need['teacher_num'] : $detail['teacher_num']}人</label>
                </div>

                <div class="form-group col-md-4">
                    <label>教师级别：{$need['teacher_level'] ? $need['teacher_level'] : $detail['teacher_level']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>教师费用：{$need['teacher_cost'] ? $need['teacher_cost'] : $detail['teacher_cost']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>教师要求：{$need['teacher_condition'] ? $need['teacher_condition'] : $detail['teacher_condition']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>其他资源需求：{$need['other_res_condition'] ? $need['other_res_condition'] : $detail['other_res_condition']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>其他需求：{$need['remark'] ? $need['remark'] : $detail['remark']}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>