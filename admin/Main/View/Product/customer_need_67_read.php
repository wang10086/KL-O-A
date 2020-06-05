<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php if ($need || $detail){ ?>
            <div class="content">
                <div class="form-group col-md-12">
                    <P class="border-bottom-line"> 研发方案需求</P>
                    <div class="form-group col-md-6">
                        <label>类型： {$need['type'] ? $need['type'] : $detail['type']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>领域：{$need['field'] ? $need['field'] : $detail['field']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>受众群体：{$need['group'] ? $need['group'] : $detail['group']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>预估周期：{$need['cycle'] ? $need['cycle'] : $detail['cycle']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>面积与高度：{$need['area'] ? $need['area'] : $detail['area']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>其他：{$need['other'] ? $need['other'] : $detail['other']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>建设方案初稿提交时间：<?php echo $need['pro_time'] ? date('Y-m-d',$need['pro_time']) : ($detail['pro_time'] ? date('Y-m-d',$detail['pro_time']) : ''); ?></label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>项目成本初稿提交时间：<?php echo $need['costacc_time'] ? date('Y-m-d',$need['costacc_time']) : ($detail['costacc_time'] ? date('Y-m-d',$detail['costacc_time']) : ''); ?></label>
                    </div>

                    <div class="form-group col-md-12">
                        <label>项目建设诉求（客户沟通内容）：{$need['content'] ? $need['content'] : $detail['content']}</label>
                    </div>

                    <P class="border-bottom-line"> 资源管理需求</P>
                    <div class="form-group col-md-6">
                        <label>院所支持需求：{$need['ins_need'] ? $need['ins_need'] : $detail['ins_need']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>专家级别需求：{$need['expert_need'] ? $need['expert_need'] : $detail['expert_need']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>现场踏勘需求：{$need['site_need'] ? $need['site_need'] : $detail['site_need']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>效果设计需求：{$need['design_need'] ? $need['design_need'] : $detail['design_need']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>招投标需求：{$need['bidding_need'] ? $need['bidding_need'] : $detail['bidding_need']}</label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>后期服务需求：{$need['service_need'] ? $need['service_need'] : $detail['service_need']}</label>
                    </div>

                    <div class="form-group col-md-12">
                        <label>其他需求：{$need['other_condition'] ? $need['other_condition'] : $detail['other_condition']}</label>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="content">
                <div class="form-group col-md-12">
                    暂无客户需求信息!
                </div>
            </div>
        <?php } ?>
    </div><!-- /.box-body -->
</div>