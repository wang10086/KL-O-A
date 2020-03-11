<include file="Index:header2" />
<style>
    #btn-default_1{
        background-color:#00acd6;
    }
</style>
<aside class="right-side">

    <section class="content-header">
        <h1><a ></a>{$title}<small>{$year}年{$month}月</small></h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> {$title}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">{$title}</h3>
                        <h3 class="box-title pull-right">
                            <span class=" green">被考核人：{$userinfo.nickname}</span>
                        </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                        <div class="btn-group" id="catfont">
                            <a href="{:U('Kpi/public_expert_achivement',array('year'=>$year,'month'=>$month,'st'=>$st,'et'=>$et,'uid'=>$uid,'pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">本人研发设计的产品/方案</a>
                            <a href="{:U('Kpi/public_expert_achivement',array('year'=>$year,'month'=>$month,'st'=>$st,'et'=>$et,'uid'=>$uid,'pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">协助他人设计的产品/方案</a>
                        </div>

                        <table class="table table-bordered dataTable fontmini" id="tablecenter">
                            <tr role="row" class="orders" style="text-align:center;" >
                                <th class="black">项目编号</th>
                                <th class="black">团号</th>
                                <th class="black">项目名称</th>
                                <th class="black">业务</th>
                                <th class="black">结算毛利</th>
                                <?php if ($pin == 2){ ?>
                                    <th class="black">协助权重</th>
                                    <th class="black">权重毛利</th>
                                <?php } ?>
                            </tr>

                            <foreach name="lists" item="v">
                                <tr>
                                    <td>{$v.op_id}</td>
                                    <td>{$v.group_id}</td>
                                    <td>{$v.project}</td>
                                    <td>{$v.create_user_name}</td>
                                    <td>{$v.maoli}</td>
                                    <?php if ($pin == 2){ ?>
                                    <td>{$v.expert_weight}</td>
                                    <td>{$v.expert_weight_maoli}</td>
                                    <?php } ?>
                                </tr>
                            </foreach>

                            <tr class="black">
                                <td>合计</td>
                                <td colspan="<?php echo $pin==2 ? 6 : 4; ?>">{$sum_profit}</td>
                            </tr>
                        </table>
                        <br><br>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div><!--/.col (right) -->

        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->


<include file="Index:footer2" />
