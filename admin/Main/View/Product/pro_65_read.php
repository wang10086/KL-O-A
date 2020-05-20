<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>培训时间： <?php echo $detail['st_time'] ? date('Y-m-d', $detail['st_time']) : ''; ?> - <?php echo $detail['et_time'] ? date('Y-m-d', $detail['et_time']) : ''; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>培训预算：{$detail.price}元/人</label>
                </div>

                <div class="form-group col-md-4">
                    <label>往返大交通：{$detail.traffic}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>院所：<?php echo $detail['is_need_ins']==1 ? '需要；' : '不需要；'; ?> <?php echo $detail['is_sure_ins']==1 ? '指定院所：' : '非指定院所；'; ?> <?php echo $detail['ins_name']; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>企业：<?php echo $detail['is_need_company']==1 ? '需要；' : '不需要；'; ?> <?php echo $detail['is_sure_company']==1 ? '指定企业：' : '非指定企业；'; ?> <?php echo $detail['company_name']; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>高校：<?php echo $detail['is_need_school']==1 ? '需要；' : '不需要；'; ?> <?php echo $detail['is_sure_school']==1 ? '指定高校：' : '非指定高校；'; ?> <?php echo $detail['school_name']; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>景点：<?php echo $detail['is_need_scenicSpot']==1 ? '需要；' : '不需要；'; ?> <?php echo $detail['is_sure_scenicSpot']==1 ? '指定景点：' : '非指定景点；'; ?> <?php echo $detail['scenicSpot_name']; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>博物馆：<?php echo $detail['is_need_museum']==1 ? '需要；' : '不需要；'; ?> <?php echo $detail['is_sure_museum']==1 ? '指定博物馆：' : '非指定博物馆；'; ?> <?php echo $detail['museum_name']; ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>开闭营：<?php echo $detail['is_need_openingClosingCamp']==1 ? '需要' : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>讲座：<?php echo $detail['is_need_lecture']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['lecture_time'] ? '时间：'.date('Y-m-d',$detail['lecture_time']) : ''; ?>
                        <?php echo $detail['lecture_addr'] ? '地点：'.$detail['lecture_addr'] : ''; ?>
                        <?php echo $detail['lecture_long'] ? '时长：'.$detail['lecture_long'].'小时' : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>动手材料：<?php echo $detail['is_need_material']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['member'] ? '人数：'.$detail['member'].'人；' : ''; ?>
                        <?php echo $detail['num'] ? '次数：'.$detail['num'] : ''; ?>
                        <?php echo $detail['material_cost'] ? '费用预算：'.$detail['material_cost'].'元' : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>是否需要领导出席及讲话：<?php echo $detail['is_need_leader']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['leader_time'] ? '出席时间：'.date('Y-m-d H:i:s',$detail['leader_time']).'；' : ''; ?>
                        <?php echo $detail['leader_condition'] ? '要求：'.$detail['leader_condition'] : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他线路需求：{$detail.other_line_condition}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>专家：<?php echo $detail['is_need_expert']==1 ? '需要；' : '不需要；'; ?> 专家信息：{$detail.expert_info}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>院所：<?php echo $detail['is_need_institutes']==1 ? '需要；' : '不需要；'; ?> 院所名称：{$detail.institutes}</label>
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
                <div class="form-group col-md-12">
                    <label>住宿：<?php echo $detail['star'] ? '星级：'.$detail['star'].'星级；' : ''; ?>
                        <?php echo $detail['stay_price'] ? '预算价格：'.$detail['stay_price'].'元；' : ''; ?>
                        <?php echo $detail['house_num'] ? '房间数：'.$detail['house_num'].'间；' : ''; ?>
                        <?php echo $detail['house_condition'] ? '要求：'.$detail['house_condition'] : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>餐食：早餐：{$detail.breakfast_num}餐；正餐：{$detail.dinner_num}餐；餐标：{$detail.dinner_price}元；要求：{$detail.dinner_condition}；
                        火车餐：<?php echo $detail['is_need_train_meal'] ? '需要；数量'.$detail['train_meal_num'].'餐；价格'.$detail['train_meal_price'].'元；' : '不需要；'; ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>接送站：<?php echo $detail['is_need_transfer']==1 ? '需要；' : '不需要；'; ?>
                        <?php echo $detail['transfer_num'] ? '数量：'.$detail['transfer_num'].'；' : ''; ?>
                        <?php echo $detail['transfer_seat'] ? '几座车：'.$detail['transfer_seat'].'座；' : ''; ?>
                        <?php echo $detail['transfer_condition'] ? '要求：'.$detail['transfer_condition'] : ''; ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>当地大巴车：<?php echo $detail['is_need_bus']==1 ? '需要；' : '不需要；'; ?>
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
                    <label>保险：{$detail.safe_price}元</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：{$detail.other_jd_condition}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12">
                    <label>手册：页数：{$detail.page_num}； 设计要求：{$detail.manual_condition}；</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他设计需求：{$detail.other_sj_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>