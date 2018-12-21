
    <form method="post" action="{:U('Finance/public_save')}" name="jiekuanform" id="jiekuanform" onsubmit="return submitBefore()" >

        <div class="content">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="savetype" value="13">
            <input type="hidden" id="qianzi" value="0">
            <input type="hidden" name="info[department]" id="department">
            <input type="hidden" name="zmysr_id" id="zmysr_id">
            <div style="width:100%; float:left;">

                <div class="form-group col-md-6">
                    <label>报销单位：</label>
                    <select class="form-control" name="info[department_id]" onchange="get_department()" id="department_id" required>
                        <option value="">==请选择==</option>
                        <foreach name="departments" item="v">
                            <option value="{$v.id}">{$v.department}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label>证明验收人：<font color="#999999">（可通过姓名拼音快速检索）</font></label>
                    <input type="text" name="zmysr_name" class="form-control zmysr_name" value="{$list.zmysr}" required />
                </div>

                <div class="form-group col-md-6">
                    <label>报销金额：</label>
                    <input type="text" name="info[sum]" id="jiekuanjine" class="form-control" value="{$list.sum}" onblur="todaxie($(this).val())" />
                </div>

                <div class="form-group col-md-6">
                    <label>人民币(大写)：</label>
                    <input type="text" name="info[sum_chinese]" id="daxie" class="form-control" value="{$list.sum_chinese}" />
                </div>

                <div class="form-group col-md-12" id="jk_type">
                    <label>支付方式：</label>
                    <foreach name="jk_type" key="k" item="v">
                        <input type="radio" name="type" value="{$k}" /> &nbsp;{$v} &emsp;&emsp;
                    </foreach>
                </div>

                <div class="form-group col-md-12">
                    <label>用途说明：</label>
                    <textarea class="form-control"  name="info[description]"></textarea>
                </div>
                <div class="form-group col-md-12 zp_show hk_show">
                    <label>受款单位：</label>
                    <input type="text" name="info[payee]" class="form-control zhipiao huikuan" value="{$list.payee}">
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>开户行名称：</label>
                    <input type="text" name="info[bank_name]" class="form-control huikuan" value="{$list.bank_name}">
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>账号：</label>
                    <input type="text" name="info[card_num]" class="form-control huikuan" value="{$list.card_num}">
                </div>

                <div class="form-group col-md-6" id="jkr_qianzi">
                    <label>报销人：</label>
                    <input type="button" onclick="show_qianzi()" class="info-button" value="签字">
                </div>

            </div>
        </div>
        <div style="width:100%; text-align:center;">
            <input type="submit" class="btn btn-info btn-lg" value="提交">
        </div>
    </form>

    <script>

        $(function () {
            var keywords = <?php echo $userkey; ?>;
            getUserKeyWords('zmysr_name','zmysr_id',keywords);

            $('.hk_show').hide();
            $('.jkje').hide();
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
            html += '<label>报销人：</label>'+
                '<input type="text" name="password" style="width:160px;height: 30px;" placeholder="请输入签字密码"  />&emsp;'+
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
                        html += '<label>报销人：</label>'+
                            '<input type="hidden" name="info[jk_file]" value="'+msg.file_url+'">'+
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
            let isqianzi = $('#qianzi').val();
            let zmysr    = $('#zmysr_id').val();
            if (!zmysr){
                art_show_msg('请填写证明验收人');
                return false;
            }
            if (isqianzi == 1){
                $('#jiekuanform').submit();
            }else{
                art_show_msg('请完善报销信息');
                return false;
            }
        }
    </script>
