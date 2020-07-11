<div class="form-group col-md-12"  >
    <label class="lit-title" >需求记录</label>
        <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
            <tr role="row" class="orders" >
                <th class="sorting" data="" width="80">日期</th>
                <th class="sorting" data="">活动地点</th>
                <!--<th class="sorting" data="">职务信息</th>
                <th class="sorting" data="">职能类型</th>-->
                <th class="sorting" data="">所属领域</th>
                <th class="sorting" data="" width="50">天数</th>
                <th class="sorting" data="" width="50">人数</th>
                <th class="sorting" data="" width="80">单次价格</th>
                <th class="sorting" data="" width="80">合计价格</th>
                <th class="sorting" data="">备注</th>
                <if condition="rolemenu(array('Op/edit_tcs_need'))">
                    <th width="60" class="taskOptions">编辑</th>
                </if>
            </tr>
            <foreach name="{guide_price}" item="row">
                <tr>
                    <input type="hidden" name="confirm_id" value="{$row.cid}">
                    <input type="hidden" name="price_id" value="{$row.pid}">
                    <td>
                    <if condition="$row.in_begin_day neq 0">
                        {$row.in_begin_day|date='Y-m-d',###} - {$row.in_day|date='Y-m-d',###}
                        <else />
                        {$row.in_day|date='Y-m-d',###}
                    </if>
                    </td>
                    <td>{$row.address}</td>
                    <!--<td>{$row.zhiwu}</td>
                    <td>{$row.zhineng}</td>-->
                    <td>{$fields[$row['field']]}</td>
                    <td>{$row.days}</td>
                    <td>{$row.num}</td>
                    <td>&yen;{$row.price}</td>
                    <td>&yen;{$row.total}</td>
                    <td>{$row.remark}</td>
                    <if condition="rolemenu(array('Op/edit_tcs_need'))">
                        <td class="taskOptions">
                            <?php if ($row['guide_status'] == 1){ ?>
                                <a href="javascript:;" onClick="art_show_msg('本次需求已安排辅导员,需求信息不可更改',3)" ><button onClick="javascript:;" title="修改" class="btn btn-default btn-smsm"><i class="fa fa-pencil"></i></button></a>
                            <?php }else{ ?>
                                <a href="javascript:;" onClick="upd_tcs_need({$row.cid},{$row.op_id})" ><button onClick="javascript:;" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button></a>
                            <?php } ?>
                        </td>
                    </if>
                </tr>
            </foreach>
        </table>
    </div>
        <div class="col-md-12"></div>
