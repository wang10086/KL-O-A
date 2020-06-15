<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">项目交接实施表</h3>
            </div>
            <div class="box-body">
                <div class="content">

                    <form method="post" action="{:U('Op/handover')}" name="myform" id="myform">
                        <input type="hidden" name="dosubmint" value="1" />
                        <input type="hidden" name="savetype" value="1" />
                        <input type="hidden" name="opid" value="{$list.op_id}" />
                        <input type="hidden" name="id" value="{$handover_list.id}" />

                        <!-----------------------------------start----------------------------------------->
                        <div class="content" style="padding-top:0px;">
                            <div id="costacc">
                                <div class="userlist">
                                    <div class="unitbox">活动日期</div>
                                    <div class="unitbox">活动时间</div>
                                    <div class="unitbox">活动地点</div>
                                    <div class="unitbox">活动安排</div>
                                    <div class="unitbox">物资情况</div>
                                    <div class="unitbox">注意事项</div>
                                    <div class="unitbox">项目负责人</div>
                                    <div class="unitbox">备注</div>
                                </div>

                                <foreach name="costacc" key="k" item="v">
                                    <div class="userlist cost_expense" id="costacc_id_b_{$k}">
                                        <span class="title"><?php echo $k+1; ?></span>
                                        <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" >
                                        <input type="hidden" class="form-control" name="costacc[888{$k}][supplier_id]" value="{$v.supplier_id}">
                                        <input type="hidden" class="form-control" name="costacc[888{$k}][supplier_name]" value="{$v.supplier_name}">
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
                            <!--<div id="costacc_sum">
                                <div class="userlist">
                                    <div class="unitbox"></div>
                                    <div class="unitbox"></div>
                                    <div class="unitbox" style="  text-align:right;">合计</div>
                                    <div class="unitbox" id="costaccsum"></div>
                                    <div class="unitbox longinput"></div>
                                </div>
                            </div>-->
                            <div id="costacc_val">1</div>
                            <div class="form-group col-md-12" id="useraddbtns" style="margin-left:15px;">
                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="/*add_costacc();*/ art_show_msg('开发中...')"><i class="fa fa-fw fa-plus"></i> 新增交接项</a>
                            </div>
                            <div class="form-group">&nbsp;</div>
                        </div>

                        <!--<div class="content">
                            <input type="hidden" name="info[op_id]" value="{$op.op_id}" />
                            <input type="hidden" name="info[name]" value="{$op.project}" />
                            <input type="hidden" name="info[budget]" id="costaccsumval" value="{$op.costacc}" />
                            <input type="hidden" name="info[untraffic_sum]" id="untraffic_sum" value="{$budget.untraffic_sum}" />
                            <input type="hidden" name="budget" value="{$budget.id}" />
                            <div style="width:100%; float:left;">
                                <div class="form-group col-md-4">
                                    <label>人数：</label>
                                    <input type="text" name="info[renshu]" id="renshu" class="form-control" value="<?php /*if($budget['renshu']){ echo $budget['renshu'];}else{ echo $op['number'];} */?>" onBlur="lilv()" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>预算收入：</label>
                                    <input type="text" name="info[shouru]" id="shouru" class="form-control" value="<?php /*if($budget['shouru']){ echo $budget['shouru'];}else{ echo 0;} */?>" onBlur="lilv(),untraffic_lilv()"/>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>收入性质：</label>
                                    <div style="margin-top:5px;">
                                        <input type="checkbox" name="xinzhi[]" <?php /*if(in_array('单位',$budget['xz'])){ echo 'checked';} */?> value="单位"> 单位 &nbsp;&nbsp;
                                        <input type="checkbox" name="xinzhi[]" <?php /*if(in_array('个人',$budget['xz'])){ echo 'checked';} */?> value="个人"> 个人 &nbsp;&nbsp;
                                        <input type="checkbox" name="xinzhi[]" <?php /*if(in_array('政府',$budget['xz'])){ echo 'checked';} */?> value="政府"> 政府 &nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>

                            <div style="width:100%; float:left;">
                                <div class="form-group col-md-4">
                                    <label>毛利：</label>
                                    <input type="text" name="info[maoli]" id="maoli" class="form-control" value="{$budget.maoli}" />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>组团方毛利（<span class="" id="zt">{$maoli_rate.zt_rate}</span>）：</label>
                                    <input type="hidden" name="info[zt_rate]" id="zt_rate" value="{$maoli_rate['zt_rate']}" />
                                    <input type="text" name="info[zt_maoli]" id="zt_maoli" class="form-control" value="{$budget.zt_maoli}" readonly />
                                </div>

                                <div class="form-group col-md-4">
                                    <label>接待方毛利（<span class="" id="dj">{$maoli_rate.dj_rate}</span>）：</label>
                                    <input type="hidden" name="info[dj_rate]" id="dj_rate" value="{$maoli_rate['dj_rate']}" />
                                    <input type="text" name="info[dj_maoli]" id="dj_maoli" class="form-control" value="{$budget.dj_maoli}" readonly />
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
                                    <input type="text" name="info[untraffic_shouru]" id="untraffic_shouru" class="form-control" value="{$budget.untraffic_shouru}" readonly />
                                </div>

                                <div class="form-group col-md-3">
                                    <label>毛利率(不含大交通)：</label>
                                    <input type="text" name="info[untraffic_maolilv]" id="untraffic_maolilv" class="form-control" value="{$budget.untraffic_maolilv}" readonly />
                                </div>
                            </div>
                        </div>-->
                        <!------------------------------------end------------------------------------------>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{:U('Op/public_save')}" name="myform" id="submitForm">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="savetype" value="26">
    <input type="hidden" name="opid" value="{$list.op_id}">
    <input type="hidden" name="id" value="{$handover_list.id}">
</form>

<div id="formsbtn">
    <button type="button" class="btn btn-info btn-lg" id="lrpd" onclick="$('#myform').submit()">保存</button>
    <?php if ($handover_list['id'] && in_array($handover_list['audit_status'], array(0,2))){ ?>
        <button type="button" class="btn btn-warning btn-lg" id="lrpd" onclick="$('#submitForm').submit()" >提交</button>
    <?php } ?>
</div>