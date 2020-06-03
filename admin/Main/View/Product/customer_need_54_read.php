<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>研学时间： <?php echo $need['st_time'] ? date('Y-m-d',$need['st_time']).' - '.date('Y-m-d',$need['et_time']) : ($detail['st_time'] ? date('Y-m-d',$detail['st_time']).' - '.date('Y-m-d',$detail['et_time']) : ''); ?></label>
                </div>

                <div class="form-group col-md-4">
                    <label>研学预算：{$need['price'] ? $need['price'] : $detail['price']}元/人</label>
                </div>

                <div class="form-group col-md-4">
                    <label>往返大交通：{$need['traffic'] ? $need['traffic'] : $detail['traffic']}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>院所：
                        {$need ? ($need['is_need_ins']==1 ? '需要；' : '不需要；') : ($detail['is_need_ins']==1 ? '需要；' : '不需要；')}
                        {$need ? ($need['is_sure_ins']==1 ? '指定院所；' : '非指定院所；') : ($detail['is_sure_ins']==1 ? '指定院所；' : '非指定院所；')}
                        {$need ? $need['ins_name'] : $detail['ins_name']}
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label>企业：
                        {$need ? ($need['is_need_company']==1 ? '需要；' : '不需要；') : ($detail['is_need_company']==1 ? '需要；' : '不需要；')}
                        {$need ? ($need['is_sure_company']==1 ? '指定企业；' : '非指定企业；') : ($detail['is_sure_company']==1 ? '指定企业；' : '非指定企业；')}
                        {$need ? $need['company_name'] : $detail['company_name']}
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label>高校：
                        {$need ? ($need['is_need_school']==1 ? '需要；' : '不需要；') : ($detail['is_need_school']==1 ? '需要；' : '不需要；')}
                        {$need ? ($need['is_sure_school']==1 ? '指定高校；' : '非指定高校；') : ($detail['is_sure_school']==1 ? '指定高校；' : '非指定高校；')}
                        {$need ? $need['school_name'] : $detail['school_name']}
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label>景点：
                        {$need ? ($need['is_need_scenicSpot']==1 ? '需要；' : '不需要；') : ($detail['is_need_scenicSpot']==1 ? '需要；' : '不需要；')}
                        {$need ? ($need['is_sure_scenicSpot']==1 ? '指定景点；' : '非指定景点；') : ($detail['is_sure_scenicSpot']==1 ? '指定景点；' : '非指定景点；')}
                        {$need ? $need['scenicSpot_name'] : $detail['scenicSpot_name']}
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label>博物馆：
                        {$need ? ($need['is_need_museum']==1 ? '需要；' : '不需要；') : ($detail['is_need_museum']==1 ? '需要；' : '不需要；')}
                        {$need ? ($need['is_sure_museum']==1 ? '指定博物馆；' : '非指定博物馆；') : ($detail['is_sure_museum']==1 ? '指定博物馆；' : '非指定博物馆；')}
                        {$need ? $need['museum_name'] : $detail['museum_name']}
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label>开闭营：
                        {$need ? ($need['is_need_openingClosingCamp']==1 ? '需要；' : '不需要；') : ($detail['is_need_openingClosingCamp']==1 ? '需要；' : '不需要；')}
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>讲座：
                        <?php echo $need ? ($need['is_need_lecture']==1 ? '需要；' : '不需要；') : ($detail['is_need_lecture']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['lecture_time'] ? '时间：'.date('Y-m-d',$need['lecture_time']) : '') : ($detail['lecture_time'] ? '时间：'.date('Y-m-d',$detail['lecture_time']) : ''); ?>
                        <?php echo $need ? ($need['lecture_addr'] ? '地点：'.$need['lecture_addr'] : '') : ($detail['lecture_addr'] ? '地点：'.$detail['lecture_addr'] : ''); ?>
                        <?php echo $need ? ($need['lecture_long'] ? '时长：'.$need['lecture_long'].'小时' : '') : ($detail['lecture_long'] ? '时长：'.$detail['lecture_long'].'小时' : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>动手材料：
                        <?php echo $need ? ($need['is_need_material']==1 ? '需要；' : '不需要；') : ($detail['is_need_material']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['member'] ? '人数：'.$need['member'] : '') : ($detail['member'] ? '人数：'.$detail['member'] : ''); ?>
                        <?php echo $need ? ($need['num'] ? '次数：'.$need['num'] : '') : ($detail['num'] ? '次数：'.$detail['lecture_addr'] : ''); ?>
                        <?php echo $need ? ($need['material_cost'] ? '费用预算：'.$need['material_cost'] : '') : ($detail['material_cost'] ? '费用预算：'.$detail['material_cost'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他线路需求：{$need['other_line_condition'] ? $need['other_line_condition'] : $detail['other_line_condition']}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>专家：
                        <?php echo $need ? ($need['is_need_expert']==1 ? '需要；' : '不需要；') : ($detail['is_need_expert']==1 ? '需要；' : '不需要；'); ?>
                        专家信息：{$need ? $need['expert_info'] : $detail['expert_info']}
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>院所：
                        <?php echo $need ? ($need['is_need_institutes']==1 ? '需要；' : '不需要；') : ($detail['is_need_institutes']==1 ? '需要；' : '不需要；'); ?>
                        院所名称：{$need ? $need['institutes'] : $detail['institutes']}
                    </label>
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
                <div class="form-group col-md-12">
                    <label>住宿：
                        <?php echo $need ? ($need['star'] ? $need['star'].'星级；' : '') : ($detail['star'] ? $detail['star'].'星级；' : ''); ?>
                        <?php echo $need ? ($need['stay_price'] ? '预算价格：'.$need['stay_price'].'；' : '') : ($detail['stay_price'] ? '预算价格：'.$detail['stay_price'].'；': ''); ?>
                        <?php echo $need ? ($need['house_num'] ? '房间数：'.$need['house_num'].'；' : '') : ($detail['house_num'] ? '房间数：'.$detail['house_num'] .'；': ''); ?>
                        <?php echo $need ? ($need['house_condition'] ? '要求：'.$need['house_condition'].'；' : '') : ($detail['house_condition'] ? '要求：'.$detail['house_condition'].'；' : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>餐食：早餐：{$need ? $need['breakfast_num'] : $detail['breakfast_num']}餐；
                        正餐：{$need ? $need['dinner_num'] : $detail['dinner_num']}餐；
                        餐标：{$need ? $need['dinner_price'] : $detail['dinner_price']}元；
                        要求：{$need ? $need['dinner_condition'] : $detail['dinner_condition']}；
                        火车餐：<?php echo $need ? ($need['is_need_train_meal'] ? '需要；数量'.$need['train_meal_num'].'餐；价格'.$need['train_meal_price'].'元；' : '不需要；') : ($detail['is_need_train_meal'] ? '需要；数量'.$detail['train_meal_num'].'餐；价格'.$detail['train_meal_price'].'元；' : '不需要；'); ?>
                    </label>
                </div>

                <div class="form-group col-md-12">
                    <label>接送站：
                        <?php echo $need ? ($need['is_need_transfer']==1 ? '需要；' : '不需要；') : ($detail['is_need_transfer']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['transfer_num'] ? '数量：'.$need['transfer_num'].'；' : '') : ($detail['transfer_num'] ? '数量：'.$detail['transfer_num'].'；' : ''); ?>
                        <?php echo $need ? ($need['transfer_seat'] ? '几座车：'.$need['transfer_seat'].'座；' : '') : ($detail['transfer_seat'] ? '几座车：'.$detail['transfer_seat'].'座；' : ''); ?>
                        <?php echo $need ? ($need['transfer_condition'] ? '要求：'.$need['transfer_condition'] : '') : ($detail['transfer_condition'] ? '要求：'.$detail['transfer_condition'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>当地大巴车：
                        <?php echo $need ? ($need['is_need_bus']==1 ? '需要；' : '不需要；') : ($detail['is_need_bus']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['bus_num'] ? '数量：'.$need['bus_num'] .'辆；': '') : ($detail['bus_num'] ? '数量：'.$detail['bus_num'] .'辆；': ''); ?>
                        <?php echo $need ? ($need['bus_seat'] ? '几座车：'.$need['bus_seat'] .'座；': '') : ($detail['bus_seat'] ? '几座车：'.$detail['bus_seat'] .'座；': ''); ?>
                        <?php echo $need ? ($need['bus_condition'] ? '要求：'.$need['bus_condition'] : '') : ($detail['bus_condition'] ? '要求：'.$detail['bus_condition'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>导游：
                        <?php echo $need ? ($need['is_need_guider']==1 ? '需要；' : '不需要；') : ($detail['is_need_guider']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['guider_num'] ? '数量：'.$need['guider_num'] .'人；': '') : ($detail['guider_num'] ? '数量：'.$detail['guider_num'] .'人；': ''); ?>
                        <?php echo $need ? ($need['guider_condition'] ? '要求：'.$need['guider_condition'].'；' : '') : ($detail['guider_condition'] ? '要求：'.$detail['guider_condition'].'；' : ''); ?>
                        <?php echo $need ? ($need['guider_sex'] ? '性别：'.$need['guider_sex'] : '') : ($detail['guider_sex'] ? '性别：'.$detail['guider_sex'] : ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>公关费用：
                        <?php echo $need ? ($need['is_need_relation']==1 ? '需要；' : '不需要；') : ($detail['is_need_relation']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['relation_price'] ? '金额：'.$need['relation_price'] .'元；': '') : ($detail['relation_price'] ? '金额：'.$detail['relation_price'] .'元；': ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>横幅：
                        <?php echo $need ? ($need['is_need_banner']==1 ? '需要；' : '不需要；') : ($detail['is_need_banner']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['banner_num'] ? '数量：'.$need['banner_num'] .'个；': '') : ($detail['banner_num'] ? '数量：'.$detail['banner_num'] .'个；': ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>旗子：
                        <?php echo $need ? ($need['is_need_flag']==1 ? '需要；' : '不需要；') : ($detail['is_need_flag']==1 ? '需要；' : '不需要；'); ?>
                        <?php echo $need ? ($need['flag_num'] ? '数量：'.$need['flag_num'] .'个；': '') : ($detail['flag_num'] ? '数量：'.$detail['flag_num'] .'个；': ''); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>保险：{$need ? $need['safe_price'] : $detail['safe_price']}元</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：{$need ? $need['other_jd_condition'] : $detail['other_jd_condition']}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-6">
                    <label>科学手册：页数：{$need ? $need['page_num'] : $detail['page_num']}； 设计要求：{$need ? $need['manual_condition'] : $detail['manual_condition']}；</label>
                </div>

                <div class="form-group col-md-6">
                    <label>线路宣传单：
                        <?php echo $need ? ($need['is_need_leaflet']==1 ? '需要，数量：'.$need['leaflet_num'].'，要求：'.$need['leaflet_condition'] : '不需要') : ($detail['is_need_leaflet']==1 ? '需要，数量：'.$detail['leaflet_num'].'，要求：'.$detail['leaflet_condition'] : '不需要'); ?>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label>H5宣传页：<?php echo $need ? ($need['is_need_H5']==1 ? '需要，数量：'.$need['H5_num'].'，要求：'.$need['H5_condition'] : '不需要') : ($detail['is_need_H5']==1 ? '需要，数量：'.$detail['H5_num'].'，要求：'.$detail['H5_condition'] : '不需要'); ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他设计需求：{$need ? $need['other_sj_condition'] : $detail['other_sj_condition']}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>