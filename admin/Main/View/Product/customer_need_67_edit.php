<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">

            <form method="post" action="{:U('Product/public_save_customer_need')}" name="myform" id="detailForm">
                <input type="hidden" name="dosubmit" value="1">
                <input type="hidden" name="savetype" value="5">
                <input type="hidden" name="id" value="{$need.id}">
                <input type="hidden" name="opid" value="{$list.op_id}">

                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>类型：</label>
                    <select name="data[type]" class="form-control">
                        <option value="">==请选择==</option>
                        <option value="实验室" <?php if ($need ? ($need['type']=='实验室') : ($detail['type']=='实验室')) echo "selected"; ?>>实验室</option>
                        <option value="科普基地" <?php if ($need ? ($need['type']=='科普基地') : ($detail['type']=='科普基地')) echo "selected"; ?>>科普基地</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>领域：</label>
                    <input type="text" name="data[field]"  value="{$need['field'] ? $need['field'] : $detail['field']}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>受众群体：</label>
                    <input type="text" name="data[group]"  value="{$need['group'] ? $need['group'] : $detail['group']}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>预估周期：</label>
                    <input type="text" name="data[cycle]"  value="{$need['cycle'] ? $need['cycle'] : $detail['cycle']}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>面积与高度：</label>
                    <input type="text" name="data[area]"  value="{$need['area'] ? $need['area'] : $detail['area']}" class="form-control"  />
                </div>

                <div class="form-group col-md-4">
                    <label>建设方案初稿提交时间：</label>
                    <input type="text" class="form-control inputdate" name="data[pro_time]" value="<?php echo $need['pro_time'] ? date('Y-m-d',$need['pro_time']) : ($detail['pro_time'] ? date('Y-m-d',$detail['pro_time']) : ''); ?>" />
                </div>

                <div class="form-group col-md-4">
                    <label>项目成本初稿提交时间：</label>
                    <input type="text" class="form-control inputdate" name="data[costacc_time]" value="<?php echo $need['costacc_time'] ? date('Y-m-d',$need['costacc_time']) : ($detail['costacc_time'] ? date('Y-m-d',$detail['costacc_time']) : ''); ?>" />
                </div>

                <div class="form-group col-md-8">
                    <label>其他：</label>
                    <input type="text" name="data[other]"  value="{$need['other'] ? $need['other'] : $detail['other']}" class="form-control"  />
                </div>

                <div class="form-group col-md-12">
                    <label>项目建设诉求 ：<font color="#999">（客户沟通内容）</font></label>
                    <textarea class="form-control"  name="data[content]">{$need ? $need['content'] : $detail['content']}</textarea>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>院所支持需求</label><input type="text" name="data[ins_need]"  value="{$need['ins_need'] ? $need['ins_need'] : $detail['ins_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>专家级别需求</label><input type="text" name="data[expert_need]"  value="{$need['expert_need'] ? $need['expert_need'] : $detail['expert_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>现场踏勘需求</label><input type="text" name="data[site_need]"  value="{$need['site_need'] ? $need['site_need'] : $detail['site_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>效果设计需求</label><input type="text" name="data[design_need]"  value="{$need['design_need'] ? $need['design_need'] : $detail['design_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>招投标需求</label><input type="text" name="data[bidding_need]"  value="{$need['bidding_need'] ? $need['bidding_need'] : $detail['bidding_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                    <label>后期服务需求</label><input type="text" name="data[service_need]"  value="{$need['service_need'] ? $need['service_need'] : $detail['service_need']}" class="form-control" />
                </div>

                <div class="form-group col-md-12">
                    <label>其他需求</label>
                    <textarea class="form-control"  name="data[other_condition]" rows="5">{$need ? $need['other_condition'] : $detail['other_condition']}</textarea>
                </div>
            </form>

            <div id="formsbtn">
                <button type="button" class="btn btn-info btn-sm" onclick="$('#detailForm').submit()">保存</button>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>