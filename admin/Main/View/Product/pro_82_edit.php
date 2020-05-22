<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="9">
                <input type="hidden" name="need_id" value="{$list.id}">
                <input type="hidden" name="id" value="{$detail.id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>活动时间：</label><input type="text" name="data[time]"  value="<?php echo $detail['time'] ? date('Y-m-d',$detail['time']) : ''; ?>" class="form-control inputdate"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动具体时间段：</label><input type="text" name="in_time"  value="<?php echo $detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''; ?>" class="form-control inputdate_b"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动总人数：</label>
                    <input type="text" class="form-control" name="data[member]" value="{$detail.member}" required />
                </div>

                <div class="form-group col-md-4">
                    <label>班级数量：</label>
                    <input type="text" class="form-control" name="data[class_num]" value="{$detail.class_num}" />
                </div>

                <div class="form-group col-md-4">
                    <label>每个班级人数：</label>
                    <input type="text" class="form-control" name="data[class_stu_num]" value="{$detail.class_stu_num}" />
                </div>

                <div class="form-group col-md-4">
                    <label>课题数量：</label>
                    <input type="text" class="form-control" name="data[lession_num]" value="{$detail.lession_num}" />
                </div>

                <div class="form-group col-md-4">
                    <label>课题领域：</label>
                    <input type="text" class="form-control" name="data[lession_field]" value="{$detail.lession_field}" />
                </div>

                <div class="form-group col-md-4">
                    <label>课题安排：<font class="#999">对应数量分别填写每个班级课题名称</font></label>
                    <input type="text" class="form-control" name="data[lession_plan]" value="{$detail.lession_plan}" />
                </div>

                <div class="form-group col-md-4">
                    <label>分组要求：<font color="#999">每班分（）组，请填写数字</font></label>
                    <input type="text" class="form-control" name="data[lession_group]" value="{$detail.lession_group}" />
                </div>

                <div class="form-group col-md-4">
                    <p><label>踩点需求</label></p>
                    <input type="radio" name="data[foot]" value="1" <?php if ($detail['foot'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[foot]" value="0" <?php if ($detail['foot'] == 0) echo "checked"; ?>> &#8194;否
                </div>

                <div class="form-group col-md-8">
                    <label>活动预算：</label>
                    <input type="text" class="form-control" name="data[yf_cost]" value="{$detail.yf_cost}" />
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">科学第一课</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_first_lession]" value="1" <?php if ($detail['is_first_lession'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_first_lession]" value="0" <?php if ($detail['is_first_lession'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        地点：<input type="text" name="data[addr1]" value="{$detail['addr1']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时间：<input type="text" name="data[time1]" value="{$detail.time1|date='Y-m-d',###}" class="inputdatetime" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时长(小时)：<input type="text" name="data[long1]" value="{$detail['long1']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">课题前课</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_lession_before]" value="1" <?php if ($detail['is_lession_before'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_lession_before]" value="0" <?php if ($detail['is_lession_before'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        地点：<input type="text" name="data[addr2]" value="{$detail['addr2']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时间：<input type="text" name="data[time2]" value="{$detail.time2|date='Y-m-d',###}" class="inputdatetime" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时长(小时)：<input type="text" name="data[long2]" value="{$detail['long2']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">答辩</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_defence]" value="1" <?php if ($detail['is_defence'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_defence]" value="0" <?php if ($detail['is_defence'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        地点：<input type="text" name="data[addr3]" value="{$detail['addr3']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时间：<input type="text" name="data[time3]" value="{$detail.time3|date='Y-m-d',###}" class="inputdatetime" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时长(小时)：<input type="text" name="data[long3]" value="{$detail['long3']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发需求</label><input type="text" name="data[other_yf_condition]"  value="{$detail['other_yf_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>辅导员数量：</label>
                    <input type="text" class="form-control" name="data[guide_num]" value="{$detail.guide_num}" required />
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员要求</label>
                    <select name="data[guide_condition]" class="form-control">
                        <option value="">==请选择==</option>
                        <foreach name="teacher_level" item="v">
                            <option value="{$v}" <?php if ($detail['guide_condition'] == $v) echo "selected"; ?>>{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员费用：</label>
                    <select name="data[guide_cost]" class="form-control">
                        <option value="">==请选择==</option>
                        <option value="250" <?php if ($detail['guide_cost'] == 250) echo "selected"; ?>>250元</option>
                        <option value="300" <?php if ($detail['guide_cost'] == 300) echo "selected"; ?>>300元</option>
                        <option value="500" <?php if ($detail['guide_cost'] == 500) echo "selected"; ?>>500元</option>
                        <option value="800" <?php if ($detail['guide_cost'] == 800) echo "selected"; ?>>800元</option>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求</label><input type="text" name="data[other_zy_condition]"  value="{$detail['other_zy_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-12">
                    <label>物资需求：</label>
                    <input type="text" class="form-control" name="data[material]" value="{$detail.material}" required />
                </div>

                <div class="form-group col-md-12">
                    <label>场地信息：</label>
                    <input type="checkbox" name="yard[]" value="开放性场馆" <?php if (in_array('开放性场馆',$yard_arr)) echo "checked"; ?>> &#8194;开放性场馆 &#12288;
                    <input type="checkbox" name="yard[]" value="社会大课堂资源" <?php if (in_array('社会大课堂资源',$yard_arr)) echo "checked"; ?>> &#8194;社会大课堂资源 &#12288;
                    <input type="checkbox" name="yard[]" value="收费科普场馆" <?php if (in_array('收费科普场馆',$yard_arr)) echo "checked"; ?>> &#8194;收费科普场馆 &#12288;
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">大巴车：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_bus]" value="1" <?php if ($detail['is_need_bus'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_bus]" value="0" <?php if ($detail['is_need_bus'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[bus_num]" value="{$detail['bus_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        几座车：<input type="text" name="data[bus_seat]" value="{$detail['bus_seat']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[bus_other]" value="{$detail['bus_other']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">餐食：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_food]" value="1" <?php if ($detail['is_need_food'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_food]" value="0" <?php if ($detail['is_need_food'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[food_num]" value="{$detail['food_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        价格：<input type="text" name="data[food_price]" value="{$detail['food_price']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>保险：<font color="#999">默认一天0.5元，2天1.2，有其他需求备注</font></label>
                    <input type="text" class="form-control" name="data[safe_remark]" value="{$detail.safe_remark}" required />
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求</label><input type="text" name="data[other_jd_condition]"  value="{$detail['other_jd_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">科学海报：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_poster]" value="1" <?php if ($detail['is_need_poster'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_poster]" value="0" <?php if ($detail['is_need_poster'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[poster_num]" value="{$detail['poster_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[poster_other]" value="{$detail['poster_other']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">手册要求：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_manual]" value="1" <?php if ($detail['is_need_manual'] == 1) echo "checked"; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_manual]" value="0" <?php if ($detail['is_need_manual'] == 0) echo "checked"; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[manual_num]" value="{$detail['manual_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        页数：<input type="text" name="data[page_num]" value="{$detail['page_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
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