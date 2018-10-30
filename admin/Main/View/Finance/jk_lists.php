
    <?php if($audit_yusuan && $costacc){ ?>
        <div class="content" style="padding-top:0px;">
            <table class="table table-striped" id="font-14-p">
                <thead>
                    <tr>
                        <th width="">费用项</th>
                        <th width="">单价</th>
                        <th width="">数量</th>
                        <th width="">合计</th>
                        <th width="">类型</th>
                        <th width="">备注</th>
                        <th width="">借款</th>
                    </tr>
                </thead>
                <tbody>
                    <foreach name="costacc" key="k" item="v">
                    <tr class="userlist" id="supplier_id_103">
                        <td width="16.66%">{$v.title}</td>
                        <td width="16.66%">&yen; {$v.unitcost}</td>
                        <td width="16.66%">{$v.amount}</td>
                        <td width="16.66%">&yen; {$v.total}</td>
                        <td width="16.66%"><?php echo $kind[$v['type']]; ?></td>
                        <td>{$v.remark}</td>
                        <td width="80">
                            <a href="javascript:;" class="btn btn-info btn-sm" onclick="get_jiekuan">借款</a>
                            <input type="hidden" name="id" value="{$v.id}">
                            <input type="hidden" name="total" value="{$v.total}">
                        </td>
                    </tr>
                    </foreach>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-size:16px; color:#ff3300;">&yen; {$budget.budget}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form action="">
            <div class="content">
                <input type="hidden" name="info[op_id]" value="{$op.op_id}" />
                <div style="width:100%; float:left;">
                    <div class="form-group col-md-6">
                        <label>项目名称：</label>
                        <input type="text" class="form-control" value="<?php  ?>" />
                    </div>

                    <div class="form-group col-md-6">
                        <label>借款金额：</label>
                        <input type="text" name="info[shouru]" id="shouru" class="form-control" value="<?php if($budget['shouru']){ echo $budget['shouru'];}else{ echo 0;} ?>" />
                    </div>
                </div>
                <!--<div style="width:100%;float:left; padding-bottom:50px;">
                    <div class="form-group col-md-4">
                        <label>毛利：</label>
                        <input type="text" name="info[maoli]" id="maoli" class="form-control" value="{$budget.maoli}" />
                    </div>

                    <div class="form-group col-md-4">
                        <label>毛利率：</label>
                        <input type="text" name="info[maolilv]" id="maolilv" class="form-control" value="{$budget.maolilv}" />
                    </div>

                    <div class="form-group col-md-4">
                        <label>人均毛利：</label>
                        <input type="text" name="info[renjunmaoli]" id="renjunmaoli" class="form-control" value="{$budget.renjunmaoli}" />
                    </div>
                </div>-->


            </div>
        </form>

    <?php }else{ ?>
            <div class="content" style="margin-left:15px;">该项目尚未做预算！</div>
    <?php }  ?>

    <script>

    </script>
