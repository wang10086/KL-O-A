<div id="costacc">
        <?php if($costacc){ ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="20%">费用项</th>
                    <th width="15%">单价</th>
                    <th width="15%">数量</th>
                    <th width="15%">合计</th>
                    <th width="35%">备注</th>
                </tr>
            </thead>
            <tbody>
                <foreach name="costacc" key="k" item="v">
                <tr>
                    <td>{$v.title}</td>
                    <td>{$v.unitcost}</td>
                    <td>{$v.amount}</td>
                    <td>{$v.total}</td>
                    <td>{$v.remark}</td>
                </tr>    
                </foreach>                                            
            </tbody>
        </table>
        <?php }else{ echo '<div class="form-group" style="padding:20px 0;text-indent:30px;">暂未核算成本！</div>';} ?>
    </div>