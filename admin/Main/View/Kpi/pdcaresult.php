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
                                    <div class="kjss">
                                    	<form action="" method="get" id="searchform">
                                        <input type="hidden" name="m" value="Main">
                                        <input type="hidden" name="c" value="Kpi">
                                        <input type="hidden" name="a" value="pdcaresult">
                                        <input type="hidden" name="type"  value="{$type}">
                                        <input type="hidden" name="bkpr" id="bkpr" value="">
                                    	<input type="text" name="month" class="form-control" placeholder="月份" style="width:100px; margin-right:10px;"/>
                                    	<input type="text" class="form-control keywords" placeholder="被考评人"/>
                                        <button class="btn btn-info btn-sm" style="float:left;"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                    <div class="box-tools pull-right">
                                    	
                                         <div class="btn-group" id="catfont" style="margin-top:-3px;">
                                            <button onClick="window.location.href='{:U('Kpi/pdcaresult',array('type'=>2))}'" class="btn <?php if($type==2){ echo 'btn-info';}else{ echo 'btn-default'; } ?>" >已评分</button>
                                            <button onClick="window.location.href='{:U('Kpi/pdcaresult',array('type'=>1))}'" class="btn <?php if($type==1){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">待评分</button>
                                           
                                        </div>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                	
                                    
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="120" data="month">月份</th>
                                            <th width="" class="sorting" data="tab_user_id">被考评人</th>
                                            <th width="" class="sorting" data="eva_user_id">考评人</th>
                                            <th width="" class="sorting" data="total_score">考评得分</th>
                                            <th width="" class="sorting" data="status">状态</th>
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
                                            <td><a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" >{$row.month}</a></td>
                                            <td><a href="{:U('Kpi/pdcaresult',array('bkpr'=>$row['tab_user_id'],'type'=>$type))}">{:username($row['tab_user_id'])}</a></td>
                                            <td>{$row.kaoping}</td>
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
											if(cookie('userid')==$row['eva_user_id']){
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
	$(document).ready(function(e) {
		var keywords = <?php echo $userkey; ?>;
		
		$(".keywords").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#bkpr').val(item.id);
		});
			
	})
	</script>
