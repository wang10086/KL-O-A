<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/public_pro_need')}"><i class="fa fa-gift"></i> 产品方案需求</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <include file="Product:pro_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">基本信息
                                        <?php echo $list['group_id'] ? "<span style='font-weight:normal; color:#ff3300;'>（团号：".$list['group_id']."）</span>" : ' <span style=" color:#999999;">(该项目暂未成团)</span>'; ?>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <span class="green">项目编号：{$list.op_id}</span> &nbsp;&nbsp;创建者：{$list.create_user_name}
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>客户名称：{$list.project}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>项目类型：{$kinds[$list['kind']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>递交客户时间：{$list.time|date='Y-m-d',###}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>适合人群：{$list['apply_to']}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                            <label>预计人数：{$list.number}人</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>计划出团日期：{$list.departure}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>行程天数：{$list.days}天</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>目的地省份：{$provinces[$list['province']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>详细地址：{$list.destination}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>客户单位：{$list.customer}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>接待实施部门：{$departments[$list['dijie_department_id']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>线控负责人：{$list.line_blame_name}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>客户预算：{$list.cost}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>业务人员：{$list.sale_user}</label>
                                            </div>

                                            <div class="form-group col-md-8">
                                                <label>业务部门：<?php echo $departments[$list['create_user_department_id']] ?></label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>备注：{$list.remark}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">项目评价</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><a style="color: #0BABD4;" href="javascript:;" onClick="get_qrcode(`/index.php?m=Main&c=Op&a=public_qrcode&opid={$list[op_id]}`)">获取二维码</a></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
                                            <?php if ($eval_lists){ ?>
                                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                                    <tr role="row" class="orders" >
                                                        <td>手机号</td>
                                                        <td>评价时间</td>
                                                        <td>问题反馈</td>
                                                        <td>意见建议</td>
                                                    </tr>
                                                    <foreach name="eval_lists" item="row">
                                                        <tr>
                                                            <td>{$row.mobile}</td>
                                                            <td>{$row.score_time|date='Y-m-d',###}</td>
                                                            <td>{$row.problem}</td>
                                                            <td>{$row.content}</td>
                                                        </tr>
                                                    </foreach>
                                                </table>
                                            <?php }else{ ?>
                                                暂无评价记录!
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->

            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    //获取评分二维码
    function get_qrcode(url) {
        art.dialog.open(url,{
            id:'qrcode',
            lock:true,
            title: '二维码',
            width:600,
            height:400,
            fixed: true,
        });
    }
</script>
