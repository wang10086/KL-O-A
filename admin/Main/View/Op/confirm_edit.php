<script type="text/javascript">
    var keywords = <?php echo $userkey; ?>;
    function autoComLode(name,id){
        autocomplete_id(name,id,keywords);
    }
</script>
<form method="post" action="{:U('Op/confirm')}" name="myform" id="appsubmint">
<input type="hidden" name="dosubmit" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="id" value="{$confirm.id}">
<div class="content" style="padding-bottom:20px;">

    <div style="width:100%; float:left;">
        <div class="form-group col-md-12">
            <label>项目团号：</label>
            <!-- <input type="text" name="info[group_id]"  class="form-control" onblur="check_group_id()" value="<?php if($confirm['group_id']){ echo $confirm['group_id'];}else{ echo $op['group_id'];} ?>" required /> -->
            <input type="text" name="info[group_id]"  class="form-control" onblur="check_group_id()" value="<?php if($op['group_id']){ echo $op['group_id']; }else{ echo $user_info['groupno'].date('Y');} ?>" required />
        </div>

        <div class="form-group col-md-4">
            <p><label>是否有业务实施方案需求：</label></p>
            <input type="radio" name="info[is_need_project]" value="1" <?php if ($confirm['is_need_project'] == 1) echo "checked"; ?>> &#8194;需要 &#12288;
            <input type="radio" name="info[is_need_project]" value="0" <?php if ($confirm['is_need_project'] == 0) echo "checked"; ?>> &#8194;不需要
        </div>

        <div class="form-group col-md-4">
            <label>实际出团成人数：</label>
            <input type="text" name="info[num_adult]" class="form-control" value="{$confirm.num_adult}" required />
        </div>
        <div class="form-group col-md-4">
            <label>实际出团儿童数：</label>
            <input type="text" name="info[num_children]" class="form-control" value="{$confirm.num_children}"required />
        </div>

        <div class="form-group col-md-4">
            <label>实际出发时间：</label>
            <input type="text" name="info[dep_time]" class="form-control inputdate" value="<if condition="$confirm['dep_time']">{$confirm.dep_time|date='Y-m-d',###}</if>" required />
        </div>
        <div class="form-group col-md-4">
            <label>实际返回时间：</label>
            <input type="text" name="info[ret_time]" class="form-control inputdate" onblur="set_contract_back_time()" value="<if condition="$confirm['ret_time']">{$confirm.ret_time|date='Y-m-d',###}</if>" required />
        </div>

        <div class="form-group col-md-4">
            <label>实际天数：</label>
            <input type="text" name="info[days]"  class="form-control" value="{$confirm.days}" required />
        </div>

        <div class="form-group col-md-4">
            <label>合同签订完成时间：</label>
            <input type="text" name="info[contract_sign_time]" class="form-control inputdate" value="<if condition="$confirm['contract_sign_time']">{$confirm.contract_sign_time|date='Y-m-d',###}</if>" required />
        </div>

        <div class="form-group col-md-4">
            <label>合同收回时间：</label>
            <input type="text" name="info[contract_back_time]" class="form-control inputdate" value="<if condition="$confirm['contract_back_time']">{$confirm.contract_back_time|date='Y-m-d',###}</if>" readonly />
        </div>

        <div class="form-group col-md-4">
            <label>回款时间：</label>
            <input type="text" name="info[back_money_time]"  class="form-control inputdate" value="<if condition="$confirm['back_money_time']">{$confirm.back_money_time|date='Y-m-d',###}</if>" required />
        </div>

        <div class="form-group col-md-4">
            <p><label>是否需要教委外出审批材料：</label></p>
            <input type="radio" name="info[jiaowei]" value="1" <?php if ($confirm['jiaowei'] == 1) echo "checked"; ?>> &#8194;需要 &#12288;
            <input type="radio" name="info[jiaowei]" value="0" <?php if ($confirm['jiaowei'] == 0) echo "checked"; ?>> &#8194;不需要
        </div>

        <div class="form-group col-md-4">
            <label>教委外出审批材料及时间节点：</label>
            <input type="text" name="info[jiaowei_remark]"  class="form-control" value="{$confirm.jiaowei_remark}" />
        </div>

        <div class="form-group col-md-4">
            <label>是否拼团：</label>
            <select class="form-control" name="add_group" onchange="add_group_op($(this).val())">
                <option value="0" <?php if ($op['add_group']==0){ echo 'selected'; } ?>>不拼团</option>
                <option value="1" <?php if ($op['add_group']==1){ echo 'selected'; } ?>>拼团</option>
            </select>
        </div>

        <div class="form-group col-md-12" id="add_group_box">
            <div id="addGroupContent" class="addGroupContent">
                <div class="userlist form-title">
                    <div class="unitbox" style="width:15%">员工姓名(关键字匹配)</div>
                    <div class="unitbox" style="width:15%">所属部门</div>
                    <div class="unitbox" style="width:15%">出团人数</div>
                    <div class="unitbox" style="width:20%">备注</div>
                </div>
                <div id="group_val">1</div>
                <?php if($groups){ ?>
                    <foreach name="groups" key="k" item="v">
                        <script>{++$k}; var n = parseInt($('#group_val').text());n++;$('#group_val').text(n);</script>
                        <div class="userlist no-border" id="group_con_{$k}">
                            <span class="title">{$k}</span>
                            <input type="hidden" name="resid[]" value="{$v['id']}">
                            <input type="hidden" name="group[{$k}][id]" value="{$v.id}">
                            <input type="text" class="form-control" style="width:15%" name="group[{$k}][username]" id="name_{$k}" value="{$v.username}">
                            <input type="hidden"  class="form-control" style="width:15%" name="group[{$k}][userid]" id="uid_{$k}" value="{$v.userid}">
                            <select class="form-control" style="width:15%" name="group[{$k}][code]">
                                <foreach name="businessDep" key="key" item="value">
                                    <option value="{$key}" <?php if ($v['code']==$key){ echo "selected"; } ?>>{$value}</option>
                                </foreach>
                            </select>
                            <input type="text" class="form-control" style="width:15%" name="group[{$k}][num]" value="{$v.num}">
                            <input type="text" class="form-control" style="width:20%" name="group[{$k}][remark]" value="{$v.remark}">
                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('group_con_{$k}')">删除</a>
                        </div>
                        <script> autoComLode('name_'+{$k},'uid_'+{$k}); </script>
                    </foreach>
                <?php }else{ ?>

                <?php } ?>
            </div>

            <div class="form-group col-md-12" id="useraddbtns">
                <a href="javascript:;" class="btn btn-success btn-sm" onClick="addGroup()"><i class="fa fa-fw fa-plus"></i> 拼团信息</a>
                <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="submitBefore('tcs_need_form','<?php /*echo U('Op/public_save'); */?>',{$op.op_id})">保存</a>
                <input type="submit" class="btn btn-info btn-sm" value="保存">-->
            </div>
        </div>
    </div>
</div>

<div id="formsbtn" style="padding-bottom:10px;margin-top:0;">
    <div class="content" style="margin-top:0;">
        <div id="formsbtn" style="padding-bottom:20px; color:#ff3300;">请确认该项目已经出团，认真填写相关数据，成团基本信息不可反复修改</div>
        <button type="button" onclick="check_confirm()" class="btn btn-info btn-lg" style=" padding-left:40px; padding-right:40px; margin-right:10px;">保存确认</button>
    </div>
</div>
</form>

<script type="text/javascript">
    /**
     * function set_contract_back_time() {
                let ret_time = $('input[name="info[ret_time]"]').val();
                if (ret_time){
                    let time1 = new Date(ret_time);
                    let day   = time1.getDate();
                    let month = time1.getMonth()+1;
                    let year  = time1.getFullYear();
                    day       = (day < 10) ? '0'+day : day;
                    if ( month === 12 ) {
                        year += 1;
                        month = '01';
                    } else {
                        month += 1;
                        month = (month < 10) ? '0'+month : month;
                    }

                    let nextMonth = year +'-'+month+'-'+day;
                    $('input[name="info[contract_back_time]"]').val(nextMonth)
                }
            }
     */
    //var keywords = <?php echo $userkey; ?>;
    $(function () {
       // autocomplete_id('name_1','uid_1',keywords);
        let groups      = <?php echo $groups?1:0; ?>;
        if (!groups){
            $('#add_group_box').hide();
        }

        $('input[name="info[ret_time]"]').blur(function () {
            set_contract_back_time();
        });
        $('input[name="info[days]"]').blur(function () {
            set_contract_back_time();
        });
    })

    function check_group_id() {
        var id          = $('input[name="id"]').val();
        var group_id    = $('input[name="info[group_id]"]').val().trim();
        var n           = group_id.length;
        if (n>8){
            $.ajax({
                type : 'POST',
                url  : '<?php echo U('Ajax/check_group_id'); ?>',
                dataType: 'json',
                data : {group_id:group_id,id:id},
                success:function (data) {
                    if (data.status == '-1'){
                        art_show_msg(data.info);
                    }
                    return false;
                },
                error : function () {
                    art_show_msg('连接失败',3);
                    return false;
                }
            });
        }else{
            art_show_msg('团号格式填写有误',3);
            return false;
        }
    }

    function check_confirm() {
        set_contract_back_time(); //自动填充合同收回时间
        let group_id    = $('input[name="info[group_id]"]').val().trim();
        let num_adult   = $('input[name="info[num_adult]"]').val().trim();
        let num_children= $('input[name="info[num_children]"]').val().trim();
        let dep_time    = $('input[name="info[dep_time]"]').val().trim();
        let ret_time    = $('input[name="info[ret_time]"]').val().trim();
        let days        = $('input[name="info[days]"]').val().trim();
        if (!group_id || !num_adult || !num_children || !dep_time || !ret_time || !days){
            art_show_msg('请填写完整信息',3);
        }else{
            $('#appsubmint').submit();
        }
    }

    //是否拼团
    function add_group_op(val) {
        let html = '<div class="userlist form-title" id="tcsaaaa_title">' +
            '<div class="unitbox" style="width:15%">员工姓名(模糊匹配)</div>' +
            '<div class="unitbox" style="width:15%">所属部门</div>' +
            '<div class="unitbox" style="width:15%">出团人数</div>' +
            '<div class="unitbox" style="width:20%">备注</div> </div>' +
            '<div id="group_val">1</div>';
        let html1 = '<div class="userlist no-border" id="group_con_1">'+
            '<span class="title"></span>'+
            '<input type="text"  class="form-control" style="width:15%" name="group[1][username]" id="name_1" value="{$op.create_user_name}">'+
            '<input type="hidden"  class="form-control" style="width:15%" name="group[1][userid]" id="uid_1" value="{$op.create_user}">'+
            '<select class="form-control" style="width:15%" name="group[1][code]">'+
            '<foreach name="businessDep" key="k" item="v"> <option value="{$k}">{$v}</option> </foreach> </select>'+
            '<input type="text"  class="form-control" style="width:15%" name="group[1][num]" value="">'+
            '<input type="text"  class="form-control" style="width:20%" name="group[1][remark]">'+
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(`group_con_1`)">删除</a>'+
            '</div>';
        if (val == 0){ //不拼团
            $('#add_group_box').hide();
            $('#addGroupContent').html(html);
        }else{ //拼团
            $('#addGroupContent').html(html+html1);
            $('#add_group_box').show();
            autocomplete_id('name_1','uid_1',keywords);
        }
    }

    //新增拼团信息
    function addGroup(){
        var i = parseInt($('#group_val').text())+1;
        var html = '<div class="userlist no-border" id="group_con_'+i+'">' +
            '<span class="title"></span> ' +
            '<input type="text"  class="form-control" style="width:15%" name="group['+i+'][username]" id="name_'+i+'" value="">'+
            '<input type="hidden"  class="form-control" style="width:15%" name="group['+i+'][userid]" id="uid_'+i+'" value="">'+
            '<select class="form-control" style="width:15%" name="group['+i+'][code]"> ' +
            '<foreach name="businessDep" key="k" item="v"> <option value="{$k}">{$v}</option> </foreach> </select>'+
            '<input type="text"  class="form-control" style="width:15%" name="group['+i+'][num]" value="">' +
            '<input type="text"  class="form-control" style="width:20%" name="group['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'group_con_'+i+'\')">删除</a></div>';
        $('#addGroupContent').append(html);
        $('#group_val').html(i);
        orderno();
        autocomplete_id('name_'+i,'uid_'+i,keywords);
    }

    //自动填充合同收回时间
    function set_contract_back_time() {
        let ret_time = $('input[name="info[ret_time]"]').val();
        if (ret_time){
            /*let time1 = new Date(ret_time);
            let day   = time1.getDate();
            let month = time1.getMonth()+1;
            let year  = time1.getFullYear();
            day       = (day < 10) ? '0'+day : day;
            if ( month === 12 ) {
                year += 1;
                month = '01';
            } else {
                month += 1;
                month = (month < 10) ? '0'+month : month;
            }

            let nextMonth = year +'-'+month+'-'+day;
            $('input[name="info[contract_back_time]"]').val(nextMonth)*/

            let time1 = new Date(ret_time);
            let seconds = 60*60*24*31*1000;
            let timestamp = time1.getTime();
            let newDate = timestamp+seconds;
            let str_time = format(newDate);
            $('input[name="info[contract_back_time]"]').val(str_time)
        }
    }

    function add0(m){
        return m<10?'0'+m:m
    }

    //时间戳转化为时间格式
    function format(intTime) {  //intTime是整数(毫秒)，否则要parseInt转换
        var time = new Date(intTime);
        var y = time.getFullYear();
        var m = time.getMonth()+1;
        var d = time.getDate();
        return y+'-'+add0(m)+'-'+add0(d);
    }

</script>
