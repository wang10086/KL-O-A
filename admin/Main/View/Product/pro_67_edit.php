<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="12">
                <input type="hidden" name="need_id" value="{$list.id}">
                <input type="hidden" name="id" value="{$detail.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <!--是否标准化-->
                <include file="is_standard" />

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>类型：</label>
                    <select name="data[type]" class="form-control">
                        <option value="">==请选择==</option>
                        <option value="实验室" <?php if ($detail['type']=='实验室') echo "selected"; ?>>实验室</option>
                        <option value="科普基地" <?php if ($detail['type']=='科普基地') echo "selected"; ?>>科普基地</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>领域：</label>
                    <input type="text" name="data[field]"  value="{$detail.field}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>受众群体：</label>
                    <input type="text" name="data[group]"  value="{$detail.group}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>预估周期：</label>
                    <input type="text" name="data[cycle]"  value="{$detail.cycle}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>面积与高度：</label>
                    <input type="text" name="data[area]"  value="{$detail.area}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>建设方案初稿提交时间：</label>
                    <input type="text" class="form-control inputdate" name="data[pro_time]" value="{$detail.pro_time|date='Y-m-d',###}" />
                </div>

                <div class="form-group col-md-4">
                    <label>项目成本初稿提交时间：</label>
                    <input type="text" class="form-control inputdate" name="data[costacc_time]" value="{$detail.costacc_time|date='Y-m-d',###}" />
                </div>

                <div class="form-group col-md-8">
                    <label>其他：</label>
                    <input type="text" name="data[other]"  value="{$detail.other}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>项目建设诉求 ：<font color="#999">（客户沟通内容）</font></label>
                    <textarea class="form-control"  name="data[content]">{$detail.content}</textarea>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>院所支持需求</label><input type="text" name="data[ins_need]"  value="{$detail['ins_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>专家级别需求</label><input type="text" name="data[expert_need]"  value="{$detail['expert_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>现场踏勘需求</label><input type="text" name="data[site_need]"  value="{$detail['site_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>效果设计需求</label><input type="text" name="data[design_need]"  value="{$detail['design_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>招投标需求</label><input type="text" name="data[bidding_need]"  value="{$detail['bidding_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>后期服务需求</label><input type="text" name="data[service_need]"  value="{$detail['service_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他需求</label>
                    <textarea class="form-control"  name="data[other_condition]" rows="5">{$detail.other_condition}</textarea>
                </div>
            </form>

            <form method="post" action="{:U('Product/public_save')}" name="myform" id="submitForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="7">
                <input type="hidden" name="id" value="{$list.id}">
            </form>

            <!--保存 提交按钮-->
            <include file="pro_submit_btns" />

            <!--<div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
                <?php /*if ($detail['id'] && $list['process'] == 0){ */?>
                    <button type="button" class="btn btn-warning btn-sm" onclick="$('#submitForm').submit()" >提交</button>
                <?php /*} */?>
            </div>-->
        </div>
    </div><!-- /.box-body -->
</div>