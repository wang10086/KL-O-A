<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save_customer_need')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="3">
                <input type="hidden" name="id" value="{$need.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>研学时间：</label><input type="text" name="in_time"  value="<?php echo $need['st_time'] ? date('Y-m-d',$need['st_time']).' - '.date('Y-m-d',$need['et_time']) : ($detail['st_time'] ? date('Y-m-d',$detail['st_time']).' - '.date('Y-m-d',$detail['et_time']) : ''); ?>" class="form-control between_day"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>研学预算(元/人)：</label>
                    <input type="text" class="form-control" name="data[price]" value="{$need['price'] ? $need['price'] : $detail['price']}" />
                </div>

                <div class="form-group col-md-4">
                    <p><label>往返大交通：</label></p>
                    <input type="radio" name="data[traffic]" value="火车" <?php if ($need ? $need['traffic']=='火车' : $detail['traffic']=='火车') echo 'checked'; ?>> &#8194;火车 &#12288;
                    <input type="radio" name="data[traffic]" value="飞机" <?php if ($need ? $need['traffic']=='飞机' : $detail['traffic']=='飞机') echo 'checked'; ?>> &#8194;飞机
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">院所</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_ins]" value="1" <?php if ($need ? $need['is_need_ins']==1 : $detail['is_need_ins']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_ins]" value="0" <?php if ($need ? $need['is_need_ins']==0 : $detail['is_need_ins']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <label style="float: left; width: 120px;">是否有指定院所</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_sure_ins]" value="1" <?php if ($need ? $need['is_sure_ins']==1 : $detail['is_sure_ins']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_sure_ins]" value="0" <?php if ($need ? $need['is_sure_ins']==0 : $detail['is_sure_ins']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 50%; float: left;">
                        院所名称：<input type="text" name="data[ins_name]" value="{$need['ins_name'] ? $need['ins_name'] : $detail['ins_name']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">企业</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_company]" value="1" <?php if ($need ? $need['is_need_company']==1 : $detail['is_need_company']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_company]" value="0" <?php if ($need ? $need['is_need_company']==0 : $detail['is_need_company']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <label style="float: left; width: 120px;">是否有指定企业</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_sure_company]" value="1" <?php if ($need ? $need['is_sure_company']==1 : $detail['is_sure_company']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_sure_company]" value="0" <?php if ($need ? $need['is_sure_company']==0 : $detail['is_sure_company']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 50%; float: left;">
                        企业名称：<input type="text" name="data[company_name]" value="{$need['company_name'] ? $need['company_name'] : $detail['company_name']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">高校</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_school]" value="1" <?php if ($need ? $need['is_need_school']==1 : $detail['is_need_school']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_school]" value="0" <?php if ($need ? $need['is_need_school']==0 : $detail['is_need_school']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <label style="float: left; width: 120px;">是否有指定高校</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_sure_school]" value="1" <?php if ($need ? $need['is_sure_school']==1 : $detail['is_sure_school']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_sure_school]" value="0" <?php if ($need ? $need['is_sure_school']==0 : $detail['is_sure_school']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 50%; float: left;">
                        高校名称：<input type="text" name="data[school_name]" value="{$need['school_name'] ? $need['school_name'] : $detail['school_name']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">景点</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_scenicSpot]" value="1" <?php if ($need ? $need['is_need_scenicSpot']==1 : $detail['is_need_scenicSpot']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_scenicSpot]" value="0" <?php if ($need ? $need['is_need_scenicSpot']==0 : $detail['is_need_scenicSpot']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <label style="float: left; width: 120px;">是否有指定景点</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_sure_scenicSpot]" value="1" <?php if ($need ? $need['is_sure_scenicSpot']==1 : $detail['is_sure_scenicSpot']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_sure_scenicSpot]" value="0" <?php if ($need ? $need['is_sure_scenicSpot']==0 : $detail['is_sure_scenicSpot']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 50%; float: left;">
                        景点名称：<input type="text" name="data[scenicSpot_name]" value="{$need['scenicSpot_name'] ? $need['scenicSpot_name'] : $detail['scenicSpot_name']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">博物馆</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_museum]" value="1" <?php if ($need ? $need['is_need_museum']==1 : $detail['is_need_museum']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_museum]" value="0" <?php if ($need ? $need['is_need_museum']==0 : $detail['is_need_museum']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <label style="float: left; width: 120px;">是否有指定博物馆</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_sure_museum]" value="1" <?php if ($need ? $need['is_sure_museum']==1 : $detail['is_sure_museum']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_sure_museum]" value="0" <?php if ($need ? $need['is_sure_museum']==0 : $detail['is_sure_museum']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 50%; float: left;">
                        博物馆名称：<input type="text" name="data[museum_name]" value="{$need['museum_name'] ? $need['museum_name'] : $detail['museum_name']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">开闭营</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_openingClosingCamp]" value="1" <?php if ($need ? $need['is_need_openingClosingCamp']==1 : $detail['is_need_openingClosingCamp']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_openingClosingCamp]" value="0" <?php if ($need ? $need['is_need_openingClosingCamp']==0 : $detail['is_need_openingClosingCamp']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <label style="float: left; width: 120px;">讲座</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_lecture]" value="1" <?php if ($need ? $need['is_need_lecture']==1 : $detail['is_need_lecture']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_lecture]" value="0" <?php if ($need ? $need['is_need_lecture']==0 : $detail['is_need_lecture']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 50%; float: left;">
                        时间：<input type="text" name="data[lecture_time]" value="<?php echo $need['lecture_time'] ? date('Y-m-d',$need['lecture_time']) : ($detail['lecture_time'] ? date('Y-m-d',$detail['lecture_time']) : ''); ?>" class="inputdatetime" style="border: none; border-bottom: solid 1px; width: 150px;" > &#12288;&#12288;
                        时长：<input type="text" name="data[lecture_long]" value="{$need['lecture_long'] ? $need['lecture_long'] : $detail['lecture_long']}" style="border: none; border-bottom: solid 1px; width: 100px;" > &#12288;&#12288;
                        地点：<input type="text" name="data[lecture_addr]" value="{$need['lecture_addr'] ? $need['lecture_addr'] : $detail['lecture_addr']}" style="border: none; border-bottom: solid 1px; width: 150px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">动手材料</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_material]" value="1" <?php if ($need ? $need['is_need_material']==1 : $detail['is_need_material']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_material]" value="0" <?php if ($need ? $need['is_need_material']==0 : $detail['is_need_material']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        人数：<input type="text" name="data[member]" value="{$need['member'] ? $need['member'] : $detail['member']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        次数：<input type="text" name="data[num]" value="{$need['num'] ? $need['num'] : $detail['num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        费用：<input type="text" name="data[material_cost]" value="{$need['material_cost'] ? $need['material_cost'] : $detail['material_cost']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他线路要求</label><input type="text" name="data[other_line_condition]"  value="{$need['other_line_condition'] ? $need['other_line_condition'] : $detail['other_line_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">专家</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_expert]" value="1" <?php if ($need ? $need['is_need_expert']==1 : $detail['is_need_expert']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_expert]" value="0" <?php if ($need ? $need['is_need_expert']==0 : $detail['is_need_expert']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        填写级别或指定某人：<input type="text" name="data[expert_info]" value="{$need['expert_info'] ? $need['expert_info'] : $detail['expert_info']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">院所</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_institutes]" value="1" <?php if ($need ? $need['is_need_institutes']==1 : $detail['is_need_institutes']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_institutes]" value="0" <?php if ($need ? $need['is_need_institutes']==0 : $detail['is_need_institutes']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        院所名称：<input type="text" name="data[institutes]" value="{$need['institutes'] ? $need['institutes'] : $detail['institutes']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员数量：</label>
                    <input type="text" class="form-control" name="data[guide_num]" value="{$need['guide_num'] ? $need['guide_num'] : $detail['guide_num']}" />
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员要求：</label>
                    <input type="text" class="form-control" name="data[guide_condition]" value="{$need['guide_condition'] ? $need['guide_condition'] : $detail['guide_condition']}" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求</label><input type="text" name="data[other_zy_condition]"  value="{$need['other_zy_condition'] ? $need['other_zy_condition'] : $detail['other_zy_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">住宿</label>
                    <div style="width: 70%; float: left;">
                        星级: <select name="data[star]"  style="border: none; border-bottom: solid 1px; width: 125px;">
                            <option value="0" <?php if ($need ? $need['star']==1 : $detail['star']==1) echo "selected"; ?>>==请选择==</option>
                            <option value="5" <?php if ($need ? $need['star']==5 : $detail['star']==5) echo "selected"; ?>>五星级</option>
                            <option value="4" <?php if ($need ? $need['star']==4 : $detail['star']==4) echo "selected"; ?>>四星级</option>
                            <option value="3" <?php if ($need ? $need['star']==3 : $detail['star']==3) echo "selected"; ?>>三星级</option>
                            <option value="2" <?php if ($need ? $need['star']==2 : $detail['star']==2) echo "selected"; ?>>二星级</option>
                            <option value="1" <?php if ($need ? $need['star']==1 : $detail['star']==1) echo "selected"; ?>>一星级</option>
                        </select> &emsp;&emsp;
                        预算价格：<input type="text" name="data[stay_price]" value="{$need['stay_price'] ? $need['stay_price'] : $detail['stay_price']}" style="border: none; border-bottom: solid 1px; width: 125px;" > &#12288;&#12288;
                        房间数：<input type="text" name="data[house_num]" value="{$need['house_num'] ? $need['house_num'] : $detail['house_num']}" style="border: none; border-bottom: solid 1px; width: 125px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[house_condition]" value="{$need['house_condition'] ? $need['house_condition'] : $detail['house_condition']}" style="border: none; border-bottom: solid 1px; width: 140px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">餐食</label>
                    <div style="width: 70%; float: left;">
                        早餐数：<input type="text" name="data[breakfast_num]" value="{$need['breakfast_num'] ? $need['breakfast_num'] : $detail['breakfast_num']}" style="border: none; border-bottom: solid 1px; width: 60px;" > &#12288;&#12288;
                        正餐数：<input type="text" name="data[dinner_num]" value="{$need['dinner_num'] ? $need['dinner_num'] : $detail['dinner_num']}" style="border: none; border-bottom: solid 1px; width: 60px;" > &#12288;&#12288;
                        餐标：<input type="text" name="data[dinner_price]" value="{$need['dinner_price'] ? $need['dinner_price'] : $detail['dinner_price']}" style="border: none; border-bottom: solid 1px; width: 125px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[dinner_condition]" value="{$need['dinner_condition'] ? $need['dinner_condition'] : $detail['dinner_condition']}" style="border: none; border-bottom: solid 1px; width: 140px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">火车餐</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_train_meal]" value="1" <?php if ($need ? $need['is_need_train_meal']==1 : $detail['is_need_train_meal']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_train_meal]" value="0" <?php if ($need ? $need['is_need_train_meal']==0 : $detail['is_need_train_meal']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[train_meal_num]" value="{$need['train_meal_num'] ? $need['train_meal_num'] : $detail['train_meal_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        价格：<input type="text" name="data[train_meal_price]" value="{$need['train_meal_price'] ? $need['train_meal_price'] : $detail['train_meal_price']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">接送站</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_transfer]" value="1" <?php if ($need ? $need['is_need_transfer']==1 : $detail['is_need_transfer']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_transfer]" value="0" <?php if ($need ? $need['is_need_transfer']==0 : $detail['is_need_transfer']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[transfer_num]" value="{$need['transfer_num'] ? $need['transfer_num'] : $detail['transfer_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        几座车：<input type="text" name="data[transfer_seat]" value="{$need['transfer_seat'] ? $need['transfer_seat'] : $detail['transfer_seat']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[transfer_condition]" value="{$need['transfer_condition'] ? $need['transfer_condition'] : $detail['transfer_condition']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">当地大巴车：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_bus]" value="1" <?php if ($need ? $need['is_need_bus']==1 : $detail['is_need_bus']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_bus]" value="0" <?php if ($need ? $need['is_need_bus']==0 : $detail['is_need_bus']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[bus_num]" value="{$need['bus_num'] ? $need['bus_num'] : $detail['bus_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        几座车：<input type="text" name="data[bus_seat]" value="{$need['bus_seat'] ? $need['bus_seat'] : $detail['bus_seat']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[bus_condition]" value="{$need['bus_condition'] ? $need['bus_condition'] : $detail['bus_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">导游：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_guider]" value="1" <?php if ($need ? $need['is_need_guider']==1 : $detail['is_need_guider']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_guider]" value="0" <?php if ($need ? $need['is_need_guider']==0 : $detail['is_need_guider']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[guider_num]" value="{$need['guider_num'] ? $need['guider_num'] : $detail['guider_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[guider_condition]" value="{$need['guider_condition'] ? $need['guider_condition'] : $detail['guider_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                        性别：<input type="text" name="data[guider_sex]" value="{$need['guider_sex'] ? $need['guider_sex'] : $detail['guider_sex']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">保险：</label>
                    <div style="width: 80%; float: left;">
                        <input type="radio" name="data[safe_price]" value="4" <?php if ($detail['safe_price'] == 4) echo "checked"; ?>> &#8194;4元 &#12288;
                        <input type="radio" name="data[safe_price]" value="12" <?php if ($detail['safe_price'] == 12) echo "checked"; ?>> &#8194;12元 &#12288;
                        <input type="radio" name="data[safe_price]" value="25" <?php if ($detail['safe_price'] == 25) echo "checked"; ?>> &#8194;25元 &#12288;
                    </div>
                </div>

                <div class="form-group col-md-6" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">公关费用：</label>
                    <div style="float: left; margin-right: 20px;">
                        <input type="radio" name="data[is_need_relation]" value="1" <?php if ($need ? $need['is_need_relation']==1 : $detail['is_need_relation']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_relation]" value="0" <?php if ($need ? $need['is_need_relation']==0 : $detail['is_need_relation']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="float: left;">
                        金额：<input type="text" name="data[relation_price]" value="{$need['relation_price'] ? $need['relation_price'] : $detail['relation_price']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">横幅：</label>
                    <div style="float: left; margin-right: 20px;">
                        <input type="radio" name="data[is_need_banner]" value="1" <?php if ($need ? $need['is_need_banner']==1 : $detail['is_need_banner']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_banner]" value="0" <?php if ($need ? $need['is_need_banner']==0 : $detail['is_need_banner']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="float: left;">
                        数量：<input type="text" name="data[banner_num]" value="{$need['banner_num'] ? $need['banner_num'] : $detail['banner_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">旗子：</label>
                    <div style="float: left; margin-right: 20px;">
                        <input type="radio" name="data[is_need_flag]" value="1" <?php if ($need ? $need['is_need_flag']==1 : $detail['is_need_flag']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_flag]" value="0" <?php if ($need ? $need['is_need_flag']==0 : $detail['is_need_flag']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="float: left;">
                        数量：<input type="text" name="data[flag_num]" value="{$need['flag_num'] ? $need['flag_num'] : $detail['flag_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求 <font color="#999">(矿泉水、耳机、营服、营帽、医药箱、证书、手册、行李帖等)</font></label><input type="text" name="data[other_jd_condition]"  value="{$need['other_jd_condition'] ? $need['other_jd_condition'] : $detail['other_jd_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">研学手册</label>
                    <div style="width: 70%; float: left;">
                        页数：<input type="text" name="data[page_num]" value="{$need['page_num'] ? $need['page_num'] : $detail['page_num']}" style="border: none; border-bottom: solid 1px; width: 150px;" > &#12288;&#12288;
                        设计要求：<input type="text" name="data[manual_condition]" value="{$need['manual_condition'] ? $need['manual_condition'] : $detail['manual_condition']}" style="border: none; border-bottom: solid 1px; width: 300px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">线路宣传单</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_leaflet]" value="1" <?php if ($need ? $need['is_need_leaflet']==1 : $detail['is_need_leaflet']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_leaflet]" value="0" <?php if ($need ? $need['is_need_leaflet']==0 : $detail['is_need_leaflet']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[leaflet_num]" value="{$need['leaflet_num'] ? $need['leaflet_num'] : $detail['leaflet_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[leaflet_condition]" value="{$need['leaflet_condition'] ? $need['leaflet_condition'] : $detail['leaflet_condition']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">线路H5宣传</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_H5]" value="1" <?php if ($need ? $need['is_need_H5']==1 : $detail['is_need_H5']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_H5]" value="0" <?php if ($need ? $need['is_need_H5']==0 : $detail['is_need_H5']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[H5_num]" value="{$need['H5_num'] ? $need['H5_num'] : $detail['H5_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[H5_condition]" value="{$need['H5_condition'] ? $need['H5_condition'] : $detail['H5_condition']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他设计需求</label><input type="text" name="data[other_sj_condition]"  value="{$need['other_sj_condition'] ? $need['other_sj_condition'] : $detail['other_sj_condition']}" class="form-control" />
                </div>
            </form>

            <div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>