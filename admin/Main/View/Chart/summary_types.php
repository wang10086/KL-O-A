<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目分部门汇总
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">项目分部门汇总</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <style>
                                        #chart_btn_group .btn-a{ background-color: #ddd;color: #666;}
                                    </style>
                                    <div class="box-tools btn-group" id = "chart_btn_group">
                                        <a href="{:U('Chart/summary_types',array('pin'=>0))}" class="btn btn-sm <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-a';} ?>">预算及结算分部门汇总</a>
                                        <a href="{:U('Chart/summary_types',array('pin'=>1))}" class="btn btn-sm <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-a';} ?>">已结算分部门汇总</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                        <?php if($prveyear>2016){ ?>
                                            <a href="{:U('Chart/summary_types',array('year'=>$prveyear,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'pin'=>$pin)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Chart/summary_types',array('year'=>$year,'month'=>$i,'pin'=>$pin)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Chart/summary_types',array('year'=>$nextyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr>
                                        <th class="sorting" style="text-align: center;" rowspan="2">部门</th>
                                        <th style="text-align: center;" rowspan="2">业务型态</th>
                                        <th colspan="5" style="text-align: center;">{$year}年累计</th>
                                        <th colspan="5" style="text-align: center;">{$month}月累计</th>
                                    </tr>

                                    <tr>
                                        <td class="taskOptions" data="" >项目数</td>
                                        <td class="taskOptions" data="">人数</td>
                                        <td class="taskOptions" data="">收入合计</td>
                                        <td class="taskOptions" data="">毛利合计</td>
                                        <td class="taskOptions" data="">毛利率(%)</td>
                                        <td class="taskOptions" data="">项目数</td>
                                        <td class="taskOptions" data="" width="">人数</td>
                                        <td class="taskOptions" data="">收入合计</td>
                                        <td class="taskOptions" data="">毛利合计</td>
                                        <td class="taskOptions" data="">毛利率(%)</td>
                                    </tr>


                                    <tr>
                                        <th class="taskOptions" rowspan="4">市场部</th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">科学旅行</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                         <td class="taskOptions">20.00</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">科学考察</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions">课后一小时</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                        <td class="taskOptions">20.00</td>
                                    </tr>


                                    <tr>
                                        <td class="taskOptions black" data="">合计</td>
                                        <td class="taskOptions black" data="">{$heji.yearxms}</td>
                                        <td class="taskOptions black" data="">{$heji.yearrenshu}</td>
                                        <td class="taskOptions black" data="">{$heji.yearzsr}</td>
                                        <td class="taskOptions black" data="">{$heji.yearzml}</td>
                                        <td class="taskOptions black" data="">{$heji.yearmll}</td>
                                        <td class="taskOptions black" data="">{$heji.monthxms}</td>
                                        <td class="taskOptions black" data="" width="">{$heji.monthrenshu}</td>
                                        <td class="taskOptions black" data="">{$heji.monthzsr}</td>
                                        <td class="taskOptions black" data="">{$heji.monthzml}</td>
                                        <td class="taskOptions black" data="">{$heji.monthmll}</td>
                                    </tr>
                                </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            


<include file="Index:footer2" />

<script>


</script>

给了这些忍村维持原本待遇的机会。

现在他们每天所完成的任务，从以前的各种护卫杀人，更多的转化为了民用任务。

小到抓捕盗贼，大到修建水利工程，总归不会少了他们的活干。

在地方上，相当于起到了，警察局，消防局，工程局等等一系列的职责。

或许一开始忍者们都不是很习惯，但比起以前卖命换钱来说，貌似也不是不能接受，毕竟这样的任务他们收益反而能够更高些。

而对于他们千叶也并不是毫无制衡，在维持他们原来的规模的同时，千叶大力的发展起了更多的忍村。

在所有的小国，又或者一个大国内分几个区域，分出更多的忍村。

只是眨眼间，忍界就如同雨后春笋般的冒出了数十个新忍村。

在千叶计划中，这些忍村如同地方军区一般，完全可以互相制衡。

虽然说，眼下他们的规模还是很小，但随着时间的推移，当他们成长起来，完全能够互相平衡，不至于某个忍村一家独大。

至此，千叶总算是安顿最重要的事物。

接下来，更多的统一各种度量单位乃至货币发行之类的东西，千叶选择了放手交给手下们去做。

比起这些来，千叶还有着更重要的事情要做。