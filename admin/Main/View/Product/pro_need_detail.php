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
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        方案进程：{$op_process[$list['process']]}
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">

                                        <?php if (!$budget_list && in_array(cookie('userid'), array(1,11,$list['create_user']))){ ?>
                                            <include file="Product:pro_need_base_edit" />
                                        <?php }else{ ?>
                                            <include file="Product:pro_need_base_read" />
                                        <?php } ?>
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
                            <?php }elseif ($list['kind'] == 69){ ?> <!--69=>科学快车-->
                                <include file="pro_69_read" />
                            <?php }elseif ($list['kind'] == 56){ ?> <!--56=>校园科技节-->
                                <include file="pro_56_read" />
                            <?php }elseif ($list['kind'] == 61){ ?> <!--61=>小课题-->
                                <include file="pro_61_read" />
                            <?php }elseif ($list['kind'] == 87){ ?> <!--87=>单进院所-->
                                <include file="pro_87_read" />
                            <?php }elseif ($list['kind'] == 64){ ?> <!--64=>专场讲座-->
                                <include file="pro_64_read" />
                            <?php }elseif ($list['kind'] == 57){ ?> <!--57=>综合实践-->
                                <include file="pro_57_read" />
                            <?php }elseif ($list['kind'] == 65){ ?> <!--65=>教师培训-->
                                <include file="pro_65_read" />
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
