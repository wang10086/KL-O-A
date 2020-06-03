<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/public_pro_need')}"><i class="fa fa-gift"></i> {$_action_}</a></li>
                        <li class="active">{$list.title}</li>
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
                                    <h3 class="box-title">基本信息</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"></h3>
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

                            <?PHP echo $list['kind']; ?>

                            <?php if (!$budget_list && in_array(cookie('userid'),array(10,$list['create_user'],$list['line_blame_uid']))){ ?>
                                <?php if ($list['kind'] == 60){ ?> <!--60=>科学课程-->
                                    <include file="customer_need_60_edit" />
                                <?php }elseif ($list['kind'] == 82){ ?> <!--82=>科学博物园-->
                                    <include file="customer_need_82_edit" />
                                <?php }elseif ($list['kind'] == 54){ ?> <!--54=>研学旅行-->
                                    <include file="customer_need_54_edit" />
                                <?php }elseif ($list['kind'] == 90){ ?> <!--90=>背景提升-->
                                    <include file="customer_need_90_edit" />
                                <?php }elseif ($list['kind'] == 67){ ?> <!--67=>实验室建设-->
                                    <include file="customer_need_67_edit" />
                                <?php }elseif ($list['kind'] == 69){ ?> <!--69=>科学快车-->
                                    <include file="customer_need_69_edit" />
                                <?php }elseif ($list['kind'] == 56){ ?> <!--56=>校园科技节-->
                                    <include file="customer_need_56_edit" />
                                <?php }elseif ($list['kind'] == 61){ ?> <!--61=>小课题-->
                                    <include file="customer_need_61_edit" />
                                <?php }elseif ($list['kind'] == 87){ ?> <!--87=>单进院所-->
                                    <include file="customer_need_87_edit" />
                                <?php }elseif ($list['kind'] == 64){ ?> <!--64=>专场讲座-->
                                    <include file="customer_need_64_edit" />
                                <?php }elseif ($list['kind'] == 57){ ?> <!--57=>综合实践-->
                                    <include file="customer_need_57_edit" />
                                <?php }elseif ($list['kind'] == 65){ ?> <!--65=>教师培训-->
                                    <include file="customer_need_65_edit" />
                                <?php } ?>
                            <?php }else{ ?>
                                <?php if ($list['kind'] == 60){ ?> <!--60=>科学课程-->
                                    <include file="customer_need_60_read" />
                                <?php }elseif ($list['kind'] == 82){ ?> <!--82=>科学博物园-->
                                    <include file="customer_need_82_read" />
                                <?php }elseif ($list['kind'] == 54){ ?> <!--54=>研学旅行-->
                                    <include file="customer_need_54_read" />
                                <?php }elseif ($list['kind'] == 90){ ?> <!--90=>背景提升-->
                                    <include file="customer_need_90_read" />
                                <?php }elseif ($list['kind'] == 67){ ?> <!--67=>实验室建设-->
                                    <include file="customer_need_67_read" />
                                <?php }elseif ($list['kind'] == 69){ ?> <!--69=>科学快车-->
                                    <include file="customer_need_69_read" />
                                <?php }elseif ($list['kind'] == 56){ ?> <!--56=>校园科技节-->
                                    <include file="customer_need_56_read" />
                                <?php }elseif ($list['kind'] == 61){ ?> <!--61=>小课题-->
                                    <include file="customer_need_61_read" />
                                <?php }elseif ($list['kind'] == 87){ ?> <!--87=>单进院所-->
                                    <include file="customer_need_87_read" />
                                <?php }elseif ($list['kind'] == 64){ ?> <!--64=>专场讲座-->
                                    <include file="customer_need_64_read" />
                                <?php }elseif ($list['kind'] == 57){ ?> <!--57=>综合实践-->
                                    <include file="customer_need_57_read" />
                                <?php }elseif ($list['kind'] == 65){ ?> <!--65=>教师培训-->
                                    <include file="customer_need_65_read" />
                                <?php } ?>
                            <?php } ?>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->

            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">


</script>
