<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">



                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">回访信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content mt20">
                                        <form method="post" action="{:U('Inspect/return_visit')}" id="myform">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="id" value="{$row.id}">
                                            <input type="hidden" name="opid" value="{$row.op_id}">

                                            <div class="form-group col-md-12">
                                                <label>客户联系方式</label>
                                                <input type="text" class="form-control" name="tel"  value="{$row.tel}" >
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>价格名称：</label>
                                                <textarea name="content" rows="3" style="width: 100%;" >{$row.content}</textarea>
                                            </div>
                                        </form>
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

    /*function check_field(){
        var kid = $('#k_id').val();
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/fields')}",
            data:{id:kid},
            success:function(msg){
                if(msg){
                    $("#field").empty();
                    var count = msg.length;
                    var i= 0;
                    var b="";
                    b+='<option value="" disabled selected>请选择学科领域</option>';
                    for(i=0;i<count;i++){
                        b+="<option value='"+msg[i].id+"'>"+msg[i].fname+"</option>";
                    }
                    $("#field").append(b);
                }else{
                    $("#field").empty();
                    var b='<option value="" disabled selected>无学科领域信息</option>';
                    $("#field").append(b);
                }

            }
        })
    }*/

</script>