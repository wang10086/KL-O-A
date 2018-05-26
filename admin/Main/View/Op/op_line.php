<div id="task_title">{$linetext}</div>
<div id="task_timu">
	<?php if($days || $tcs){ ?>
        <?php if($days){ ?>
            <label class="lit-title">行程方案</label>
            <foreach name="days" key="k" item="v">
            <div class="daylist">
                 <div class="col-md-12 pd"><label class="titou"><strong>第<span class="tihao">{$xuhao++}</span>天&nbsp;&nbsp;&nbsp;&nbsp;{$v.citys}</strong></label><div class="input-group pads">{$v.content}</div><div class="input-group">{$v.remarks}</div></div>
            </div>
            </foreach>
        <?php }?>
        <?php if ($tcs){ ?>
            <label class="lit-title">人员需求</label>
            <div class="content" style="padding-top:0px; font-size: 14px;">
                <table class="table table-striped" id="font-14-p">
                    <thead>
                    <tr>
                        <th width="">职务</th>
                        <th width="">职能类型</th>
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
        <?php } ?>
     <?php }else{ echo '<div class="content"><div class="form-group col-md-12">暂无线路行程信息！</div></div>';} ?>
</div>