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
        <h1><?php echo $year;?>季度预算录入</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Manage/Manage_year')}"><i class="fa fa-gift"></i> 季度预算报表</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">季度预算录入</h3>

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
                                <th style="width:10em;" ><b>状态</b></th>
                            </tr>
                            <tr role="row" class="orders">
                                <th>员工人数</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>

                            <tr role="row" class="orders">
                                <td>营业收入</td>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业毛利</td>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr role="row" class="orders">
                                <td>营业毛利率(%)</td>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr role="row" class="orders">
                                <td>人力资源成本</td>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr role="row" class="orders">
                                <td>其他费用</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <th></th>
                            </tr>
                            <tr role="row" class="orders">
                                <td>利润总额</td>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr role="row" class="orders">
                                <td>人事费用率</td>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </table><br><br>


                        <table class="table table-bordered dataTable fontmini" id="tablecenter1">
                            <tr role="row" class="orders" >
                                <th>预算季度</th>
                                <th>部门</th>
                                <th>员工人数</th>
                                <th>营业收入</th>
                                <th>营业毛利</th>
                                <th>营业毛利率(%)</th>
                                <th>人力资源成本</th>
                                <th>其他费用</th>
                                <th>利润总额</th>
                                <th>人事费用率</th>
                                <th>状态</th>
                            </tr>
                            <tr role="row" class="orders">
                                <td><input type="text" class="form-control yearly" name="datetime"></td>
                                <form action="{:U('Manage/Manage_quarter_w')}" method="post" id="searchform">
                                    <td>
                                        <select name="type" class="form-control">
                                            <option value ="1">第一季度</option>
                                            <option value ="2">第二季度</option>
                                            <option value="3">第三季度</option>
                                            <option value="4">第四季度</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select name="department" class="form-control">
                                            <option value ="公司">公司</option>
                                            <option value ="京区业务中心">京区业务中心</option>
                                            <option value="京外业务中心">京外业务中心</option>
                                            <option value="南京项目部">南京项目部</option>
                                            <option value ="武汉项目部">武汉项目部</option>
                                            <option value ="沈阳项目部">沈阳项目部</option>
                                            <option value="长春项目部">长春项目部</option>
                                            <option value="市场部(业务)">市场部(业务)</option>
                                            <option value ="常规业务中心">常规业务中心</option>
                                            <option value ="机关部门">机关部门</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="number" class="form-control"></td>
                                    <td><input type="text" name="income" class="form-control"></td>
                                    <td><input type="text" name="profit" class="form-control"></td>
                                    <td><input type="text" name="rate" class="form-control"></td>
                                    <td><input type="text" name="cost" class="form-control"></td>
                                    <td><input type="text" name="other" class="form-control"></td>
                                    <td><input type="text" name="total" class="form-control"></td>
                                    <td><input type="text" name="personnel" class="form-control"></td>
                                    <td><input type="button" value="保存" style="background-color:#00acd6;font-size:1.5em;" class="salary_add_button"></td>
                                </form>
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

</script>