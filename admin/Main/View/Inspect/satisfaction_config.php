<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        内部满意度设置
                        <small>评分人员设置</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Inspect/satisfaction')}"><i class="fa fa-gift"></i> 内部满意度</a></li>
                        <li class="active">评分人员设置</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2018){ ?>
                                            <a href="{:U('Inspect/satisfaction_config',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                <?php
                                    for($i=1;$i<=12;$i++){
                                        $mon    = str_pad($i,2,'0',STR_PAD_LEFT);
                                        if($month==$i){
                                            echo '<a href="'.U('Inspect/satisfaction_config',array('year'=>$year,'month'=>$mon)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Inspect/satisfaction_config',array('year'=>$year,'month'=>$mon)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Inspect/satisfaction_config',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">内部满意度评分人</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist">
                                    <tr role="row" class="orders">
                                        <td class="taskOptions" width="100">姓名</td>
                                        <td class="taskOptions">评分人员</td>
                                        <td class="taskOptions" width="80">编辑</td>
                                    </tr>
   
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td class="taskOptions">{$row.user_name}</td>
                                            <td class="">{$row.score_users}</td>
                                            <if condition="rolemenu(array('Inspect/satisfaction_config_edit'))">
                                            <td class="taskOptions">
                                                <a href="javascript:;" onClick="set_satisfactionConfig({$row.user_id},`{$row.user_name}`,{$year},{$yearMonth})" title="内部满意度评分人" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            </td>
                                            </if>
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
	function set_satisfactionConfig(userid,username,year,yearMonth) {
		art.dialog.open('index.php?m=Main&c=Inspect&a=satisfaction_config_edit&userid='+userid+'&username='+username+'&year='+year+'&month='+yearMonth,{
			lock:true,
			title: '配置'+username+'内部满意度评分人',
			width:1000,
			height:500,
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