<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-4">
                    <label>客户单位： {$need ? $need['customer'] : $detail['customer']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>参与人数：{$need ? $need['num'] : $detail['num']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动时间：{$need ? $need['in_time'] : $detail['in_time']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>所在年级：{$need ? $need['grade'] : $detail['grade']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>选定的课题研究方向：{$need ? $need['field'] : $detail['field']} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>涉及学科：{$need ? $need['subject'] : $detail['subject']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>课题类型：{$need ? $need['pro_type'] : $detail['pro_type']}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>活动地点：{$need ? $need['pro_addr'] : $detail['pro_addr']}</label>
                </div>

                <P class="border-bottom-line"> 专家资源信息</P>
                <div class="form-group col-md-12">
                    <label>所需专家级别： {$need ? $need['expert_level'] : $detail['expert_level']} </label>
                </div>

                <P class="border-bottom-line"> 成果要求信息</P>
                <div class="form-group col-md-12">
                    <label>成果形式： {$need ? $need['resulted'] : $detail['resulted']} </label>
                </div>

                <div class="form-group col-md-12">
                    <label>是否参加科技竞赛： {$need ? $need['match'] : $detail['match']}；如：{$need ? $need['other_match'] : $detail['other_match']} </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他相关需求：{$need ? $need['other_condition'] : $detail['other_condition']}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>