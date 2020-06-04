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
                    <label>外采比例：{$detail.buy_ratio}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>目的地：{$detail.addr}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>时间：<?php echo $detail['time'] ? date('Y-m-d',$detail['time']) : ''; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动领域：{$detail.field}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动安排：{$detail.plan}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>有无动手/讲解/体验活动：{$detail.content}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发需求：{$detail.other_line_condition}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>专家：<?php echo $detail['is_need_expert']==1 ? '需要；专家信息：'.$detail['expert_info'] : '不需要；'; ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>院所：<?php echo $detail['is_need_institutes']==1 ? '需要；院所名称：'.$detail['institutes'] : '不需要；'; ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员数量：{$detail.guide_num}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员要求：{$detail.guide_condition}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求：{$detail.other_zy_condition}</label>
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-6">
                    <label>大巴车：<?php echo $detail['is_need_bus']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['bus_num'] ? '数量：'.$detail['bus_num'] .'辆；': ''; ?>
                        <?php echo $detail['bus_seat'] ? '几座车：'.$detail['bus_seat'] .'座；': ''; ?>
                        <?php echo $detail['bus_condition'] ? '要求：'.$detail['bus_condition'] : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>导游：<?php echo $detail['is_need_guider']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['guider_num'] ? '数量：'.$detail['guider_num'] .'人；': ''; ?>
                        <?php echo $detail['guider_condition'] ? '要求：'.$detail['guider_condition'].'；' : ''; ?>
                        <?php echo $detail['guider_sex'] ? '性别：'.$detail['guider_sex'] : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>餐食：<?php echo $detail['is_need_food']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['food_num'] ? '数量：'.$detail['food_num'].'；' : ''; ?>
                        <?php echo $detail['food_condition'] ? '餐标：'.$detail['food_condition'] : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>物资需求：{$detail.material_condition}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>保险：{$detail.safe_price}元</label>
                </div>

                <div class="form-group col-md-6">
                    <label>公关费用：<?php echo $detail['is_need_relation']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['relation_price'] ? '金额：'.$detail['relation_price'] .'元；': ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>横幅：<?php echo $detail['is_need_banner']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['banner_num'] ? '数量：'.$detail['banner_num'] .'个；': ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>旗子：<?php echo $detail['is_need_flag']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['flag_num'] ? '数量：'.$detail['flag_num'] .'个；': ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>门票：{$detail.ticket}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：{$detail.other_jd_condition}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-6">
                    <label>手册：页数：{$detail.page_num}； 设计要求：{$detail.manual_condition}；</label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他设计需求：{$detail.other_sj_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>