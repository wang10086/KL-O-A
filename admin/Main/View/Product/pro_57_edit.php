<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="18">
                <input type="hidden" name="need_id" value="{$list.id}">
                <input type="hidden" name="id" value="{$detail.id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-6">
                    <label>类型：</label>
                    <select name="data[type]" class="form-control">
                        <option value="自研" <?php if ($detail['type']=='自研') echo 'selected'; ?>>自研</option>
                        <option value="外采社会大课堂" <?php if ($detail['type']=='外采社会大课堂') echo 'selected'; ?>>外采社会大课堂</option>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>外采比例： <font color="#999">(门票/门票+自研课程)</font></label>
                    <input type="text" class="form-control" name="data[buy_ratio]" value="{$detail.buy_ratio}" />
                </div>

                <div class="form-group col-md-6">
                    <label>目的地：</label>
                    <input type="text" class="form-control" name="data[addr]" value="{$detail.addr}" />
                </div>

                <div class="form-group col-md-6">
                    <label>时间：</label><input type="text" name="data[time]"  value="<?php echo $detail['time'] ? date('Y-m-d',$detail['time']) : ''; ?>" class="form-control inputdate"  required />
                </div>

                <div class="form-group col-md-6">
                    <label>活动领域：</label>
                    <input type="text" class="form-control" name="data[field]" value="{$detail.field}" />
                </div>

                <div class="form-group col-md-6">
                    <label>活动安排：</label>
                    <input type="text" class="form-control" name="data[plan]" value="{$detail.plan}" />
                </div>

                <div class="form-group col-md-6">
                    <label>有无动手/讲解/体验活动：</label>
                    <input type="text" class="form-control" name="data[content]" value="{$detail.content}" />
                </div>

                <div class="form-group col-md-6">
                    <label>其他研发方案需求</label><input type="text" name="data[other_yf_condition]"  value="{$detail['other_yf_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">专家</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_expert]" value="1" <?php if ($detail['is_need_expert'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_expert]" value="0" <?php if ($detail['is_need_expert'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        填写级别或指定某人：<input type="text" name="data[expert_info]" value="{$detail['expert_info']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">院所</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_institutes]" value="1" <?php if ($detail['is_need_institutes'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_institutes]" value="0" <?php if ($detail['is_need_institutes'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        填写具体院所：<input type="text" name="data[institutes]" value="{$detail['institutes']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员数量：</label>
                    <input type="text" class="form-control" name="data[guide_num]" value="{$detail.guide_num}" />
                </div>

                <div class="form-group col-md-6">
                    <label>辅导员要求：</label>
                    <input type="text" class="form-control" name="data[guide_condition]" value="{$detail.guide_condition}" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求</label><input type="text" name="data[other_zy_condition]"  value="{$detail['other_zy_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">大巴车：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_bus]" value="1" <?php if ($detail['is_need_bus'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_bus]" value="0" <?php if ($detail['is_need_bus'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[bus_num]" value="{$detail['bus_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        几座车：<input type="text" name="data[bus_seat]" value="{$detail['bus_seat']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[bus_condition]" value="{$detail['bus_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">导游：</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_guider]" value="1" <?php if ($detail['is_need_guider'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_guider]" value="0" <?php if ($detail['is_need_guider'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[guider_num]" value="{$detail['guider_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[guider_condition]" value="{$detail['guider_condition']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                        性别：<input type="text" name="data[guider_sex]" value="{$detail['guider_sex']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">餐食</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_need_food]" value="1" <?php if ($detail['is_need_food'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_food]" value="0" <?php if ($detail['is_need_food'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        数量：<input type="text" name="data[food_num]" value="{$detail['food_num']}" style="border: none; border-bottom: solid 1px; min-width: 150px;" > &#12288;&#12288;
                        餐标：<input type="text" name="data[food_condition]" value="{$detail['food_condition']}" style="border: none; border-bottom: solid 1px; min-width: 150px;" > &#12288;&#12288;
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
                        <input type="radio" name="data[is_need_relation]" value="1" <?php if ($detail['is_need_relation'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_relation]" value="0" <?php if ($detail['is_need_relation'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="float: left;">
                        金额：<input type="text" name="data[relation_price]" value="{$detail['relation_price']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">横幅：</label>
                    <div style="float: left; margin-right: 20px;">
                        <input type="radio" name="data[is_need_banner]" value="1" <?php if ($detail['is_need_banner'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_banner]" value="0" <?php if ($detail['is_need_banner'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="float: left;">
                        数量：<input type="text" name="data[banner_num]" value="{$detail['banner_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">旗子：</label>
                    <div style="float: left; margin-right: 20px;">
                        <input type="radio" name="data[is_need_flag]" value="1" <?php if ($detail['is_need_flag'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_flag]" value="0" <?php if ($detail['is_need_flag'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="float: left;">
                        数量：<input type="text" name="data[flag_num]" value="{$detail['flag_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>物资需求： <font color="#999">(矿泉水、耳机、营服、营帽、医药箱、证书、手册、行李帖等)</font></label><input type="text" name="data[material_condition]"  value="{$detail['material_condition']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>门票： </label><input type="text" name="data[ticket]"  value="{$detail['ticket']}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：</label><input type="text" name="data[other_jd_condition]"  value="{$detail['other_jd_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 100px;">手册：</label>
                    <div style="width: 70%; float: left;">
                        页数：<input type="text" name="data[page_num]" value="{$detail['page_num']}" style="border: none; border-bottom: solid 1px; width: 150px;" > &#12288;&#12288;
                        设计要求：<input type="text" name="data[manual_condition]" value="{$detail['manual_condition']}" style="border: none; border-bottom: solid 1px; width: 300px;" > &#12288;&#12288;
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

            <div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
                <?php if ($detail['id'] && in_array($list['status'],array(0,2))){ ?>
                    <button type="button" class="btn btn-warning btn-sm" onclick="$('#submitForm').submit()" >提交</button>
                <?php } ?>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>