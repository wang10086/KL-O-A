<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>合同统计<small>季度统计</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">合同统计</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <a href="{:U('Contract/public_statis')}" class="btn <?php echo ACTION_NAME == 'statis' ? 'btn-info' : 'btn-default';  ?>" style="padding:8px 18px;">月度</a>
                                <a href="{:U('Contract/public_statis_quarter')}" class="btn <?php echo ACTION_NAME == 'statis_quarter' ? 'btn-info' : 'btn-default';  ?>" style="padding:8px 18px;">季度</a>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">合同统计</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                        <?php if($prveyear>2017){ ?>
                                            <a href="{:U('Contract/public_statis_quarter',array('year'=>$prveyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<5;$i++){
                                            $par = array();
                                            $par['year']  = $year;
                                            $par['quarter'] = $i;
                                            if($quarter==$i){
                                                echo '<a href="'.U('Contract/public_statis_quarter',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                            }else{
                                                echo '<a href="'.U('Contract/public_statis_quarter',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Contract/public_statis_quarter',array('year'=>$nextyear,'month'=>'01'))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="" data="">业务部门</th>
                                            <th class="taskOptions" width="" data="">项目数量</th>
                                            <th class="taskOptions" width="" data="">签合同项目数量</th>
                                            <th class="taskOptions" width="" data="">合同份数</th>
                                            <th class="taskOptions" width="" data="">合同签订率</th>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td class="taskOptions"><a href="{:U('Contract/public_department_quarter_detail',array('year'=>$year,'quarter'=>$quarter,'month'=>$month,'id'=>$row[id]))}" title="查看部门合同信息">{$row.department}</a></td>
                                            <td class="taskOptions">{$row.op_num}</td>
                                            <td class="taskOptions">{$row.contract_num}</td>
                                            <td class="taskOptions">{$row.}</td>
                                            <td class="taskOptions">{$row.average}</td>
                                        </tr>
                                        </foreach>
                                        <tr>
                                            <td class="taskOptions black">{$sum.name}</td>
                                            <td class="taskOptions black">{$sum.op_num}</td>
                                            <td class="taskOptions black">{$sum.contract_num}</td>
                                            <td class="taskOptions black">{$sum.}</td>
                                            <td class="taskOptions black">{$sum.average}</td>
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
                <input type="hidden" name="c" value="Contract">
                <input type="hidden" name="a" value="statis">
                <input type="hidden" name="uid" value="{$uid}">
                <input type="hidden" name="start_time" value="{$start_time}">
                <input type="hidden" name="end_time" value="{$end_time}">
                <input type="hidden" name="pin" value="{$pin}">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>

                </form>
            </div>

<include file="Index:footer2" />


