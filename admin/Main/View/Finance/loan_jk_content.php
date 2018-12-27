
    <form method="post" action="{:U('Finance/public_save')}" name="jiekuanform" id="jiekuanform" onsubmit="return submitBefore()" >
        <div class="content" id="departmentlist" style="display:block; display: none">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="20%">部门名称</th>
                    <th width="10%">分摊金额</th>
                    <th width="25%">备注</th>
                    <th width="80">删除</th>
                </tr>
                </thead>
                <tbody>
                <foreach name="supplier" item="v">
                    <!--<tr class="expense" id="share_{$v.sid}">
                        <td style="vertical-align:middle">
                            <input type="hidden" name="share[30000{$v.id}][department]" value="'+departments[j].department+'">;
                            {$v.department}
                        </td>
                        <td>
                            <input type="hidden" id="ftje_30000{$v.id}">
                            <input type="text" name="share[30000{$v.id}][depart_sum]" onblur="check_total(30000{$v.id},$(`#ftje_'+30000{$v.id}+'`).val(),$(this).val())" placeholder="分摊金额" value="0.00" class="form-control" />
                        </td>
                        <td>
                            <input type="text" name="share[30000{$v.id}][remark]" value="" class="form-control" />
                        </td>
                        <td>
                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'share_'+30000{$v.id}+'\','+30000{$v.id}+',$(`#ftje_'+30000{$v.id}+'`).val())">删除</a>
                        </td>
                    </tr>;-->
                </foreach>
                <tr id="shareTotal">
                    <td></td>
                    <td style="font-size:16px; color:#ff3300;">合计: <span id="shareSum">0.00</span></td>
                    <td></td>
                    <td></td>
                </tr>

                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>

        <div class="content mt20">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="savetype" value="13">
            <input type="hidden" name="bxd_type" value="2"><!--非团借款报销-->
            <input type="hidden" name="yingbaoxiao" value="{$list.sum}">
            <input type="hidden" id="qianzi" value="0">
            <input type="hidden" name="info[department]" id="department" value="{$list.department}">
            <input type="hidden" name="zmysr_id" id="zmysr_id">
            <div style="width:100%; float:left;">
                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-4">
                    <label>借款单号：</label>
                    <input type="text" name="jkd_id" class="form-control" value="{$list.jkd_id}" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>报销单位：</label>
                    <select class="form-control" name="info[department_id]" onchange="get_department()" id="department_id" required>
                        <foreach name="departments" item="v">
                            <option value="{$v.id}" <?php if ($list['department_id']==$v['id']) echo 'selected'; ?>>{$v.department}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-4">
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

                <div class="form-group col-md-6" id="jk_type">
                    <label>支付方式：</label>
                    <div class="form-control" style="border: none;">
                        <foreach name="jk_type" key="k" item="v">
                            <input type="radio" name="type" value="{$k}" /> &nbsp;{$v} &emsp;&emsp;
                        </foreach>
                    </div>
                </div>

                <div class="form-group col-md-6" id="share">
                    <p><label>是否分摊至各部门(如房租、电话费、网费等)：</label></p>
                    <input type="radio" name="info[share]" value="1"> &emsp;分摊 &emsp;&emsp;&emsp;
                    <input type="radio" name="info[share]" value="0" checked> &emsp;不分摊
                </div>

                <div class="form-group col-md-12">
                    <label>用途说明：</label>
                    <textarea class="form-control"  name="info[description]"></textarea>
                </div>
                <div class="form-group col-md-12 zp_show hk_show">
                    <label>受款单位：</label>
                    <input type="text" name="info[payee]" class="form-control zhipiao huikuan" >
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>开户行名称：</label>
                    <input type="text" name="info[bank_name]" class="form-control huikuan" >
                </div>

                <div class="form-group col-md-6 hk_show">
                    <label>账号：</label>
                    <input type="text" name="info[card_num]" class="form-control huikuan" >
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

            $('#share').find('ins').each(function (index,ele) {
                $(this).click(function () {
                    let share = $(this).prev('input').val();
                    if (share ==1){ //分享
                        selectDepartment();
                    }else{
                        $('#departmentlist').hide();
                    }
                })
            })
        })

        function check_total(a,oldje=0,newje=0){
            var ftje     = $('#shareSum').html();
            var sum1     = accSub(ftje,oldje);        //数据相减
            var sum      = accAdd(sum1,newje);        //数据相加
            $('#shareSum').html(sum);
            $('#ftje_'+a).val(newje);
        }

        //选择部门
        function selectDepartment() {
            $('#departmentlist').show();
            art.dialog.open('<?php echo U('Finance/select_department'); ?>',{
                lock:true,
                title: '选择分摊部门',
                width:800,
                height:400,
                okValue: '提交',
                fixed: true,
                ok: function () {
                    var origin = artDialog.open.origin;
                    var departments = this.iframe.contentWindow.gosubmint();
                    var share_html = '';
                    for (var j = 0; j < departments.length; j++) {
                        if (departments[j].department) {
                            var i = parseInt(Math.random()*100000)+j;
                            var aaa = '<input type="hidden" name="share['+i+'][department]" value="'+departments[j].department+'">';
                            share_html += '<tr class="expense" id="share_'+i+'"><td style="vertical-align:middle">'+aaa+departments[j].department+'</td><td><input type="hidden" id="ftje_'+i+'"><input type="text" name="share['+i+'][depart_sum]" onblur="check_total('+i+',$(`#ftje_'+i+'`).val(),$(this).val())" placeholder="分摊金额" value="0.00" class="form-control" /></td><td><input type="text" name="share['+i+'][remark]" value="" class="form-control" /></td><td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'share_'+i+'\','+i+',$(`#ftje_'+i+'`).val())">删除</a></td></tr>';
                        };
                    }
                    $('#departmentlist').show();
                    $('#nonetext').hide();
                    $('#departmentlist').find('#shareTotal').before(share_html);
                },
                cancelValue:'取消',
                cancel: function () {
                }
            });
        }

        //移除
        function delbox(obj,i,oldje=0,newje=0){
            $('#'+obj).remove();
            check_total(1,oldje,newje)
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
                        html += '<label>借款人：</label>'+
                            '<input type="hidden" name="info[bx_file]" value="'+msg.file_url+'">'+
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
            let sbxje    = $('#jiekuanjine').val();
            let sftje    = $('#shareSum').html();
            let bxje     = parseFloat(sbxje);
            let ftje     = parseFloat(sftje);
            let isShare  = $('#share').find('div[class="iradio_minimal checked"]').find('input[name="info[share]"]').val()
            if (isShare==1 && bxje != ftje){
                art_show_msg('报销金额和分摊金额不相等');
                return false;
            }
            if (!zmysr){
                art_show_msg('请填写证明验收人');
                return false;
            }
            if (isqianzi == 1 && zmysr){
                $('#jiekuanform').submit();
            }else{
                art_show_msg('请完善报销信息');
                return false;
            }
        }

    </script>
