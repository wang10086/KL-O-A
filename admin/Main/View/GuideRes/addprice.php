<include file="Index:header2" />


            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        导游辅导员价格体系
                        <small>{$pagedesc}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('GuideRes/price')}"><i class="fa fa-gift"></i> {$pagetitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('GuideRes/addprice')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$row['id']}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">



                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">添加数据</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">

                                        <div class="form-group col-md-6">
                                            <label>职务</label>
                                            <select  class="form-control"  name="info[gk_id]" required>
                                                <foreach name="kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['gk_id'])) echo ' selected'; ?> >{$v.name}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6" onchange="check_con()">
                                            <label>类型</label>
                                            <select  class="form-control"  name="info[kid]" id="kid" required>
                                                <foreach name="pro_kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kid'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)}{$v.name}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <div><label>备注</label></div>
                                            <textarea name="info[remark]" class="wbk-style" >{$row['remark']}</textarea>
                                        </div>

                                        <div id="choose_con">

                                        </div>

                                        <style>
                                            .wbk-style{width: 100%;}
                                        </style>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认添加</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

        <div id="hide" style="height: 50px;">
            <div id="pub_price">
                <div class="form-group col-md-12">
                    <label>价格：</label><input type="text" name="info[price]" class="form-control" value="{$row.price}" required />
                </div>
            </div>

            <div id="price_lists">
                <div class="box-body mb-50">
                    <div class="content" style="padding-top:0px;">
                        <div id="choose">
                            <h3 class="price-title">价格信息</h3>
                            <div class="userlist form-title">
                                <div class="unitbox lp_remark">名称</div>
                                <div class="unitbox lp_remark">价格</div>
                            </div>
                            <?php if($pricelists){ ?>
                                <foreach name="pricelists" key="k" item="v">
                                    <div class="userlist no-border" id="choose_id_{$v.id}">
                                        <span class="title"><?php echo $k+1; ?></span>
                                        <select  class="form-control lp_remark"  name="data[{$k}][price_kind_id]" id="sele_con_$k+1">
                                            <foreach name="dataPrice" key="key" item="value">
                                                <option value="{$value['id']}" <?php if($v['kid'] == $value['id']) echo 'selected'; ?>>{$value.name}</option>
                                            </foreach>
                                        </select>
                                        <input type="text" class="form-control lp_remark" name="data[{$k}][price]" value="{$v.price}" >
                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('choose_id_{$v.id}')">删除</a>
                                    </div>
                                </foreach>
                            <?php }else{ ?>
                                <div class="userlist no-border" id="choose_id">
                                    <span class="title">1</span>
                                    <select  class="form-control lp_remark"  name="data[1][price_kind_id]" id="sele_con">
                                        <option value="" selected disabled>请选择</option>
                                        <foreach name="dataPrice" key="k" item="v">
                                            <option value="{$k}">{$v}</option>
                                        </foreach>
                                    </select>
                                    <input type="text" class="form-control lp_remark" name="data[1][price]" value="">
                                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('choose_id')">删除</a>
                                </div>
                            <?php } ?>
                        </div>

                        <div id="choose_val">1</div>
                        <div class="form-group col-md-12" id="useraddbtns">
                            <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_choose()"><i class="fa fa-fw fa-plus"></i> 添加价格信息</a>
                        </div>
                        <div class="form-group">&nbsp;</div>
                    </div>
                </div><!-- /.box-body -->
            </div>
        </div>
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">
    $(function(){
        var pub_con = $('#pub_price').html();
        var pl_con  = $('#price_lists').html();
        var pricelist = <?php echo $judge; ?>;
        if(pricelist){
            check_con();
            $('#choose_con').html(pl_con);
        }else{
            $('#choose_con').html(pub_con);
        }
        $('#hide').hide();

    });

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

    var dataPrice = '';

    function check_con(){
        var kid         = $('#kid').val();
        var pub_price   = $('#pub_price').html();
        var price_lists = $('#price_lists').html();
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/gui_price')}",
            data:{kid:kid},
            async : false,
            success:function(msg){
                if(msg){
                    //$('#choose_con').html(price_lists);
                    $("#field").empty();
                    var count = msg.length;
                    var a= 0;
                    var b="";
                    b+='<option value="" disabled selected>请选择分类</option>';
                    for(a=0;a<count;a++){
                        b+="<option value='"+msg[a].id+"'>"+msg[a].name+"</option>";
                    }
                    $('#choose_con').html(price_lists);
                    $('#sele_con').html(b);
                    dataPrice = b;    //全局变量
                }else{
                    $('#choose_con').html(pub_price);
                }

            }
        })
    }

    //新增可选(星级)价格政策
    function add_choose(){
        var i = parseInt($('#choose_val').text())+1;
        var html = '<div class="userlist no-border" id="choose_'+i+'"><span class="title"></span> <select  class="form-control lp_remark"  name="data['+i+'][price_kind_id]" id="sele_con_'+i+'"> <option value="" selected disabled>请选择</option> <foreach name="dataPrice" key="k" item="v"> <option value="{$k}">{$v}</option> </foreach> </select> <input type="text"  class="form-control lp_remark" name="data['+i+'][price]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'choose_'+i+'\')">删除</a></div>';
        $('#choose').append(html);
        $('#choose_val').html(i);
        orderno();
        options('sele_con_'+i);
    }

    //填充后续生成的select下拉框中的option
    function options(sid){
        if(dataPrice){
            $("#"+sid).html(dataPrice);
        }
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
    }

    //编号
    function orderno(){
        $('#choose').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });

    }
</script>