<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('GuideRes/addPriceKind')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$row['id']}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">



                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">价格体系</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">

                                        <div class="form-group col-md-4" onchange="check_con()">
                                            <label>项目类型</label>
                                            <select  class="form-control"  name="info[pk_id]" id="kid" required>
                                                <foreach name="pro_kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['pk_id'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)}{$v.name}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>价格名称：</label><input type="text" name="info[name]" class="form-control" value="{$row.name}" required />
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