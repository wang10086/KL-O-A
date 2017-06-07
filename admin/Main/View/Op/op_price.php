<div id="pretium">
        <?php if($pretium){ ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="">价格名称</th>
                    <th width="">销售价</th>
                    <th width="">同行价</th>
                    <th width="">成人人数</th>
                    <th width="">儿童人数</th>
                    <th width="30%">备注</th>
                </tr>
            </thead>
            <tbody>
                <foreach name="pretium" key="k" item="v">
                <tr>
                    <td>{$v.pretium}</td>
                    <td>{$v.sale_cost}</td>
                    <td>{$v.peer_cost}</td>
                    <td>{$v.adult}</td>
                    <td>{$v.children}</td>
                    <td>{$v.remark}</td>
                </tr>    
                </foreach>                                            
            </tbody>
        </table>
        <?php }else{ 
		if($op['costacc']=='0.00'){
				echo '<div class="form-group" style="padding:20px 0;margin-left:15px;">请先核算成本！</div>';
			}else{
				echo '<div class="form-group" style="padding:20px 0;margin-left:15px;">暂未定价！</div>';
			}
		} ?>
        
    </div>