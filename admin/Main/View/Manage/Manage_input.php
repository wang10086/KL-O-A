<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
    th{
        text-align:center;
    }
    td input{
        text-align:center;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><?php echo $year;?>年度预算录入</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Manage/Manage_year')}"><i class="fa fa-gift"></i> 年度经营报表</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">年度预算录入</h3>

                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" >
                                <th style="width:10em;" ><b>项目</b></th>
                                <th style="width:10em;" ><b>公司</b></th>
                                <th style="width:10em;" ><b>京区业务中心</b></th>
                                <th style="width:10em;" ><b>京外业务中心</b></th>
                                <th style="width:10em;" ><b>南京项目部</b></th>
                                <th style="width:10em;" ><b>武汉项目部</b></th>
                                <th style="width:10em;" ><b>沈阳项目部</b></th>
                                <th style="width:10em;" ><b>长春项目部</b></th>
                                <th style="width:10em;" ><b>市场部</b></th>
                                <th style="width:10em;" ><b>常规业务中心</b></th>
                                <th style="width:10em;" ><b>机关部门</b></th>
                            </tr>
                            <tr role="row" class="orders">
                                <th>员工人数</th>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['employees_number']=="" || $m['employees_number']==0){echo '';}else{echo $m['employees_number'].'（人）'; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业收入</td>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['logged_income']=="" || $m['logged_income']==0){echo '';}else{echo '¥ '.$m['logged_income']; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业毛利</td>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['logged_profit']=="" || $m['logged_profit']==0){echo '';}else{echo '¥ '.$m['logged_profit']; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业毛利率(%)</td>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['logged_rate']=="" || $m['logged_rate']==0){echo '';}else{echo $m['logged_rate'].' %'; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>人力资源成本</td>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['manpower_cost']=="" || $m['manpower_cost']==0){echo '';}else{echo '¥ '.$m['manpower_cost']; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>其他费用</td>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['other_expenses']=="" || $m['other_expenses']==0){echo '';}else{echo '¥ '.$m['other_expenses']; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>利润总额</td>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['total_profit']=="" || $m['total_profit']==0){echo '';}else{echo '¥ '.$m['total_profit']; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>人事费用率(%)</td>
                                <foreach name="manage" item="m">
                                    <th><?php if($m['personnel_cost_rate']=="" || $m['personnel_cost_rate']==0){echo '';}else{echo $m['personnel_cost_rate'].' %'; }?></th>
                                </foreach>
                            </tr>
                            <tr role="row" class="orders">
                                <td>状态</td>
                                <foreach name="manage" item="m">
                                    <th><a><b><?php if($m['statu']=="" || $m['statu']==0){echo '';}elseif($m['statu']==1){echo "待提交审核"; }elseif($m['statu']==2){echo "待提交批准"; }elseif($m['statu']==3){echo "待批准"; }?></b></a></th>
                                </foreach>
                            </tr>
                        </table><br><br>


                        <table class="table table-bordered dataTable fontmini" id="tablecenter1">
                            <tr role="row" class="orders" >
                                <th>部门</th>
                                <th>员工人数</th>
                                <th>营业收入</th>
                                <th>营业毛利</th>
                                <th>营业毛利率(%)</th>
                                <th>人力资源成本</th>
                                <th>其他费用</th>
                                <th>利润总额</th>
                                <th>人事费用率(%)</th>
                                <th>状态</th>
                            </tr>
                            <tr role="row" class="orders">
                                <form action="{:U('Manage/Manage_year_w')}" method="post">
                                    <td>
                                        <select name="department" class="form-control">
                                            <option value ="公司">公司</option>
                                            <option value ="京区业务中心">京区业务中心</option>
                                            <option value="京外业务中心">京外业务中心</option>
                                            <option value="南京项目部">南京项目部</option>
                                            <option value ="武汉项目部">武汉项目部</option>
                                            <option value ="沈阳项目部">沈阳项目部</option>
                                            <option value="长春项目部">长春项目部</option>
                                            <option value="市场部">市场部(业务)</option>
                                            <option value ="常规业务中心">常规业务中心</option>
                                            <option value ="机关部门">机关部门</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="number" class="form-control" placeholder="例如：50 或 50.29"></td>
                                    <td><input type="text" name="income" class="form-control" placeholder="例如：500.23 或 500"></td>
                                    <td><input type="text" name="profit" class="form-control" placeholder="例如：500.23 或 500"></td>
                                    <td><input type="text" name="rate" class="form-control" placeholder="例如：25.23 或 25"></td>
                                    <td><input type="text" name="cost" class="form-control"  placeholder="例如：500.23 或 500"></td>
                                    <td><input type="text" name="other" class="form-control" placeholder="例如：500.23 或 500"></td>
                                    <td><input type="text" name="total" class="form-control" placeholder="例如：500.23 或 500"></td>
                                    <td><input type="text" name="personnel" class="form-control" placeholder="例如：50.23 或 50"></td>
                                    <td><input type="submit" value="保存" style="background-color:#00acd6;font-size:1.5em;"></td>
                                </form>
                            </tr>

                        </table>

                        <div style="margin-top:2em;text-align:center;" id="shr_qianzi">

                            <form action="{:U('Manage/year_submit')}" method="post" style="<?php if($type==1){echo "display:none;";}else{echo "display:none;";}?>">
                                <p style="color:red;">(请确认自己部门数据预算后点击 <b>"提交审核"</b>)</p>
                                <input type="hidden" name="status" value="1">
                                <input type="submit" value="提交审核" class="btn btn-info" style="width:10em;">
                            </form>
                            <div style="<?php if($type==2){echo "";}else{echo "";}?>">
                                <a href="{:U('Manage/year_paprova',array('status'=>2))}" class="btn btn-info" style="width:10em;">提交批准</a>
                                <a href="{:U('Manage/year_paprova',array('type'=>1))}"  class="btn btn-info" style="width:10em;">驳回</a>
                            </div>
                            <div style="<?php if($type==3){echo "display:none;";}else{echo "display:none;";}?>">
                                <a href="{:U('Manage/year_approve',array('status'=>3))}" class="btn btn-info" style="width:10em;">批准</a>
                                <a href="{:U('Manage/year_approve',array('type'=>1))}"  class="btn btn-info" style="width:10em;">驳回</a>
                            </div>

                        </div><br><br>

                    </div><!-- /.box-body -->

                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />

<script>
    $('#custom1').jeDate({
        isinitVal:true,
        // 分隔符可以任意定义，该例子表示只显示年月
        format: 'YYYY/MM'
        // 可以将此改为    `format: 'YYYY'`     表示只显示年的插件
    });
</script>
