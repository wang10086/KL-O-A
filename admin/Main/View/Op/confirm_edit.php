<form method="post" action="{:U('Op/confirm')}" name="myform" id="appsubmint">
<input type="hidden" name="dosubmit" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="id" value="{$confirm.id}">
<div class="content" style="padding-bottom:20px;">
	
    <div style="width:100%; float:left;">
        <div class="form-group col-md-4">
            <label>项目团号：</label>
            <input type="text" name="info[group_id]"  class="form-control" onblur="check_group_id()" value="<?php if($confirm['group_id']){ echo $confirm['group_id'];}else{ echo $op['group_id'];} ?>" required />
        </div>
        
        <div class="form-group col-md-4">
            <label>实际出团成人数：</label>
            <input type="text" name="info[num_adult]" class="form-control" value="{$confirm.num_adult}" required />
        </div>
        <div class="form-group col-md-4">
            <label>实际出团儿童数：</label>
            <input type="text" name="info[num_children]" class="form-control" value="{$confirm.num_children}"required />
        </div>
    </div>
    <div style="width:100%;float:left;">
        <div class="form-group col-md-4">
            <label>实际出发时间：</label>
            <input type="text" name="info[dep_time]" class="form-control inputdate" value="<if condition="$confirm['dep_time']">{$confirm.dep_time|date='Y-m-d',###}</if>" required />
        </div>
        <div class="form-group col-md-4">
            <label>实际返回时间：</label>
            <input type="text" name="info[ret_time]" class="form-control inputdate" value="<if condition="$confirm['ret_time']">{$confirm.ret_time|date='Y-m-d',###}</if>" required />
        </div>
        
        <div class="form-group col-md-4">
            <label>实际天数：</label>
            <input type="text" name="info[days]"  class="form-control" value="{$confirm.days}" required />
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

<script>
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
                    if (data.num == '-1'){
                        art_show_msg(data.msg);
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
</script>
    