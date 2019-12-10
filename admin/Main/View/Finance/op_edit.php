<form method="post" action="{:U('Finance/save_appcost')}" name="myform" id="save_appcost">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
    <div class="content" style="padding-top:0px;">
        <div id="costacc">
            <div class="userlist">
                <div class="unitbox">费用项</div>
                <div class="unitbox">单价</div>
                <div class="unitbox">数量</div>
                <div class="unitbox">合计</div>
                <div class="unitbox">类型</div>
                <div class="unitbox longinput">备注</div>
            </div>

            <foreach name="costacc" key="k" item="v">
            <div class="userlist cost_expense" id="costacc_id_b_{$k}">
                <span class="title"><?php echo $k+1; ?></span>
                <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" >
                <input type="text" class="form-control" name="costacc[888{$k}][title]" value="{$v.title}">
                <input type="text" class="form-control cost" name="costacc[888{$k}][unitcost]" value="{$v.unitcost}">
                <input type="text" class="form-control amount" name="costacc[888{$k}][amount]" value="{$v.amount}">
                <input type="text" class="form-control totalval" name="costacc[888{$k}][total]" value="{$v.total}">
                <select class="form-control costaccType"  name="costacc[888{$k}][type]" >
                    <foreach name="kind" key="kk" item="vv">
                    <option value="{$kk}" <?php if($kk==$v['type']){ echo 'selected';} ?> >{$vv}</option>
                    </foreach>
                </select>
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
            <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_costacc()"><i class="fa fa-fw fa-plus"></i> 新增预算项</a>
        </div>
        <div class="form-group">&nbsp;</div>
    </div>




    <div class="content">
        <input type="hidden" name="info[op_id]" value="{$op.op_id}" />
        <input type="hidden" name="info[name]" value="{$op.project}" />
        <input type="hidden" name="info[budget]" id="costaccsumval" value="{$op.costacc}" />
        <input type="hidden" name="info[untraffic_sum]" id="untraffic_sum" value="{$budget.untraffic_sum}" />
        <input type="hidden" name="budget" value="{$budget.id}" />
        <div style="width:100%; float:left;">
            <div class="form-group col-md-3">
                <label>人数：</label>
                <input type="text" name="info[renshu]" id="renshu" class="form-control" value="<?php if($budget['renshu']){ echo $budget['renshu'];}else{ echo $op['number'];} ?>" onBlur="lilv()" />
            </div>

            <div class="form-group col-md-3">
                <label>预算收入：</label>
                <input type="text" name="info[shouru]" id="shouru" class="form-control" value="<?php if($budget['shouru']){ echo $budget['shouru'];}else{ echo 0;} ?>" onBlur="lilv(),untraffic_lilv()"/>
            </div>

            <div class="form-group col-md-3">
                <label>收入性质：</label>
                <div style="margin-top:5px;">
                    <input type="checkbox" name="xinzhi[]" <?php if(in_array('单位',$budget['xz'])){ echo 'checked';} ?> value="单位"> 单位 &nbsp;&nbsp;
                    <input type="checkbox" name="xinzhi[]" <?php if(in_array('个人',$budget['xz'])){ echo 'checked';} ?> value="个人"> 个人 &nbsp;&nbsp;
                    <input type="checkbox" name="xinzhi[]" <?php if(in_array('政府',$budget['xz'])){ echo 'checked';} ?> value="政府"> 政府 &nbsp;&nbsp;
                </div>
            </div>

            <div class="form-group col-md-3">
                <label>毛利：</label>
                <input type="text" name="info[maoli]" id="maoli" class="form-control" value="{$budget.maoli}" />
            </div>
        </div>
        <div style="width:100%;float:left; padding-bottom:50px;">
            <div class="form-group col-md-3">
                <label>毛利率：</label>
                <input type="text" name="info[maolilv]" id="maolilv" class="form-control" value="{$budget.maolilv}" />
            </div>

            <div class="form-group col-md-3">
                <label>人均毛利：</label>
                <input type="text" name="info[renjunmaoli]" id="renjunmaoli" class="form-control" value="{$budget.renjunmaoli}" />
            </div>

            <div class="form-group col-md-3">
                <label>收入(不含大交通)：</label>
                <!--<input type="text" name="info[untraffic_maoli]" id="untraffic_maoli" class="form-control" value="{$budget.untraffic_maoli}" />-->
                <input type="text" name="info[untraffic_shouru]" id="untraffic_shouru" class="form-control" value="{$budget.untraffic_shouru}" readonly />
            </div>

            <div class="form-group col-md-3">
                <label>毛利率(不含大交通)：</label>
                <input type="text" name="info[untraffic_maolilv]" id="untraffic_maolilv" class="form-control" value="{$budget.untraffic_maolilv}" readonly />
            </div>
        </div>
    </div>

    <!--回款计划-->
    <?php if($is_dijie==0){ ?> <!--排除地接团-->
        <div class="content" style="padding-top:0px;">
            <h2 style="font-size:16px; border-bottom:2px solid #dedede; padding-bottom:10px;"> <span class="black">回款计划</span> (应回款总金额:<span id="sum_money_return"></span>元)</h2>
            <div class="callout callout-danger">
                <h4>提示！一般情况应做到：</h4>
                <p>1、在业务实施前回款不小于70%；</p>
                <p>2、在业务实施结束后10个工作日收回全部尾款；</p>
            </div>
            <div class="form-group col-md-12" id="payment">
                <div class="userlist">
                    <div class="unitbox_15">回款金额(元)</div>
                    <div class="unitbox_15">回款比例(%)</div>
                    <div class="unitbox_15">计划回款时间</div>
                    <div class="unitbox_15">收款方</div>
                    <div class="unitbox_15">回款方式</div>
                    <div class="unitbox_25">备注</div>
                </div>
                <?php if($pays){ ?>
                    <foreach name="pays" key="kk" item="pp">
                        <div class="userlist" id="pretium_8888{$pp.id}">
                            <span class="title"><?php echo $kk+1; ?></span>
                            <input type="hidden" name="payment[8888{$pp.id}][no]" class="payno"  value="{$pp.no}">
                            <input type="hidden" class="form-control" name="payment[8888{$pp.id}][pid]" value="{$pp.id}">
                            <div class="f_15">
                                <input type="text" class="form-control money_back_amount" name="payment[8888{$pp.id}][amount]" onblur="check_ratio('8888'+{$pp.id},$(this).val())" value="{$pp.amount}">
                            </div>
                            <div class="f_15">
                                <input type="text" class="form-control" name="payment[8888{$pp.id}][ratio]" value="{$pp.ratio}">
                            </div>
                            <div class="f_15">
                                <input type="text" class="form-control inputdate"  name="payment[8888{$pp.id}][return_time]" value="<if condition="$pp['return_time']">{$pp.return_time|date='Y-m-d',###}</if>">
                            </div>
                            <div class="f_15">
                                <select class="form-control" name="payment[8888{$pp.id}][company]" >
                                    <foreach name="company" key="k" item="v">
                                        <option value="{$k}" <?php if ($pp['company']==$k) echo 'selected'; ?>>{$v}</option>
                                    </foreach>
                                </select>
                            </div>
                            <div class="f_15">
                                <select class="form-control" name="payment[8888{$pp.id}][type]" >
                                    <foreach name="type" key="k" item="v">
                                        <option value="{$k}" <?php if ($pp['type']==$k) echo "selected"; ?>>{$v}</option>
                                    </foreach>
                                </select>
                            </div>
                            <div class="f_25">
                                <input type="text" class="form-control" name="payment[8888{$pp.id}][remarks]" value="{$pp.remark}">
                            </div>

                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_8888{$pp.id}')">删除</a>
                        </div>
                    </foreach>
                <?php }else{ ?>
                    <div class="userlist" id="pretium_id">
                        <span class="title">1</span>
                        <input type="hidden" name="payment[1][no]" class="payno" value="1">
                        <div class="f_15">
                            <input type="text" class="form-control money_back_amount" name="payment[1][amount]" onblur="check_ratio($(this).parent('div').prev().val(),$(this).val())" value="">
                        </div>
                        <div class="f_15">
                            <input type="text" class="form-control" name="payment[1][ratio]" value="">
                        </div>
                        <div class="f_15">
                            <input type="text" class="form-control inputdate"  name="payment[1][return_time]" value="">
                        </div>
                        <div class="f_15">
                            <select class="form-control" name="payment[1][company]">
                                <foreach name="company" key="k" item="v">
                                    <option value="{$k}">{$v}</option>
                                </foreach>
                            </select>
                        </div>
                        <div class="f_15">
                            <select class="form-control" name="payment[1][type]">
                                <foreach name="type" key="k" item="v">
                                    <option value="{$k}">{$v}</option>
                                </foreach>
                            </select>
                        </div>
                        <div class="f_25">
                            <input type="text" class="form-control" name="payment[1][remarks]" value="">
                        </div>

                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                    </div>
                <?php } ?>
            </div>
            <div id="payment_val">1</div>
            <div class="form-group col-md-12" id="useraddbtns">
                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加回款信息</a>
                <!--<input type="submit" class="btn btn-info btn-sm" value="保存">-->
            </div>
            <div class="form-group">&nbsp;</div>
        </div>
    <?php } ?>
</form>

    
     <div class="content line-warning"  style="padding-bottom:20px;">
        <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td width="33.33%">审批状态：{$op.showstatus}</td>
                <td width="33.33%">审批人：{$op.show_user}</td>
                <td width="33.33%">审批时间：{$op.show_time}</td>
            </tr>
            <?php if($op['show_reason']){ ?>
            <tr>
                <td colspan="3">审批说明：{$op.show_reason}</td>
            </tr>
            <?php } ?>
        </table>
    </div>

<script type="text/javascript">

</script>


