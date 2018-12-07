<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>团内支出报销</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 借款报销</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">借款报销</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                        <include file="loan_jk_content" />
                                </div>
                            </div>

                            <!--<div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目操作记录</h3>
                                </div>
                                <div class="box-body">
                                    <div class="content" style="padding:10px 30px;">
                                        <table rules="none" border="0">
                                            <tr>
                                                <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="160">操作时间</th>
                                                <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="100">操作人</th>
                                                <th style="border-bottom:2px solid #06E0F3; font-weight:bold;" width="500">操作说明</th>
                                            </tr>
                                            <foreach name="record" item="v">
                                                <tr>
                                                    <td style="padding:20px 0 0 0">{$v.op_time|date='Y-m-d H:i:s',###}</td>
                                                    <td style="padding:20px 0 0 0">{$v.uname}</td>
                                                    <td style="padding:20px 0 0 0">{$v.explain}</td>
                                                </tr>
                                            </foreach>
                                        </table>
                                    </div>
                                </div>
                            </div>-->

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->

                </section><!-- /.content -->

            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />





