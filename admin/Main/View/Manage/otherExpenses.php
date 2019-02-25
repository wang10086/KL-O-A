<include file="Index:header2" />
<!--<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>-->
<aside class="right-side">

    <section class="content-header">
        <h1>
            <if condition="$tm eq 'm'">
                {$year}年月度经营报表 - 其他费用
                <elseif condition="$tm eq 'q'" />
                {$year}年季度经营报表 - 其他费用
                <elseif condition="$tm eq 'y'" />
                {$year}年年度经营报表 - 其他费用
            </if>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> 其他费用</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <?php if ($tm == 'm'){ ?>
                    <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                        <?php if($prveyear>2017){ ?>
                            <a href="{:U('Manage/otherExpenses',array('year'=>$prveyear,'tm'=>$tm))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                        <?php } ?>
                        <?php
                        for($i=1;$i<13;$i++){
                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                echo '<a href="'.U('Manage/otherExpenses',array('year'=>$year,'month'=>$i,'tm'=>$tm)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                            }else{
                                echo '<a href="'.U('Manage/otherExpenses',array('year'=>$year,'month'=>$i,'tm'=>$tm)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                            }
                        }
                        ?>
                        <?php if($year<date('Y')){ ?>
                            <a href="{:U('Manage/otherExpenses',array('year'=>$nextyear,'month'=>'01','tm'=>$tm))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                        <?php } ?>
                    </div>
                <?php }elseif ($tm =='q'){ ?>
                    <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                        <!--<a href="{:U('Manage/otherExpenses',array('year'=>$year-1))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>-->
                        <a href="{:U('Manage/otherExpenses',array('year'=>$year,'quarter'=>1,'month'=>3,'tm'=>$tm))}" class="btn btn-default <?php if($quarter==1){echo 'btn-info';}?>">第一季度</a>
                        <a href="{:U('Manage/otherExpenses',array('year'=>$year,'quarter'=>2,'month'=>6,'tm'=>$tm))}" class="btn btn-default <?php if($quarter==2){echo 'btn-info';}?>">第二季度</a>
                        <a href="{:U('Manage/otherExpenses',array('year'=>$year,'quarter'=>3,'month'=>9,'tm'=>$tm))}" class="btn btn-default <?php if($quarter==3){echo 'btn-info';}?>">第三季度</a>
                        <a href="{:U('Manage/otherExpenses',array('year'=>$year,'quarter'=>4,'month'=>12,'tm'=>$tm))}" class="btn btn-default <?php if($quarter==4){echo 'btn-info';}?>">第四季度</a>
                        <!--<a href="{:U('Manage/otherExpenses',array('year'=>$year+1))}" class="btn btn-default">下一年</a>-->
                    </div>
                <?php }?>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">
                            <if condition="$tm eq 'm'">
                                月度经营报表 - 其他费用
                            <elseif condition="$tm eq 'q'" />
                                季度经营报表 - 其他费用
                            <elseif condition="$tm eq 'y'" />
                                年度经营报表 - 其他费用
                            </if>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th style="width:10em;" ><b>科目</b></th>
                                <!--<th style="width:10em;" ><b>公司</b></th>
                                <th style="width:10em;" ><b>京区业务中心</b></th>
                                <th style="width:10em;" ><b>京外业务中心</b></th>
                                <th style="width:10em;" ><b>南京项目部</b></th>
                                <th style="width:10em;" ><b>武汉项目部</b></th>
                                <th style="width:10em;" ><b>沈阳项目部</b></th>
                                <th style="width:10em;" ><b>长春项目部</b></th>
                                <th style="width:10em;" ><b>市场部(业务)</b></th>
                                <th style="width:10em;" ><b>常规业务中心</b></th>
                                <th style="width:10em;" ><b>机关部门</b></th>-->
                                <foreach name="departments" item="v">
                                    <th style="width:10em;" ><b>{$v}</b></th>
                                </foreach>
                            </tr>

                            <foreach name="lists" key="k" item="v">
                                <tr role="row" class="orders" style="text-align:center;">
                                    <td>{$kinds[$k]}</td>
                                    <td>{$v.gongsi}</td>
                                    <td>{$v.jqyw}</td>
                                    <td>{$v.jwyw}</td>
                                    <td>{$v.nanjing}</td>
                                    <td>{$v.wuhan}</td>
                                    <td>{$v.shenyang}</td>
                                    <td>{$v.changchun}</td>
                                    <td>{$v.shichang}</td>
                                    <td>{$v.changgui}</td>
                                    <td>{$v.jiguan}</td>
                                </tr>
                            </foreach>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td><b>合计</b></td>
                                <td>{$heji.gongsi}</td>
                                <td>{$heji.jqyw}</td>
                                <td>{$heji.jwyw}</td>
                                <td>{$heji.nanjing}</td>
                                <td>{$heji.wuhan}</td>
                                <td>{$heji.shenyang}</td>
                                <td>{$heji.changchun}</td>
                                <td>{$heji.shichang}</td>
                                <td>{$heji.changgui}</td>
                                <td>{$heji.jiguan}</td>
                            </tr>


                            <!--<tr role="row" class="orders" style="text-align:center;">
                                <th>员工人数</th>
                                <foreach name="number" item="n">
                                    <th><?php /*if($n['sum']=="" || $n['sum']==0){echo '0';}else{echo $n['sum']; }*/?>（人)</th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <th>营业收入</th>
                                <td>¥ <?php /*if($company['monthzsr']=="" || $company['monthzsr']==0 ){echo '0.00';}else{echo $company['monthzsr']; }*/?></td>
                                <foreach name="profit" item="pf">
                                    <th>¥ <?php /*if($pf['department']['monthzsr']=="" || $pf['department']['monthzsr']==0 ){echo '0.00';}else{echo $pf['department']['monthzsr']; }*/?></th>
                                </foreach>
                                <th>¥ 0.00</th>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>营业毛利</td>
                                <td>¥ <?php /*if($company['monthzml']=="" || $company['monthzml']==0 ){echo '0.00';}else{echo $company['monthzml']; }*/?></td>
                                <foreach name="profit" item="pr">
                                    <th>¥ <?php /*if($pr['department']['monthzml']=="" || $pr['department']['monthzml']==0 ){echo '0.00';}else{echo $pr['department']['monthzml']; }*/?></th>
                                </foreach>
                                <td>¥ 0.00</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>营业毛利率(%)</td>
                                <td><?php /*if($company['monthmll']=="" || $company['monthmll']==0 ){echo '0.00';}else{echo $company['monthmll']; }*/?> %</td>
                                <foreach name="profit" item="pro">
                                    <th><?php /*if($pro['department']['monthmll']=="" || $pr['department']['monthzml']==0 ){echo '0.00';}else{echo $pro['department']['monthmll']; }*/?> %</th>
                                </foreach>
                                <td>0.00 %</td>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>人力资源成本</td>
                                <foreach name="number" item="num">
                                    <th>¥ <?php /*if($num['money']=="" || $num['money']==0 ){echo '0.00';}else{echo $num['money'];}*/?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td><a href="">其他费用</a></td>
                                <foreach name="department" item="d">
                                    <th>¥ <?php /*if($d['money']=="" || $d['money']==0){echo '0.00';}else{echo $d['money'];}*/?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <td>利润总额</td>
                                <foreach name="total_profit" item="t">
                                    <th>¥ <?php /*if($t['total_profit']=="" || $t['total_profit']==0 ){echo '0.00';}else{echo $t['total_profit'];}*/?></th>
                                </foreach>

                            </tr>
                            <tr role="row" class="orders" style="text-align:center;">
                                <th>人事费用率(%)</th>
                                <foreach name="human_affairs" item="aff">
                                    <th><?php /*if($aff['human_affairs']=="" || $aff['human_affairs']==0 ){echo '0.00';}else{echo $aff['human_affairs'];}*/?> %</th>
                                </foreach>
                            </tr>-->
                        </table><br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />
<script>
    /*$(function(){

        var sum = "<?php echo $post;?>";
        var num = "\<?php echo $month;?>";
        if(sum==1 && num==''){
           $('#btn-default_id1').attr('id','btn-default_1');return false;
        }
        if(sum==2 && num==''){
            $('#btn-default_id3').attr('id','btn-default_1');return false;
        }
        if(sum=='' && num!==''){
            $("#btn-default<?php echo $month;?>").attr('id','btn-default_1');return false;
        }
    });*/
</script>