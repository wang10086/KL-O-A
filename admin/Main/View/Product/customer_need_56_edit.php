<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save_customer_need')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="7">
                <input type="hidden" name="id" value="{$need.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-4">
                    <label>活动时间：</label><input type="text" name="data[time]"  value="<?php echo $need['time'] ? date('Y-m-d',$need['time']) : ($detail['time'] ? date('Y-m-d',$detail['time']) : ''); ?>" class="form-control inputdate"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动具体时间段：</label><input type="text" name="in_time"  value="<?php echo $need['st_time'] ? date('H:i:s',$need['st_time']).' - '.date('H:i:s',$need['et_time']) : ($detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''); ?>" class="form-control inputdate_b"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动地址：</label><input type="text" name="data[addr]"  value="{$need['addr'] ? $need['addr'] : $detail['addr']}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>参与年级：</label><input type="text" name="data[grade]"  value="{$need['grade'] ? $need['grade'] : $detail['grade']}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：</label><input type="text" name="data[stu_num]"  value="{$need['stu_num'] ? $need['stu_num'] : $detail['stu_num']}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动预算(成本价格)：</label><input type="text" name="data[price]"  value="{$need['price'] ? $need['price'] : $detail['price']}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>场地条件：</label>
                    <input type="checkbox" name="yard[]" value="室内" <?php if (in_array('室内',$yards)) echo "checked"; ?>> &#8194;室内 &#12288;
                    <input type="checkbox" name="yard[]" value="室外" <?php if (in_array('室外',$yards)) echo "checked"; ?>> &#8194;室外 &#12288;
                </div>

                <div class="form-group col-md-4">
                    <label>接电：</label>
                    <input type="radio" name="data[electric]" value="1" <?php if ($need ? $need['electric']==1 : $detail['electric']==1) echo 'checked'; ?> <?php if ($detail['']==1) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[electric]" value="0" <?php if ($need ? $need['electric']==0 : $detail['electric']==0) echo 'checked'; ?> <?php if ($detail['']==0) echo "checked"; ?>> &#8194;否 &#12288;
                </div>

                <div class="form-group col-md-4">
                    <label>其它场地信息，如场地大小等：</label><input type="text" name="data[yard_more]" value="{$need['yard_more'] ? $need['yard_more'] : $detail['yard_more']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-6">
                    <label>项目总数：</label>
                    <input type="text" class="form-control" name="data[op_num]" value="{$need['op_num'] ? $need['op_num'] : $detail['op_num']}" />
                </div>

                <div class="form-group col-md-6">
                    <label>开幕式项目数量：</label>
                    <input type="text" class="form-control" name="data[begin_op_num]" value="{$need['begin_op_num'] ? $need['begin_op_num'] : $detail['begin_op_num']}" />
                </div>

                <div class="form-group col-md-6">
                    <label>制作类项目种类：</label>
                    <input type="text" class="form-control" name="data[make_op_type]" value="{$need['make_op_type'] ? $need['make_op_type'] : $detail['make_op_type']}" />
                </div>

                <div class="form-group col-md-6">
                    <label>制作类各种类数量：</label>
                    <input type="text" class="form-control" name="data[make_op_num]" value="{$need['make_op_num'] ? $need['make_op_num'] : $detail['make_op_num']}" />
                </div>

                <div class="form-group col-md-4">
                    <p><label>开幕式是否串场：</label></p>
                    <input type="radio" name="data[is_comeOut]" value="1" <?php if ($need ? $need['is_comeOut']==1 : $detail['is_comeOut']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[is_comeOut]" value="0" <?php if ($need ? $need['is_comeOut']==0 : $detail['is_comeOut']==0) echo 'checked'; ?>> &#8194;否
                </div>

                <div class="form-group col-md-4">
                    <p><label>开幕式串词：</label></p>
                    <input type="radio" name="data[is_comeOutWord]" value="1" <?php if ($need ? $need['is_comeOutWord']==1 : $detail['is_comeOutWord']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[is_comeOutWord]" value="0" <?php if ($need ? $need['is_comeOutWord']==0 : $detail['is_comeOutWord']==0) echo 'checked'; ?>> &#8194;否
                </div>

                <div class="form-group col-md-4">
                    <label>开幕式其他具体要求：</label>
                    <input type="text" class="form-control" name="data[comeOut_condition]" value="{$need['comeOut_condition'] ? $need['comeOut_condition'] : $detail['comeOut_condition']}" />
                </div>

                <div class="form-group col-md-4">
                    <p><label>小礼品：</label></p>
                    <input type="radio" name="data[is_gift]" value="1" <?php if ($need ? $need['is_gift']==1 : $detail['is_gift']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[is_gift]" value="0" <?php if ($need ? $need['is_gift']==0 : $detail['is_gift']==0) echo 'checked'; ?>> &#8194;否
                </div>

                <div class="form-group col-md-4">
                    <label>小礼品具体要求：</label>
                    <input type="text" class="form-control" name="data[gift_condition]" value="{$need['gift_condition'] ? $need['gift_condition'] : $detail['gift_condition']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>小礼品均价：</label>
                    <input type="text" class="form-control" name="data[gift_price]" value="{$need['gift_price'] ? $need['gift_price'] : $detail['gift_price']}" />
                </div>

                <div class="form-group col-md-12">
                    <label>活动流程(时间安排)</label><input type="text" name="data[content]"  value="{$need['content'] ? $need['content'] : $detail['content']}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发方案需求 <font color="#999">(主持人等)</font></label><input type="text" name="data[other_yf_condition]"  value="{$need['other_yf_condition'] ? $need['other_yf_condition'] : $detail['other_yf_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>辅导员数量：<font color="#999">(个)</font></label>
                    <input type="text" class="form-control" name="data[guide_num]" value="{$need['guide_num'] ? $need['guide_num'] : $detail['guide_num']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员要求：</label>
                    <input type="text" class="form-control" name="data[guide_condition]" value="{$need['guide_condition'] ? $need['guide_condition'] : $detail['guide_condition']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员费用：<font color="#999">(元)</font></label>
                    <input type="text" class="form-control" name="data[guide_price]" value="{$need['guide_price'] ? $need['guide_price'] : $detail['guide_price']}" />
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合时间：<font color="red">(时间请填写到分)</font></label>
                    <input type="text" class="form-control inputdatetime" name="data[guide_come_time]" value="{$need['guide_come_time'] ? $need['guide_come_time'] : $detail['guide_come_time']}" />
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合地点：</label>
                    <input type="text" class="form-control" name="data[guide_come_addr]" value="{$need['guide_come_addr'] ? $need['guide_come_addr'] : $detail['guide_come_addr']}" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源管理需求</label><input type="text" name="data[other_zy_condition]"  value="{$need['other_zy_condition'] ? $need['other_zy_condition'] : $detail['other_zy_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">用车需求：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_bus]" value="1" <?php if ($need ? $need['is_need_bus']==1 : $detail['is_need_bus']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_bus]" value="0" <?php if ($need ? $need['is_need_bus']==0 : $detail['is_need_bus']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[bus_num]" value="{$need['bus_num'] ? $need['bus_num'] : $detail['bus_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        几座车：<input type="text" name="data[bus_seat]" value="{$need['bus_seat'] ? $need['bus_seat'] : $detail['bus_seat']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        具体要求：<input type="text" name="data[bus_condition]" value="{$need['bus_condition'] ? $need['bus_condition'] : $detail['bus_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">用餐需求：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_food]" value="1" <?php if ($need ? $need['is_need_food']==1 : $detail['is_need_food']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_food]" value="0" <?php if ($need ? $need['is_need_food']==0 : $detail['is_need_food']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[food_num]" value="{$need['food_num'] ? $need['food_num'] : $detail['food_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        价格：<input type="text" name="data[food_price]" value="{$need['food_price'] ? $need['food_price'] : $detail['food_price']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求</label><input type="text" name="data[other_jd_condition]"  value="{$need ? $need['other_jd_condition'] : $detail['other_jd_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">任务卡</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_taskCard]" value="1" <?php if ($need ? $need['is_need_taskCard']==1 : $detail['is_need_taskCard']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_taskCard]" value="0" <?php if ($need ? $need['is_need_taskCard']==0 : $detail['is_need_taskCard']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        页数：<input type="text" name="data[taskCard_page_num]" value="{$need['taskCard_page_num'] ? $need['taskCard_page_num'] : $detail['taskCard_page_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        数量：<input type="text" name="data[taskCard_num]" value="{$need['taskCard_num'] ? $need['taskCard_num'] : $detail['taskCard_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        设计要求：<input type="text" name="data[taskCard_condition]" value="{$need['taskCard_condition'] ? $need['taskCard_condition'] : $detail['taskCard_condition']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">项目展板</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_displayBoard]" value="1" <?php if ($need ? $need['is_need_displayBoard']==1 : $detail['is_need_displayBoard']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_displayBoard]" value="0" <?php if ($need ? $need['is_need_displayBoard']==0 : $detail['is_need_displayBoard']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">横幅</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_banner]" value="1" <?php if ($need ? $need['is_need_banner']==1 : $detail['is_need_banner']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_banner]" value="0" <?php if ($need ? $need['is_need_banner']==0 : $detail['is_need_banner']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        具体要求：<input type="text" name="data[banner_condition]" value="{$need['banner_condition'] ? $need['banner_condition'] : $detail['banner_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">环创需求</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_HC]" value="1" <?php if ($need ? $need['is_need_HC']==1 : $detail['is_need_HC']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_HC]" value="0" <?php if ($need ? $need['is_need_HC']==0 : $detail['is_need_HC']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        具体要求：<input type="text" name="data[HC_condition]" value="{$need['HC_condition'] ? $need['HC_condition'] : $detail['HC_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
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