<div class="row">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">项目交接实施表</h3>
            </div>
            <div class="box-body">
                <div class="content">
                    <?php if (!$confirm || $confirm['ret_time'] > time()){  ?>
                        <form method="post" action="{:U('Op/handover')}" name="myform" id="myform">
                            <input type="hidden" name="dosubmint" value="1" />
                            <input type="hidden" name="savetype" value="1" />
                            <input type="hidden" name="opid" value="{$list.op_id}" />
                            <input type="hidden" name="id" value="{$handover_list.id}" />

                            <P class="border-bottom-line"> 交接清单是否交接</P>
                            <foreach name="handover_types" key="kk" item="vv">
                                <div class="form-group col-md-4">
                                    <label>{$vv}：</label>
                                    <input type="radio" name="data[{$kk}]" value="1" <?php if ($handover_list && $handover_list[$kk]==1) echo 'checked'; ?>> &#8194;是 &#12288;
                                    <input type="radio" name="data[{$kk}]" value="0" <?php if ($handover_list && $handover_list[$kk]==0) echo 'checked'; ?>> &#8194;否
                                </div>
                            </foreach>

                            <P class="border-bottom-line"> 项目交接实施表</P>
                            <div id="task_timu">
                                <?php if (!$days){ ?>
                                    <div class="daylist" id="task_ti_id_1">
                                        <a class="aui_close" href="javascript:;" style="right:25px;" onclick="del_timu('task_ti_id_1')">×</a>
                                        <div class="col-md-12 pd">
                                            <label class="titou"><strong>第<span class="tihao">1</span>项</strong></label>
                                            <div class="form-group input-group-3"> <input type="text" name="info[1][day]" class="form-control inputdate" value="" placeholder="活动日期" /> </div>
                                            <div class="form-group input-group-3 ml4r"> <input type="text" name="info[1][in_time]" class="form-control inputdate_b" value="" placeholder="活动时间" /> </div>
                                            <div class="form-group input-group-3 ml4r"> <input type="text" name="info[1][addr]" class="form-control" value="" placeholder="活动地点" /> </div>
                                            <div class="form-group input-group-3"> <input type="text" name="info[1][plan]" class="form-control" value="" placeholder="活动安排" /> </div>
                                            <div class="form-group input-group-3 ml4r"> <input type="text" name="info[1][material]" class="form-control" value="" placeholder="物资情况" /> </div>
                                            <div class="form-group input-group-3 ml4r"> <input type="text" name="info[1][blame]" class="form-control" value="" placeholder="项目负责人" /> </div>
                                            <div class="input-group"><input type="text" placeholder="注意事项" name="info[1][note]" value="" class="form-control"></div>
                                            <div class="input-group pads"><textarea class="form-control" placeholder="备注" name="info[1][remark]"></textarea></div>
                                        </div>
                                    </div>
                                    <div style="display:none" id="task_val">1</div>
                                <?php }else{ ?>
                                    <foreach name="days" key="k" item="v">
                                        <div class="daylist" id="task_ti_id_{$k}">
                                            <a class="aui_close" href="javascript:;" style="right:25px;" onclick="del_timu('task_ti_id_{$k}')">×</a>
                                            <div class="col-md-12 pd">
                                                <label class="titou"><strong>第<span class="tihao"><?php echo $k+1; ?></span>项</strong></label>
                                                <div class="form-group input-group-3"> <input type="text" name="info[8888{$v.id}][day]" class="form-control inputdate" value="{$v[day] ? date('Y-m-d',$v['day']) : ''}" placeholder="活动日期" /> </div>
                                                <div class="form-group input-group-3 ml4r"> <input type="text" name="info[8888{$v.id}][in_time]" class="form-control inputdate_b" value="<?php echo ($v['st_time'] || $v['et_time']) ? (date('H:i:s',$v['st_time']).' - '.date('H:i:s',$v['et_time'])) : ''; ?>" placeholder="活动时间" /> </div>
                                                <div class="form-group input-group-3 ml4r"> <input type="text" name="info[8888{$v.id}][addr]" class="form-control" value="{$v.addr}" placeholder="活动地点" /> </div>
                                                <div class="form-group input-group-3"> <input type="text" name="info[8888{$v.id}][plan]" class="form-control" value="{$v.plan}" placeholder="活动安排" /> </div>
                                                <div class="form-group input-group-3 ml4r"> <input type="text" name="info[8888{$v.id}][material]" class="form-control" value="{$v.material}" placeholder="物资情况" /> </div>
                                                <div class="form-group input-group-3 ml4r"> <input type="text" name="info[8888{$v.id}][blame]" class="form-control" value="{$v.blame}" placeholder="项目负责人" /> </div>
                                                <div class="input-group"><input type="text" placeholder="注意事项" name="info[8888{$v.id}][note]" value="{$v.note}" class="form-control"></div>
                                                <div class="input-group pads"><textarea class="form-control" placeholder="备注" name="info[8888{$v.id}][remark]">{$v.remark}</textarea></div>
                                            </div>
                                        </div>
                                    </foreach>
                                    <div style="display:none" id="task_val"><?php echo count(days); ?></div>
                                <?php } ?>
                            </div>

                            <div class="form-group col-md-12" id="addti_btn">
                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="task(1)" ><i class="fa fa-fw  fa-plus"></i> 新增交接项</a>
                                <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:public_save('myform','<?php /*echo U('Op/public_save_handover'); */?>');">保存</a>-->
                            </div>
                        </form>
                    <?php }else{ ?>
                        <form method="post" action="{:U('Op/public_save_handover')}" name="myform" id="myform">
                            <input type="hidden" name="dosubmint" value="1" />
                            <input type="hidden" name="savetype" value="1" />
                            <input type="hidden" name="opid" value="{$list.op_id}" />
                            <input type="hidden" name="id" value="{$handover_list.id}" />

                            <P class="border-bottom-line"> 交接清单是否交回</P>
                            <foreach name="handover_types" key="kk" item="vv">
                                <div class="form-group col-md-4">
                                    <label>{$vv}：</label>
                                    <input type="radio" name="data[{$kk}1]" value="1" <?php $key= $kk.'1'; if ($handover_list && $handover_list[$key]==1) echo 'checked'; ?>> &#8194;是 &#12288;
                                    <input type="radio" name="data[{$kk}1]" value="0" <?php $key= $kk.'1'; if ($handover_list && $handover_list[$key]==0) echo 'checked'; ?>> &#8194;否
                                </div>
                            </foreach>
                        </form>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div id="formsbtn">
    <button type="button" class="btn btn-info btn-lg" id="lrpd" onclick="$('#myform').submit()">保存</button>
</div>