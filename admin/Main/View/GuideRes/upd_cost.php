<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('GuideRes/upd_cost')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="op_id" value="{$op_id}">
                <input type="hidden" name="remark" value="{$name}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">



                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">实际提成[{$name}]</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        
                                        <div class="form-group col-md-4">
                                            <label>应得提成信息：</label>
                                            <input type="text" class="form-control" value="{$cost}" readonly>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>实际所得提成：</label>
                                            <input type="text" name="info[really_cost]" class="form-control" required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>备注：</label>
                                            <input type="text" name="info[upd_remark]" class="form-control" required />
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
