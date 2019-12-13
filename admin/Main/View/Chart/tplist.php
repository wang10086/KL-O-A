<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>团队总体业绩排行榜</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">团队总体业绩排行榜</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php /*if($prveyear>2017){ */?><!--
                                            <a href="{:U('Chart/tplist',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        --><?php /*} */?>
                                <?php
                                for($i=2018;$i<=date('Y');$i++){
                                    if($year==$i){
                                        echo '<a href="'.U('Chart/tplist',array('year'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'年</a>';
                                    }else{
                                        echo '<a href="'.U('Chart/tplist',array('year'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'年</a>';
                                    }
                                }
                                ?>
                                <?php /*if($year<date('Y')){ */?><!--
                                            <a href="{:U('Chart/tplist',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        --><?php /*} */?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <div class="box-tools btn-group" id="chart_btn_group">
                                        <a href="{:U('Chart/pplist')}" class="btn btn-sm btn-group-header">个人业绩排行榜</a>
                                        <a href="{:U('Chart/tplist')}" class="btn btn-sm btn-info">团队总体业绩排行榜</a>
                                        <a href="{:U('Chart/tpavglist')}" class="btn btn-sm btn-group-header">团队人均排行榜</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <p>提示：以下累计数据从{$year-1}年12月26日起已完成结算项目中采集</p>
                                    <table id="example2" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr role="row" class="orders" >
                                                <th width="40" data="">序号</th>
                                                <th>团队</th>
                                                <th>负责人</th>
                                                <th class="orderth">累计收入(元)</th>
                                                <th class="orderth">累计毛利(元)</th>
                                                <th class="orderth">累计毛利率(%)</th>
                                                <?php if ($year == date("Y")){ ?>
                                                <th class="orderth">当月收入(元)</th>
                                                <th class="orderth">当月毛利(元)</th>
                                                <th class="orderth">当月毛利率(%)</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                        <foreach name="lists" item="row" key="k">                      
                                            <tr>
                                                <td class="orderNo"></td>
                                                <td><a href="{:U('Chart/tpmore',array('dept'=>$row['rid'],'year'=>$year))}">{$row.rolename}</a></td>
                                                <td>{$row.fzr}</td>
                                                <td>{$row.zsr}</td>
                                                <td>{$row.zml}<?php echo $row['year_partner_money'] ? " (其中城市合伙人<br />保证金：$row[year_partner_money])" : ''; ?></td>
                                                <td>{$row.mll}</td>
                                                <?php if ($year == date("Y")){ ?>
                                                <td>{$row.ysr}</td>
                                                <td>{$row.yml}<?php echo $row['month_partner_money'] ? "(其中城市合伙人<br />保证金：$row[month_partner_money])" : ''; ?></td>
                                                <td>{$row.yll}</td>
                                                <?php } ?>
                                            </tr>
                                        </foreach>	
                                        </tbody>
                                        
                                    </table>
                                </div>
                                
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
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1,2 ] }]
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