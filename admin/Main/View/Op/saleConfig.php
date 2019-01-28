<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        部门信息
                        <small>销售任务系数</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/pdca_auth')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">销售任务系数</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php /*if($prveyear>2017){ */?><!--
                                            <a href="{:U('Op/saleConfig',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        --><?php /*} */?>
                                <?php
                                    for($i=2018;$i<=date('Y');$i++){
                                        if($year==$i){
                                            echo '<a href="'.U('Op/saleConfig',array('year'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'年</a>';
                                        }else{
                                            echo '<a href="'.U('Op/saleConfig',array('year'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'年</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Op/saleConfig',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders" >
                                        <th rowspan="2" width="40">ID</th>
                                        <th rowspan="2">部门名称</th>
                                        <th colspan="3" class="taskOptions">第一季度</th>
                                        <th colspan="3" class="taskOptions">第二季度</th>
                                        <th colspan="3" class="taskOptions">第三季度</th>
                                        <th colspan="3" class="taskOptions">第四季度</th>
                                        <th rowspan="2" class="taskOptions" width="80">设置</th>
                                    </tr>
                                    <tr role="row" class="orders">
                                        <td class="taskOptions">一月</td>
                                        <td class="taskOptions">二月</td>
                                        <td class="taskOptions">三月</td>
                                        <td class="taskOptions">四月</td>
                                        <td class="taskOptions">五月</td>
                                        <td class="taskOptions">六月</td>
                                        <td class="taskOptions">七月</td>
                                        <td class="taskOptions">八月</td>
                                        <td class="taskOptions">九月</td>
                                        <td class="taskOptions">十月</td>
                                        <td class="taskOptions">十一月</td>
                                        <td class="taskOptions">十二月</td>
                                    </tr>
   
                                    <foreach name="departments" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.department}</td>
                                            <td class="taskOptions">{$row.January}</td>
                                            <td class="taskOptions">{$row.February}</td>
                                            <td class="taskOptions">{$row.March}</td>
                                            <td class="taskOptions">{$row.April}</td>
                                            <td class="taskOptions">{$row.May}</td>
                                            <td class="taskOptions">{$row.June}</td>
                                            <td class="taskOptions">{$row.July}</td>
                                            <td class="taskOptions">{$row.August}</td>
                                            <td class="taskOptions">{$row.September}</td>
                                            <td class="taskOptions">{$row.October}</td>
                                            <td class="taskOptions">{$row.November}</td>
                                            <td class="taskOptions">{$row.December}</td>
                                            <td class="taskOptions">
                                                <a href="javascript:;" onClick="set_saleConfig({$row.id},{$year})" title="设置部门分管领导" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                                    </foreach>										
                                </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <ul class="pagination pagination-sm no-margin pull-right">
                                        {$pages}
                                    </ul>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<include file="Index:footer2" />
	<script>
    //编辑PDCA项目
	function set_saleConfig(id,$year) {
		art.dialog.open('index.php?m=Main&c=Op&a=sale_config_edit&id='+id+'&year='+$year,{
			lock:true,
			title: '配置销售任务系数',
			width:600,
			height:400,
			okValue: '提交',
			fixed: true,
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}

	</script>