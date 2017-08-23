<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/pdca')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                	<div class="btn-group" id="catfont">
                                        <button onClick="window.location.href='{:U('Kpi/pdcaresult',array('type'=>2))}'" class="btn <?php if($type==2){ echo 'btn-info';}else{ echo 'btn-default'; } ?>" >已评分</button>
                                        <button onClick="window.location.href='{:U('Kpi/pdcaresult',array('type'=>1))}'" class="btn <?php if($type==1){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">待评分</button>
                                       
                                    </div>
                                    
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="120" data="month">月份</th>
                                            <th class="sorting" data="title">PDCA描述</th>
                                            <th width="100" class="sorting" data="tab_user_id">被考评人</th>
                                            <th width="100" class="sorting" data="eva_user_id">考评人</th>
                                            <th width="100" class="sorting" data="total_score">考评得分</th>
                                            <th width="100" class="sorting" data="status">状态</th>
                                            <!--
                                            <if condition="rolemenu(array('Kpi/expdca'))">
                                            <th width="50" class="taskOptions">导出</th>
                                            </if>
                                            -->
                                            <if condition="rolemenu(array('Kpi/score'))">
                                            <th width="50" class="taskOptions">评分</th>
                                            </if>
                                            
                                        </tr>
                                        <foreach name="lists" item="row"> 
                                        <tr>
                                            <td>{$row.month}</td>
                                            <td><a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" >{$row.title}</a></td>
                                            <td>{:username($row['tab_user_id'])}</td>
                                            <td>
                                            <?php 
											if($row['eva_user_id']){
												echo username($row['eva_user_id']);
											}else{
												echo '未评分';	
											}
											?>
                                            </td>
                                            <td>{$row.total_score}</td>
                                            <td>{$pdcasta.$row[status]}</td>
                                            
                                            <!--
                                            <if condition="rolemenu(array('Kpi/expdca'))">
                                            <td class="taskOptions">
                                            <a href="{:U('Kpi/expdca',array('id'=>$row['id']))}" title="导出" class="btn btn-success btn-smsm"><i class="fa fa-arrow-circle-down"></i></a>
                                            </td>
                                            </if>
                                            -->
                                            <if condition="rolemenu(array('Kpi/score'))">
                                            <td class="taskOptions">
                                            <?php 
											if(cookie('roleid')==$row['app_role']){
											?>
                                            <a href="{:U('Kpi/score',array('pdcaid'=>$row['id']))}" title="评分" class="btn btn-success btn-smsm"><i class="fa fa-check-circle"></i></a>
                                            <?php 
											}
											?>
                                            </td>
                                            </if>
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
            
            
            <div id="mkdir">
                <form method="post" action="{:U('Files/mkdirs')}" name="myform" id="gosub">
            	<input type="hidden" name="dosubmit"  value="1">
                <input type="hidden" name="pid" value="{$pid}">
                <input type="hidden" name="level" value="{$level}">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="filename" placeholder="文件夹名称">
                </div>
                </form>
            </div>
            
            
           

	<include file="Index:footer2" />


	<script>
    //新建PDCA
	function add_pdca(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=addpdca&id='+id,{
			lock:true,
			title: '新建PDCA',
			width:800,
			height:200,
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
