
        <div class="content" style="padding-top:0px;">
            <table class="table table-striped" id="font-14-p">
                <thead>
                    <tr>
                        <th width="">费用项</th>
                        <th width="">单价</th>
                        <th width="">数量</th>
                        <th width="">合计</th>
                        <th width="">类型</th>
                        <!--<th width="">预算备注</th>-->
                        <th width="">借款单号</th>
                        <th width="">支付方式</th>
                        <th width="">支付时间</th>
                        <th width="">借款金额</th>
                        <th width="">受款单位</th>
                        <th width="">财务备注</th>
                    </tr>
                </thead>
                <tbody>
                    <foreach name="costacc" key="k" item="v">
                    <form method="post" action="{:U('Finance/public_save')}" id="form_{$v.id}">
                    <input type="hidden" name="dosubmint" value="1">
                    <input type="hidden" name="savetype" value="18">
                    <tr class="userlist" id="supplier_id_103">
                        <td width="10%">{$v.title}</td>
                        <td width="8%">&yen; {$v.unitcost}</td>
                        <td width="5%">{$v.amount}</td>
                        <td width="8%">&yen; {$v.total}</td>
                        <td width="8%"><?php echo $kind[$v['type']]; ?></td>
                        <td width="15%">{$v.jkd_ids}</td>
                        <td width="6%">{$jiekuan_type[$v['jktype']]}</td>
                        <td width="8%">
                            <if condition="$v.cw_audit_time neq 0">
                                {$v.cw_audit_time|date='Y-m-d',###}
                            </if>
                        </td>
                        <td width="6%">{$v.jiekuan}</td>
                        <td width="10%">{$v.payee}</td>
                        <td width="10%" style="overflow: hidden;">
                            <input type="hidden" name="costacc_id" value="{$v.id}">
                            <input type="text" class="form-control" style="width: 80%; float: left;" name="cwremark"  value="{$v.cwremark}" >
                            <if condition="rolemenu(array('Finance/save_cwremark'))">
                            <a class="rightSideBtn-info" href="javascript:;" title="保存" onClick="save('form_'+{$v.id},`<?php echo U('Finance/public_save'); ?>`)"><i class="fa fa-check-circle-o"></i></a>
                            </if>
                        </td>
                    </tr>
                    </form>
                    </foreach>

                    <style>
                        .rightSideBtn-info{background-color: #00c0ef; border-color: #00acd6;float: left; height: 34px; line-height: 34px; width: 20px; text-align: center; margin-left: 2px;}
                    </style>

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
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>




        <div class="content"  style="border-top:2px solid #f39c12; margin-top:20px; padding-bottom:20px;">

            <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">

                <tr>
                    <td width="33.33%">人数：{$budget.renshu}</td>
                    <td width="33.33%">预算收入：{$budget.shouru}</td>
                    <td width="33.33%">收入性质：{$budget.xinzhi}</td>
                </tr>
                <tr>
                    <td>毛利：{$budget.maoli}</td>
                    <td>毛利率：{$budget.maolilv}</td>
                    <td>人均毛利：{$budget.renjunmaoli}</td>
                </tr>
            </table>

        </div>

        <div class="content"  style="border-top:2px solid #f39c12; margin-top:20px; padding-bottom:20px;">

            <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="33.33%">审批状态：{$op.showstatus}</td>
                    <td width="33.33%">审批人：{$op.show_user}</td>
                    <td width="33.33%">审批时间：{$op.show_time}</td>
                </tr>
                <?php if($op['show_reason']){ ?>
                <tr>
                    <td colspan="3">审批说明：{$op.show_reason}</td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="content no-print">
            <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> 打印</button>
            <a href="{:U('Export/budget',array('opid'=>$op['op_id']))}" class="btn btn-default"><i class="fa fa-arrow-circle-down"></i> 导出</a>
        </div>

        <script>
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