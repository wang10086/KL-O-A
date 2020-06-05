<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php if ($need || $detail){ ?>
            <div class="content">
                <div class="form-group col-md-12">
                    <P class="border-bottom-line"> 研发方案需求</P>
                    <div class="form-group col-md-4">
                        <label>类型： {$detail.type}</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>产品状态：{$need ? ($need['standard']==1 ? '标准化' : '非标准化') : ($detail['standard']==1 ? '标准化' : '非标准化')}</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>学科：{$need['lession'] ? $need['lession'] : $detail['lession']}</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>领域：{$need['field'] ? $need['field'] : $detail['field']}</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>授课形式：{$need['teaching_form'] ? $need['teaching_form'] : $detail['teaching_form']}</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>成果：{$need['gain'] ? $need['gain'] : $detail['gain']}</label>
                    </div>

                    <div class="form-group col-md-12">
                        <label>其他线路需求：{$need['other_yf_condition'] ? $need['other_yf_condition'] : $detail['other_yf_condition']}</label>
                    </div>

                    <P class="border-bottom-line"> 资源管理需求</P>
                    <div class="form-group col-md-6">
                        <label>专家级别：{$need['expert_level'] ? $need['expert_level'] : $detail['expert_level']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>是否指定院所：
                            <?php echo $need['is_sure_ins']==1 ?  '是；院所名称：'.$need['ins_name'] : ($detail['is_sure_ins']==1 ? '是；院所名称：'.$detail['ins_name'] : '否；'); ?>
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>辅导员（科研秘书）数量：{$need['guide_num'] ? $need['guide_num'] : $detail['guide_num']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>辅导员（科研秘书）要求：{$need['guide_condition'] ? $need['guide_condition'] : $detail['guide_condition']}</label>
                    </div>

                    <div class="form-group col-md-12">
                        <label>其他资源需求：{$need['other_zy_condition'] ? $need['other_zy_condition'] : $detail['other_zy_condition']}</label>
                    </div>

                    <P class="border-bottom-line"> 市场设计需求</P>
                    <div class="form-group col-md-6">
                        <label>海报：
                            <?php echo $need['is_need_poster']==1 ? ('需要，要求：'.$need['poster_condition']) : ($detail['is_need_poster']==1 ? '需要，要求：'.$detail['poster_condition'] : '不需要'); ?>
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>微信软文：
                            <?php echo $need['is_need_wechat']==1 ? ('需要，要求：'.$need['wechat_condition']) : ($detail['is_need_wechat']==1 ? '需要，要求：'.$detail['wechat_condition'] : '不需要'); ?>
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>H5宣传页：
                            <?php echo $need['is_need_H5']==1 ? ('需要，数量：'.$need['H5_num'].'，要求：'.$need['H5_condition']) : ($detail['is_need_H5']==1 ? '需要，数量：'.$detail['H5_num'].'，要求：'.$detail['H5_condition'] : '不需要'); ?>
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>其他设计需求：{$need['other_sj_condition'] ? $need['other_sj_condition'] : $detail['other_sj_condition']}</label>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="content">
                <div class="form-group col-md-12">
                    暂无客户需求信息!
                </div>
            </div>
        <?php } ?>
    </div><!-- /.box-body -->
</div>