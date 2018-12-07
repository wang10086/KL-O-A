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

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">借款信息</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php if($jiekuan){ ?>
                            <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="150" data="title">费用项</th>
                                        <th class="sorting" width="150" data="unitcost">单价</th>
                                        <th class="sorting" width="150" data="amount">数量</th>
                                        <th class="sorting" width="150" data="total">合计</th>
                                        <th class="sorting" width="150" data="yjk">可借金额</th>
                                        <th class="sorting" width="150" data="sjk">本次借款金额</th>
                                    </tr>
                                    <foreach name="jk_lists" item="row">
                                        <tr>
                                            <td>{$row.title}</td>
                                            <td>{$row.unitcost}</td>
                                            <td>{$row.amount}</td>
                                            <td>{$row.total}</td>
                                            <td>{$row.yjk}</td>
                                            <td <?php if ($row['sjk']>$row['yjk']){ echo "class='red'"; } ?>>{$row.sjk}</td>
                                        </tr>
                                    </foreach>
                                </table>
                            </div><!-- /.box-body -->

                            <div class="box-body" id="jiekuandan" >
                                <div class="row"><!-- right column -->
                                    <div class="form-group col-md-12">
                                        <div class="form-group col-md-12" style="align: center;">
                                            <table style="width: 100%; margin-top: 20px;">
                                                <tr>
                                                    <td class="td_title" colspan="6">
                                                        <div class="form-group col-md-12">
                                                            <h4><b>借款单</b></h4>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td_con" colspan="2" style="text-align: left; min-width:230px; ">借款单编号：{$jiekuan['jkd_id']}</td>
                                                    <td class="td_con" colspan="4" style="text-align: right;">
                                                        支付方式：
                                                        <foreach name="jk_type" key="k" item="v">
                                                            <input type="radio" name="type" value="{$k}" <?php if ($jiekuan['type']== $k) echo "checked"; ?> /> <?php if ($jiekuan['type']== $k) echo '√'; ?>{$v} &nbsp;
                                                        </foreach>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td class="td_con td" colspan="2">团号：{$op['group_id']}</td>
                                                    <td class="td_con td" colspan="3">项目名称：{$op['project']}</td>
                                                    <td class="td_con td">借款时间：{$jiekuan['jk_time']|date='Y 年 m 月 d 日',###}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" class="td_con td">用途说明</td>
                                                    <td colspan="4" class="td_con td">
                                                        <div class="form-group col-md-12">
                                                            <textarea class="form-control no-border-textarea" readonly>{$jiekuan.description}</textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="td_con td">借款金额</td>
                                                    <td colspan="3" class="td_con td">{$jiekuan.sum_chinese}</td>
                                                    <td class="td_con td">&yen;&emsp;<input type="text" style="border:none;border-bottom: solid 1px #808080; " value="{$jiekuan.sum}">元</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="td_con td">受款单位：{$jiekuan.payee}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="td_con td">开户行名称：{$jiekuan.bank_name}</td>
                                                    <td colspan="2" class="td_con td">账号：{$jiekuan.card_num}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" class="td_con td">借款单位：{$jiekuan.department}</td>
                                                    <td colspan="2" class="td_con td">借款人签字：<img src="/{$jiekuan.jk_file}" height="50px" alt=""></td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" class="td_con td">预算审批人签字：<span id="ysspr"> <?php if($jiekuan['ys_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($jiekuan['ys_audit_status']==1){ echo "<img src='/$jiekuan[ys_audit_file]' height='50px'>";}; ?></span></td>
                                                    <td colspan="2" class="td_con td">财务主管签字：<span id="cwzg"><?php if($jiekuan['cw_audit_status']==2){echo "<span class='red'>不通过</span>"; }elseif ($jiekuan['cw_audit_status']==1){ echo "<img src='/$jiekuan[cw_audit_file]' height='50px'>";}; ?></span></td>
                                                </tr>
                                                <tr id="print_time">
                                                    <td class="td_con" colspan="6" style="text-align: right; ">打印时间：<?php echo date('Y-m-d H:i:s',time()); ?></td>
                                                </tr>

                                            </table>
                                        </div>
                                        <if condition="rolemenu(array('Finance/print_jkd'))">
                                            <div class="content no-print">
                                                <button class="btn btn-default" onclick="show_print_time(),print_view('jiekuandan');"><i class="fa fa-print"></i> 打印</button>
                                            </div>
                                        </if>
                                    </div>
                                </div><!--/.col (right) -->
                            </div>

                        <?php }else{ ?>
                            <div class="content" style="padding-top:40px;">  获取借款信息失败!</div>
                        <?php } ?>
                    </div>
                </div>

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->

</div>
</div>

<include file="Index:footer2" />

<script>
    $(function () {
        $('#print_time').hide();
    })
    
    function show_print_time() {
        $('#print_time').show();
    }
</script>



