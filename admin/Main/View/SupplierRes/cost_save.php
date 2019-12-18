<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2018){ ?>
                                    <a href="{:U('SupplierRes/public_cost_save',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <a href="{:U('SupplierRes/public_cost_save',array('year'=>$year,'type'=>$year.'-1'))}" class="btn <?php echo $type==$year.'-1' ? 'btn-info' : 'btn-default'; ?>" style="padding:8px 18px;">{$year}年寒假</a>
                                <a href="{:U('SupplierRes/public_cost_save',array('year'=>$year,'type'=>$year.'-2'))}" class="btn <?php echo $type==$year.'-2' ? 'btn-info' : 'btn-default'; ?>" style="padding:8px 18px;">{$year}年春季</a>
                                <a href="{:U('SupplierRes/public_cost_save',array('year'=>$year,'type'=>$year.'-3'))}" class="btn <?php echo $type==$year.'-3' ? 'btn-info' : 'btn-default'; ?>" style="padding:8px 18px;">{$year}年暑假</a>
                                <a href="{:U('SupplierRes/public_cost_save',array('year'=>$year,'type'=>$year.'-4'))}" class="btn <?php echo $type==$year.'-4' ? 'btn-info' : 'btn-default'; ?>" style="padding:8px 18px;">{$year}年秋季</a>
                                <?php if($year<(date('Y')+1)){ ?>
                                    <a href="{:U('SupplierRes/public_cost_save',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                        <if condition="rolemenu(array('SupplierRes/cost_save_add'))">
                                            <a href="{:U('SupplierRes/cost_save_add')}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> 新增集采内容</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="60">序号</th>
                                            <th class="taskOptions">集中采购方</th>
                                            <th class="taskOptions">计价规则</th>
                                            <th class="taskOptions">计价单位</th>
                                            <th class="taskOptions">集采差价</th>
                                            <th class="taskOptions">基准单价</th>
                                            <th class="taskOptions">集采成本降低率</th>
                                            <th width="60" class="taskOptions">详情</th>
                                            <!--<if condition="rolemenu(array('SupplierRes/cost_save_add'))">-->
                                            <th width="60" class="taskOptions">编辑</th>
                                            <!--</if>-->
                                            <th width="60" class="taskOptions">录入基准单价</th>
                                            <th width="60" class="taskOptions">删除</th>
                                        </tr>
                                        <foreach name="lists" key="k" item="v">
                                            <tr>
                                                <td class="taskOptions">{$k+1}</td>
                                                <td class="taskOptions"><a href="{:U('SupplierRes/res_view',array('id'=>$v['supplier_id']))}">{$v.supplier_name}</a></td>
                                                <td class="taskOptions" style="max-width: 150px;">{$v.rule}</td>
                                                <td class="taskOptions">{$v.unit}</td>
                                                <td class="taskOptions">{$v.}</td>
                                                <td class="taskOptions">{$v.business_unitcost}</td>
                                                <td class="taskOptions">{$v.average}</td>
                                                <td class="taskOptions">
                                                    <a href="javascript:;" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                </td>
                                                <td class="taskOptions">
                                                    <a href="{:U('SupplierRes/cost_save_add',array('id'=>$v['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                </td>
                                                <td class="taskOptions">
                                                    <a href="javascript:;" title="录入基准单价" class="btn btn-info btn-smsm"><i class="fa fa-money"></i></a>
                                                </td>
                                                <td class="taskOptions">
                                                    <a href="javascript:;" title="详情" class="btn btn-danger btn-smsm"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<script type="text/javascript">
    //查看考核指标详情
    function detail(id) {
        art.dialog.open('index.php?m=Main&c=SupplierRes&a=public_focus_buy_info&id='+id,{
            lock:true,
            title: '集中采购执行率',
            width:800,
            height:400,
            fixed: true,

        });
    }
</script>

<include file="Index:footer2" />
