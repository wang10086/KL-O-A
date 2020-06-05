<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php if ($need || $detail){ ?>
            <div class="content">
                <div class="form-group col-md-12">
                    <P class="border-bottom-line"> 基本信息</P>
                    <div class="form-group col-md-6">
                        <label>讲座时间： <?php echo  $need ? ($need['time'] ? date('Y-m-d H:i:s',$need['time']) : '') : ($detail['time'] ? date('Y-m-d H:i:s',$detail['time']) : ''); ?> </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>讲座时长：{$need ? $need['long'] : $detail['long']} </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>讲座地点：{$need ? $need['addr'] : $detail['addr']} </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>学校硬件设备：{$need ? $need['equipment'] : $detail['equipment']} </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>讲座领域或题目：{$need ? $need['field'] : $detail['field']} </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>专家库：{$need ? $need['expert_type'] : $detail['expert_type']} </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>专家级别：{$need ? $need['expert_level'] : $detail['expert_level']} </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>是否指定专家：<?php echo $need ? ($need['is_sure_expert']==1 ? '是；指定专家姓名：'.$need['expert_name'] : '否') : ($detail['is_sure_expert']==1 ? '是；指定专家姓名：'.$detail['expert_name'] : '否'); ?> </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>专家费用：{$need ? $need['cost'] : $detail['cost']} 元 </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>接送：<?php echo $need ? ($need['is_transfer']==1 ? '是' : '否') : ($detail['is_transfer']==1 ? '是' : '否'); ?> </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>讲座形式：{$need ? $need['type'] : $detail['type']} </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label>是否接受调剂同领域/同级别其他专家：<?php echo $need ? ($need['adjust']==1 ? '是' : '否') : ($detail['adjust']==1 ? '是' : '否'); ?></label>
                    </div>

                    <div class="form-group col-md-12">
                        <label>其他相关需求：{$need ? $need['other_condition'] : $detail['other_condition']}</label>
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