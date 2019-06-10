<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Sale/public_save')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="savetype" value="2">
                <input type="hidden" name="info[kind_id]" value="{$row['id']}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">



                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">最低毛利率设置</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">

                                        <div class="form-group col-md-4">
                                            <label>项目类型</label><input type="text" name="info[kind]" class="form-control" value="{$row['name']}" readonly />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>最低毛利率：</label><input type="text" name="info[gross]" class="form-control" value="{$row.gross}" required />
                                        </div>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <!--<div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认添加</button>
                            </div>-->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />