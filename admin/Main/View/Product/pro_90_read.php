<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>类型： {$detail.type}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>产品状态：<?php echo $detail['standard']==1 ? '定制化' : '标准化'; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>学科：{$detail.lession}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>领域：{$detail.field}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>授课形式：{$detail.teaching_form}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>成果：{$detail.gain}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他线路需求：{$detail.other_yf_condition}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>专家级别：{$detail.expert_level}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>是否指定院所：<?php echo $detail['is_need_ins']==1 ? '是；院所名称：'.$detail['ins_name'] : '否；'; ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员（科研秘书）数量：{$detail.guide_num}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员（科研秘书）要求：{$detail.guide_condition}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求：{$detail.other_zy_condition}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-6">
                    <label>海报：<?php echo $detail['is_need_poster']==1 ? '需要，要求：'.$detail['poster_condition'] : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>微信软文：<?php echo $detail['is_need_wechat']==1 ? '需要，要求：'.$detail['wechat_condition'] : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>H5宣传页：<?php echo $detail['is_need_H5']==1 ? '需要，数量：'.$detail['H5_num'].'，要求：'.$detail['H5_condition'] : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他设计需求：{$detail.other_sj_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>