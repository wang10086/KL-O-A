<div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                            <div class="form-group col-md-12">
                                                <div class="form-group col-md-4">
                                                    <label>活动标题：{$list.title}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>销售支持类型：{$types[$list['type']]}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>客户单位： {$list.customer}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>开始时间：{$list.st_time|date='Y-m-d',###}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>结束时间：{$list.et_time|date='Y-m-d',###}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>活动负责人：{$list.blame_name}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>计划费用(元)：{$list.cost}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>目的地：{$pro_list.addr}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>期望目的：{$pro_list.hope}</label>
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label>是否需要爱借款：{$pro_list['jiekaun']==1 ? '<span class="red">需要</span>' : '不需要'}</label>
                                                </div>

                                                <div class="form-group col-md-8">
                                                    <label>活动安排：{$pro_list.content}</label>
                                                </div>

                                                <P class="border-bottom-line"> 活动预算 </P>
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
                                                            </tr>
                                                        </foreach>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>

                            <?php if ($pro_list['audit_status'] == 3 && in_array(cookie('userid'),array(1,11,$pro_list['audit_uid']))){ ?>
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">审核</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="content">
                                            <form method="post" action="{:U('Customer/public_save_process')}" id="audit_form">
                                                <input type="hidden" name="dosubmint" value="1">
                                                <input type="hidden" name="saveType" value="7">
                                                <input type="hidden" name="id" value="{$pro_list.id}">

                                                <div class="form-group box-float-12">
                                                    <label class="">审核意见：</label>
                                                    <input type="radio" name="status" value="1"> &#8194;审核通过 &#12288;&#12288;&#12288;
                                                    <input type="radio" name="status" value="2"> &#8194;审核不通过
                                                </div>

                                                <div class="form-group box-float-12">
                                                    <label>备注</label>
                                                    <textarea class="form-control" name="audit_remark"></textarea>
                                                </div>

                                                <div id="formsbtn">
                                                    <button type="button" class="btn btn-info btn-sm" onclick="$('#audit_form').submit()">保存</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div>
                            <?php } ?>
