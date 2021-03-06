<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-6">
                    <label>预约院所： {$detail.institutes} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>预约时间：<?php echo $detail['time'] ? date('Y-m-d',$detail['time']) : ''; ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>参观内容：{$detail.content} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>参观时长：{$detail.long} </label>
                </div>

                <div class="form-group col-md-12">
                    <label>是否接受调剂同领域/同级别其他专家：<?php echo $detail['adjust']==1 ? '是' : '否'; ?></label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他相关需求：{$detail.other_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>