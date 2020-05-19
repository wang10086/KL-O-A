<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-4">
                    <label>客户单位： {$detail.customer} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>参与人数：{$detail.num} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动世间：{$detail.in_time} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>所在年级：{$detail.grade} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>选定的课题研究方向：{$detail.field} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>涉及学科：{$detail.subject}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>课题类型：{$detail.pro_type}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>活动地点：{$detail.pro_addr}</label>
                </div>

                <P class="border-bottom-line"> 专家资源信息</P>
                <div class="form-group col-md-12">
                    <label>所需专家级别： {$detail.expert_level} </label>
                </div>

                <P class="border-bottom-line"> 成果要求信息</P>
                <div class="form-group col-md-12">
                    <label>成果形式： {$detail.resulted} </label>
                </div>

                <div class="form-group col-md-12">
                    <label>是否参加科技竞赛： {$detail.match}；如：{$detail.other_match} </label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他市场设计需求：{$detail.other_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>