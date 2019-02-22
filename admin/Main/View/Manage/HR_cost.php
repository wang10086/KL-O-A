<include file="Index:header2" />

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
                <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                    <?php if($prveyear>2017){ ?>
                        <a href="{:U('Manage/HR_cost',array('year'=>$prveyear,'tm'=>$tm))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                    <?php } ?>
                    <?php
                    for($i=1;$i<13;$i++){
                        if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                            echo '<a href="'.U('Manage/HR_cost',array('year'=>$year,'month'=>$i,'tm'=>$tm)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                        }else{
                            echo '<a href="'.U('Manage/HR_cost',array('year'=>$year,'month'=>$i,'tm'=>$tm)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                        }
                    }
                    ?>
                    <?php if($year<date('Y')){ ?>
                        <a href="{:U('Manage/HR_cost',array('year'=>$nextyear,'month'=>'01','tm'=>$tm))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                    <?php } ?>
                </div>

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">
                            <if condition="$tm eq 'm'">
                                月度经营报表 - 人力资源成本
                            <elseif condition="$tm eq 'q'" />
                                季度经营报表 - 人力资源成本
                            <elseif condition="$tm eq 'y'" />
                                年度经营报表 - 人力资源成本
                            </if>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th style="width:10em;" ><b>科目</b></th>
                                <foreach name="departments" item="v">
                                    <th style="width:10em;" ><b>{$v}</b></th>
                                </foreach>
                            </tr>

                            <foreach name="hr_cost" item="v">
                                <foreach name="data" key="kk" item="vv">
                                    <if condition="$kk eq $v">
                                        <tr role="row" class="orders" style="text-align:center;">
                                            <td>{$v}</td>
                                            <td>&yen; <?PHP echo $vv['公司']?$vv['公司']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['京区业务中心']?$vv['京区业务中心']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['京外业务中心']?$vv['京外业务中心']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['南京项目部']?$vv['南京项目部']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['武汉项目部']?$vv['武汉项目部']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['沈阳项目部']?$vv['沈阳项目部']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['长春项目部']?$vv['长春项目部']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['市场部']?$vv['市场部']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['常规业务中心']?$vv['常规业务中心']:'0.00'; ?></td>
                                            <td>&yen; <?PHP echo $vv['机关部门']?$vv['机关部门']:'0.00'; ?></td>
                                        </tr>
                                    </if>
                                </foreach>
                            </foreach>

                            <tr role="row" class="orders" style="text-align:center;">
                                <td><b>合计</b></td>
                                <td>{$sum.公司}</td>
                                <td>{$sum.京区业务中心}</td>
                                <td>{$sum.京外业务中心}</td>
                                <td>{$sum.南京项目部}</td>
                                <td>{$sum.武汉项目部}</td>
                                <td>{$sum.沈阳项目部}</td>
                                <td>{$sum.长春项目部}</td>
                                <td>{$sum.市场部}</td>
                                <td>{$sum.常规业务中心}</td>
                                <td>{$sum.机关部门}</td>
                            </tr>

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