<!--<div id="task_title">{$linetext}</div>-->
<div id="task_timu" class="content">
	<?php if($tcs){ ?>
            <label class="lit-title">专家辅导员需求</label>
            <div class="content" style="padding-top:0px; font-size: 14px;">
                <table class="table table-striped" id="font-14-p">
                    <thead>
                    <tr>
                        <th width="">职务</th>
                        <th width="">职能类型</th>
                        <th width="">天数</th>
                        <th width="">人数</th>
                        <th width="">单价</th>
                        <th width="">总价</th>
                        <th width="">备注</th>
                    </tr>
                    </thead>
                    <tbody>
                    <foreach name="tcs" key="k" item="v">
                        <tr class="userlist" id="supplier_id_103">
                            <td width="14%">{$v.gkname}</td>
                            <td width="14%">{$v.gpkname}</td>
                            <td width="14%">{$v.days}</td>
                            <td width="14%">{$v.num}</td>
                            <td width="14%">&yen; {$v.price}</td>
                            <td width="14%">&yen; {$v.total}</td>
                            <td>{$v.remark}</td>
                        </tr>
                        <tr></tr>
                    </foreach>
                    </tbody>
                </table>
            </div>
     <?php }else{ echo '<div class="content"><div class="form-group col-md-12">暂无辅导员需求信息！</div></div>';} ?>
</div>