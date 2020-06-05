<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>类型： {$need ? $need['type'] : $detail['type']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>外采比例：{$need ? $need['buy_ratio'] : $detail['buy_ratio']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>目的地：{$need ? $need['addr'] : $detail['addr']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>时间：<?php echo $need ? ($need['time'] ? date('Y-m-d',$need['time']) : '') : ($detail['time'] ? date('Y-m-d',$detail['time']) : ''); ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动领域：{$need ? $need['field'] : $detail['field']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动安排：{$need ? $need['plan'] : $detail['plan']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>有无动手/讲解/体验活动：{$need ? $need['content'] : $detail['content']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发需求：{$need ? $need['other_line_condition'] : $detail['other_line_condition']}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>专家：<?php echo $need ? ($need['is_need_expert']==1 ? '需要；专家信息：'.$need['expert_info'] : '不需要；') : ($detail['is_need_expert']==1 ? '需要；专家信息：'.$detail['expert_info'] : '不需要；'); ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>院所：<?php echo $need ? ($need['is_need_institutes']==1 ? '需要；院所名称：'.$need['institutes'] : '不需要；') : ($detail['is_need_institutes']==1 ? '需要；院所名称：'.$detail['institutes'] : '不需要；'); ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员数量：{$need ? $need['guide_num'] : $detail['guide_num']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员要求：{$need ? $need['guide_condition'] : $detail['guide_condition']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求：{$need ? $need['other_zy_condition'] : $detail['other_zy_condition']}</label>
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-6">
                    <label>大巴车：<?php echo $need ? ($need['is_need_bus']==1 ? '需要；' : '不需要；') : ($detail['is_need_bus']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['bus_num'] ? '数量：'.$need['bus_num'] .'辆；': '') : ($detail['bus_num'] ? '数量：'.$detail['bus_num'] .'辆；': ''); ?>
                        <?php echo $need ? ($need['bus_seat'] ? '几座车：'.$need['bus_seat'] .'座；': '') : ($detail['bus_seat'] ? '几座车：'.$detail['bus_seat'] .'座；': ''); ?>
                        <?php echo $need ? ($need['bus_condition'] ? '要求：'.$need['bus_condition'] : '') : ($detail['bus_condition'] ? '要求：'.$detail['bus_condition'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>导游：<?php echo $need ? ($need['is_need_guider']==1 ? '需要；' : '不需要；') : ($detail['is_need_guider']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['guider_num'] ? '数量：'.$need['guider_num'] .'人；': '') : ($detail['guider_num'] ? '数量：'.$detail['guider_num'] .'人；': ''); ?>
                        <?php echo $need ? ($need['guider_condition'] ? '要求：'.$need['guider_condition'].'；' : '') : ($detail['guider_condition'] ? '要求：'.$detail['guider_condition'].'；' : ''); ?>
                        <?php echo $need ? ($need['guider_sex'] ? '性别：'.$need['guider_sex'] : '') : ($detail['guider_sex'] ? '性别：'.$detail['guider_sex'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>餐食：<?php echo $need ? ($need['is_need_food']==1 ? '需要；' : '不需要；') : ($detail['is_need_food']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['food_num'] ? '数量：'.$need['food_num'].'；' : '') : ($detail['food_num'] ? '数量：'.$detail['food_num'].'；' : ''); ?>
                        <?php echo $need ? ($need['food_condition'] ? '餐标：'.$need['food_condition'] : '') : ($detail['food_condition'] ? '餐标：'.$detail['food_condition'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>物资需求：{$need ? $need['material_condition'] : $detail['material_condition']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>保险：{$need ? $need['safe_price'] : $detail['safe_price']} 元</label>
                </div>

                <div class="form-group col-md-6">
                    <label>公关费用：<?php echo $need ? ($need['is_need_relation']==1 ? '需要；' : '不需要；') : ($detail['is_need_relation']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['relation_price'] ? '金额：'.$need['relation_price'] .'元；': '') : ($detail['relation_price'] ? '金额：'.$detail['relation_price'] .'元；': ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>横幅：<?php echo $need ? ($need['is_need_banner']==1 ? '需要；' : '不需要；') : ($detail['is_need_banner']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['banner_num'] ? '数量：'.$need['banner_num'] .'个；': '') : ($detail['banner_num'] ? '数量：'.$detail['banner_num'] .'个；': ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>旗子：<?php echo $need ? ($need['is_need_flag']==1 ? '需要；' : '不需要；') : ($detail['is_need_flag']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['flag_num'] ? '数量：'.$need['flag_num'] .'个；': '') : ($detail['flag_num'] ? '数量：'.$detail['flag_num'] .'个；': ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>门票：{$need ? $need['ticket'] : $detail['ticket']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：{$need ? $need['other_jd_condition'] : $detail['other_jd_condition']}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-6">
                    <label>手册：页数：{$need ? $need['page_num'] : $detail['page_num']}； 设计要求：{$need ? $need['manual_condition'] : $detail['manual_condition']}；</label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他设计需求：{$need ? $need['other_sj_condition'] : $detail['other_sj_condition']}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>