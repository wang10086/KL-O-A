<div class="form-group col-md-12 box-title" style="margin:20px 0 10px 0;">拼团数据</div>
<div class="content line-gray" id="add_group_box">
    <div class="form-group col-md-12">
        <div id="addGroupContent" class="addGroupContent ">
            <div class="userlist form-title" id="">
                <div class="unitbox" style="width:80px">员工姓名</div>
                <div class="unitbox" style="width:15%">所属部门</div>
                <div class="unitbox" style="width:10%">实际人数</div>
                <div class="unitbox" style="width:10%">收入</div>
                <div class="unitbox" style="width:10%">毛利</div>
                <!--<div class="unitbox" style="width:10%">毛利率</div>
                <div class="unitbox" style="width:10%">人均毛利</div>-->
                <div class="unitbox" style="width:20%">备注</div>
            </div>
            <div id="group_val">1</div>
            <?php if($groups){ ?>
                <foreach name="groups" key="k" item="v">
                    <script>{++$k}; var n = parseInt($('#group_val').text());n++;$('#group_val').text(n);</script>
                    <div class="userlist no-border group-content" id="group_con_{$k}">
                        <span class="title">{$k}</span>
                        <input type="hidden" name="resid[]" value="{$v['id']}">
                        <input type="hidden" name="group[{$k}][id]" value="{$v.id}">
                        <input type="text" class="form-control" style="width:80px" name="group[{$k}][username]" id="name_{$k}" value="{$v.username}" readonly>
                        <input type="hidden"  class="form-control" name="group[{$k}][userid]" id="uid_{$k}" value="{$v.userid}">
                        <select class="form-control" style="width:15%" name="group[{$k}][code]">
                            <foreach name="businessDep" key="key" item="value">
                                <option value="{$key}" <?php if ($v['code']==$key){ echo "selected"; } ?>>{$value}</option>
                            </foreach>
                        </select>
                        <input type="text" class="form-control" style="width:10%" name="group[{$k}][num]" value="{$v.num}">
                        <input type="text" class="form-control group-shouru" style="width:10%" name="group[{$k}][shouru]" value="{$v.shouru}" onblur="get_group_maoli($(this).val(),{$k})">
                        <input type="text" class="form-control" style="width:10%" name="group[{$k}][maoli]" value="{$v.maoli}" id="group_maoli_{$k}">
                        <!--<input type="text" class="form-control" style="width:10%" name="group[{$k}][maolilv]" value="{$v.maolilv}">
                        <input type="text" class="form-control" style="width:10%" name="group[{$k}][renjunmaoli]" value="{$v.renjunmaoli}">-->
                        <input type="text" class="form-control" style="width:20%" name="group[{$k}][jd_remark]" value="<?php echo $v['jd_remark'] ? $v['jd_remark'] : $v['remark']; ?>">
                    </div>
                </foreach>

                <div class="sumUserList">
                    <div class="unitbox" style="width: 80px">&nbsp;</div>
                    <div class="unitbox" style="width: 15%;">&nbsp;</div>
                    <div class="unitbox" style="width: 10%;">&nbsp;</div>
                    <div class="unitbox" style="width: 10%;" id="groupShouruSum"></div>
                    <div class="unitbox" style="width: 20%">&nbsp;</div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>