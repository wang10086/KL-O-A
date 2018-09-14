<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>客户满意度</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Inspect/record')}"><i class="fa fa-gift"></i> 客户满意度</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                         <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">客户满意度追责</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
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
                                                <if condition="rolemenu(array('Inspect/blame'))">
                                                    <th width="40" class="taskOptions">追责</th>
                                                </if>
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
                                                    <if condition="rolemenu(array('Inspect/blame'))">
                                                        <td class="taskOptions">
                                                            <!--<a href="{:U('Inspect/',array())}" title="追责" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>-->
                                                            <button class="btn btn-info btn-smsm" onclick="show_form({$row.confirm_id},{$row.score_id})"><i class="fa fa-pencil"></i></button>
                                                        </td>
                                                    </if>

                                                </tr>
                                            </foreach>
                                        </table>
                                    </div>


                                    <div class="" id="zhuize">
                                        <form method="post" action="{:U('Inspect/blame')}" name="myform" id="myform">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="confirm_id">
                                            <input type="hidden" name="score_id">

                                            <div class="form-group col-md-12">
                                                <label>问题原因：</label>
                                                <textarea name="info[problem]"  class="form-control" style="height:100px;" required>{$row.problem}</textarea>
                                            </div>

                                            <div class="form-group col-md-12" style="margin-top:15px;">
                                                <div class="checkboxlist" id="problemcheckbox">
                                                <input type="radio" name="info[solve]" value="0" <?php if($row['problem']==0){ echo 'checked';} ?> > 未解决
                                                &nbsp;&nbsp;
                                                <input type="radio" name="info[solve]" value="1" <?php if($row['problem']==1){ echo 'checked';} ?> > 已解决
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 issolvebox" <?php if($row['solve']==1){ echo ' style="display:none;"';} ?>>
                                                <textarea name="info[resolvent]"  class="form-control"  placeholder="解决方案" style="height:100px;">{$row.resolvent}</textarea>
                                            </div>
                                        
                                            <div style="width:100%; text-align:center; margin-top:30px;">
                                                <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                            </div>
                                        </form>

                                </div>
                            </div>

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script>
	$(document).ready(function(e) {
		$('#zhuize').hide();

        $('#problemcheckbox').find('ins').each(function(index, element){
            $(this).click(function () {
                if(index==0){
                    $('.issolvebox').hide();
                }else{
                    $('.issolvebox').show();
                }
            })
        })

	});

    function show_form(confirm_id,score_id){
        $('#zhuize').show();
        $('.issolvebox').hide();
        $('input[name="confirm_id"]').val(confirm_id);
        $('input[name="score_id"]').val(score_id);

    }

	
</script>
		