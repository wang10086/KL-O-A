<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-4">
                    <label>活动时间： <?php echo $need['time'] ? date('Y-m-d',$need['time']) : ($detail['time'] ? date('Y-m-d',$detail['time']) : ''); ?> </label>
                </div>

                <div class="form-group col-md-4">
                    <label>具体时间段： <?php echo $need['st_time'] ? date('H:i:s',$need['st_time']).' - '.date('H:i:s',$need['et_time']) : ($detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''); ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动地址：{$need ? $need['addr'] : $detail['addr']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>参与年级：{$need ? $need['grade'] : $detail['grade']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：{$need ? $need['stu_num'] : $detail['stu_num']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动预算(成本价格)：{$need ? $need['price'] : $detail['price']}元</label>
                </div>

                <div class="form-group col-md-12">
                    <label>场地条件：{$need ? $need['yard'] : $detail['yard']}；接电：<?php echo $need ? ($need['electric']==1 ? '能；' : '否；') : ($detail['electric']==1 ? '能；' : '否；'); ?>其他具体要求：{$need ? $need['yard_more'] : $detail['yard_more']}</label>
                </div>

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-6">
                    <label>项目总数： {$need ? $need['op_num'] : $detail['op_num']} 个</label>
                </div>

                <div class="form-group col-md-6">
                    <label>开幕式项目数量： {$need ? $need['begin_op_num'] : $detail['begin_op_num']} 个</label>
                </div>

                <div class="form-group col-md-6">
                    <label>制作类项目种类： {$need ? $need['make_op_type'] : $detail['make_op_type']} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>制作类各种类数量： {$need ? $need['make_op_num'] : $detail['make_op_num']} 个</label>
                </div>

                <div class="form-group col-md-12">
                    <label>开幕式要求：串场：<?php echo $need ? ($need['is_comeOut']==1 ? '是；' : '否；') : ($detail['is_comeOut']==1 ? '是；' : '否；'); ?>&nbsp;串词：<?php echo $need ? ($need['is_comeOutWord']==1 ? '是；' : '否；') : ($detail['is_comeOutWord']==1 ? '是；' : '否；'); ?>其他具体要求：{$need ? $need['comeOut_condition'] : $detail['comeOut_condition']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>小礼品：<?php echo $need ? ($need['is_gift']==1 ? '是；' : '否；') : ($detail['is_gift']==1 ? '是；' : '否；'); ?>&nbsp;均价：{$need ? $need['gift_price'] : $detail['gift_price']}元；其他具体要求：{$need ? $need['gift_condition'] : $detail['gift_condition']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>活动流程(时间安排)： {$need ? $need['content'] : $detail['content']} </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发方案需求： {$need ? $need['other_yf_condition'] : $detail['other_yf_condition']} </label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>辅导员数量：{$need ? $need['guide_num'] : $detail['guide_num']} 个</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员要求：{$need ? $need['guide_condition'] : $detail['guide_condition']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员费用：{$need ? $need['guide_price'] : $detail['guide_price']} 元</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合时间：{$need ? $need['guide_come_time'] : $detail['guide_come_time']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合地点：{$need ? $need['guide_come_addr'] : $detail['guide_come_addr']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他资源需求：{$need ? $need['other_zy_condition'] : $detail['other_zy_condition']}</label>
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-6">
                    <label>用车需求：<?php echo $need ? ($need['is_need_bus']==1 ? '需要；' : '不需要；') : ($detail['is_need_bus']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['bus_num'] ? '数量：'.$need['bus_num'] .'辆；': '') : ($detail['bus_num'] ? '数量：'.$detail['bus_num'] .'辆；': ''); ?>
                        <?php echo $need ? ($need['bus_seat'] ? '几座车：'.$need['bus_seat'] .'座；': '') : ($detail['bus_seat'] ? '几座车：'.$detail['bus_seat'] .'座；': ''); ?>
                        <?php echo $need ? ($need['bus_condition'] ? '要求：'.$need['bus_condition'] : '') : ($detail['bus_condition'] ? '要求：'.$detail['bus_condition'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>用餐需求：<?php echo $detail['is_need_food']==1 ? '需要；' : '不需要；'; ?>
                        数量：{$need ? $need['food_num'] : $detail['food_num']} 份；
                        价格：{$need ? $need['food_price'] : $detail['food_price']} 元；
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：{$need ? $need['other_jd_condition'] : $detail['other_jd_condition']}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12">
                    <label>任务卡：<?php echo $need ? ($need['is_need_taskCard']==1 ? '是；' : '否；') : ($detail['is_need_taskCard']==1 ? '是；' : '否；'); ?>&nbsp;任务卡页数: {$need ? $need['taskCard_page_num'] : $detail['taskCard_page_num']}；&nbsp;任务卡数量: {$need ? $need['taskCard_num'] : $detail['taskCard_num']}；&nbsp;设计要求: {$need ? $need['taskCard_condition'] : $detail['taskCard_condition']}；</label>
                </div>

                <div class="form-group col-md-6">
                    <label>项目展板：<?php echo $need ? ($need['is_need_displayBoard']==1 ? '是；' : '否；') : ($detail['is_need_displayBoard']==1 ? '是；' : '否；'); ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>横幅：<?php echo $need ? ($need['is_need_banner']==1 ? '是；' : '否；') : ($detail['is_need_banner']==1 ? '是；' : '否；'); ?> &nbsp; 具体要求: {$need ? $need['banner_condition'] : $detail['banner_condition']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>环创需求：<?php echo $need ? ($need['is_need_HC']==1 ? '是；' : '否；') : ($detail['is_need_HC']==1 ? '是；' : '否；'); ?> &nbsp; 具体要求: {$need ? $need['HC_condition'] : $detail['HC_condition']}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他市场设计需求：{$need ? $need['other_sj_condition'] : $detail['other_sj_condition']}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>