<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目回款</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <include file="Op:op_navigate" />
                             
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header">
                                    <h3 class="box-title">
                                    <php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="form-group">
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
                                            <?php if($settlement['audit_status']==1){ ?>
                                            <tr>
                                                <td width="33.33%">实际人数：{$settlement.renshu}</td>
                                                <td width="33.33%">实际收入：{$settlement.shouru}</td>
                                                <td width="33.33%">合同签订：<?php if($settlement['hetong']){ echo '已签订';}else{ echo '未签订';} ?></td>
                                            </tr>
                                            <tr>
                                                <td width="33.33%">毛利：{$settlement.maoli}</td>
                                                <td width="33.33%">毛利率：{$settlement.maolilv}</td>
                                                <td width="33.33%">人均毛利：{$settlement.renjunmaoli}</td>
                                            </tr>
                                            
                                            <?php } ?>
                                            <if condition="$payment">
                                            <tr>
                                                <td width="33.33%" colspan="3">总计回款：{$payment}</td>
                                            </tr>
                                            </if>
                                        </table>
                                        </div>
                                        <?php if (in_array(cookie('userid'),array(1,11,55,$budget_audit_uid))){ ?> <!--乔总+财务+预算审核人-->
                                            <form action="{:U('Finance/public_save')}" method="post">
                                                <input type="hidden" name="savetype" value="20">
                                                <input type="hidden" name="dosubmint" value="1">
                                                <input type="hidden" name="opid" value="{$op.op_id}">
                                                <input type="hidden" name="old_sum" value="{$should_back_money}">
                                                <div class="content" style="padding-top:0px;">
                                                    <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;"> <span class="black">回款计划</span> (应回款总金额:<span id="sum_money_return">{$should_back_money}</span>元)</h2>
                                                    <div class="callout callout-danger">
                                                        <h4>提示！一般情况应做到：</h4>
                                                        <p>1、在业务实施前回款不小于70%；</p>
                                                        <p>2、在业务实施结束后10个工作日收回全部尾款；</p>
                                                    </div>
                                                    <div class="form-group col-md-12" id="payment">
                                                        <div class="userlist">
                                                            <div class="unitbox_15">回款金额(元)</div>
                                                            <div class="unitbox_15">回款比例(%)</div>
                                                            <div class="unitbox_15">计划回款时间</div>
                                                            <div class="unitbox_15">收款方</div>
                                                            <div class="unitbox_15">回款方式</div>
                                                            <div class="unitbox_25">备注</div>
                                                        </div>
                                                        <?php if($pays){ ?>
                                                            <foreach name="pays" key="kk" item="pp">
                                                                <div class="userlist" id="pretium_8888{$pp.id}">
                                                                    <span class="title"><?php echo $kk+1; ?></span>
                                                                    <input type="hidden" name="payment[8888{$pp.id}][no]" class="payno"  value="{$pp.no}">
                                                                    <input type="hidden" class="form-control" name="payment[8888{$pp.id}][pid]" value="{$pp.id}">
                                                                    <div class="f_15">
                                                                        <input type="text" class="form-control" name="payment[8888{$pp.id}][amount]" onblur="check_ratio('8888'+{$pp.id},$(this).val())" value="{$pp.amount}">
                                                                    </div>
                                                                    <div class="f_15">
                                                                        <input type="text" class="form-control" name="payment[8888{$pp.id}][ratio]" value="{$pp.ratio}">
                                                                    </div>
                                                                    <div class="f_15">
                                                                        <input type="text" class="form-control inputdate"  name="payment[8888{$pp.id}][return_time]" value="<if condition="$pp['return_time']">{$pp.return_time|date='Y-m-d',###}</if>">
                                                                    </div>
                                                                    <div class="f_15">
                                                                        <select class="form-control" name="payment[8888{$pp.id}][company]" >
                                                                            <foreach name="company" key="k" item="v">
                                                                                <option value="{$k}" <?php if ($pp['company']==$k) echo 'selected'; ?>>{$v}</option>
                                                                            </foreach>
                                                                        </select>
                                                                    </div>
                                                                    <div class="f_15">
                                                                        <select class="form-control" name="payment[8888{$pp.id}][type]" >
                                                                            <foreach name="type" key="k" item="v">
                                                                                <option value="{$k}" <?php if ($pp['type']==$k) echo "selected"; ?>>{$v}</option>
                                                                            </foreach>
                                                                        </select>
                                                                    </div>
                                                                    <div class="f_25">
                                                                        <input type="text" class="form-control" name="payment[8888{$pp.id}][remarks]" value="{$pp.remark}">
                                                                    </div>

                                                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_8888{$pp.id}')">删除</a>
                                                                </div>
                                                            </foreach>
                                                        <?php }else{ ?>
                                                            <div class="userlist" id="pretium_id">
                                                                <span class="title">1</span>
                                                                <input type="hidden" name="payment[1][no]" class="payno" value="1">
                                                                <div class="f_15">
                                                                    <input type="text" class="form-control" name="payment[1][amount]" onblur="check_ratio($(this).parent('div').prev().val(),$(this).val())" value="">
                                                                </div>
                                                                <div class="f_15">
                                                                    <input type="text" class="form-control" name="payment[1][ratio]" value="">
                                                                </div>
                                                                <div class="f_15">
                                                                    <input type="text" class="form-control inputdate"  name="payment[1][return_time]" value="">
                                                                </div>
                                                                <div class="f_15">
                                                                    <select class="form-control" name="payment[1][company]">
                                                                        <foreach name="company" key="k" item="v">
                                                                            <option value="{$k}">{$v}</option>
                                                                        </foreach>
                                                                    </select>
                                                                </div>
                                                                <div class="f_15">
                                                                    <select class="form-control" name="payment[1][type]">
                                                                        <foreach name="type" key="k" item="v">
                                                                            <option value="{$k}">{$v}</option>
                                                                        </foreach>
                                                                    </select>
                                                                </div>
                                                                <div class="f_25">
                                                                    <input type="text" class="form-control" name="payment[1][remarks]" value="">
                                                                </div>

                                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div id="payment_val">1</div>
                                                    <div class="form-group col-md-12" id="useraddbtns">
                                                        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加回款信息</a>
                                                        <input type="submit" class="btn btn-info btn-sm" value="保存">
                                                    </div>
                                                    <div class="form-group">&nbsp;</div>
                                                </div>
                                            </form>
                                        <?php }else{ ?>
                                           <!-- --><?php /*if($pays){ */?>
                                            <div class="form-group">
                                                <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;"> <span class="black">回款计划</span> (应回款总金额：{$should_back_money}元)&emsp;
                                                    <?php if (in_array(cookie('userid'),array($jd))){ ?>
                                                    <div style="display: inline-block" id="upd_money_back_div"><button class="btn btn-success btn-sm edit_money_back_btn">修改总回款金额</button></div>
                                                    <?php } ?>
                                                </h2>
                                                <div class="callout callout-danger">
                                                    <h4>提示！一般情况应做到：</h4>
                                                    <p>1、在业务实施前回款不小于70%；</p>
                                                    <p>2、在业务实施结束后10个工作日收回全部尾款；</p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <table class="table table-bordered dataTable "  style="margin-top:-20px;" id="tablelist">
                                                    <thead>
                                                        <tr>
                                                            <th width="150">合同编号</th>
                                                            <th width="40" style="text-align:center;">序号</th>
                                                            <th width="100">回款金额(元)</th>
                                                            <th width="100">回款比例(%)</th>
                                                            <th width="100">计划回款时间</th>
                                                            <th>备注</th>
                                                            <th width="100">已回款金额(元)</th>
                                                            <th width="100">状态</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <foreach name="pays" key="k" item="v">
                                                            <tr class="userlist">
                                                                <td><a href="{:U('Contract/detail',array('id'=>$v['cid']))}"><?php if($v['contract_id']){ echo $v['contract_id']; }else{ echo '未编号';} ?></a></td>
                                                                <td style="text-align:center;">{$v.no}</td>
                                                                <td>&yen; {$v.amount}</td>
                                                                <td>{$v.ratio}</td>
                                                                <td><if condition="$v['return_time']">{$v.return_time|date='Y-m-d',###}</if></td>
                                                                <td>{$v.remark}</td>
                                                                <td>&yen; {$v.pay_amount}</td>
                                                                <td><?php if($v['status']==2){ echo '<span class="green">已回款</span>';}else if($v['status']==1){ echo '<span class="blue">待回款</span>';}else if($v['status']==0){ echo '<span class="red">未回款</span>';} ?></td>
                                                            </tr>
                                                        </foreach>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php /*}} */?>
                                        <?php } ?>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">开票申请</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <?php if ($ticketAskFor){ ?>  <!--开票申请记录-->
                                            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                <tr role="row" class="orders" >
                                                    <th class="taskOptions">开票主体</th>
                                                    <th class="taskOptions">开票类型</th>
                                                    <th class="taskOptions">开票金额</th>
                                                    <th class="taskOptions">申请时间</th>
                                                    <th class="taskOptions" width="80">状态</th>
                                                    <if condition="rolemenu(array('Finance/addAskFor'))">
                                                        <td class="taskOptions">操作</td>
                                                    </if>
                                                    <th class="taskOptions" width="80">开票完成</th>
                                                </tr>
                                                <foreach name="ticketAskFor" item="row">
                                                    <tr>
                                                        <td class="taskOptions"><a href="javascript:;" onclick="ticket_detail({$row.id},{$row.audit_uid})">{$company[$row['company']]}</a></td>
                                                        <td class="taskOptions">{$row.type}</td>
                                                        <td class="taskOptions">{$row.money}</td>
                                                        <td class="taskOptions">{$row.create_time|date='Y-m-d H:i:s',###}</td>
                                                        <td class="taskOptions">{$ticket_status[$row['audit_status']]}</td>
                                                        <if condition="rolemenu(array('Finance/addAskFor'))">
                                                            <td class="taskOptions">
                                                                <?php if (in_array($row['audit_status'],array(0,2))){ ?>
                                                                    <a href="javascript:;" onclick="addTicketAskFor({$op.op_id},{$row.id})" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                                <?php }else{ ?>
                                                                    <a href="javascript:;" title="编辑" class="btn btn-default btn-smsm"><i class="fa fa-pencil"></i></a>
                                                                <?php } ?>
                                                            </td>
                                                        </if>
                                                        <td class="taskOptions">
                                                            <?php if (in_array(cookie('userid'),array($row['audit_uid'],1)) && $row['audit_status']==1){ ?>
                                                                <button onClick="javascript:ConfirmTicket('{:U('Finance/public_ConfirmTicket',array('id'=>$row['id']))}')" title="完成" class="btn btn-warning btn-smsm"><i class="fa fa-check"></i></button>
                                                            <?php }else{ ?>
                                                                <button onClick="javascript:;" title="完成" class="btn btn-default btn-smsm"><i class="fa fa-check"></i></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </foreach>
                                            </table>
                                        <?php }else{ ?>
                                            <div class="form-group col-md-12"> 暂无开票申请记录! </div>
                                        <?php } ?>
                                        <?php if (in_array(cookie('userid'),array(1,$op['create_user']))){ ?>
                                        <div class="form-group col-md-12" id="useraddbtns">
                                            <a href="javascript:;" class="btn btn-success btn-sm" onClick="addTicketAskFor({$op.op_id})"><i class="fa fa-fw fa-plus"></i> 新增开票申请</a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目回款</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<?php if($huikuanlist){ ?>
                                    <form method="post" action="{:U('Finance/save_huikuan')}" name="myform" id="save_huikuan">
                                    <input type="hidden" name="dosubmint" value="1">
                                    <input type="hidden" name="info[op_id]" value="{$op.op_id}">
                                    <input type="hidden" name="info[name]" value="{$op.project}">
                                    <input type="hidden" name="settlement" value="{$settlement.id}" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <div class="content" >
                                        <div style="width:100%; float:left;">
                                            <div class="form-group col-md-6">
                                                <label>回款计划：</label>
                                                <select class="form-control" name="info[payid]" required>
                                                    <foreach name="huikuanlist" key="k" item="v">
                                                        <option value="{$v.id}"><?php if($v['contract_id']){ echo $v['contract_id'].'  / '; } ?>第{$v.no}笔 / {$v.amount}元 / {$v.remark}</option>
                                                    </foreach>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>付款方：</label>
                                                <input type="text" name="info[payer]" class="form-control" value="" required />
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>本次回款金额：</label>
                                                <input type="text" name="info[huikuan]" id="renshu" class="form-control" value=""/>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>收款方式：</label>
                                                <select class="form-control" name="info[type]" required>
                                                    <option value="">选择</option>
                                                    <option value="转账">转账</option>
                                                    <option value="支票">支票</option>
                                                    <option value="现金">现金</option>
                                                    <option value="其他">其他</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>收款日期：</label>
                                                <input type="text" name="info[huikuan_time]" class="form-control inputdate" value=""/>
                                            </div>
                                            
                                            <div class="form-group col-md-12">
                                                <label>备注：</label>
                                                <input type="text" name="info[remark]" id="remark" class="form-control" value=""/>
                                            </div>
                                            
                                            <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                                <button class="btn btn-success btn-lg">保存并提交审核</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    </form>  
                                    <?php }else{ ?>
									<?php if($pays){ ?>
                                    <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">已全部回款</span></div>
                                    <?php }else{ ?>
                                    <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">尚未制定回款计划</span></div>
                                    <?php }} ?>
                                </div>
                            </div>
                            
                            
                            
                            <?php if($huikuan){ ?>
                             <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">回款记录</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="padding-top:0px;">
                                         <table class="table table-striped" id="font-14-p">
                                            <thead>
                                                <tr>
                                                    <th width="120">回款金额</th>
                                                    <th width="120">回款方式</th>
                                                    <th width="180">申请时间</th>
                                                    <th>回款备注</th>
                                                    <th width="">付款方</th>
                                                    <th width="120">审批状态</th>
                                                    <th width="120">审批者</th>
                                                    <th width="">审批说明</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <foreach name="huikuan" key="k" item="v">
                                                    <tr class="userlist">
                                                        <td>&yen; {$v.huikuan}</td>
                                                        <td>{$v.type}</td>
                                                        <td>{$v.create_time|date='Y-m-d H:i:s',###}</td>
                                                        <td>{$v.remark}</td>
                                                        <td>{$v.payer}</td>
                                                        <td>{$v.showstatus}</td>
                                                        <td>{$v.show_user}</td>
                                                        <td>{$v.show_reason}</td>
                                                    </tr> 
                                                </foreach>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                                <?php } ?>
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
        $('.edit_money_back_btn').click(function () {
            var should_back_money   = <?php echo $should_back_money?$should_back_money:'0.00'; ?>;
            var action              = "{:U('Finance/save_upd_money_back')}";
            var opid                = {$op.op_id};
            var form_html           = '<form action="'+action+'" method="post"> ' +
                '<input type="hidden" name="opid" value="{$op.op_id}">'+
                '<div style="width:150px; float:left; border-radius:0;">' +
                '<input type="text" class="form-control" name="should_back_money" value="{$should_back_money}">' +
                '</div> ' +
                '<input type="submit" class="btn btn-info btn-sm ml10" value="提交">' +
                ' </form>';
            $('#upd_money_back_div').html(form_html);
        })
    })

    //新增回款计划
    function add_payment(){
        var i = parseInt($('#payment_val').text())+1;

        var html = '<div class="userlist" id="pretium_'+i+'">';
        html += '<span class="title"></span>';
        html += '<input type="hidden" name="payment['+i+'][no]" class="payno" value="">';
        html += '<div class="f_15"><input type="text" class="form-control" name="payment['+i+'][amount]" onblur="check_ratio('+i+',$(this).val())" value=""></div>';
        html += '<div class="f_15"><input type="text" class="form-control" name="payment['+i+'][ratio]" value=""></div>';
        html += '<div class="f_15"><input type="text" class="form-control inputdate"  name="payment['+i+'][return_time]" value=""></div>';
        html += '<div class="f_15"><select class="form-control" name="payment['+i+'][company]"><foreach name="company" key="k" item="v"><option value="{$k}">{$v}</option></foreach></select></div>';
        html += '<div class="f_15"><select class="form-control" name="payment['+i+'][type]"><foreach name="type" key="k" item="v"><option value="{$k}">{$v}</option></foreach></select></div>';
        html += '<div class="f_25"><input type="text" class="form-control" name="payment['+i+'][remarks]" value=""></div>';
        html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a>';
        html += '</div>';
        $('#payment').append(html);
        $('#payment_val').html(i);
        orderno();
        relaydate();
    }

    //编号
    function orderno(){
        $('#payment').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#payment').find('.payno').each(function(index, element) {
            $(this).val(parseInt(index)+1);
        });
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
        //cost_total();
    }

    //百分数转化为小数
    function toPoint(percent){
        var str=percent.replace("%","");
        str= str/100;
        var res = str.toFixed(2);
        return res;
    }

    //自动计算回款比例
    function check_ratio(num,obj) {
        var sum         = $('#sum_money_return').html(); //预算收入
        /*if (sum == 0){
            art_show_msg('预算收入有误,请重新输入');
            return false;
        }else{*/
            var money_back  = obj;
            var ratio       = accDiv(money_back,sum); //相除
            var ratio       = ratio.toFixed(4); //保留4位小数
            var average     = accMul(ratio,'100')+'%'; //相加
            $('input[name="payment['+num+'][ratio]"]').val(average);
        /*}*/

    }

    //新增开票申请
    function addTicketAskFor(opid,id=0) {
        let url = '/index.php?m=Main&c=Finance&a=addAskFor&opid='+opid+'&id='+id;
        art.dialog.open(url,{
            lock:true,
            id: 'audit_win',
            title: '开票申请',
            width:1000,
            height:550,
            okVal: '提交至出纳',
            fixed: true,
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                return false;
            },
            cancelVal:'取消',
            cancel: function () {
            }
        });
    }

    //开票详情 + 审核
    function ticket_detail(id,audit_uid) {
        let uid = <?php echo cookie('userid'); ?>;
        let url = '/index.php?m=Main&c=Finance&a=public_ticket_detail&id='+id;
        if (uid == audit_uid || uid == 1){
            art.dialog.open(url,{
                lock:true,
                id: 'audit_win',
                title: '开票申请',
                width:1000,
                height:550,
                okVal: '确定',
                fixed: true,
                ok: function () {
                    this.iframe.contentWindow.gosubmint();
                    return false;
                }
                /*cancelVal:'取消',
                cancel: function () {
                }*/
            });
        } else{
            art.dialog.open(url,{
                lock:true,
                id: 'audit_win',
                title: '开票申请',
                width:1000,
                height:550,
                okVal: '确定',
                fixed: true,
                ok: function () { }
            });
        }
    }

    //确认开票完成
    function ConfirmTicket(url) {
        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">确定已开本次发票？<br/>将会通知相关业务人员领取发票!</span>',
            ok: function () {
                window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }

</script>

     


