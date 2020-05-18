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

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">基本信息</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        审核状态：{$status[$list['status']]}
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">

                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>客户名称：{$list.title}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>项目类型：{$kinds[$list['kind']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>递交客户时间：{$list.time|date='Y-m-d',###}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>适合人群：{$apply_to[$list['apply_to']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                            <label>预计人数：{$list.number}人</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>计划出团日期：{$list.departure|date='Y-m-d',###}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>行程天数：{$list.days}天</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>目的地省份：{$provinces[$list['province']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>详细地址：{$list.addr}</label>
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

                                            <div class="form-group col-md-12">
                                                <label>备注：{$list.remark}</label>
                                            </div>

                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php if ($list['kind'] == 60){ ?> <!--60=>科学课程-->
                                <include file="pro_60_read" />
                            <?php }elseif ($list['kind'] == 82){ ?> <!--82=>科学博物园-->
                                <include file="pro_82_read" />
                            <?php }elseif ($list['kind'] == 54){ ?> <!--54=>研学旅行-->
                                <include file="pro_54_read" />
                            <?php }elseif ($list['kind'] == 90){ ?> <!--90=>背景提升-->
                                <include file="pro_90_read" />
                            <?php }elseif ($list['kind'] == 67){ ?> <!--67=>实验室建设-->
                                <include file="pro_67_read" />
                            <?php } ?>

                            <!--审核-->
                            <?php if ($list['status'] == 3 && in_array(cookie('userid'),array(1,11,$list['audit_uid']))){ ?>
                                <include file="pro_audit_box" />
                            <?php } ?>


                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->

            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">


</script>
