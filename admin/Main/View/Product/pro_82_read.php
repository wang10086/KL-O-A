<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">详细信息</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 研发方案需求</P>
                <div class="form-group col-md-4">
                    <label>活动时间：{$detail.time|date='Y-m-d',###} {$detail.st_time|date='H:i:s',###} - {$detail.et_time|date='H:i:s',###}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>活动总人数：{$detail.member}人</label>
                </div>

                <div class="form-group col-md-4">
                    <label>班级数量：{$detail.class_num}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>班级人数：{$detail.class_stu_num}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>课题数量：{$detail.lession_num}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>课题领域：{$detail.lession_field}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>课题安排：{$detail.lession_plan}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>分组要求：每班分{$detail.lession_group}组</label>
                </div>

                <div class="form-group col-md-4">
                    <label>踩点需求：<?php echo $detail[foot]==1 ? '是' :'否'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>科学第一课：<?php echo $detail['is_first_lession']==1 ? '是，地点：'.$detail['addr1'].'，时间：'.date('Y-m-d',$detail['time1']).',时长：'.$detail['long1'].'小时' : '否'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>课题前课：<?php echo $detail['is_lession_before']==1 ? '是，地点：'.$detail['addr2'].'，时间：'.date('Y-m-d',$detail['time2']).',时长：'.$detail['long2'].'小时' : '否'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>答辩：<?php echo $detail['is_defence']==1 ? '是，地点：'.$detail['addr3'].'，时间：'.date('Y-m-d',$detail['time3']).',时长：'.$detail['long3'].'小时' : '否'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>其他研发需求：{$detail.other_yf_condition}</label>
                </div>

                <P class="border-bottom-line"> 资源管理需求</P>
                <div class="form-group col-md-4">
                    <label>辅导员数量：{$detail.guide_num} 人</label>
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员要求：{$detail.guide_condition}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>辅导员费用：{$detail.guide_cost}</label>
                </div>

                <div class="form-group col-md-12">
                    <label>辅导员数量：{$detail.other_zy_condition}</label>
                </div>

                <P class="border-bottom-line"> 计调物资需求</P>
                <div class="form-group col-md-4">
                    <label>物资需求：{$detail.material} </label>
                </div>

                <div class="form-group col-md-4">
                    <label>场地信息：{$detail.yard}</label>
                </div>

                <div class="form-group col-md-4">
                    <label>保险：{$detail.safe_remark}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>大巴车：<?php echo $detail['is_need_bus']==1 ? '需要，数量：'.$detail['bus_num'].'，座位数：'.$detail['bus_seat'].'，要求：'.$detail['bus_other'] : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>餐食：<?php echo $detail['is_need_food']==1 ? '需要，数量：'.$detail['food_num'].'，价格：'.$detail['food_price'] : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他计调物资需求：{$detail.other_jd_condition}</label>
                </div>

                <P class="border-bottom-line"> 市场设计需求</P>
                <div class="form-group col-md-6">
                    <label>科学海报：<?php echo $detail['is_need_poster']==1 ? '需要，数量：'.$detail['food_num'].'，价格：'.$detail['food_price'] : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-6">
                    <label>手册要求：<?php echo $detail['is_need_manual']==1 ? '需要，数量：'.$detail['manual_num'].'，页数：'.$detail['page_num'] : '不需要'; ?></label>
                </div>

                <div class="form-group col-md-12">
                    <label>其他设计需求：{$detail.other_sj_condition}</label>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>