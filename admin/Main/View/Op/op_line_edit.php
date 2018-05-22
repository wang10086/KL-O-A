<form method="post" action="" name="myform" id="save_line_days">
<input type="hidden" name="dosubmint" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="savetype" value="6">
<div id="task_title">{$linetext}</div>
<div id="task_timu">
    <foreach name="days" key="k" item="v">
    <div class="daylist" id="task_ti_id_{$k}">
        <a class="aui_close" href="javascript:;" style="right:25px;" onclick="del_timu('task_ti_id_{$k}')">×</a>
        <div class="col-md-12 pd">
            <label class="titou"><strong>第<span class="tihao"><?php echo $k+1; ?></span>天</strong></label>
            <div class="input-group"><input type="text" placeholder="所在城市" name="days[1000{$v.id}][citys]" value="{$v.citys}" class="form-control"></div>
            <div class="input-group pads"><textarea class="form-control" placeholder="行程安排" name="days[1000{$v.id}][content]">{$v.content}</textarea></div>
            <div class="input-group"><input type="text" placeholder="房餐车安排" name="days[1000{$v.id}][remarks]" value="{$v.remarks}" class="form-control"></div>
         </div>
    </div>
    </foreach>
   
    
</div>

<div style="display:none" id="task_val"><?php echo count($days_list); ?></div>

<div class="form-group col-md-12" id="addti_btn">
    
    <a href="javascript:;" class="btn btn-warning btn-sm" onClick="selectmodel()" style="margin-left:15px;"><i class="fa fa-sign-in fa-plus"></i> 选择行程线路</a>
    <a href="javascript:;" class="btn btn-success btn-sm" onClick="task(1)" ><i class="fa fa-fw  fa-plus"></i> 加一天</a> 
    <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_line_days','<?php echo U('Op/public_save_line'); ?>',{$op.op_id});">保存</a>
</div>
</form>


<div class="form-group col-md-12 ml-12" id="tcscheckbox">
    <h2 class="tcs_need_h2">辅导员/教师、专家需求</h2>
    <input type="radio" name="need-tcs-or-not" value="0" <?php if($rad==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
    <input type="radio" name="need-tcs-or-not" value="1" <?php if($rad==1){ echo 'checked';} ?>> &#8194;需要
</div>

<form method="post" action="" id="tcs_need_form">
    <div class="tcsbox">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="opid" value="{$op.op_id}">
        <input type="hidden" name="savetype" value="12">
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="tcscon">
                    <div class="box-body mb-50">
                        <div class="content" style="padding-top:0px;">
                            <div id="tcs">
                                <!--<h3 class="price-title">辅导员/教师、专家需求</h3>-->
                                <div class="userlist form-title">
                                    <div class="unitbox w-150">职务</div>
                                    <div class="unitbox w-150">职能类型</div>
                                    <div class="unitbox">人数</div>
                                    <div class="unitbox">单价</div>
                                    <div class="unitbox">合计</div>
                                    <div class="unitbox lp_remark">备注</div>
                                </div>
                                <?php if($guide_price){ ?>
                                    <foreach name="guide_price" key="k" item="v">
                                        <div class="userlist no-border" id="tcs_id_{$v.id}">
                                            <div id="tcs_val">0</div>
                                            <script>{++$k}; var n = parseInt($('#tcs_val').text());n++;$('#tcs_val').text(n);</script>
                                            <span class="title"><?php echo $k; ?></span>
                                            <select  class="form-control w-150"  name="data[{$k}][guide_kind_id]" id="se_{$k}" onchange="getPrice({$k})">
                                                <foreach name="guide_kind" key="key" item="value">
                                                    <option value="{$key}" <?php if($v['guide_kind_id']==$key) echo 'selected'; ?>>{$value}</option>
                                                </foreach>
                                            </select>
                                            <select  class="form-control w-150 gpk"  name="data[{$k}][gpk_id]" id="gpk_id_{$k}" onchange="getPrice({$k})">
                                                <foreach name="price_kind" key="key" item="value">
                                                    <option value="{$key}" <?php if($v['gpk_id']==$key) echo 'selected'; ?>>{$value}</option>
                                                </foreach>
                                            </select>
                                            <input type="text" class="form-control" name="data[{$k}][num]" value="{$v.num}" id="num_{$k}" onblur="getTotal({$k})">
                                            <input type="text" class="form-control" name="data[{$k}][price]" value="{$v.price}" id="dj_{$k}">
                                            <input type="text" class="form-control" name="data[{$k}][total]" value="{$v.total}" id="total_{$k}">
                                            <input type="text" class="form-control lp_remark" name="data[{$k}][remark]" value="{$v.remark}">
                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="deltcsbox('tcs_id_{$v.id}')">删除</a>
                                        </div>
                                    </foreach>
                                <?php }else{ ?>
                                    <div class="userlist no-border" id="tcs_id">
                                        <span class="title">1</span>
                                        <select  class="form-control w-150"  name="data[1][guide_kind_id]" id="se_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                            <foreach name="guide_kind" key="k" item="v">
                                                <option value="{$k}">{$v}</option>
                                            </foreach>
                                        </select>

                                        <select  class="form-control w-150"  name="data[1][gpk_id]" id="gpk_id_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                        </select>
                                        <input type="text" class="form-control" name="data[1][num]" id="num_1" onblur="getTotal(1)" value="">
                                        <input type="text" class="form-control" name="data[1][price]" id="dj_1" value="">
                                        <input type="text" class="form-control" name="data[1][total]" id="total_1" value="">
                                        <input type="text" class="form-control lp_remark" name="data[1][remark]" value="">
                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="deltcsbox('tcs_id')">删除</a>
                                        <div id="tcs_val">1</div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group col-md-12" id="useraddbtns">
                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_tcs()"><i class="fa fa-fw fa-plus"></i> 人员信息</a>
                                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('tcs_need_form','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>
                            </div>
                            <div class="form-group">&nbsp;</div>
                        </div>
                    </div><!-- /.box-body -->

                    <div style="width:100%; text-align:center;">
                        <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('tcs_need_form','<?php /*echo U('Op/public_save'); */?>',{$op.op_id});">保存</a>-->
                    </div>
                </div><!--/.col (right) -->
            </div>
        </div><!-- /.box-body -->
    </div>
</form>


<script>

</script>