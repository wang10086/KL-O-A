<form method="post" action="{:U('Task/public_save')}" id="tcs_need_form">
    <div class="tcsbox">
        <input type="hidden" name="dosubmint" value="1">
        <input type="hidden" name="opid" value="{$opid}">
        <input type="hidden" name="savetype" value="3">
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">

                <div class="tcscon">
                    <div class="box-body mb-50">
                        <div class="content" style="padding-top:0px;">
                            <div id="tcs">
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
                                <?php if($guide_price){ ?>
                                    <foreach name="guide_price" key="k" item="v">
                                        <div class="userlist no-border" id="tcs_id_{$v.id}">
                                            <div id="tcs_val">0</div>
                                            <script>{++$k}; var n = parseInt($('#tcs_val').text());n++;$('#tcs_val').text(n);</script>
                                            <span class="title"><?php echo $k; ?></span>
                                            <select  class="form-control" style="width:12%"  name="data[{$k}][guide_kind_id]" id="se_{$k}" onchange="getPrice({$k})">
                                                <foreach name="guide_kind" key="key" item="value">
                                                    <option value="{$key}" <?php if($v['guide_kind_id']==$key) echo 'selected'; ?>>{$value}</option>
                                                </foreach>
                                            </select>
                                            <select  class="form-control " style="width:12%"  name="data[{$k}][gpk_id]" id="gpk_id_{$k}" onchange="getPrice({$k})">
                                                <foreach name="price_kind" key="key" item="value">
                                                    <option value="{$value.id}" <?php if($v['gpk_id']==$value['id']) echo 'selected'; ?>>{$value.name}</option>
                                                </foreach>
                                            </select>
                                            <select  class="form-control" style="width:12%"  name="data[{$k}][field]">
                                                <foreach name="field" key="key" item="value">
                                                    <option value="{$key}" <?php if($v['field_id']==$key) echo 'selected'; ?>>{$value}</option>
                                                </foreach>
                                            </select>
                                            <input type="text" class="form-control" style="width:5%" name="data[{$k}][num]" value="{$v.num}" id="num_{$k}" onblur="getTotal({$k})">
                                            <input type="text" class="form-control" style="width:8%" name="data[{$k}][price]" value="{$v.price}" id="dj_{$k}" onblur="getTotal({$k})">
                                            <input type="text" class="form-control" style="width:8%" name="data[{$k}][total]" value="{$v.total}" id="total_{$k}">
                                            <input type="text" class="form-control" style="width:18%" name="data[{$k}][remark]" value="{$v.remark}">
                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="deltcsbox('tcs_id_{$v.id}')">删除</a>
                                        </div>
                                    </foreach>
                                <?php }else{ ?>
                                    <div class="userlist no-border" id="tcs_id">
                                        <span class="title">1</span>
                                        <select  class="form-control" style="width:12%"  name="data[1][guide_kind_id]" id="se_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                            <foreach name="guide_kind" key="k" item="v">
                                                <option value="{$k}">{$v}</option>
                                            </foreach>
                                        </select>

                                        <select  class="form-control" style="width:12%"  name="data[1][gpk_id]" id="gpk_id_1" onchange="getPrice(1)">
                                            <option value="" selected disabled>请选择</option>
                                        </select>
                                        <select  class="form-control" style="width:12%"  name="data[{$k}][field]">
                                            <foreach name="field" key="key" item="value">
                                                <option value="{$key}" <?php if($v['field_id']==$key) echo 'selected'; ?>>{$value}</option>
                                            </foreach>
                                        </select>
                                        <input type="text" class="form-control" style="width:5%" name="data[1][num]" id="num_1" onblur="getTotal(1)" value="">
                                        <input type="text" class="form-control" style="width:8%" name="data[1][price]" id="dj_1" onblur="getTotal(1)" value="">
                                        <input type="text" class="form-control" style="width:8%" name="data[1][total]" id="total_1" value="">
                                        <input type="text" class="form-control" style="width:18%" name="data[1][remark]" value="">
                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="deltcsbox('tcs_id')">删除</a>
                                        <div id="tcs_val">1</div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-group col-md-12" id="useraddbtns">
                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_tcs()"><i class="fa fa-fw fa-plus"></i> 人员信息</a>
                                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('tcs_need_form','<?php echo U('Task/public_save'); ?>',{$op.op_id});">保存</a>
                            </div>
                            <div class="form-group">&nbsp;</div>
                        </div>
                    </div><!-- /.box-body -->

                    <div style="width:100%; text-align:center;">
                        <!--<a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('tcs_need_form','<?php /*echo U('Op/public_save'); */?>',{$op.op_id});">保存</a>-->
                    </div>
                </div><!--/.col (right) -->
            </div>
        </div><!-- /.box-body -->
    </div>
</form>

<script>
    var price_kind = '';
    var opid    = <?php echo $op['op_id']; ?>;

    $(function(){
        /* $('#hide_div').html('');*/

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


    /*function checkPrice(i){
        var pro_kind = <?php echo $pro_kind; ?>;
        var gpk_id = $('#cp_'+i).val();
        var guide_id = $('#guide_'+i).val();
        //var fee      = $('#cost_'+i).val(); //单价
        var num      = $('#gnum_'+i).val();
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/get_guide_price')}",
            data:{pro_kind:pro_kind,gpk_id:gpk_id,guide_id:guide_id,opid:opid},
            success:function(msg){
                if(msg){
                    $('#cost_'+i).val(msg);
                    /!*var total = parseFloat(num)*parseFloat(msg);
                     $('#total_'+i).html("&yen;"+total);*!/
                    total();
                }

            }
        })
    }
*/

    /*//更新价格与数量
     function total(){
     $('.expense').each(function(index, element) {
     $(this).find('.cost').blur(function(){
     var cost = $(this).val();
     var amount = $(this).parent().parent().find('.amount').val();
     $(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));
     $(this).parent().parent().find('.cost_cost').val(cost);
     $(this).parent().parent().find('.totalval').val(accMul(cost,amount));
     });
     $(this).find('.amount').blur(function(){
     var amount = $(this).val();
     var cost = $(this).parent().parent().find('.cost').val();
     $(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));
     $(this).parent().parent().find('.cost_amount').val(amount);
     $(this).parent().parent().find('.totalval').val(accMul(cost,amount));
     });
     $(this).find('.sel-pk').blur(function(){
     var amount = $(this).parent().parent().find('.amount').val();
     var cost = $(this).parent().parent().find('.cost').val();
     $(this).parent().parent().find('.total').html('&yen;'+accMul(cost,amount));
     $(this).parent().parent().find('.cost_amount').val(amount);
     $(this).parent().parent().find('.totalval').val(accMul(cost,amount));
     });
     });
     }*/

    //编号
    function orderno(){
        /*$('#guidelist').find('.title').each(function(index, element) {
         $(this).text(parseInt(index)+1);
         });*/
        $('#tcs').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
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

    artDialog.alert = function (content, status) {
        return artDialog({
            id: 'Alert',
            icon: status,
            width:300,
            height:120,
            fixed: true,
            lock: true,
            time: 1,
            content: content,
            ok: true
        });
    };


    //新增辅导员/教师、专家
    function add_tcs(){
        var i = parseInt($('#tcs_val').text())+1;
        var html = '<div class="userlist no-border" id="tcs_'+i+'">' +
            '<span class="title"></span> ' +
            '<select  class="form-control" style="width:12%" name="data['+i+'][guide_kind_id]" id="se_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="guide_kind" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<select  class="form-control gpk" style="width:12%" name="data['+i+'][gpk_id]" id="gpk_id_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="hotel_start" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<select  class="form-control" style="width:12%"  name="data[{$k}][field]"> <foreach name="field" key="key" item="value"> <option value="{$key}">{$value}</option> </foreach> </select>'+
            '<input type="text"  class="form-control" style="width:5%" name="data['+i+'][num]" id="num_'+i+'" onblur="getTotal('+i+')" > ' +
            '<input type="text"  class="form-control" style="width:8%" name="data['+i+'][price]" id="dj_'+i+'" value="" onblur="getTotal('+i+')">' +
            '<input type="text"  class="form-control" style="width:8%" name="data['+i+'][total]" id="total_'+i+'">' +
            '<input type="text"  class="form-control" style="width:18%" name="data['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="deltcsbox(\'tcs_'+i+'\')">删除</a></div>';
        $('#tcs').append(html);
        $('#tcs_val').html(i);
        assign_option(i);
        orderno();
    }

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
            url:"{:U('Ajax/get_guide_price')}",
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

    //移除
    function deltcsbox(obj){
        $('#'+obj).remove();
        orderno();
    }
</script>
