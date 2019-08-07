
    <?php if($audit_yusuan && $costacc){ ?>
    <form method="post" action="{:U('Finance/public_save')}" name="jiekuanform" id="jiekuanform" onsubmit="return submitBefore()" >
        <div class="content" style="padding-top:0px;">
            <table class="table table-striped" id="font-14-p">
                <thead>
                    <tr>
                        <th width="">费用项</th>
                        <th width="">单价</th>
                        <th width="">数量</th>
                        <th width="">合计</th>
                        <th width="">已借金额</th>
                        <th width="">可借金额</th>
                        <th width="">备注</th>
                        <th width="">借款金额</th>
                        <th width="">借款</th>
                    </tr>
                </thead>
                <tbody>
                    <foreach name="costacc" key="k" item="v">
                    <tr class="userlist" id="supplier_id_103">
                        <td width="12%">{$v.title}</td>
                        <td width="10%">&yen; {$v.unitcost}</td>
                        <td width="10%">{$v.amount}</td>
                        <td width="10%">{$v.ctotal}</td>
                        <td width="10%">{$v.sjk}</td>
                        <td width="10%">&yen; {$v.total}</td>
                        <td>{$v.remark}</td>
                        <td width="16%" id="jk_{$v.id}"></td>
                        <td width="80" id="td_{$v.id}">
                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="add_jiekuan({$v.id},{$v.total})">借款</a>
                            <input type="hidden" name="id" value="{$v.id}">
                            <input type="hidden" name="total" value="{$v.total}" id="total_{$v.id}">
                        </td>
                    </tr>
                    </foreach>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-size:16px; color:#ff3300;">&yen; {$budget.budget}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="content">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="savetype" value="2">
            <input type="hidden" name="info[op_id]" value="{$op.op_id}" />
            <input type="hidden" name="info[costacc_ids]" id="ids">
            <input type="hidden" id="qianzi" value="0">
            <input type="hidden" name="info[yingjiekuan]" id="jk_sum">
            <input type="hidden" name="info[department]" id="department">
            <div style="width:100%; float:left;">

                <div class="form-group col-md-6">
                    <label>借款部门：</label>
                    <select class="form-control" name="info[department_id]" onchange="get_department()" id="department_id" required >
                        <option value="">--请选择--</option>
                        <foreach name="departments" item="v">
                            <option value="{$v.id}">{$v.department}</option>
                        </foreach>
                    </select>
                    <!--<input type="text" name="info[department]" class="form-control" value="<?php /*echo $list['rolename']?$list['rolename']:session('rolename'); */?>" readonly />-->
                </div>

                <div class="form-group col-md-6">
                    <label>团号：</label>
                    <input type="text" name="info[group_id]" class="form-control" value="<?php echo $list['group_id']?$list['group_id']:$op['group_id']; ?>" readonly />
                    <input type="hidden" name="info[op_id]" value="<?php echo $list['op_id']?$list['op_id']:$op['op_id']; ?>" />
                </div>

                <div class="form-group col-md-6">
                    <label>借款金额：</label>
                    <input type="text" name="info[sum]" id="jiekuanjine" class="form-control" value="{$list.sum}" onblur="todaxie($(this).val())" readonly />
                </div>

                <div class="form-group col-md-6">
                    <label>人民币(大写)：</label>
                    <input type="text" name="info[sum_chinese]" id="daxie" class="form-control" value="{$list.sum_chinese}" readonly />
                </div>

                <div class="form-group col-md-6" id="jk_type">
                    <label>支付方式：</label>
                    <div class="form-control" style="border: none;">
                        <foreach name="jk_type" key="k" item="v">
                            <input type="radio" name="type" value="{$k}" <?php if ($list['type']== $k) echo "checked"; ?> /> &nbsp;{$v} &emsp;&emsp;
                        </foreach>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label>账单分类：</label>
                    <select class="form-control" name="info[company]" id="company" >
                        <option value="">==请选择==</option>
                        <foreach name="company" key="k" item="v">
                            <option value="{$k}" <?php if ($list['company']==$k) echo 'selected'; ?>>{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <label>用途说明：</label>
                    <textarea class="form-control"  name="info[description]">{$list.description}</textarea>
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
                    <label>借款人：</label>
                    <input type="button" onclick="show_qianzi()" class="info-button" value="签字">
                </div>

            </div>
        </div>
        <div style="width:100%; text-align:center;">
            <!--<a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('design','<?php /*echo U('Op/public_save'); */?>');">保存</a>-->
            <input type="submit" class="btn btn-info btn-lg" value="提交">
        </div>
    </form>

    <?php }else{ ?>
            <div class="content" style="margin-left:15px;">该项目尚未做预算！</div>
    <?php }  ?>

    <script>
        $(function () {
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

        function add_jiekuan(id,total) {
            var jkhtml    = '';
            var qxhtml    = '';
                jkhtml += '<input type="text" id="sjk_'+id+'" style="width: 10em;" value="'+total+'" onblur="check_total($(`#yjk_'+id+'`).val(),$(this).val(),'+id+')">'+
                '<input type="hidden" value="'+total+'" id="yjk_'+id+'">'+
                '<input type="hidden" name="data[8888'+id+'][costacc_id]" value="'+id+'">'+
                '<input type="hidden" name="data[8888'+id+'][yjk]" value="'+total+'">'+
                '<input type="hidden" name="data[8888'+id+'][sjk]" value="'+total+'" id="data_sjk_'+id+'">';
                qxhtml += '<a href="javascript:;" class="btn btn-sm" onclick="del_jiekuan('+id+','+total+')">取消</a>'+
                    '<input type="hidden" name="id" value="'+id+'">'+
                    '<input type="hidden" name="total" value="'+total+'" id="total_'+id+'">';
            $('#jk_'+id).html(jkhtml);
            $('#td_'+id).html(qxhtml);

            var arr_ids         = $('#ids').val();
            var aid             = '['+id+'],';
            arr_ids             += aid;
            $('#ids').val(arr_ids);

            //应借款
            var yingjiekuan     = $('#jk_sum').val();
            var yjk             = accAdd(yingjiekuan,total);
            $('#jk_sum').val(yjk);

            check_total(0,total);
        }

        function del_jiekuan(id,total){

            var arr_ids         = $('#ids').val();
            var aid             = '['+id+'],';
            var aaa             = arr_ids.replace(aid,'');
            $('#ids').val(aaa);

            //应借款
            var yingjiekuan     = $('#jk_sum').val();
            var yjk             = accSub(yingjiekuan,total);
            $('#jk_sum').val(yjk);

            //上次修改后的借款金额
            var upd_jk             = $('#yjk_'+id).val();
            check_total(upd_jk,0);

            var jkhtml    = '';
            jkhtml  += '<a href="javascript:;" class="btn btn-info btn-sm" onclick="add_jiekuan('+id+','+total+')">借款</a>'+
                '<input type="hidden" name="id" value="'+id+'">'+
                '<input type="hidden" name="total" value="'+total+'" id="total_'+id+'">';
            $('#jk_'+id).html('');
            $('#td_'+id).html(jkhtml);
        }

        function check_total(yjk,sjk=0,id=0){
            var jiekuanjine     = $('#jiekuanjine').val();
            var sum1            = accSub(jiekuanjine,yjk);  //数据相减
            var sum             = accAdd(sum1,sjk);  //数据相加
            $('#jiekuanjine').val(sum);
            todaxie(sum);       //转换为大写

            if (id != 0){
                $('#yjk_'+id).val(sjk);
                $('#data_sjk_'+id).val(sjk);
            }
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
            html += '<label>借款人：</label>'+
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
                        html += '<label>借款人：</label>'+
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
            var isqianzi = $('#qianzi').val();
            var company  = $('#company').val();
            if (!company){
                art_show_msg('请选择账单分类');
                return false;
            }
            if (isqianzi == 1){
                $('#jiekuanform').submit();
            }else{
                art_show_msg('请完善借款信息');
                return false;
            }
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

        /*function qianzi() {
            art.dialog.open("<?php echo U('Finance/sign_jk',array('opid'=>$op['op_id'])); ?>",{
                lock:true,
                title: '借款人签字',
                width:600,
                height:300,
                okValue: '提交',
                fixed: true,
                ok: function () {
                    this.iframe.contentWindow.gosubmint();
                    return false;
                },
                cancelValue:'取消',
                cancel: function () {
                }
            });
        }*/

    </script>
