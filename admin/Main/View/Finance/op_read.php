<?php if($is_zutuan == 1 && $dijie_shouru == 0){ ?>
    <div class="content" style="margin-left:15px;">地接部门尚未做该地接项目的预算！</div>
<?php }else{ ?>
    <?php if($op['costacc']!='0.00'){ ?>
        <div class="content" style="padding-top:0px;">
            <table class="table table-striped" id="font-14-p">
                <thead>
                    <tr>
                        <th width="">费用项</th>
                        <th width="">单价</th>
                        <th width="">数量</th>
                        <th width="">合计</th>
                        <th width="">类型</th>
                        <th width="">备注</th>
                    </tr>
                </thead>
                <tbody>
                    <foreach name="costacc" key="k" item="v">
                    <tr class="userlist" id="supplier_id_103">
                        <td width="16.66%">{$v.title}</td>
                        <td width="16.66%">&yen; {$v.unitcost}</td>
                        <td width="16.66%">{$v.amount}</td>
                        <td width="16.66%">&yen; {$v.total}</td>
                        <td width="16.66%"><?php echo $kind[$v['type']]; ?></td>
                        <td>{$v.remark}</td>
                    </tr>
                    </foreach>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-size:16px; color:#ff3300;">&yen; {$budget.budget}</td>
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
    <?php }else{ ?>
            <div class="content" style="margin-left:15px;">请先核算成本，再进行项目预算！</div>
    <?php } } ?>


