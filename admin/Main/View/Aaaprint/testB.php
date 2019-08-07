<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Aaaprint/testB')}" name="myform" id="save_plans">
            <input type="hidden" name="dosubmint" value="1">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">


                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">

                                    <div class="form-group col-md-6">
                                        <label>开始时间：</label><input type="text" name="st" class="form-control inputdate" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>结束时间：</label><input type="text" name="et" class="form-control inputdate" required />
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                        <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">导出</button>
                        </div>

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
    <!--<script type="text/javascript">
        laydate.render({
            elem: '.inputdate',theme: '#0099CC',type: 'datetime'
        });
    </script>-->