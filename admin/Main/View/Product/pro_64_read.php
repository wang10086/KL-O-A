<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 基本信息</P>
                <div class="form-group col-md-6">
                    <label>讲座时间： <?php echo  $detail['time'] ? date('Y-m-d H:i:s',$detail['time']) : ''; ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>讲座时长：{$detail.long} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>讲座地点：{$detail.addr} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>学校硬件设备：{$detail.equipment} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>讲座领域或题目：{$detail.field} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>专家库：{$detail.expert_type} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>专家级别：{$detail.expert_level} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>是否指定专家：<?php echo $detail['is_sure_expert']==1 ? '是；指定专家姓名：'.$detail['expert_name'] : '否'; ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>专家费用：{$detail.cost} 元 </label>
                </div>

                <div class="form-group col-md-6">
                    <label>接送：<?php echo $detail['is_transfer']==1 ? '是' : '否'; ?> </label>
                </div>

                <div class="form-group col-md-6">
                    <label>讲座形式：{$detail.type} </label>
                </div>

                <div class="form-group col-md-6">
                    <label>是否接受调剂同领域/同级别其他专家：<?php echo $detail['adjust']==1 ? '是' : '否'; ?></label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他相关需求：{$detail.other_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>