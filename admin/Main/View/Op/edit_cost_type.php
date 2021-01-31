<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

        <aside class="right-side">
            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Op/edit_cost_type')}" name="myform" id="myform">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="id" value="{$row['id']}">
                <div class="row">
                        <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">编辑费用项</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">
                                    <div class="form-group col-md-4">
                                        <label>费用项名称：</label><input type="text" name="name" class="form-control" value="{$row.name}" required />
                                    </div>

                                </div>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />
