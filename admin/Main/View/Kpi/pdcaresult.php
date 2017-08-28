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
                                        <input type="hidden" name="kpr" id="kpr" value="">
                                    	<input type="text" name="month" class="form-control monthly" placeholder="月份" style="width:100px; margin-right:10px;"/>
                                    	<input type="text" class="form-control keywords_bkpr" placeholder="被考评人"  style="width:180px; margin-right:10px;"/>
                                        <!-- <input type="text" class="form-control keywords_kpr" placeholder="考评人"  style="width:180px;"/> -->
                                        <button class="btn btn-info btn-sm" style="float:left;"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                    <!--
                                    <div class="box-tools pull-right">
                                    	
                                         <div class="btn-group" id="catfont" style="margin-top:-3px;">
                                            <button onClick="window.location.href='{:U('Kpi/pdcaresult',array('type'=>2))}'" class="btn <?php if($type==2){ echo 'btn-info';}else{ echo 'btn-default'; } ?>" >已评分</button>
                                            <button onClick="window.location.href='{:U('Kpi/pdcaresult',array('type'=>1))}'" class="btn <?php if($type==1){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">待评分</button>
                                           
                                        </div>
                                    </div>
                                    -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                	
                                    
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" width="14.8%" data="month">月份</th>
                                            <th width="14.8%" class="sorting" data="tab_user_id">被考评人</th>
                                            <!-- <th width="20%" class="sorting" data="eva_user_id">考评人</th> -->
                                            <th width="14.8%" class="sorting" data="total_score">PDCA加减分</th>
                                            <th width="14.8%" class="sorting" data="total_qa_score">品质检查加减分</th>
                                            <th width="14.8%" class="sorting" data="total_kpi_score">KPI加减分</th>
                                            <th width="14.8%" class="sorting">合计总分</th>
                                        </tr>
                                        <foreach name="lists" item="row"> 
                                        <tr>
                                            <td>{$row.month}</a></td>
                                            <td><a href="{:U('Kpi/pdcaresult',array('bkpr'=>$row['tab_user_id']))}">{:username($row['tab_user_id'])}</a></td>
                                            <!--<td>{$row.kaoping}</td>-->
                                            <td>
                                            {$row.total_score_show} 
                                            &nbsp;&nbsp;
                                            <a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" style="float:right;">[详细]</a>
                                            </td>
                                            <td>
                                            {$row.show_qa_score}
                                            &nbsp;&nbsp;
                                            <?php if($row['total_qa_score']!=0){ ?>
                                            <a href="{:U('Kpi/qa',array('uid'=>$row['tab_user_id'],'type'=>2,'month'=>$row['month']))}" style="float:right;">[详细]</a>
                                            <?php } ?>
                                            </td>
                                            <td>{$row.total_kpi_score}</td>
                                            <td>{$row.sum_total_score}</td>
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
		
		$(".keywords_bkpr").autocomplete(keywords, {
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
		
		
		$(".keywords_kpr").autocomplete(keywords, {
			 matchContains: true,
			 highlightItem: false,
			 formatItem: function(row, i, max, term) {
				 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
			 },
			 formatResult: function(row) {
				 return row.user_name;
			 }
		}).result(function(event, item) {
		   $('#kpr').val(item.id);
		});
			
	})
	</script>
