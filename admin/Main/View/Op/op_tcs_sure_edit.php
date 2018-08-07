<div class="form-group col-md-12 ml-12" id="tcscheckbox">
    <h2 class="tcs_need_h2">辅导员/教师、专家需求</h2>
    <input type="radio" name="need-tcs-or-not" value="0"  <?php if($rad==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
    <input type="radio" name="need-tcs-or-not" value="1"  <?php if($rad==1){ echo 'checked';} ?>> &#8194;需要
</div>

<!--<form method="post" action="{:U('Op/public_save')}" id="tcs_sure_form">-->
<form method="post" action="{:U('Op/public_save')}" id="tcs_need_form">
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
                                    <div class="unitbox" style="width:15%">职务</div>
                                    <div class="unitbox" style="width:15%">职能类型</div>
                                    <div class="unitbox" style="width:6%">天数</div>
                                    <div class="unitbox" style="width:6%">人数</div>
                                    <div class="unitbox" style="width:10%">单价</div>
                                    <div class="unitbox" style="width:10%">合计</div>
                                    <div class="unitbox" style="width:20%">备注</div>
                                </div>
                                <?php if($guide_price){ ?>
                                    <foreach name="guide_price" key="k" item="v">
                                        <div class="userlist no-border" id="tcs_id_{$v.id}">
                                            <div id="tcs_val">0</div>
                                            <script>{++$k}; var n = parseInt($('#tcs_val').text());n++;$('#tcs_val').text(n);</script>
                                            <span class="title"><?php echo $k; ?></span>
                                            <select  class="form-control" style="width:15%"  name="data[{$k}][guide_kind_id]" id="se_{$k}" onchange="getPrice({$k})">
                                                <foreach name="guide_kind" key="key" item="value">
                                                    <option value="{$key}" <?php if($v['guide_kind_id']==$key) echo 'selected'; ?>>{$value}</option>
                                                </foreach>
                                            </select>
                                            <select  class="form-control" style="width:15%"  name="data[{$k}][gpk_id]" id="gpk_id_{$k}" onchange="getPrice({$k})">
                                                <foreach name="price_kind" key="key" item="value">
                                                    <option value="{$value.id}" <?php if($v['gpk_id']==$value['id']) echo 'selected'; ?>>{$value.name}</option>
                                                </foreach>
                                            </select>
                                            <input type="text" class="form-control" style="width:6%" name="data[{$k}][days]" value="{$v.days}" id="days_{$k}" onblur="getTotal({$k})">
                                            <input type="text" class="form-control" style="width:6%" name="data[{$k}][num]" value="{$v.num}" id="num_{$k}" onblur="getTotal({$k})">
                                            <input type="text" class="form-control" style="width:10%" name="data[{$k}][price]" value="{$v.price}" id="dj_{$k}" onblur="getTotal({$k})">
                                            <input type="text" class="form-control" style="width:10%" name="data[{$k}][total]" value="{$v.total}" id="total_{$k}">
                                            <input type="text" class="form-control" style="width:20%" name="data[{$k}][remark]" value="{$v.remark}">
                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('tcs_id_{$v.id}')">删除</a>
                                        </div>
                                    </foreach>
                                <?php }else{ ?>
                                    <div class="userlist no-border" id="tcs_id">
                                        <span class="title">1</span>
                                        <select  class="form-control" style="width:15%"  name="data[1][guide_kind_id]" id="se_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                            <foreach name="guide_kind" key="k" item="v">
                                                <option value="{$k}">{$v}</option>
                                            </foreach>
                                        </select>

                                        <select  class="form-control" style="width:15%"  name="data[1][gpk_id]" id="gpk_id_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                        </select>
                                        <input type="text" class="form-control" style="width:6%" name="data[1][days]" id="days_1" onblur="getTotal(1)" value="1">
                                        <input type="text" class="form-control" style="width:6%" name="data[1][num]" id="num_1" onblur="getTotal(1)" value="1">
                                        <input type="text" class="form-control" style="width:10%" name="data[1][price]" id="dj_1" onblur="getTotal(1)" value="">
                                        <input type="text" class="form-control" style="width:10%" name="data[1][total]" id="total_1" value="">
                                        <input type="text" class="form-control" style="width:20%" name="data[1][remark]" value="">
                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('tcs_id')">删除</a>
                                        <div id="tcs_val">1</div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group col-md-12" id="useraddbtns">
                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_tcs()"><i class="fa fa-fw fa-plus"></i> 人员信息</a>
                                <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('tcs_sure_form','<?php /*echo U('Op/public_save'); */?>',{$op.op_id});">保存</a>-->
                                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('tcs_need_form','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>
                            </div>
                            <div class="form-group">&nbsp;</div>
                        </div>
                    </div><!-- /.box-body -->

                    <div style="width:100%; text-align:center;">
                    </div>
                </div><!--/.col (right) -->
            </div>
        </div><!-- /.box-body -->
    </div>
</form>

