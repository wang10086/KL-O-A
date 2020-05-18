<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-6">
                    <label>类型： {$detail.type}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>领域：{$detail.field}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>受众群体：{$detail.group}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>预估周期：{$detail.cycle}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>面积与高度：{$detail.area}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他：{$detail.other}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>建设方案初稿提交时间：<?php echo $detail['pro_time'] ? date('Y-m-d',$detail['pro_time']): ''; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>项目成本初稿提交时间：<?php echo $detail['costacc_time'] ? date('Y-m-d',$detail['costacc_time']): ''; ?></label>
                </div>

                <div class="form-group col-md-12">
                    <label>项目建设诉求（客户沟通内容）：{$detail.content}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-6">
                    <label>院所支持需求：{$detail.ins_need}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>专家级别需求：{$detail.expert_need}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>现场踏勘需求：{$detail.site_need}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>效果设计需求：{$detail.design_need}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>招投标需求：{$detail.bidding_need}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>后期服务需求：{$detail.service_need}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他需求：{$detail.other_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>