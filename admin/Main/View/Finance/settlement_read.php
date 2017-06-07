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
        	<?php if($jiesuan){ ?>
        	<foreach name="jiesuan" key="k" item="v">
            	<tr class="userlist">
                    <td width="16.66%">{$v.title}</td>
                    <td width="16.66%">&yen; {$v.unitcost}</td>
                    <td width="16.66%">{$v.amount}</td>
                    <td width="16.66%">&yen; {$v.total}</td>
                    <td width="16.66%"><?php echo $kind[$v['type']] ?></td>
                    <td>{$v.remark}</td>
                </tr> 
           
        	</foreach>
        	<?php }else{ ?>
            <foreach name="costacc" key="k" item="v">
			<?php 
            if($v['cost_type']==4){
                $shiyong = $v['m_outsum']-$v['m_returnsum'];
                $jieyong = $v['m_returnsum'];
                if($shiyong){ 
            ?>
            	<tr class="userlist">
                    <td width="16.66%">{$v.remark}</td>
                    <td width="16.66%">&yen; {$v.cost}</td>
                    <td width="16.66%">{$shiyong}</td>
                    <td width="16.66%">&yen; <?php echo sprintf("%.2f", $v['cost']*$shiyong) ?></td>
                    <td width="16.66%">物资</td>
                    <td>未归还</td>
                </tr> 
                
            <?php 
                }
                if($jieyong){
                    $fy = sprintf("%.2f", $v['cost']/$v['m_stages']);
            ?>
            	<tr class="userlist">
                    <td width="16.66%">{$v.remark}</td>
                    <td width="16.66%">&yen; {$fy}</td>
                    <td width="16.66%">{$jieyong}</td>
                    <td width="16.66%">&yen; <?php echo sprintf("%.2f", $fy*$jieyong) ?></td>
                    <td width="16.66%">物资</td>
                    <td>已归还，{$v.m_stages} 期</td>
                </tr> 
                
            <?php	
                }
            }else{
            ?>
            	<tr class="userlist">
                    <td width="16.66%">{$v.remark}</td>
                    <td width="16.66%">&yen; {$v.cost}</td>
                    <td width="16.66%">{$v.amount}</td>
                    <td width="16.66%">&yen; {$v.total}</td>
                    <td width="16.66%"><?php echo $costtype[$v['cost_type']] ?></td>
                    <td>{$v.beizhu}</td>
                </tr> 
                
            <?php } ?>
            </foreach>
        	<?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-size:16px; color:#ff3300;">&yen; {$settlement.budget}</td>
                <td></td>
                <td></td>
            </tr>        
        </tbody>
    </table>
    
</div>




<div class="content"  style="border-top:2px solid #f39c12; margin-top:20px; padding-bottom:20px;">
    <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">       
        <tr>
            <td width="33.33%">实际人数：{$settlement.renshu}</td>
            <td width="33.33%">实际收入：{$settlement.shouru}</td>
            <td width="33.33%"></td>
        </tr>
        <tr>
            <td width="33.33%">毛利：{$settlement.maoli}</td>
            <td width="33.33%">毛利率：{$settlement.maolilv}</td>
            <td width="33.33%">人均毛利：{$settlement.renjunmaoli}</td>
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
    <a href="{:U('Export/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default"><i class="fa fa-arrow-circle-down"></i> 导出</a>
</div>