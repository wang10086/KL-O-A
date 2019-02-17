<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>KPI排行榜</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">KPI绩排行榜</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <div class="row" >
                        <div class="col-md-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php /*if($prveyear>2017){ */?><!--
                                            <a href="{:U('Kpi/chart',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        --><?php /*} */?>
                                <?php
                                for($i=2018;$i<=date('Y');$i++){
                                    if($year==$i){
                                        echo '<a href="'.U('Kpi/chart',array('year'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'年</a>';
                                    }else{
                                        echo '<a href="'.U('Kpi/chart',array('year'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'年</a>';
                                    }
                                }
                                ?>
                                <?php /*if($year<date('Y')){ */?><!--
                                            <a href="{:U('Kpi/chart',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        --><?php /*} */?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <div class="box-tools btn-group" id="chart_btn_group">
                                        <a href="{:U('Kpi/chart')}" class="btn btn-sm btn-info">全部人员</a>
                                        <a href="{:U('Kpi/chart',array('pin'=>'00'))}" class="btn btn-sm btn-info">0列队</a>
                                        <a href="{:U('Kpi/chart',array('pin'=>'01'))}" class="btn btn-sm btn-info">1列队</a>
                                        <a href="{:U('Kpi/chart',array('pin'=>'02'))}" class="btn btn-sm btn-info">2列队</a>
                                        <a href="{:U('Kpi/chart',array('pin'=>'03'))}" class="btn btn-sm btn-info">3列队</a>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                     <p>提示：未到考核周期月份只是暂时考核结果，最终考核结果以考核周期考核结果为准。</p>
                                	 <table id="example2" class="table table-striped table-bordered table-hover" >
                                        <thead>
                                            <tr role="row" class="orders" >
                                            	<th width="40">列队</th>
                                            	<th width="40">序号</th>
                                                <th>姓名</th>
                                                <th>周期</th>
                                                <th>年平均</th>
                                                <th>1月</th>
                                                <th>2月</th>
                                                <th>3月</th>
                                                <th>4月</th>
                                                <th>5月</th>
                                                <th>6月</th>
                                                <th>7月</th>
                                                <th>8月</th>
                                                <th>9月</th>
                                                <th>10月</th>
                                                <th>11月</th>
                                                <th>12月</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <foreach name="lists" item="row" key="k">                      
                                            <tr>
                                            	<td class="orderNo"></td>
                                                <td><a href="{:U('Kpi/finance',array('xs'=>$row['create_user_name'],'st'=>($year-1).'-12-26'))}">{$row.create_user_name}</a></td>
                                                <!--<td>{$row.rolename}</td>-->
                                                <td>{$row.department}</td>
                                                <td>{$row.zsr}</td>
                                                <td>{$row.zml}</td>
                                                <td>{$row.mll}</td>
                                                <?php if ($year == date("Y")){ ?>
                                                <td>{$row.ysr}</td>
                                                <td>{$row.yml}</td>
                                                <td>{$row.yll}</td>
                                                <?php } ?>
                                            </tr>
                                            </foreach>	
                                        </tbody>	
                                        
                                    </table>
                                
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

        <include file="Index:footer2" />
        <script type="text/javascript">
		$('#example2').dataTable({
			"bPaginate": false,
			"bLengthChange": false,
			"bFilter": false,
			"bSort": true,
			"bInfo": false,
			"aaSorting" : [[4, "desc"]],
			"bAutoWidth": true,
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1,2] }]
		});
		
		$(document).ready(function(e) {
			$('.orderNo').each(function(index, element) {
				$(this).text(index+1);
			});	
				
			$('.orderth').click(function(){
				$('.orderNo').each(function(index, element) {
					$(this).text(index+1);
				});	
			})
		});
        </script>
        