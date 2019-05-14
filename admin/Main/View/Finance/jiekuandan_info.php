<include file="Index:header2" />

<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>借款单详情</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Finance/jiekuan_lists')}"><i class="fa fa-gift"></i> 借款单管理</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="box box-warning" style="margin-top:15px;">
                    <div class="box-header">
                        <h3 class="box-title">
                            <php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php>
                        </h3>
                        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="content">
                            <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="3">项目名称：{$op.project}</td>
                                </tr>
                                <tr>
                                    <td width="33.33%">项目类型：<?php echo $kinds[$op['kind']]; ?></td>
                                    <td width="33.33%">预计人数：{$op.number}人</td>
                                    <td width="33.33%">预计出团日期：{$op.departure}</td>
                                </tr>
                                <tr>
                                    <td width="33.33%">预计行程天数：{$op.days}天</td>
                                    <td width="33.33%">目的地：{$op.destination}</td>
                                    <td width="33.33%">立项时间：{$op.op_create_date}</td>
                                </tr>
                            </table>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-warning" style="margin-top:15px;">
                    <div class="box-header">
                        <h3 class="box-title">借款单详情</h3>
                    </div><!-- /.box-header -->
                    <include file="jiekuandan" />
                </div><!-- /.box -->


                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">项目操作记录</h3>
                    </div>
                    <div class="box-body">
                        <div class="content" style="padding:10px 30px;">
                            <table rules="none" border="0">
                                <tr>
                                    <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="160">操作时间</th>
                                    <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="100">操作人</th>
                                    <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="500">操作说明</th>
                                </tr>
                                <foreach name="record" item="v">
                                    <tr>
                                        <td style="padding:20px 0 0 0">{$v.time|date='Y-m-d H:i:s',###}</td>
                                        <td style="padding:20px 0 0 0">{$v.uname}</td>
                                        <td style="padding:20px 0 0 0">{$v.explain}</td>
                                    </tr>
                                </foreach>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->

</div>
</div>

<include file="Index:footer2" />

<!--<script>
    $(function () {
        $('#print_time').hide();
    })
    
    function show_print_time() {
        $('#print_time').show();
    }

    function show_qianzi() {
        var html = '';
        html += '<label>签字：</label>'+
            '<input type="password" name="password" class="" placeholder="请输入签字密码"  />&emsp;'+
            '<input type="button" value="确定" onclick="check_pwd()">';
        $('#shr_qianzi').html(html);
    }

    function check_pwd() {
        var pwd = $('input[name="password"]').val();
        var audit_usertype = '<?php /*echo "$audit_usertype"; */?>';
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/check_pwd')}",
            data: {pwd:pwd},
            success:function (msg) {
                if (msg.stu ==1){
                    var html = '';
                    if (audit_usertype ==1 ){
                        html += '<label>预算审核人签字：</label>'+
                            '<input type="hidden" name="info[ys_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }else if(audit_usertype ==2){
                        html += '<label>财务主管签字：</label>'+
                            '<input type="hidden" name="info[cw_audit_file]" value="'+msg.file_url+'">'+
                            '<img width="100" src="/'+msg.file_url+'" alt="">';
                    }
                    $('#shr_qianzi').html(html);
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
            art_show_msg('请完善审核信息');
            return false;
        }
    }
</script>-->



