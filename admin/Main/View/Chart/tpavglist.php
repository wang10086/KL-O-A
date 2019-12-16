<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>团队人均排行榜</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">团队人均排行榜</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php /*if($prveyear>2017){ */?><!--
                                    <a href="{:U('Chart/tpavglist',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                --><?php /*} */?>
                                <?php
                                for($i=2018;$i<=date('Y');$i++){
                                    if($year==$i){
                                        echo '<a href="'.U('Chart/tpavglist',array('year'=>$i)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'年</a>';
                                    }else{
                                        echo '<a href="'.U('Chart/tpavglist',array('year'=>$i)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'年</a>';
                                    }
                                }
                                ?>
                                <?php /*if($year<date('Y')){ */?><!--
                                    <a href="{:U('Chart/tpavglist',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                --><?php /*} */?>
                            </div>

                            <div class="box box-warning">

                                <div class="box-header">
                                    <div class="box-tools btn-group" id="chart_btn_group">
                                        <a href="{:U('Chart/pplist')}" class="btn btn-sm btn-group-header">个人业绩排行榜</a>
                                        <a href="{:U('Chart/tplist')}" class="btn btn-sm btn-group-header">团队总体业绩排行榜</a>
                                        <a href="{:U('Chart/tpavglist')}" class="btn btn-sm btn-info">团队人均排行榜</a>
                                    </div>
                                </div><!-- /.box-header -->
                               
                                <div class="box-body">
                                    <p>提示：以下累计数据从{$year-1}年12月26日起已完成结算项目中采集</p>
                                    <table id="example2" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr role="row" class="orders" >
                                                <th width="40" data="">序号</th>
                                                <th>团队</th>
                                                <?php if ($year == date("Y")){ ?>
                                                <th>当月人数(个)</th>
                                                <?php } ?>
                                                <th>累计计算人数(个)</th>
                                                <th class="orderth">累计人均收入(元)</th>
                                                <th class="orderth">累计人均毛利(元)</th>
                                                <th class="orderth">累计人均毛利率(%)</th>
                                                <?php if ($year == date("Y")){ ?>
                                                <th class="orderth">当月人均收入(元)</th>
                                                <th class="orderth">当月人均毛利(元)</th>
                                                <th class="orderth">当月人均毛利率(%)</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                        <foreach name="lists" item="row" key="k">                      
                                            <tr>
                                                <td class="orderNo"></td>
                                                <td><a href="{:U('Chart/tpmore',array('dept'=>$row['rid'],'year'=>$year))}">{$row.rolename}</a></td>
                                                <?php if ($year == date("Y")){ ?>
                                                <td>{$row.sumMonth}</td>
                                                <?php } ?>
                                                <td>{$row.sumYear}</td>
                                                <td>{$row.rjzsr}</td>
                                                <!--<td>{$row.rjzml}</td>-->
                                                <?php if ($row['rjzml_partner']){ ?>
                                                    <td class="red" onclick="art_left_show_msg('包含城市合伙人人均毛利：'+{$row.rjzml_partner}+'<br>'+'不包含城市合伙人人均毛利：'+{$row.rjzml})">{$row.rjzml_partner}</td>
                                                <?php }else{ ?>
                                                    <td>{$row.rjzml}</td>
                                                <?php } ?>
                                                <td>{$row.rjmll}</td>
                                                <?php if ($year == date("Y")){ ?>
                                                <td>{$row.rjysr}</td>
                                                <!--<td>{$row.rjyml}</td>-->
                                                    <?php if ($row['rjyml_partner']){ ?>
                                                        <td class="red" onclick="art_left_show_msg('包含城市合伙人人均毛利：'+{$row.rjyml_partner}+'<br>'+'不包含城市合伙人人均毛利：'+{$row.rjyml})">{$row.rjyml_partner}</td>
                                                    <?php }else{ ?>
                                                        <td>{$row.rjyml}</td>
                                                    <?php } ?>
                                                <td>{$row.rjyll}</td>
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
			"aaSorting" : [[5, "desc"]],
			"bAutoWidth": true,
			"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1,2,3 ] }]
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