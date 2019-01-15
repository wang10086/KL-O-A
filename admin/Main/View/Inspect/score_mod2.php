<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">评分详情</h3>
        <!--<h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>-->
    </div>
    <div class="box-body">
        <div class="content">
            <div class="form-group" style="margin-bottom: 50px;">
                <div class="col-md-2">
                    <span class="score-black">分值说明：</span>
                </div>
                <div class="col-md-2">
                    <span>5分=>非常满意</span>
                </div>
                <div class="col-md-2">
                    <span>4分=>满意</span>
                </div>
                <div class="col-md-2">
                    <span>3分=>较满意</span>
                </div>
                <div class="col-md-2">
                    <span>2分=>较不满意</span>
                </div>
                <div class="col-md-2">
                    <span>1分=>非常不满意</span>
                </div>
            </div>
            <table class="table table-bordered dataTable fontmini" id="tablelist" >
                <tr role="row" class="orders" >
                    <th class="sorting" width="80" data="c.in_begin_day">活动日期</th>
                    <th class="sorting" data="c.address">活动地点</th>
                    <th>联系方式</th>
                    <?php if (in_array($kind,$score_kind2)){ ?>
                        <th class="sorting" data="s.before_sell">前期沟通</th>
                        <th class="sorting" data="s.depth">课程深度</th>
                        <th class="sorting" data="s.major">课程专业性</th>
                        <th class="sorting" data="s.interest">课程趣味性</th>
                        <th class="sorting" data="s.material">材料及设备</th>
                        <th class="sorting" data="s.teacher">专家/讲师</th>
                        <th class="sorting" data="s.guide">辅导员</th>
                        <!--<th class="sorting" data="s.late">迟到早退(教务人员)</th>
                        <th class="sorting" data="s.manage">管理组织能力(教务人员)</th>
                        <th class="sorting" data="s.morality">师德仪表(教务人员)</th>-->
                    <?php }elseif(in_array($kind,$score_kind3)){ ?>
                        <th class="sorting" data="s.before_sell">前期沟通</th>
                        <th class="sorting" data="s.new_media">新媒体推广</th>
                        <th class="sorting" data="s.major">内容专业性</th>
                        <th class="sorting" data="s.stay">住宿</th>
                        <th class="sorting" data="s.food">餐</th>
                        <th class="sorting" data="s.travel">场地</th>
                        <th class="sorting" data="s.bus">车</th>
                        <th class="sorting" data="s.driver">司机服务</th>
                        <th class="sorting" data="s.guide">辅导员/领队</th>
                        <th class="sorting" data="s.material">材料及设备</th>
                    <?php }else{ ?>
                        <th class="sorting" data="s.before_sell">前期沟通</th>
                        <th class="sorting" data="s.stay">住宿</th>
                        <th class="sorting" data="s.food">餐</th>
                        <th class="sorting" data="s.bus">车</th>
                        <th class="sorting" data="s.travel">行程安排</th>
                        <th class="sorting" data="s.content">活动内容</th>
                        <th class="sorting" data="s.driver">司机服务</th>
                        <th class="sorting" data="s.guide">辅导员/领队</th>
                        <th class="sorting" data="s.teacher">教师/专家</th>
                    <?php } ?>
                    <th>意见建议</th>
                    <!--<th>处理结果</th>-->
                    <th width="40" class="taskOptions">详情</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr>
                        <td>{$row.in_begin_day|date="Y-m-d",###} - {$row.in_day|date="Y-m-d",###}</td>
                        <td>{$row.address}</a></td>
                        <td>{$row.mobile}</td>
                        <?php if (in_array($kind,$score_kind2)){ ?>
                            <td>{$row.before_sell}</td>
                            <td>{$row.depth}</td>
                            <td>{$row.major}</td>
                            <td>{$row.interest}</td>
                            <td>{$row.material}</td>
                            <td>{$row.teacher}</td>
                            <td>{$row.guide}</td>
                            <!--<td>{$row.late}</td>
                            <td>{$row.manage}</td>
                            <td>{$row.morality}</td>-->
                        <?php }elseif(in_array($kind,$score_kind3)){ ?>
                            <td>{$row.before_sell}</td>
                            <td>{$row.new_media}</td>
                            <td>{$row.major}</td>
                            <td>{$row.stay}</td>
                            <td>{$row.food}</td>
                            <td>{$row.travel}</td>
                            <td>{$row.bus}</td>
                            <td>{$row.driver}</td>
                            <td>{$row.guide}</td>
                            <td>{$row.material}</td>
                        <?php }else{ ?>
                            <td>{$row.before_sell}</td>
                            <td>{$row.stay}</td>
                            <td>{$row.food}</td>
                            <td>{$row.bus}</td>
                            <td>{$row.travel}</td>
                            <td>{$row.content}</td>
                            <td>{$row.driver}</td>
                            <td>{$row.guide}</td>
                            <td>{$row.teacher}</td>
                        <?php } ?>
                        <td>{$row['suggest']}</td>
                        <!--<td>{$row.status}</td>-->

                        <td class="taskOptions">
                            <if condition="rolemenu(array('Inspect/score_detail'))">
                                <button class="btn btn-info btn-smsm" onclick="show_score({$row.id})"><i class="fa fa-bars"></i></button>
                            </if>
                        </td>

                    </tr>
                </foreach>
            </table>
        </div>

    </div>

    <div class="box-footer clearfix">
        <div class="pagestyle">{$pages}</div>
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