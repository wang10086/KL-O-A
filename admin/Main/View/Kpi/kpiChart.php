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
                                            <a href="{:U('Kpi/kpiChart',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        --><?php /*} */?>
                                <?php
                                for($i=2018;$i<=$last_year;$i++){
                                    if($year==$i){
                                        echo '<a href="'.U('Kpi/kpiChart',array('year'=>$i,'pin'=>$pin)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'年</a>';
                                    }else{
                                        echo '<a href="'.U('Kpi/kpiChart',array('year'=>$i,'pin'=>$pin)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'年</a>';
                                    }
                                }
                                ?>
                                <?php /*if($year<date('Y')){ */?><!--
                                            <a href="{:U('Kpi/kpiChart',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        --><?php /*} */?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <div class="box-tools btn-group" id="chart_btn_group">
                                        <?php if(cookie('userid')==1 || cookie('userid')==11){ ?>
                                        <a href="{:U('Kpi/kpiChart',array('year'=>$year,'pin'=>'100'))}" class="btn btn-sm <?php if($pin=='100'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">全部人员</a>
                                        <?php } ?>
                                        <a href="{:U('Kpi/kpiChart',array('year'=>$year,'pin'=>'00'))}" class="btn btn-sm <?php if($pin=='00'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">0队列</a>
                                        <a href="{:U('Kpi/kpiChart',array('year'=>$year,'pin'=>'01'))}" class="btn btn-sm <?php if($pin=='01'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">1队列</a>
                                        <a href="{:U('Kpi/kpiChart',array('year'=>$year,'pin'=>'02'))}" class="btn btn-sm <?php if($pin=='02'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">2队列</a>
                                        <a href="{:U('Kpi/kpiChart',array('year'=>$year,'pin'=>'03'))}" class="btn btn-sm <?php if($pin=='03'){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">3队列</a>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                     <p>提示：未到考核周期月份只是暂时考核结果(蓝色)，最终考核结果(红色)以考核周期考核结果为准。</p>
                                	 <table id="example3" class="table table-striped table-bordered table-hover" >
                                        <thead>
                                            <tr role="row" class="orders" >
                                                <th width="60" class="taskOptions">队列</th>
                                                <th width="40" class="taskOptions">序号</th>
                                                <th width="80">姓名</th>
                                                <th>周期</th>
                                                <th class="taskOptions orderth">年平均</th>
                                                <?php for ($i=1;$i<13;$i++){
                                                    echo "<th class='taskOptions'>".$i."月</th>";
                                                } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <foreach name="lists" item="row" key="k">
                                            <tr>
                                                <td class="taskOptions">{$row.ranks}</td>
                                                <!--<td class="taskOptions">{$row.employee_member}</td>-->
                                                <td class="taskOptions orderNo"></td>
                                                <td>{$row.nickname}</td>
                                                <td>{$row.cycle}</td>
                                                <td class="taskOptions">{$row.average}</td>
                                                <?php if ($row['kpi_cycle']==1){ ?>     <!--月度-->
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'01','uid'=>$row['id']))}" target="_blank" <?php if ((($year-1 == date('Y') && date('md')>1225) || ($year == date('Y') && date('md')<126))){echo "class=red"; }; ?>><?php echo (time()>strtotime(($year-1).'1226') && $row['kpi']['01'] !== null)?$row["kpi"]['01']:'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'02','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 125) && (date('md') < 226)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0126') && $row['kpi']['01'] !== null)?$row["kpi"]['02'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'03','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 225) && (date('md') < 326)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0226') && $row['kpi']['01'] !== null)?$row["kpi"]['03'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'04','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 325) && (date('md') < 426)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0326') && $row['kpi']['01'] !== null)?$row["kpi"]['04']:'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'05','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 425) && (date('md') < 526)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0426') && $row['kpi']['01'] !== null)?$row["kpi"]['05'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'06','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 525) && (date('md') < 626)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0526') && $row['kpi']['01'] !== null)?$row["kpi"]['06'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'07','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 625) && (date('md') < 726)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0626') && $row['kpi']['01'] !== null)?$row["kpi"]['07'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'08','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 725) && (date('md') < 826)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0726') && $row['kpi']['01'] !== null)?$row["kpi"]['08'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'09','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 825) && (date('md') < 926)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0826') && $row['kpi']['01'] !== null)?$row["kpi"]['09'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'10','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 925) && (date('md') < 1026)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0926') && $row['kpi']['01'] !== null)?$row["kpi"]['10'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'11','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 1025) && (date('md') < 1126)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'1026') && $row['kpi']['01'] !== null)?$row["kpi"]['11'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'12','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 1125) && (date('md') < 1226)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'1126') && $row['kpi']['01'] !== null)?$row["kpi"]['12'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                <?php }elseif($row['kpi_cycle']==2){ ?>     <!--季度-->
                                                    <td class="taskOptions" colspan="3"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'03','uid'=>$row['id']))}" target="_blank" <?php if (($year-1 == date('Y') && date('md')>1225) || ($year == date('Y') && date('md')<0326)){echo "class=red"; }; ?>><?php echo (time()>strtotime(($year-1).'0126') && $row['kpi']['01'] !== null)?$row["kpi"]['01'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions" colspan="3"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'06','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 325) && (date('md') < 626)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0326') && $row['kpi']['01'] !== null)?$row["kpi"]['04'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions" colspan="3"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'09','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 625) && (date('md') < 926)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0626') && $row['kpi']['01'] !== null)?$row["kpi"]['07'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions" colspan="3"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'12','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 925) && (date('md') < 1226)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0926') && $row['kpi']['01'] !== null)?$row["kpi"]['10'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                <?php }elseif($row['kpi_cycle']==3){ ?>     <!--半年度-->
                                                    <td class="taskOptions" colspan="6"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'06','uid'=>$row['id']))}" target="_blank" <?php if (($year-1 == date('Y') && date('md')>1225) || ($year == date('Y') && date('md')<0626)){echo "class=red"; }; ?>><?php echo (time()>strtotime(($year-1).'0126') && $row['kpi']['01'] !== null)?$row["kpi"]['01'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                    <td class="taskOptions" COLSPAN="6"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'12','uid'=>$row['id']))}" target="_blank" <?php if ($year == date('Y') && (date('md') > 625) && (date('md') < 1226)){echo "class=red"; }; ?>><?php echo (time()>strtotime($year.'0626') && $row['kpi']['01'] !== null)?$row["kpi"]['02'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                <?php }elseif($row['kpi_cycle']==4){ ?>     <!--年度-->
                                                    <td class="taskOptions" colspan="12"><a href="{:U('Kpi/kpiinfo',array('year'=>$year,'month'=>'12','uid'=>$row['id']))}" target="_blank" <?php if (($year-1 == date('Y') && date('md')>1225) || ($year == date('Y') && date('md')<1226)){echo "class=red"; }; ?>><?php echo (time()>strtotime(($year-1).'1226') && $row['kpi']['01'] !== null)?$row["kpi"]['01'] :'<font color="#999999">未考核</font>';  ?></a></td>
                                                <?php } ?>
                                            </tr>
                                            </foreach>
                                        </tbody>
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

<script type="text/javascript">
    /*$('#example3').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": true,
        "bInfo": false,
        "aaSorting" : [[4, "desc"]],
        "bAutoWidth": true,
        /!*"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0,1,2,5,6,7,8,9,10,11,12,13,14,15,16] }] //设置不排序的列*!/
        "aoColumnDefs": [
            {
                "bSortable": false,
                "aTargets": [ 0,1,2,5,6,7,8,9,10,11,12,13,14,15,16]
            }
        ]
    });*/

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

