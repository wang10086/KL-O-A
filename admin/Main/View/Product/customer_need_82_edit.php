<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save_customer_need')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="2">
                <input type="hidden" name="id" value="{$need.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>活动时间：</label><input type="text" name="data[time]"  value="<?php echo $need['time'] ? date('Y-m-d',$need['time']) : ($detail['time'] ? date('Y-m-d',$detail['time']) : ''); ?>" class="form-control inputdate"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动具体时间段：</label><input type="text" name="in_time"  value="<?php echo $need['st_time'] ? date('H:i:s',$need['st_time']).' - '.date('H:i:s',$need['et_time']) : ($detail['st_time'] ? date('H:i:s',$detail['st_time']).' - '.date('H:i:s',$detail['et_time']) : ''); ?>" class="form-control inputdate_b"  required />
                </div>

                <div class="form-group col-md-4">
                    <label>活动总人数：</label>
                    <input type="text" class="form-control" name="data[member]" value="{$need['member'] ? $need['member'] : $detail['member']}" required />
                </div>

                <div class="form-group col-md-4">
                    <label>班级数量：</label>
                    <input type="text" class="form-control" name="data[class_num]" value="{$need['class_num'] ? $need['class_num'] : $detail['class_num']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>每个班级人数：</label>
                    <input type="text" class="form-control" name="data[class_stu_num]" value="{$need['class_stu_num'] ? $need['class_stu_num'] : $detail['class_stu_num']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>课题数量：</label>
                    <input type="text" class="form-control" name="data[lession_num]" value="{$need['lession_num'] ? $need['lession_num'] : $detail['lession_num']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>课题领域：</label>
                    <input type="text" class="form-control" name="data[lession_field]" value="{$need['lession_field'] ? $need['lession_field'] : $detail['lession_field']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>课题安排：<font class="#999">对应数量分别填写每个班级课题名称</font></label>
                    <input type="text" class="form-control" name="data[lession_plan]" value="{$need['lession_plan'] ? $need['lession_plan'] : $detail['lession_plan']}" />
                </div>

                <div class="form-group col-md-4">
                    <label>分组要求：<font color="#999">每班分（）组，请填写数字</font></label>
                    <input type="text" class="form-control" name="data[lession_group]" value="{$need['lession_group'] ? $need['lession_group'] : $detail['lession_group']}" />
                </div>

                <div class="form-group col-md-4">
                    <p><label>踩点需求</label></p>
                    <input type="radio" name="data[foot]" value="1" <?php if ($need ? $need['foot']==1 : $detail['foot']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                    <input type="radio" name="data[foot]" value="0" <?php if ($need ? $need['foot']==0 : $detail['foot']==0) echo 'checked'; ?>> &#8194;否
                </div>

                <div class="form-group col-md-8">
                    <label>活动预算：</label>
                    <input type="text" class="form-control" name="data[yf_cost]" value="{$need['yf_cost'] ? $need['yf_cost'] : $detail['yf_cost']}" />
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">科学第一课</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_first_lession]" value="1" <?php if ($need ? $need['is_first_lession']==1 : $detail['is_first_lession']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_first_lession]" value="0" <?php if ($need ? $need['is_first_lession']==0 : $detail['is_first_lession']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        地点：<input type="text" name="data[addr1]" value="{$need['addr1'] ? $need['addr1'] : $detail['addr1']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时间：<input type="text" name="data[time1]" value="<?php echo $need['time1'] ? date('Y-m-d',$need['time1']) : ($detail['time1'] ? date('Y-m-d',$detail['time1']) : ''); ?>" class="inputdatetime" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时长(小时)：<input type="text" name="data[long1]" value="{$need['long1'] ? $need['long1'] : $detail['long1']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">课题前课</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_lession_before]" value="1" <?php if ($need ? $need['is_lession_before']==1 : $detail['is_lession_before']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_lession_before]" value="0" <?php if ($need ? $need['is_lession_before']==0 : $detail['is_lession_before']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        地点：<input type="text" name="data[addr2]" value="{$need['addr2'] ? $need['addr2'] : $detail['addr2']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时间：<input type="text" name="data[time2]" value="<?php echo $need['time2'] ? date('Y-m-d',$need['time2']) : ($detail['time2'] ? date('Y-m-d',$detail['time2']) : ''); ?>" class="inputdatetime" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时长(小时)：<input type="text" name="data[long2]" value="{$need['long2'] ? $need['long2'] : $detail['long2']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">答辩</label>
                    <div style="width: 20%; float: left;">
                        <input type="radio" name="data[is_defence]" value="1" <?php if ($need ? $need['is_defence']==1 : $detail['is_defence']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_defence]" value="0" <?php if ($need ? $need['is_defence']==0 : $detail['is_defence']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 70%; float: left;">
                        地点：<input type="text" name="data[addr3]" value="{$need['addr3'] ? $need['addr3'] : $detail['addr3']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时间：<input type="text" name="data[time3]" value="<?php echo $need['time3'] ? date('Y-m-d',$need['time3']) : ($detail['time3'] ? date('Y-m-d',$detail['time3']) : ''); ?>" class="inputdatetime" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                        时长(小时)：<input type="text" name="data[long3]" value="{$need['long3'] ? $need['long3'] : $detail['long3']}" style="border: none; border-bottom: solid 1px; min-width: 160px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>其他研发需求</label><input type="text" name="data[other_yf_condition]"  value="{$need['other_yf_condition'] ? $need['other_yf_condition'] : $detail['other_yf_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>辅导员数量：</label>
                    <input type="text" class="form-control" name="data[guide_num]" value="{$need['guide_num'] ? $need['guide_num'] : $detail['guide_num']}" required />
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员要求</label>
                    <select name="data[guide_condition]" class="form-control">
                        <option value="">==请选择==</option>
                        <foreach name="teacher_level" item="v">
                            <option value="{$v}" <?php if ($need ? $need['guide_condition'] == $v : $detail['guide_condition']==$v) echo "selected"; ?>>{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员费用：</label>
                    <select name="data[guide_cost]" class="form-control">
                        <option value="">==请选择==</option>
                        <option value="250" <?php if ($need ? $need['guide_cost'] == 250 : $detail['guide_cost']==250) echo "selected"; ?>>250元</option>
                        <option value="300" <?php if ($need ? $need['guide_cost'] == 300 : $detail['guide_cost']==300) echo "selected"; ?>>300元</option>
                        <option value="500" <?php if ($need ? $need['guide_cost'] == 500 : $detail['guide_cost']==500) echo "selected"; ?>>500元</option>
                        <option value="800" <?php if ($need ? $need['guide_cost'] == 800 : $detail['guide_cost']==800) echo "selected"; ?>>800元</option>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label>其他资源需求</label><input type="text" name="data[other_zy_condition]"  value="{$need['other_zy_condition'] ? $need['other_zy_condition'] : $detail['other_zy_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-12">
                    <label>物资需求：</label>
                    <input type="text" class="form-control" name="data[material]" value="{$need['material'] ? $need['material'] : $detail['material']}" required />
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
                        <input type="radio" name="data[is_need_bus]" value="1" <?php if ($need ? $need['is_need_bus']==1 : $detail['is_need_bus']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_bus]" value="0" <?php if ($need ? $need['is_need_bus']==0 : $detail['is_need_bus']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[bus_num]" value="{$need['bus_num'] ? $need['bus_num'] : $detail['bus_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        几座车：<input type="text" name="data[bus_seat]" value="{$need['bus_seat'] ? $need['bus_seat'] : $detail['bus_seat']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[bus_other]" value="{$need['bus_other'] ? $need['bus_other'] : $detail['bus_other']}" style="border: none; border-bottom: solid 1px; min-width: 200px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">餐食：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_food]" value="1" <?php if ($need ? $need['is_need_food']==1 : $detail['is_need_food']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_food]" value="0" <?php if ($need ? $need['is_need_food']==0 : $detail['is_need_food']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[food_num]" value="{$need['food_num'] ? $need['food_num'] : $detail['food_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        价格：<input type="text" name="data[food_price]" value="{$need['food_price'] ? $need['food_price'] : $detail['food_price']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>保险：<font color="#999">默认一天0.5元，2天1.2，有其他需求备注</font></label>
                    <input type="text" class="form-control" name="data[safe_remark]" value="{$need['safe_remark'] ? $need['safe_remark'] : $detail['safe_remark']}" required />
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求</label><input type="text" name="data[other_jd_condition]"  value="{$need['other_jd_condition'] ? $need['other_jd_condition'] : $detail['other_jd_condition']}" class="form-control" />
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">科学海报：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_poster]" value="1" <?php if ($need ? $need['is_need_poster']==1 : $detail['is_need_poster']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_poster]" value="0" <?php if ($need ? $need['is_need_poster']==0 : $detail['is_need_poster']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[poster_num]" value="{$need['poster_num'] ? $need['poster_num'] : $detail['poster_num']}{$detail['']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        要求：<input type="text" name="data[poster_other]" value="{$need['poster_other'] ? $need['poster_other'] : $detail['poster_other']}{$detail['']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                    </div>
                </div>

                <div class="form-group col-md-12" style="overflow: hidden;">
                    <label style="float: left; width: 80px;">手册要求：</label>
                    <div style="width: 15%; float: left;">
                        <input type="radio" name="data[is_need_manual]" value="1" <?php if ($need ? $need['is_need_manual']==1 : $detail['is_need_manual']==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[is_need_manual]" value="0" <?php if ($need ? $need['is_need_manual']==0 : $detail['is_need_manual']==0) echo 'checked'; ?>> &#8194;否
                    </div>
                    <div style="width: 75%; float: left;">
                        数量：<input type="text" name="data[manual_num]" value="{$need['manual_num'] ? $need['manual_num'] : $detail['manual_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
                        页数：<input type="text" name="data[page_num]" value="{$need['page_num'] ? $need['page_num'] : $detail['page_num']}" style="border: none; border-bottom: solid 1px; min-width: 100px;" > &#12288;&#12288;
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