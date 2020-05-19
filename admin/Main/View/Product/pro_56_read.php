<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-4">
                    <label>活动时间： <?php echo $detail['time'] ? date('Y-m-d', $detail['time']) : ''; ?> </label>
                </div>

                <div class="form-group col-md-4">
                    <label>具体时间段： <?php echo $detail['st_time'] ? date('H:i:s', $detail['st_time']) : ''; ?> - <?php echo $detail['et_time'] ? date('H:i:s', $detail['et_time']) : ''; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动地址：{$detail.addr} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>参与年级：{$detail.grade} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：{$detail.stu_num} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动预算(成本价格)：{$detail.price}元</label>
                </div>

                <div class="form-group col-md-12">
                    <label>场地条件：{$detail.yard}；接电：<?php echo $detail['electric']==1 ? '能；' : '否；'; ?>其他具体要求：{$detail.yard_more}</label>
                </div>

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-6">
                    <label>项目总数： {$detail.op_num} 个</label>
                </div>

                <div class="form-group col-md-6">
                    <label>开幕式项目数量： {$detail.begin_op_num} 个</label>
                </div>

                <div class="form-group col-md-6">
                    <label>制作类项目种类： {$detail.make_op_type} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>制作类各种类数量： {$detail.make_op_num} 个</label>
                </div>

                <div class="form-group col-md-12">
                    <label>开幕式要求：串场：<?php echo $detail['is_comeOut']==1 ? '是；' : '否；'; ?>&nbsp;串词：<?php echo $detail['is_comeOutWord']==1 ? '是；' : '否；'; ?>其他具体要求：{$detail.comeOut_condition}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>小礼品：<?php echo $detail['is_gift']==1 ? '是；' : '否；'; ?>&nbsp;均价：{$detail.gift_price}元；其他具体要求：{$detail.gift_condition}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>活动流程(时间安排)： {$detail.content} </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发方案需求： {$detail.other_yf_condition} </label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>辅导员数量：{$detail.guide_num} 个</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员要求：{$detail.guide_condition}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员费用：{$detail.guide_price} 元</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合时间：{$detail.guide_come_time}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合地点：{$detail.guide_come_addr}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他资源需求：{$detail.other_zy_condition}</label>
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-6">
                    <label>用车需求：<?php echo $detail['is_need_bus']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['bus_num'] ? '数量：'.$detail['bus_num'] .'辆；': ''; ?>
                        <?php echo $detail['bus_seat'] ? '几座车：'.$detail['bus_seat'] .'座；': ''; ?>
                        <?php echo $detail['bus_condition'] ? '要求：'.$detail['bus_condition'] : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>用餐需求：<?php echo $detail['is_need_food']==1 ? '需要；' : '不需要；'; ?>
                        数量：{$detail.food_num} 份；
                        价格：{$detail.food_price} 元；
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：{$detail.other_jd_condition}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12">
                    <label>任务卡：<?php echo $detail['is_need_taskCard']==1 ? '是；' : '否；'; ?>&nbsp;任务卡页数: {$detail.taskCard_page_num}；&nbsp;任务卡数量: {$detail.taskCard_num}；&nbsp;设计要求: {$detail.taskCard_condition}；</label>
                </div>

                <div class="form-group col-md-6">
                    <label>项目展板：<?php echo $detail['is_need_displayBoard']==1 ? '是；' : '否；'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>横幅：<?php echo $detail['is_need_banner']==1 ? '是；' : '否；'; ?> &nbsp; 具体要求: {$detail.banner_condition}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>环创需求：<?php echo $detail['is_need_HC']==1 ? '是；' : '否；'; ?> &nbsp; 具体要求: {$detail.HC_condition}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他市场设计需求：{$detail.other_sj_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>