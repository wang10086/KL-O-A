<div class="box box-warning mt20">
    <div class="box-header">
        <h3 class="box-title">{$_action_}</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <form method="post" action="{:U('Customer/public_save_process')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="saveType" value="5">
                <input type="hidden" name="sale_id" value="{$list.id}">
                <input type="hidden" name="id" value="{$pro_list.id}">
                <div class="form-group col-md-4">
                    <label>销售支持标题</label>
                    <!--<select class="form-control" name="sale_id" onchange="get_customer_sale_data($(this).val())">
                        <option value="">==请选择==</option>
                        <foreach name="sale_lists" key="k" item="v">
                            <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>-->
                    <input type="text" class="form-control" value="{$list.title}" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>申请人</label>
                    <input type="text" class="form-control" value="{$list.blame_name}" id="blame_name" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>销售支持类型</label>
                    <input type="text" class="form-control" value="{$types[$list['type']]}" id="type" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>客户</label>
                    <input type="text" class="form-control" value="{$list.customer}" id="customer" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>起始日期</label>
                    <input type="text"  class="form-control" value="{$list.st_time|date='Y-m-d',###}" id="st_time" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>结束日期</label>
                    <input type="text"  class="form-control" value="{$list.et_time|date='Y-m-d',###}" id="et_time" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>计划费用</label>
                    <input type="text" class="form-control" value="{$list.cost}" id="cost" readonly />
                </div>

                <div class="form-group col-md-4">
                    <label>目的地</label>
                    <input type="text" name="info[addr]" value="{$pro_list.addr}" class="form-control" />
                </div>

                <div class="form-group col-md-4">
                    <label>期望目的</label>
                    <input type="text" name="info[hope]" value="{$pro_list.hope}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>活动安排：</label><textarea class="form-control"  name="info[content]">{$pro_list.content}</textarea>
                    <span id="contextTip"></span>
                </div>

                <div class="form-group col-md-12">
                    <P class="border-bottom-line"> 活动预算 &emsp;&emsp;&emsp;&emsp;
                        <label>是否需要借款</label> &emsp;
                        <input type="radio" name="info[jiekuan]" value="0"  <?php if($pro_list['jiekuan']==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                        <input type="radio" name="info[jiekuan]" value="1"  <?php if($pro_list['jiekuan']==1){ echo 'checked';} ?>> &#8194;需要
                    </P>

                    <div id="costacc">
                        <div class="userlist">
                            <div class="unitbox">费用项</div>
                            <div class="unitbox">单价</div>
                            <div class="unitbox">数量</div>
                            <div class="unitbox">合计</div>
                            <div class="unitbox longinput">备注</div>
                        </div>

                        <foreach name="costacc" key="k" item="v">
                            <div class="userlist cost_expense" id="costacc_id_b_{$k}">
                                <span class="title"><?php echo $k+1; ?></span>
                                <input type="hidden" name="resid[888{$k}][]" value="{$v.id}" >
                                <input type="text" class="form-control" name="costacc[888{$k}][title]" value="{$v.title}">
                                <input type="text" class="form-control cost" name="costacc[888{$k}][unitcost]" value="{$v.unitcost}">
                                <input type="text" class="form-control amount" name="costacc[888{$k}][amount]" value="{$v.amount}">
                                <input type="text" class="form-control totalval" name="costacc[888{$k}][total]" value="{$v.total}">
                                <input type="text" class="form-control longinput" name="costacc[888{$k}][remark]" value="{$v.remark}">
                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_b_{$k}')">删除</a>
                            </div>
                        </foreach>

                    </div>
                    <div id="costacc_sum">
                        <div class="userlist">
                            <div class="unitbox"></div>
                            <div class="unitbox"></div>
                            <div class="unitbox" style="  text-align:right;">合计</div>
                            <div class="unitbox" id="costaccsum"></div>
                            <div class="unitbox longinput"></div>
                        </div>
                    </div>
                    <div id="costacc_val">1</div>
                    <div class="form-group col-md-12" id="useraddbtns" style="margin-left:15px;">
                        <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_costacc()"><i class="fa fa-fw fa-plus"></i> 新增活动预算</a>
                    </div>
                    <div class="form-group">&nbsp;</div>
                </div>

                <div id="formsbtn">
                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                    <?php if ($pro_list && in_array($pro_list['audit_status'],array(0,2))){ ?>
                        <button type="button" onclick="$('#submitForm').submit()" class="btn btn-warning btn-lg" id="lrpd">提交</button>
                    <?php } ?>
                </div>
            </form>

            <form method="post" action="{:U('Customer/public_save_process')}" name="myform" id="submitForm">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="saveType" value="6">
                <input type="hidden" name="id" value="{$pro_list.id}">
            </form>

        </div>
    </div><!-- /.box-body -->
</div>