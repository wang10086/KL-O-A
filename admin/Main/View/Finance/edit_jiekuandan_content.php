<div class="box-body">
    <form method="post" action="<?php echo U('Finance/public_save'); ?>" id="save_loan" onsubmit="return submitBefore()">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="savetype" value="19">
        <input type="hidden" name="jkid" value="{$jkid}">
        <input type="hidden" name="info[department]" value="{$jiekuandan.department}" id="department">
        <input type="hidden" name="jkd_id" value="{$jiekuandan.jkd_id}">

        <div class="content">
            <input type="hidden" id="qianzi" value="0">
            <div style="width:100%; float:left;">

                <div class="form-group col-md-12">
                    <label>借款部门：</label>
                    <select class="form-control" name="info[department_id]" onchange="get_department()" id="department_id" required >
                        <option value="">--请选择--</option>
                        <foreach name="departments" item="v">
                            <option value="{$v.id}" <?php if($jiekuandan['department_id']==$v['id']){ echo "selected";} ?>>{$v.department}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>借款金额：</label>
                    <input type="text" name="info[sum]" id="baoxiaojine" class="form-control" value="{$jiekuandan.sum}" onblur="todaxie($(this).val())" />
                </div>

                <div class="form-group col-md-6">
                    <label>人民币(大写)：</label>
                    <input type="text" name="info[sum_chinese]" id="daxie" class="form-control" value="{$jiekuandan.sum_chinese}" readonly />
                </div>

                <div class="form-group col-md-6" id="jk_type">
                    <label>支付方式：</label>
                    <div class="form-control" style="border: none;">
                        <foreach name="jk_type" key="k" item="v">
                            <input type="radio" name="type" value="{$k}" <?php if ($jiekuandan['type']== $k) echo "checked"; ?> /> &nbsp;{$v} &emsp;&emsp;
                        </foreach>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>账单分类：</label>
                    <select class="form-control" name="info[company]" id="company" >
                        <option value="">==请选择==</option>
                        <foreach name="company" key="k" item="v">
                            <option value="{$k}" <?php if ($jiekuandan['company']==$k) echo 'selected'; ?>>{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label>用途说明：</label>
                    <textarea class="form-control"  name="info[description]">{$jiekuandan.description}</textarea>
                </div>
                <div class="form-group col-md-12 zp_show hk_show">
                    <label>受款单位：</label>
                    <input type="text" name="info[payee]" class="form-control zhipiao huikuan" value="{$jiekuandan.payee}">
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>开户行名称：</label>
                    <input type="text" name="info[bank_name]" class="form-control huikuan" value="{$jiekuandan.bank_name}">
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>账号：</label>
                    <input type="text" name="info[card_num]" class="form-control huikuan" value="{$jiekuandan.card_num}">
                </div>

                <div class="form-group col-md-6" id="jkr_qianzi">
                    <label>更改人：</label>
                    <input type="button" onclick="show_qianzi()" class="info-button" value="签字">
                </div>

            </div>
        </div>
        <div style="width:100%; text-align:center;">
            <input type="submit" class="btn btn-info btn-lg" value="提交">
        </div>
    </form> 
</div>

<script>
    $(function () {
        /*$('.hk_show').hide();*/
        //修改
        var edit_type       = <?php echo $jiekuandan['type']?$jiekuandan['type']:0 ?>;
        if (edit_type ==1){ //支票
            $('.huikuan').removeAttr('required');
            $('.hk_show').hide();
            $('.zp_show').show();
            $('.zhipiao').attr('required','true');
        }else if(edit_type == 3){ //汇款
            $('.hk_show').show();
            $('.huikuan').attr('required','true');
        }else{
            $('.huikuan').removeAttr('required');
            $('.hk_show').hide();
        }

        $('#jk_type').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var type = $(this).prev('input').val();

                if(type ==1){ //支票
                    $('.huikuan').removeAttr('required');
                    $('.hk_show').hide();
                    $('.zp_show').show();
                    $('.zhipiao').attr('required','true');
                }else if(type == 3){ //汇款
                    $('.hk_show').show();
                    $('.huikuan').attr('required','true');
                }else{
                    $('.huikuan').removeAttr('required');
                    $('.hk_show').hide();
                }
            })
        })
    })

    function get_department(){
        var departid        = $('#department_id').val();
        $.ajax({
            type: "POST",
            url : "{:U('Ajax/get_department')}",
            dataType : "JSON",
            data : {department_id:departid},
            success : function (msg) {
                $('#department').val(msg);
            }
        })
    }

    function todaxie(num) {
        $.ajax({
            type: "post",
            url: "<?php echo U('Ajax/numTrmb'); ?>",
            dataType:'json',
            data: {num:num},
            success:function(data){
                if(data){
                    $('#daxie').val(data);
                }
            }
        });
    }

    function show_qianzi() {
        var html = '';
        html += '<label>更改人：</label>'+
            '<input type="password" name="password" style="width:160px;height: 30px;" placeholder="请输入签字密码"  />&emsp;'+
            '<input type="button" class="info-button" value="确定" onclick="check_pwd()">';
        $('#jkr_qianzi').html(html);
    }

    function check_pwd() {
        var pwd = $('input[name="password"]').val();
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/check_pwd')}",
            data: {pwd:pwd},
            success:function (msg) {
                if (msg.stu ==1){
                    var html = '';
                    html += '<label>更改人：</label>'+
                        /*'<input type="hidden" name="info[jk_file]" value="'+msg.file_url+'">'+*/
                        '<input type="hidden" value="'+msg.file_url+'">'+
                        '<img width="100" src="/'+msg.file_url+'" alt="">';
                    $('#jkr_qianzi').html(html);
                    $('#qianzi').val('1');
                }else{
                    art_show_msg(msg.message);
                    return false;
                }
            }
        })
    }

    function submitBefore() {
        var isqianzi = $('#qianzi').val();
        if (isqianzi == 1){
            $('#jiekuanform').submit();
        }else{
            art_show_msg('请完善签字信息');
            return false;
        }
    }

    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width:300,
            height:120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    };


    //保存信息
    function save(id,url){
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                if(parseInt(data)>0){
                    art.dialog.alert('保存成功','success');
                }else{
                    art.dialog.alert('保存失败','warning');
                }
            }
        });

        setTimeout("history.go(0)",1000);
    }

</script>