<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">评分详情</h3>
        <!--<h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>-->
    </div>
    <div class="box-body">
        <div class="content">
            <table class="table table-bordered dataTable fontmini" id="tablelist" >
                <tr role="row" class="orders" >
                    <th class="sorting" width="80" data="c.in_begin_day">活动日期</th>
                    <th class="sorting" data="c.address">活动地点</th>
                    <th>联系方式</th>
                    <th class="sorting" data="s.stay">住宿</th>
                    <th class="sorting" data="s.food">餐</th>
                    <th class="sorting" data="s.bus">车</th>
                    <th class="sorting" data="s.travel">行程安排</th>
                    <th class="sorting" data="s.content">活动内容</th>
                    <th class="sorting" data="s.driver">司机服务</th>
                    <th class="sorting" data="s.guide">辅导员/领队</th>
                    <th class="sorting" data="s.teacher">教师/专家</th>
                    <th>意见建议</th>
                    <th>处理结果</th>
                    <th width="40" class="taskOptions">详情</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr>
                        <td>{$row.in_begin_day|date="Y-m-d",###} - {$row.in_day|date="Y-m-d",###}</td>
                        <td>{$row.address}</a></td>
                        <td>{$row.mobile}</td>
                        <td>{$score_stu.$row[stay]}</td>
                        <td>{$score_stu.$row[food]}</td>
                        <td>{$score_stu.$row[bus]}</td>
                        <td>{$score_stu.$row[travel]}</td>
                        <td>{$score_stu.$row[content]}</td>
                        <td>{$score_stu.$row[driver]}</td>
                        <td>{$score_stu.$row[guide]}</td>
                        <td>{$score_stu.$row[teacher]}</td>
                        <td>{$row['suggest']}</td>
                        <td>{$row.status}</td>

                        <td class="taskOptions">
                            <button class="btn btn-info btn-smsm" onclick="show_score({$row.id})"><i class="fa fa-pencil"></i></button>
                        </td>

                    </tr>
                </foreach>
            </table>
        </div>

    </div>

</div><!--/.col (right) -->

<script type="text/javascript">

    function show_score(id) {
        art.dialog.open('index.php?m=Main&c=Inspect&a=score_detail&id='+id,{
            lock:true,
            title: '客户满意度详情',
            width:800,
            height:'90%',
            fixed: true,

        });
    }

</script>