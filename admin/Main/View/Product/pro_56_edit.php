<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="14">
                <!--<input type="hidden" name="need_id" value="{$list.id}">-->
                <input type="hidden" name="id" value="{$detail.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-4">
                    <label>活动时间：</label><input type="text" name="data[time]"  value="<?php echo $detail['time'] ? date('Y-m-d',$detail['time']) : ''; ?>" class="form-control inputdate"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动具体时间段：</label><input type="text" name="in_time"  value="<?php echo $detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''; ?>" class="form-control inputdate_b"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动地址：</label><input type="text" name="data[addr]"  value="{$detail.addr}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>参与年级：</label><input type="text" name="data[grade]"  value="{$detail.grade}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：</label><input type="text" name="data[stu_num]"  value="{$detail.stu_num}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动预算(成本价格)：</label><input type="text" name="data[price]"  value="{$detail.price}" class="form-control"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>场地条件：</label>
                    <input type="checkbox" name="yard[]" value="室内" <?php if (in_array('室内',$yards)) echo "checked"; ?>> &#8194;室内 &#12288;
                    <input type="checkbox" name="yard[]" value="室外" <?php if (in_array('室外',$yards)) echo "checked"; ?>> &#8194;室外 &#12288;
                </div>

                <div class="form-group col-md-4">
                    <label>接电：</label>
                    <input type="radio" name="data[electric]" value="1" <?php if ($detail['electric']==1) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[electric]" value="0" <?php if ($detail['electric']==0) echo "checked"; ?>> &#8194;否 &#12288;
                </div>

                <div class="form-group col-md-4">
                    <label>其它场地信息，如场地大小等：</label><input type="text" name="data[yard_more]" value="{$detail.yard_more}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-6">
                    <label>项目总数：</label>
                    <input type="text" class="form-control" name="data[op_num]" value="{$detail.op_num}" />
                </div>

                <div class="form-group col-md-6">
                    <label>开幕式项目数量：</label>
                    <input type="text" class="form-control" name="data[begin_op_num]" value="{$detail.begin_op_num}" />
                </div>

                <div class="form-group col-md-6">
                    <label>制作类项目种类：</label>
                    <input type="text" class="form-control" name="data[make_op_type]" value="{$detail.make_op_type}" />
                </div>

                <div class="form-group col-md-6">
                    <label>制作类各种类数量：</label>
                    <input type="text" class="form-control" name="data[make_op_num]" value="{$detail.make_op_num}" />
                </div>

                <div class="form-group col-md-4">
                    <p><label>开幕式是否串场：</label></p>
                    <input type="radio" name="data[is_comeOut]" value="1" <?php if ($detail['is_comeOut'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[is_comeOut]" value="0" <?php if ($detail['is_comeOut'] == 0) echo "checked"; ?>> &#8194;否
                </div>

                <div class="form-group col-md-4">
                    <p><label>开幕式串词：</label></p>
                    <input type="radio" name="data[is_comeOutWord]" value="1" <?php if ($detail['is_comeOutWord'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[is_comeOutWord]" value="0" <?php if ($detail['is_comeOutWord'] == 0) echo "checked"; ?>> &#8194;否
                </div>

                <div class="form-group col-md-4">
                    <label>开幕式其他具体要求：</label>
                    <input type="text" class="form-control" name="data[comeOut_condition]" value="{$detail.comeOut_condition}" />
                </div>

                <div class="form-group col-md-4">
                    <p><label>小礼品：</label></p>
                    <input type="radio" name="data[is_gift]" value="1" <?php if ($detail['is_gift'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[is_gift]" value="0" <?php if ($detail['is_gift'] == 0) echo "checked"; ?>> &#8194;否
                </div>

                <div class="form-group col-md-4">
                    <label>小礼品具体要求：</label>
                    <input type="text" class="form-control" name="data[gift_condition]" value="{$detail.gift_condition}" />
                </div>

                <div class="form-group col-md-4">
                    <label>小礼品均价：</label>
                    <input type="text" class="form-control" name="data[gift_price]" value="{$detail.gift_price}" />
                </div>

                <div class="form-group col-md-12">
                    <label>活动流程(时间安排)</label><input type="text" name="data[content]"  value="{$detail['content']}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发方案需求 <font color="#999">(主持人等)</font></label><input type="text" name="data[other_yf_condition]"  value="{$detail['other_yf_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>辅导员数量：<font color="#999">(个)</font></label>
                    <input type="text" class="form-control" name="data[guide_num]" value="{$detail.guide_num}" />
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员要求：</label>
                    <input type="text" class="form-control" name="data[guide_condition]" value="{$detail.guide_condition}" />
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员费用：<font color="#999">(元)</font></label>
                    <input type="text" class="form-control" name="data[guide_price]" value="{$detail.guide_price}" />
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合时间：<font color="red">(时间请填写到分)</font></label>
                    <input type="text" class="form-control inputdatetime" name="data[guide_come_time]" value="{$detail.guide_come_time}" />
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员集合地点：</label>
                    <input type="text" class="form-control" name="data[guide_come_addr]" value="{$detail.guide_come_addr}" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源管理需求</label><input type="text" name="data[other_zy_condition]"  value="{$detail['other_zy_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">用车需求：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_bus]" value="1" <?php if ($detail['is_need_bus'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_bus]" value="0" <?php if ($detail['is_need_bus'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[bus_num]" value="{$detail['bus_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        几座车：<input type="text" name="data[bus_seat]" value="{$detail['bus_seat']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        具体要求：<input type="text" name="data[bus_condition]" value="{$detail['bus_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">用餐需求：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_food]" value="1" <?php if ($detail['is_need_food'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_food]" value="0" <?php if ($detail['is_need_food'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[food_num]" value="{$detail['food_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        价格：<input type="text" name="data[food_price]" value="{$detail['food_price']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求</label><input type="text" name="data[other_jd_condition]"  value="{$detail['other_jd_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">任务卡</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_taskCard]" value="1" <?php if ($detail['is_need_taskCard'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_taskCard]" value="0" <?php if ($detail['is_need_taskCard'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        页数：<input type="text" name="data[taskCard_page_num]" value="{$detail['taskCard_page_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        数量：<input type="text" name="data[taskCard_num]" value="{$detail['taskCard_num']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        设计要求：<input type="text" name="data[taskCard_condition]" value="{$detail['taskCard_condition']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">项目展板</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_displayBoard]" value="1" <?php if ($detail['is_need_displayBoard'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_displayBoard]" value="0" <?php if ($detail['is_need_displayBoard'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">横幅</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_banner]" value="1" <?php if ($detail['is_need_banner'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_banner]" value="0" <?php if ($detail['is_need_banner'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        具体要求：<input type="text" name="data[banner_condition]" value="{$detail['banner_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">环创需求</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_HC]" value="1" <?php if ($detail['is_need_HC'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_HC]" value="0" <?php if ($detail['is_need_HC'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        具体要求：<input type="text" name="data[HC_condition]" value="{$detail['HC_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label>其他设计需求</label><input type="text" name="data[other_sj_condition]"  value="{$detail['other_sj_condition']}" class="form-control" />
                </div>
            </form>

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="submitForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="7">
                <input type="hidden" name="id" value="{$list.id}">
            </form>

            <!--保存 提交按钮-->
            <include file="pro_submit_btns" />

            <!--<div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
                <?php /*if ($detail['id'] && $list['process'] == 0){ */?>
                    <button type="button" class="btn btn-warning btn-sm" onclick="$('#submitForm').submit()" >提交</button>
                <?php /*} */?>
            </div>-->
        </div>
    </div><!-- /.box-body -->
</div>