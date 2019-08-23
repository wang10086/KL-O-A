<form method="post" action="{:U('Finance/save_settlement')}" name="myform" id="save_settlement">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
    <div class="content" style="padding-top:0px;">
        <div id="setcostacc">
            <div class="userlist">
                <div class="unitbox">费用项</div>
                <div class="unitbox">单价</div>
                <div class="unitbox">数量</div>
                <div class="unitbox">合计</div>
                <div class="unitbox">类型</div>
                <div class="unitbox">供方</div>
                <div class="unitbox longinput">备注</div>
            </div>

            <style>
                #setcostacc {
                    padding: 0 15px;
                }

                #setcostacc .form-control {
                    width: 100px;
                    float: left;
                    margin-right: 10px;
                    border-radius: 0;
                }

                #setcostacc .unitbox {
                    width: 100px;
                    margin-right: 10px;
                    float: left;
                    clear: none;
                    border: none;
                    padding: 0;
                }

                #setcostacc .title {
                    width: 22px;
                    float: left;
                    height: 30px;
                    line-height: 30px;
                    margin-left: -30px;
                    text-align: right;
                }

                #setcostacc .userlist {
                    width: 100%;
                    height: auto !important;
                    float: left;
                    clear: both;
                    padding-bottom: 15px;
                    border-bottom: 1px solid #cccccc;
                    margin-top: 15px;
                }

                #setcostacc .input-group {
                    width: auto;
                    float: left;
                    height: 34px;
                    margin-right: 10px;
                    background: #ffffff;
                }

                #setcostacc .input-group span {
                    border: 1px solid #cccccc;
                    width: 40px;
                    background: #ffffff;
                }

                #setcostacc .input-group span.rr {
                    margin-left: -1px;
                }

                #setcostacc .input-group span input {
                    margin-left: 5px;
                }

                #setcostacc .btn {
                    padding: 7px 12px;
                    font-size: 12px;
                }

                #setcostacc td {
                    line-height: 34px;
                }

                #setcostacc_val {
                    display: none
                }

                #setcostacc .total {
                    color: #333333;
                    font-size: 14px;
                }

                #setcostacc .longinput {
                    width: 200px;
                }

                #setcostacc_sum {
                    padding: 0 15px;
                }

                #setcostacc_sum .unitbox {
                    width: 120px;
                    margin-right: 10px;
                    float: left;
                    clear: none;
                    border: none;
                    padding: 0;
                }

                /* #costaccsum{ color:#ff3300; font-size:18px; margin-top:18px;}
            #costaccsum_red{ color:#ff3300; font-size:18px; margin-top:18px;} */
            </style>


            <?php if ($jiesuan) { ?>
            <foreach name="jiesuan" key="k" item="v">
                <?php if ($v['type'] == 2) { //专家辅导员  ?>
                <div class="userlist cost_expense" id="costacc_id_jsg_{$k}">
                    <?php if (cookie('userid') == 11) { ?>
                    <span class="title"></span>
                    <input type="hidden" name="resid[2222{$k}][id]" value="{$v.id}">
                    <input type="text" class="form-control" name="costacc[2222{$k}][title]" value="{$v.title}" list="2222{$k}_cost_title">
                    <datalist id="2222{$k}_cost_title">
                        <foreach name="op_cost_type" item="ct">
                            <option value="{$ct}" label="" />
                        </foreach>
                    </datalist>
                    <input type="text" class="form-control cost" name="costacc[2222{$k}][unitcost]" value="{$v.unitcost}">
                    <input type="text" class="form-control amount" name="costacc[2222{$k}][amount]" value="{$v.amount}">
                    <input type="text" class="form-control totalval" name="costacc[2222{$k}][total]" value="{$v.total}">
                    <select class="form-control" name="costacc[2222{$k}][type]">
                        <foreach name="kind" key="kk" item="vv">
                            <option value="{$kk}" <?php if ($kk == $v['type']) { echo 'selected'; } ?>>{$vv}</option>
                        </foreach>
                    </select>
                    <input type="hidden" class="form-control" name="costacc[2222{$k}][supplier_id]" value="{$v.supplier_id}" id="2222{$k}_supplierRes_id">
                    <input type="text" class="form-control" name="costacc[2222{$k}][supplier_name]" value="{$v.supplier_name}" id="2222{$k}_supplierRes_name" onfocus="get_supplierRes(2222{$k})">
                    <input type="text" class="form-control longinput" name="costacc[2222{$k}][remark]" value="{$v.remark}">
                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_jsg_{$k}')">删除</a>
                    <?php } else { ?>
                    <span class="title"></span>
                    <input type="hidden" name="resid[2222{$k}][id]" value="{$v.id}">
                    <input type="text" class="form-control" name="costacc[2222{$k}][title]" value="{$v.title}" readonly>
                    <input type="text" class="form-control cost" name="costacc[2222{$k}][unitcost]" value="{$v.unitcost}" readonly>
                    <input type="text" class="form-control amount" name="costacc[2222{$k}][amount]" value="{$v.amount}" readonly>
                    <input type="text" class="form-control totalval" name="costacc[2222{$k}][total]" value="{$v.total}" readonly>
                    <select class="form-control" name="costacc[2222{$k}][type]">
                        <foreach name="kind" key="kk" item="vv">
                            <option value="{$kk}" <?php if ($kk == $v['type']) { echo 'selected'; } ?>>{$vv}</option>
                        </foreach>
                    </select>
                    <input type="hidden" class="form-control" name="costacc[2222{$k}][supplier_id]" value="{$v.supplier_id}" id="2222{$k}_supplierRes_id">
                    <input type="text" class="form-control" name="costacc[2222{$k}][supplier_name]" value="{$v.supplier_name}" id="2222{$k}_supplierRes_name" onfocus="get_supplierRes(2222{$k})" readonly>
                    <input type="text" class="form-control longinput" name="costacc[2222{$k}][remark]" value="{$v.remark}">
                    <?php } ?>
                </div>
                <?php } else { ?>
                <div class="userlist cost_expense" id="costacc_id_js_{$k}">
                    <span class="title"></span>
                    <input type="hidden" name="resid[2222{$k}][id]" value="{$v.id}">
                    <input type="text" class="form-control" name="costacc[2222{$k}][title]" value="{$v.title}" list="2222{$k}_cost_title">
                    <datalist id="2222{$k}_cost_title">
                        <foreach name="op_cost_type" item="ct">
                            <option value="{$ct}" label="" />
                        </foreach>
                    </datalist>
                    <input type="text" class="form-control cost" name="costacc[2222{$k}][unitcost]" value="{$v.unitcost}">
                    <input type="text" class="form-control amount" name="costacc[2222{$k}][amount]" value="{$v.amount}">
                    <input type="text" class="form-control totalval" name="costacc[2222{$k}][total]" value="{$v.total}">
                    <select class="form-control" name="costacc[2222{$k}][type]">
                        <foreach name="kind" key="kk" item="vv">
                            <option value="{$kk}" <?php if ($kk == $v['type']) { echo 'selected'; } ?>>{$vv}</option>
                        </foreach>
                    </select>
                    <input type="hidden" class="form-control" name="costacc[2222{$k}][supplier_id]" value="{$v.supplier_id}" id="2222{$k}_supplierRes_id">
                    <input type="text" class="form-control" name="costacc[2222{$k}][supplier_name]" value="{$v.supplier_name}" id="2222{$k}_supplierRes_name" onfocus="get_supplierRes(2222{$k})">
                    <input type="text" class="form-control longinput" name="costacc[2222{$k}][remark]" value="{$v.remark}">
                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_js_{$k}')">删除</a>
                </div>
                <?php } ?>
            </foreach>
            <?php } else { ?>

            <foreach name="costacc" key="k" item="v">
                <?php
                    if ($v['type'] == 4) { ?>
                <div class="userlist cost_expense" id="costacc_id_aa_{$k}">
                    <span class="title"></span>
                    <input type="hidden" name="resid[888{$k}][id]" value="0">
                    <input type="text" class="form-control" name="costacc[888{$k}][title]" value="{$v.title}" list="888{$k}_cost_title">
                    <datalist id="888{$k}_cost_title">
                        <foreach name="op_cost_type" item="ct">
                            <option value="{$ct}" label="" />
                        </foreach>
                    </datalist>
                    <input type="text" class="form-control cost" name="costacc[888{$k}][unitcost]" value="{$v.unitcost}">
                    <input type="text" class="form-control amount" name="costacc[888{$k}][amount]" value="{$v.amount}">
                    <input type="text" class="form-control totalval" name="costacc[888{$k}][total]" value="{$v.total}">
                    <select class="form-control" name="costacc[888{$k}][type]">
                        <foreach name="kind" key="kk" item="vv">
                            <option value="{$kk}" <?php if ($kk == $v['type']) { echo 'selected'; } ?>>{$vv}</option>
                        </foreach>
                    </select>
                    <input type="hidden" class="form-control" name="costacc[888{$k}][supplier_id]" value="{$v.supplier_id}" id="888{$k}_supplierRes_id">
                    <input type="text" class="form-control" name="costacc[888{$k}][supplier_name]" value="{$v.supplier_name}" id="888{$k}_supplierRes_name" onfocus="get_supplierRes(888{$k})">
                    <input type="text" class="form-control longinput" name="costacc[888{$k}][remark]" value="{$remark}">
                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_aa_{$k}')">删除</a>
                </div>

                <?php } elseif ($v['type'] == 2) { //专家辅导员 ?>
                <?php if (cookie('userid') == 11) { ?>
                <div class="userlist cost_expense" id="costacc_id_ac_{$k}">
                    <span class="title"></span>
                    <input type="hidden" name="resid[7777{$k}][id]" value="0">
                    <input type="text" class="form-control" name="costacc[7777{$k}][title]" value="{$v.title}" list="7777{$k}_cost_title">
                    <datalist id="7777{$k}_cost_title">
                        <foreach name="op_cost_type" item="ct">
                            <option value="{$ct}" label="" />
                        </foreach>
                    </datalist>
                    <input type="text" class="form-control cost" name="costacc[7777{$k}][unitcost]" value="{$v.unitcost}">
                    <input type="text" class="form-control amount" name="costacc[7777{$k}][amount]" value="{$v.amount}">
                    <input type="text" class="form-control totalval" name="costacc[7777{$k}][total]" value="{$v.total}">
                    <select class="form-control" name="costacc[7777{$k}][type]">
                        <foreach name="cost_type" key="kk" item="vv">
                            <option value="{$kk}" <?php if ($v['type'] == $kk) { echo "selected"; } ?>>{$vv}</option>
                        </foreach>
                    </select>
                    <input type="hidden" class="form-control" name="costacc[7777{$k}][supplier_id]" value="{$v.supplier_id}" id="7777{$k}_supplierRes_id">
                    <input type="text" class="form-control" name="costacc[7777{$k}][supplier_name]" value="{$v.supplier_name}" id="7777{$k}_supplierRes_name" onfocus="get_supplierRes(7777{$k})">
                    <input type="text" class="form-control longinput" name="costacc[7777{$k}][remark]" value="{$v.remark}">
                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_ac_{$k}')">删除</a>
                </div>
                <?php } else { ?>
                <div class="userlist cost_expense" id="costacc_id_ac_{$k}">
                    <span class="title"></span>
                    <input type="hidden" name="resid[7777{$k}][id]" value="0">
                    <input type="text" class="form-control" name="costacc[7777{$k}][title]" value="{$v.title}" readonly>
                    <input type="text" class="form-control cost" name="costacc[7777{$k}][unitcost]" value="{$v.unitcost}" readonly>
                    <input type="text" class="form-control amount" name="costacc[7777{$k}][amount]" value="{$v.amount}" readonly>
                    <input type="text" class="form-control totalval" name="costacc[7777{$k}][total]" value="{$v.total}" readonly>
                    <select class="form-control" name="costacc[7777{$k}][type]">
                        <foreach name="cost_type" key="kk" item="vv">
                            <option value="{$kk}" <?php if ($v['type'] == $kk) { echo "selected"; } ?>>{$vv}</option>
                        </foreach>
                    </select>
                    <input type="hidden" class="form-control" name="costacc[7777{$k}][supplier_id]" value="{$v.supplier_id}" id="7777{$k}_supplierRes_id">
                    <input type="text" class="form-control" name="costacc[7777{$k}][supplier_name]" value="{$v.supplier_name}" id="7777{$k}_supplierRes_name" onfocus="get_supplierRes(7777{$k})" readonly disabled>
                    <input type="text" class="form-control longinput" name="costacc[7777{$k}][remark]" value="{$v.remark}" readonly>
                </div>
                <?php } ?>
                <?php } else { ?>
                <div class="userlist cost_expense" id="costacc_id_a_{$k}">
                    <span class="title"></span>
                    <input type="hidden" name="resid[7777{$k}][id]" value="0">
                    <input type="text" class="form-control" name="costacc[7777{$k}][title]" value="{$v.title}" list="7777{$k}_cost_title">
                    <datalist id="7777{$k}_cost_title">
                        <foreach name="op_cost_type" item="ct">
                            <option value="{$ct}" label="" />
                        </foreach>
                    </datalist>
                    <input type="text" class="form-control cost" name="costacc[7777{$k}][unitcost]" value="{$v.unitcost}">
                    <input type="text" class="form-control amount" name="costacc[7777{$k}][amount]" value="{$v.amount}">
                    <input type="text" class="form-control totalval" name="costacc[7777{$k}][total]" value="{$v.total}">
                    <select class="form-control" name="costacc[7777{$k}][type]">
                        <foreach name="cost_type" key="kk" item="vv">
                            <option value="{$kk}" <?php if ($v['type'] == $kk) { echo "selected"; } ?>>{$vv}</option>
                        </foreach>
                    </select>
                    <input type="hidden" class="form-control" name="costacc[7777{$k}][supplier_id]" value="{$v.supplier_id}" id="7777{$k}_supplierRes_id">
                    <input type="text" class="form-control" name="costacc[7777{$k}][supplier_name]" value="{$v.supplier_name}" id="7777{$k}_supplierRes_name" onfocus="get_supplierRes(7777{$k})" onfocus="get_supplierRes(7777{$k})">
                    <input type="text" class="form-control longinput" name="costacc[7777{$k}][remark]" value="{$v.remark}">
                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_a_{$k}')">删除</a>
                </div>
                <?php } ?>
            </foreach>
            <?php } ?>

        </div>
        <div id="setcostacc_sum">
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
            <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_costacc()"><i class="fa fa-fw fa-plus"></i> 新增结算项</a>
        </div>
        <div class="form-group">&nbsp;</div>
    </div>

    <div class="content" style="padding-bottom:50px;">
        <input type="hidden" name="info[op_id]" value="{$op.op_id}" />
        <input type="hidden" name="info[name]" value="{$op.project}" />
        <input type="hidden" name="settlement" value="{$settlement.id}" />
        <input type="hidden" name="info[budget]" id="costaccsumval" value="">
        <div style="width:100%; float:left;">
            <div class="form-group col-md-4">
                <label>实际人数：</label>
                <input type="text" name="info[renshu]" id="renshu" class="form-control" value="{$settlement.renshu}" onBlur="lilv()" />
            </div>

            <div class="form-group col-md-4">
                <label>实际收入：</label>
                <?php if ($is_dijie) { ?>
                <input type="text" name="info[shouru]" id="shouru" class="form-control" value="{$should_back_money}" onBlur="lilv()" />
                <?php } else { ?>
                <?php if ($op['create_time'] < strtotime('20190101')) { ?>
                <!--兼容之前的旧数据手动填写-->
                <input type="text" name="info[shouru]" id="shouru" class="form-control" value="{$settlement.shouru}" onBlur="lilv()" />
                <?php } else { ?>
                <input type="text" name="info[shouru]" id="shouru" class="form-control" value="{$should_back_money}" onBlur="lilv()" readonly />
                <?php } ?>
                <?php } ?>
            </div>
            <div class="form-group col-md-4">
                <!--
            <label>是否签订合同：</label>
            <select class="form-control" name="info[hetong]">
            	<option value="0" <?php if ($settlement['hetong'] == 0) { echo 'selected'; } ?> >未签订合同</option>
                <option value="1" <?php if ($settlement['hetong'] == 1) { echo 'selected'; } ?>>已签订合同</option>
            </select>
            -->
            </div>
        </div>
        <div style="width:100%;float:left;">
            <div class="form-group col-md-4">
                <label>毛利：</label>
                <input type="text" name="info[maoli]" id="maoli" class="form-control" value="{$settlement.maoli}" />
            </div>

            <div class="form-group col-md-4">
                <label>毛利率：</label>
                <input type="text" name="info[maolilv]" id="maolilv" class="form-control" value="{$settlement.maolilv}" />
            </div>

            <div class="form-group col-md-4">
                <label>人均毛利：</label>
                <input type="text" name="info[renjunmaoli]" id="renjunmaoli" class="form-control" value="{$settlement.renjunmaoli}" />
            </div>
        </div>

    </div>

    <div class="content" style="border-top:2px solid #f39c12; margin-top:20px; padding-bottom:20px;">
        <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="33.33%">审批状态：{$op.showstatus}</td>
                <td width="33.33%">审批人：{$op.show_user}</td>
                <td width="33.33%">审批时间：{$op.show_time}</td>
            </tr>
            <?php if ($op['show_reason']) { ?>
            <tr>
                <td colspan="3">审批说明：{$op.show_reason}</td>
            </tr>
            <?php } ?>
        </table>
    </div>

</form>