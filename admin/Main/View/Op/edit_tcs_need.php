<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Op/edit_tcs_need')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="confirm_id" value="{$row['cid']}">
                <input type="hidden" name="price_id" value="{$row['pid']}">

                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">修改需求信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" >

                                        <div class="form-group col-md-4">
                                            <label>活动日期：</label>
                                            <input type="text" name="in_day" class="form-control inputdate" value="" required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>活动时间(请填写具体时间段)：</label>
                                            <input type="text" name="tcs_time" class="form-control inputdate_b" value="" required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>活动地点：</label>
                                            <input type="text" name="address"  class="form-control" value="" required />
                                        </div>
                                        <div class="form-group col-md-12"></div>

                                        <div id="tcs" class="tcs">
                                            <!--<h3 class="price-title">辅导员/教师、专家需求</h3>-->
                                            <div class="userlist form-title">
                                                <div class="unitbox" style="width:12%">职务</div>
                                                <div class="unitbox" style="width:12%">职能类型</div>
                                                <div class="unitbox" style="width:12%">所属领域</div>
                                                <div class="unitbox" style="width:5%">人数</div>
                                                <div class="unitbox" style="width:8%">单价</div>
                                                <div class="unitbox" style="width:8%">合计</div>
                                                <div class="unitbox" style="width:18%">备注</div>
                                            </div>

                                            <div class="userlist no-border" id="tcs_id">
                                                <span class="title"></span>
                                                <select  class="form-control" style="width:12%"  name="data[1][guide_kind_id]" id="se_1" onchange="getPrice(1)">
                                                    <option value="" selected disabled>请选择</option>
                                                    <foreach name="guide_kind" key="k" item="v">
                                                        <option value="{$k}">{$v}</option>
                                                    </foreach>
                                                </select>

                                                <select  class="form-control" style="width:12%"  name="data[1][gpk_id]" id="gpk_id_1" onchange="getPrice(1)">
                                                    <option value="" selected disabled>请选择</option>
                                                </select>
                                                <select  class="form-control" style="width:12%"  name="data[1][field]">
                                                    <option value="" selected disabled>请选择</option>
                                                    <foreach name="fields" key="key" item="value">
                                                        <option value="{$key}" <?php if($v['field']==$key) echo 'selected'; ?>>{$value}</option>
                                                    </foreach>
                                                </select>
                                                <input type="text" class="form-control" style="width:5%" name="data[1][num]" id="num_1" onblur="getTotal(1)" value="1">
                                                <input type="text" class="form-control" style="width:8%" name="data[1][price]" id="dj_1" onblur="getTotal(1)" value="">
                                                <input type="text" class="form-control" style="width:8%" name="data[1][total]" id="total_1" value="">
                                                <input type="text" class="form-control" style="width:18%" name="data[1][remark]" value="">
                                            </div>

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

<script>

    var price_kind = '';
    var opid    = <?php echo $opid; ?>;
    var fields  = <?php echo $fields; ?>

        $(function(){

            $.ajax({
                type:"POST",
                url:"{:U('Ajax/get_gpk')}",
                data:{opid:opid},
                success:function(msg){
                    if(msg){
                        price_kind = msg;
                        $(".gpk").empty();
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                        $(".gpk").append(b);
                        //获取职能类型信息
                        assign_option(1);
                    }else{
                        $(".gpk").empty();
                        var b='<option value="" disabled selected>无数据</option>';
                        $(".gpk").append(b);
                        assign_option(1);
                    }
                }
            })

        })


    function assign_option(a){
        if(price_kind){
            $("#gpk_id_"+a).empty();
            var count = price_kind.length;
            var i= 0;
            var b="";
            b+='<option value="" disabled selected>请选择</option>';
            for(i=0;i<count;i++){
                b+="<option value='"+price_kind[i].id+"'>"+price_kind[i].name+"</option>";
            }
            $("#gpk_id_"+a).append(b);
        }else{
            $("#gpk_id_"+a).empty();
            var b='<option value="" disabled selected>无数据</option>';
            $("#gpk_id_"+a).append(b);
        }
    }

    //获取单价信息
    function getPrice(a){
        var guide_kind_id = $('#se_'+a).val();
        var gpk_id        = $('#gpk_id_'+a).val();
        $.ajax({
            type:'POST',
            url:"{:U('Ajax/getPrice')}",
            data:{guide_kind_id:guide_kind_id,gpk_id:gpk_id,opid:opid},
            success:function(msg){
                $('#dj_'+a).val(msg);
                getTotal(a);
            }
        })
    }

    //获取人数,计算出总价格\
    function getTotal(a){
        var num     = parseInt($('#num_'+a).val());
        var price   = parseFloat($('#dj_'+a).val());
        var total   = num*price;
        $('#total_'+a).val(total);
    }


    //保存信息
    function save(id,url,opid){
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                if(parseInt(data)>0){
                    art.dialog.alert('保存成功','success');
                }else{
                    art.dialog.alert('保存失败','warning');
                }
            }
        });

        setTimeout("history.go(0)",1000);

    }



</script>