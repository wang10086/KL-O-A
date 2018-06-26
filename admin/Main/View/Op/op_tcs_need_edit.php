<?php if($guide_price){ ?>
    <include file="op_tcs_list" />
<?php } ?>

<form method="post" action="{:U('Op/public_save')}" id="tcs_need_form">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="13">
<div class="content">

    <div class="form-group col-md-12" >
        <label class="lit-title" >辅导员/教师、专家需求</label>
    </div>

    <div class="form-group col-md-12" id="longline">
        <input type="hidden" value="1" id="number">
        <div class="form-group col-md-4">
            <label>活动日期：</label>
            <input type="text" name="in_day" class="form-control inputdate" value="" required />
        </div>

        <div class="form-group col-md-4">
            <label>活动时间(请填写具体时间段)：</label>
            <input type="text" name="tcs_time" class="form-control inputdate_b" value="" required />
        </div>

        <div class="form-group col-md-4">
            <label>活动地点：</label>
            <input type="text" name="address"  class="form-control" value="" required />
        </div>
        <div class="form-group col-md-12"></div>

        <div class="tcsbox">
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">

                    <div class="tcscon">
                        <div class="box-body mb-50">
                            <div class="content" style="padding-top:0px;">
                                <div id="tcs" class="tcs">
                                    <!--<h3 class="price-title">辅导员/教师、专家需求</h3>-->
                                    <div class="userlist form-title">
                                        <div class="unitbox" style="width:12%">职务</div>
                                        <div class="unitbox" style="width:12%">职能类型</div>
                                        <div class="unitbox" style="width:12%">所属领域</div>
                                        <div class="unitbox" style="width:5%">人数</div>
                                        <div class="unitbox" style="width:8%">单价</div>
                                        <div class="unitbox" style="width:8%">合计</div>
                                        <div class="unitbox" style="width:18%">备注</div>
                                    </div>

                                    <div class="userlist no-border" id="tcs_id">
                                        <span class="title">1</span>
                                        <select  class="form-control" style="width:12%"  name="data[1][guide_kind_id]" id="se_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                            <foreach name="guide_kind" key="k" item="v">
                                                <option value="{$k}">{$v}</option>
                                            </foreach>
                                        </select>

                                        <select  class="form-control" style="width:12%"  name="data[1][gpk_id]" id="gpk_id_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                        </select>
                                        <select  class="form-control" style="width:12%"  name="data[1][field]">
                                            <option value="" selected disabled>请选择</option>
                                            <foreach name="fields" key="key" item="value">
                                                <option value="{$key}" <?php if($v['field']==$key) echo 'selected'; ?>>{$value}</option>
                                            </foreach>
                                        </select>
                                        <input type="text" class="form-control" style="width:5%" name="data[1][num]" id="num_1" onblur="getTotal(1)" value="1">
                                        <input type="text" class="form-control" style="width:8%" name="data[1][price]" id="dj_1" onblur="getTotal(1)" value="">
                                        <input type="text" class="form-control" style="width:8%" name="data[1][total]" id="total_1" value="">
                                        <input type="text" class="form-control" style="width:18%" name="data[1][remark]" value="">
                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="deltcsbox('tcs_id')">删除</a>
                                        <div id="tcs_val">1</div>
                                    </div>

                                </div>

                                <div class="form-group col-md-12" id="useraddbtns">
                                    <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_tcs()"><i class="fa fa-fw fa-plus"></i> 人员信息</a>
                                    <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('tcs_need_form','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>

                                </div>
                                <div class="form-group col-md-12">&nbsp;</div>
                            </div>
                        </div><!-- /.box-body -->

                    </div><!--/.col (right) -->
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

</form>




