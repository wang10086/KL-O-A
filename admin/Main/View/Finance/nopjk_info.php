<include file="Index:header2" />

<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>借款单详情</h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('Finance/jiekuan_lists')}"><i class="fa fa-gift"></i> 借款单管理</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">借款信息</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <?php if($jiekuan){ ?>
                            <div class="box-body" id="jiekuandan" >
                                <include file="nop_jiekuandan" />
                            </div>
                        <?php }else{ ?>
                            <div class="content" style="padding-top:40px;">  获取借款信息失败!</div>
                        <?php } ?>
                    </div>
                </div>

                <div class="box box-warning">
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
                                        <td style="padding:20px 0 0 0">{$v.time|date='Y-m-d H:i:s',###}</td>
                                        <td style="padding:20px 0 0 0">{$v.uname}</td>
                                        <td style="padding:20px 0 0 0">{$v.explain}</td>
                                    </tr>
                                </foreach>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!--/.col (right) -->
        </div>   <!-- /.row -->

    </section><!-- /.content -->

</aside><!-- /.right-side -->

</div>
</div>

<include file="Index:footer2" />




