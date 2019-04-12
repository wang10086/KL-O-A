<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">综合评分
            <if condition="$op['group_id']">
                <span style="font-weight:normal; color:#ff3300;">（团号：{$op.group_id}）</span>
                <else />
                <span style="font-weight:normal; color:#ff3300;">（团号：未成团)</span>
            </if>
        </h3>
        <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
    </div>
    <div class="box-body">
        <div class="content">
            <?php if ($average['score_num'] != 0){ ?>
                <div class="form-group" style="margin-bottom: 50px;">
                    <div class="col-md-4">
                        <p><span class="score-black">项目名称：</span>{$op.project}</p>
                    </div>

                    <div class="col-md-4">
                        <p><span class="score-black">评分次数：</span>{$average.score_num}&emsp;次</p>
                    </div>

                    <div class="col-md-4">
                        <p><span class="score-black">总得分率：</span>{$average.sum_score}</p>
                    </div>
                </div>

                <?php if ($usertype == 'jd'){ ?> <!--计调-->
                    <div class="form-group col-md-4">
                        <p>住宿：{$average.stay}&emsp;分</p>
                    </div>

                    <div class="form-group col-md-4">
                        <p>用餐：{$average.food}&emsp;分</p>
                    </div>

                    <div class="form-group col-md-4">
                        <p>行程安排：{$average.travel}&emsp;分</p>
                    </div>

                    <div class="form-group col-md-4">
                        <p>车况：{$average.bus}&emsp;分</p>
                    </div>

                    <div class="form-group col-md-4">
                        <p>司机服务：{$average.driver}&emsp;分</p>
                    </div>
                <?php }elseif($usertype == 'yf'){ ?> <!--研发-->
                    <div class="form-group col-md-4">
                        <p>课程深度：{$average.depth}&emsp;分</p>
                    </div>

                    <div class="form-group col-md-4">
                        <p>课程专业性：{$average.major}&emsp;分</p>
                    </div>

                    <div class="form-group col-md-4">
                        <p>课程趣味性：{$average.interest}&emsp;分</p>
                    </div>

                    <div class="form-group col-md-4">
                        <p>材料及设备：{$average.material}&emsp;分</p>
                    </div>

                    <!--<div class="form-group col-md-4">
                        <p>内容专业性：{$average.content}&emsp;分</p>
                    </div>-->
                <?php }elseif($usertype == 'zy'){ ?> <!--资源-->
                    <div class="form-group col-md-4">
                        <p>场地：{$average.travel}&emsp;分</p>
                    </div>
                <?php } ?>
            <?php }else{ ?>
                <div style="text-align: center;margin: 2rem;">
                    暂无相关维度评分信息
                </div>
            <?php } ?>
        </div>

    </div>

</div><!--/.col (right) -->