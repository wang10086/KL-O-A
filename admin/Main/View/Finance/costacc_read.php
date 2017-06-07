<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">成本核算</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
    	<?php if($op['line_id']){ ?>
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
                        <td style="font-size:16px; color:#ff3300;">&yen; {$op.costacc}</td>
                        <td></td>
                        <td></td>
                    </tr>        
                </tbody>
            </table>
            
        </div>

        <div class="content"  style="border-top:2px solid #f39c12; margin-top:20px; padding-bottom:20px;">
			
            <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                
                <tr>
                    <td width="33.33%">成本价格：{$op.costacc}{$op.costacc_unit}</td>
                    <td width="33.33%">建议最低报价：{$op.costacc_min_price}{$op.costacc_min_price_unit}</td>
                    <td width="33.33%">建议最高报价：{$op.costacc_max_price}{$op.costacc_max_price_unit}</td>
                </tr>
            </table>
            
        </div>
        
        <div class="content no-print">
        	<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> 打印</button>
        </div>
        <?php }else{
			echo '<div class="content" style="margin-left:15px;">请先确认行程方案，再核算成本！</div>';	
		} ?>
    </div>
</div>

