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
            <div class="col-md-8">
                <p>项目名称：{$op.project}</p>
            </div>

            <div class="col-md-4">
                <p>评分次数：{$average.score_num}&emsp;次</p>
            </div>

            <div class="form-group col-md-4">
                <p>住宿：{$average.stay}&emsp;分</p>
            </div>

            <div class="form-group col-md-4">
                <p>用餐：{$average.food}&emsp;分</p>
            </div>

            <div class="form-group col-md-4">
                <p>车况：{$average.bus}&emsp;分</p>
            </div>

            <div class="form-group col-md-4">
                <p>行程安排：{$average.travel}&emsp;分</p>
            </div>

            <div class="form-group col-md-4">
                <p>活动内容：{$average.content}&emsp;分</p>
            </div>

            <div class="form-group col-md-4">
                <p>司机服务：{$average.driver}&emsp;分</p>
            </div>

            <div class="form-group col-md-4">
                <p>辅导员/领队：{$average.guide}&emsp;分</p>
            </div>

            <div class="form-group col-md-4">
                <p>教师/专家：{$average.teacher}&emsp;分</p>
            </div>
        </div>

    </div>

</div><!--/.col (right) -->