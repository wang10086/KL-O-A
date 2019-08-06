<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        顾客满意度详情
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">顾客满意度</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">顾客满意度信息</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" data="o.status">团号</th>
                                        <th class="sorting" data="o.project" width="160">项目名称</th>
                                        <th class="sorting" data="c.dep_time">实施日期</th>
                                        <th class="sorting" data="c.ret_time">结束日期</th>
                                        <th class="sorting" data="o.number">人数</th>
                                         <th class="sorting" data="o.sale_user">业务人员</th>
                                        <th class="sorting" data="o.guide_manager">调查人员</th>
                                        <th class="taskOptions" width="80" data="o.charity_status">满意度状态</th>
                                        <th class="taskOptions" width="80" data="">得分率</th>
                                        <if condition="rolemenu(array('Inspect/score_info'))">
                                        <th class="taskOptions">详情</th>
                                        </if>
                                    </tr>

                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td><?php if($row['status']==1){ echo "<span class='green'>".$row['group_id']."</span>";}elseif($row['status']==2){ echo "<span class='red' title='".$row['nogroup']."'>不成团</span>";}else{ echo '未成团';} ?></td>
                                        <td><div class="tdbox_long"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td><if condition="$row.dep_time neq 0">{$row.dep_time|date='Y-m-d',###}</if></td>
                                        <td><if condition="$row.ret_time neq 0">{$row.ret_time|date='Y-m-d',###}</if></td>
                                        <td>{$row.number}人</td>
                                        <td>{$row.sale_user}</td>
                                        <td>{$row.guide_manager}</td>
                                        <td><div class="tdbox_long taskOptions" style="width:80px">{$row.score_stu}</div></td>
                                        <td class="taskOptions">{$row.op_average}</td>
                                        <if condition="rolemenu(array('Inspect/score_info'))">
                                        <td class="taskOptions">
                                        <!--<a href="{:U('Inspect/user_kpi_score_info',array('opid'=>$row['op_id'],'ut'=>$usertype))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>-->
                                        <button onclick="show_user_kpi_score_info({$row.op_id},'{$usertype}')" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></button>
                                        </td>
                                        </if>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td colspan="2">项目总数：{$data.op_num}</td>
                                        <td colspan="3">有相关维度项目数/项目总数：<?php echo $data['score_num'].'/'.$data['op_num']; ?></td>
                                        <td colspan="3">已调查顾客满意度：{$data.score_average}</td>
                                        <td colspan="2">总顾客满意度：{$data.complete}</td>
                                    </tr>
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->


            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Inspect">
                <input type="hidden" name="a" value="public_user_kpi_satisfied">
                <input type="hidden" name="year" value="{$year}">
                <input type="hidden" name="month" value="{$month}">
                <input type="hidden" name="uid" value="{$uid}">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="id" placeholder="编号">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>

                </form>
            </div>

<include file="Index:footer2" />

<script type="text/javascript">
    function show_user_kpi_score_info(op_id,usertype) {
        art.dialog.open('index.php?m=Main&c=Inspect&a=public_user_kpi_score_info&opid='+op_id+'&ut='+usertype,{
            lock:true,
            title: '客户分项满意度详情',
            width:'80%',
            height:'80%',
            fixed: true,

        });
    }
</script>
