<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pagetitle}
                        <small>{$_action_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$pagetitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$year}年员工统计</h3>
                                    <if condition="rolemenu(array('Rbac/adduser'))">
                                    <div class="box-tools pull-right">
                                    	<!--<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',400,120);"><i class="fa fa-search"></i> 搜索</a>-->
                                    </div>
                                    </if>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                    <?php if($prveyear>2018){ ?>
                                        <a href="{:U('Rbac/chart_personnel',array('year'=>$prveyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                    <?php } ?>
                                    <?php
                                        for($i=1;$i<13;$i++){
                                            $par = array();
                                            $par['year']  	= $year;
                                            $par['month'] 	= str_pad($i,2,"0",STR_PAD_LEFT);
                                            if($month==str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Rbac/chart_personnel',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Rbac/chart_personnel',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                    ?>
                                    <?php if($year<date('Y')){ ?>
                                        <a href="{:U('Rbac/chart_personnel',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                    <?php } ?>
                                </div>

								<table class="table table-bordered dataTable" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="80">周期</th>
                                        <th class="taskOptions">类别</th>
                                        <th class="taskOptions">公司</th>
                                        <th class="taskOptions">京区业务中心</th>
                                        <th class="taskOptions">京外业务中心</th>
                                        <th class="taskOptions">南京项目部</th>
                                        <th class="taskOptions">武汉项目部</th>
                                        <th class="taskOptions">沈阳项目部</th>
                                        <th class="taskOptions">长春项目部</th>
                                        <th class="taskOptions">市场部</th>
                                        <th class="taskOptions">常规业务中心</th>
                                        <th class="taskOptions">机关部门</th>
                                    </tr>
                                    <foreach name="thisMonthData" key="k" item="v">
                                        <tr>
                                            <?php if ($k=='员工人数'){ ?>
                                            <td class="taskOptions" rowspan="10">{$month}月</td>
                                            <?php } ?>
                                            <td class="taskOptions">{$k}</td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['公司']['uids']))}">{$v['公司']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['京区业务中心']['uids']))}">{$v['京区业务中心']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['京外业务中心']['uids']))}">{$v['京外业务中心']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['南京项目部']['uids']))}">{$v['南京项目部']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['武汉项目部']['uids']))}">{$v['武汉项目部']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['沈阳项目部']['uids']))}">{$v['沈阳项目部']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['长春项目部']['uids']))}">{$v['长春项目部']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['市场部']['uids']))}">{$v['市场部']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['常规业务中心']['uids']))}">{$v['常规业务中心']['num']}</a></td>
                                            <td class="taskOptions"><a href="{:U('Rbac/public_chart_personnel_detail',array('year'=>$year,'month'=>$month,'uids'=>$v['机关部门']['uids']))}">{$v['机关部门']['num']}</a></td>
                                        </tr>
                                    </foreach>
                                    <foreach name="sumMonthData" key="k" item="v">
                                        <tr>
                                            <?php if ($k=='员工人数'){ ?>
                                                <td class="taskOptions" rowspan="10">{$year}年01月 - {$month}月</td>
                                            <?php } ?>
                                            <td class="taskOptions">{$k}</td>
                                            <td class="taskOptions">{$v['公司']['num']}</td>
                                            <td class="taskOptions">{$v['京区业务中心']['num']}</td>
                                            <td class="taskOptions">{$v['京外业务中心']['num']}</td>
                                            <td class="taskOptions">{$v['南京项目部']['num']}</td>
                                            <td class="taskOptions">{$v['武汉项目部']['num']}</td>
                                            <td class="taskOptions">{$v['沈阳项目部']['num']}</td>
                                            <td class="taskOptions">{$v['长春项目部']['num']}</td>
                                            <td class="taskOptions">{$v['市场部']['num']}</td>
                                            <td class="taskOptions">{$v['常规业务中心']['num']}</td>
                                            <td class="taskOptions">{$v['机关部门']['num']}</td>
                                        </tr>
                                    </foreach>
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
                <input type="hidden" name="c" value="Rbac">
                <input type="hidden" name="a" value="chart_personnel">
                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="key" placeholder="人员名称关键字">
                </div>
                </form>
            </div>

<include file="Index:footer2" />
