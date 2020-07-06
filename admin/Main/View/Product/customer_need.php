<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/public_pro_need')}"><i class="fa fa-gift"></i> {$_action_}</a></li>
                        <li class="active">{$list.title}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <include file="Product:pro_navigate" />

                            <div class="box box-warning mt20">
                                <div class="box-header">
                                    <h3 class="box-title">基本信息
                                        <?php echo $list['group_id'] ? "<span style='font-weight:normal; color:#ff3300;'>（团号：".$list['group_id']."）</span>" : ' <span style=" color:#999999;">(该项目暂未成团)</span>'; ?>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <span class="green">项目编号：{$list.op_id}</span> &nbsp;&nbsp;创建者：{$list.create_user_name}
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>客户名称：{$list.project}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>项目类型：{$kinds[$list['kind']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>递交客户时间：{$list.time|date='Y-m-d',###}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>适合人群：{$list['apply_to']}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                            <label>预计人数：{$list.number}人</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>计划出团日期：{$list.departure}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>行程天数：{$list.days}天</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>目的地省份：{$provinces[$list['province']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>详细地址：{$list.destination}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>客户单位：{$list.customer}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>接待实施部门：{$departments[$list['dijie_department_id']]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>线控负责人：{$list.line_blame_name}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>客户预算：{$list.cost}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>业务人员：{$list.sale_user}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>业务部门：<?php echo $departments[$list['create_user_department_id']] ?></label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>合同签订完成时间：{$confirm['contract_sign_time'] ? date('Y-m-d',$confirm['contract_sign_time']) : ''}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>合同收回时间：{$confirm['contract_back_time'] ? date('Y-m-d',$confirm['contract_back_time']) : ''}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>回款时间：{$confirm['back_money_time'] ? date('Y-m-d',$confirm['back_money_time']) : ''}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>是否需要教委审批材料：{$confirm['jiaowei']==1 ? '需要' : '不需要'}</label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>教委审批材料及时间节点：{$confirm['jiaowei_remark']}</label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>备注：{$list.remark}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php if (!$budget_list && in_array(cookie('userid'),array(11,$list['create_user'],$list['line_blame_uid']))){ ?>
                                <?php if ($list['kind'] == 60){ ?> <!--60=>科学课程-->
                                    <include file="customer_need_60_edit" />
                                <?php }elseif ($list['kind'] == 82){ ?> <!--82=>科学博物园-->
                                    <include file="customer_need_82_edit" />
                                <?php }elseif ($list['kind'] == 54){ ?> <!--54=>研学旅行-->
                                    <include file="customer_need_54_edit" />
                                <?php }elseif ($list['kind'] == 90){ ?> <!--90=>背景提升-->
                                    <include file="customer_need_90_edit" />
                                <?php }elseif ($list['kind'] == 67){ ?> <!--67=>实验室建设-->
                                    <include file="customer_need_67_edit" />
                                <?php }elseif ($list['kind'] == 69){ ?> <!--69=>科学快车-->
                                    <include file="customer_need_69_edit" />
                                <?php }elseif ($list['kind'] == 56){ ?> <!--56=>校园科技节-->
                                    <include file="customer_need_56_edit" />
                                <?php }elseif ($list['kind'] == 61){ ?> <!--61=>小课题-->
                                    <include file="customer_need_61_edit" />
                                <?php }elseif ($list['kind'] == 87){ ?> <!--87=>单进院所-->
                                    <include file="customer_need_87_edit" />
                                <?php }elseif ($list['kind'] == 64){ ?> <!--64=>专场讲座-->
                                    <include file="customer_need_64_edit" />
                                <?php }elseif ($list['kind'] == 57){ ?> <!--57=>综合实践-->
                                    <include file="customer_need_57_edit" />
                                <?php }elseif ($list['kind'] == 65){ ?> <!--65=>教师培训-->
                                    <include file="customer_need_65_edit" />
                                <?php } ?>
                            <?php }else{ ?>
                                <?php if ($list['kind'] == 60){ ?> <!--60=>科学课程-->
                                    <include file="customer_need_60_read" />
                                <?php }elseif ($list['kind'] == 82){ ?> <!--82=>科学博物园-->
                                    <include file="customer_need_82_read" />
                                <?php }elseif ($list['kind'] == 54){ ?> <!--54=>研学旅行-->
                                    <include file="customer_need_54_read" />
                                <?php }elseif ($list['kind'] == 90){ ?> <!--90=>背景提升-->
                                    <include file="customer_need_90_read" />
                                <?php }elseif ($list['kind'] == 67){ ?> <!--67=>实验室建设-->
                                    <include file="customer_need_67_read" />
                                <?php }elseif ($list['kind'] == 69){ ?> <!--69=>科学快车-->
                                    <include file="customer_need_69_read" />
                                <?php }elseif ($list['kind'] == 56){ ?> <!--56=>校园科技节-->
                                    <include file="customer_need_56_read" />
                                <?php }elseif ($list['kind'] == 61){ ?> <!--61=>小课题-->
                                    <include file="customer_need_61_read" />
                                <?php }elseif ($list['kind'] == 87){ ?> <!--87=>单进院所-->
                                    <include file="customer_need_87_read" />
                                <?php }elseif ($list['kind'] == 64){ ?> <!--64=>专场讲座-->
                                    <include file="customer_need_64_read" />
                                <?php }elseif ($list['kind'] == 57){ ?> <!--57=>综合实践-->
                                    <include file="customer_need_57_read" />
                                <?php }elseif ($list['kind'] == 65){ ?> <!--65=>教师培训-->
                                    <include file="customer_need_65_read" />
                                <?php } ?>
                            <?php } ?>

                            <!--辅导员需求-->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">辅导员/教师、专家需求</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" >
                                    <?php if(!$jiesuan && ($list['line_blame_uid']==cookie('userid') || in_array(cookie('userid'),array(1,11,$department_manager['manager_id'])))){ ?>
                                        <include file="confirm_tcs_need_edit" />
                                    <?php }else{ ?>
                                        <include file="confirm_tcs_need_read" />
                                    <?php }?>
                                </div>
                            </div>

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->

            </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">
    var price_kind = '';

    /*function get_gpk(){

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
    }*/

    //新增辅导员/教师、专家
    function add_tcs(){
        var i = parseInt($('#tcs_val').text())+1;
        console.log(i);
        var html = '<div class="userlist no-border" id="tcs_'+i+'">' +
            '<span class="title"></span> ' +
            '<select  class="form-control" style="width:12%" name="data['+i+'][guide_kind_id]" id="se_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="guide_kind" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<select  class="form-control gpk" style="width:12%" name="data['+i+'][gpk_id]" id="gpk_id_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="hotel_start" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<select  class="form-control" style="width:12%"  name="data['+i+'][field]"><option value="" selected disabled>请选择</option> <foreach name="fields" key="key" item="value"> <option value="{$key}">{$value}</option> </foreach> </select>'+
            '<input type="text"  class="form-control" style="width:5%" name="data['+i+'][days]" id="days_'+i+'" value="1" onblur="getTotal('+i+')" >'+
            '<input type="text"  class="form-control" style="width:5%" name="data['+i+'][num]"  id="num_'+i+'" value="1" onblur="getTotal('+i+')" > ' +
            '<input type="text"  class="form-control" style="width:8%" name="data['+i+'][price]" id="dj_'+i+'" value="" onblur="getTotal('+i+')">' +
            '<input type="text"  class="form-control" style="width:8%" name="data['+i+'][total]" id="total_'+i+'">' +
            '<input type="text"  class="form-control" style="width:18%" name="data['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'tcs_'+i+'\')">删除</a></div>';
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

    //编号
    function orderno(){
        $('#tcs').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
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
        var days    = parseInt($('#days_'+a).val());
        var total   = num*price*days;
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

    function upd_tcs_need(confirm_id,op_id){
        var confirm_id  = confirm_id;
        var op_id       = op_id;
        $('#fdy_lit-title').text('编辑辅导员/教师、专家需求');
        $.ajax({
            type:"POST",
            url:"{:U('Ajax/get_tcs_need')}",
            data:{confirm_id:confirm_id,op_id:op_id},
            success:function (msg) {
                var begin_day   = msg[0].in_begin_day;
                var end_day     = msg[0].in_day;
                if (begin_day != 0){
                    var in_begin_day= timestampToDay(begin_day);
                }else{
                    var in_begin_day= timestampToDay(end_day);
                }
                var in_end_day  = timestampToDay(end_day);
                var in_days     = in_begin_day+' - '+in_end_day;
                $('#in_day').val(in_days);
                $('#address').val(msg[0].address);
                $('#confirm_id').val(msg[0].confirm_id);

                var con = '';
                for (var j=0; j<msg.length; j++){
                    var i = parseInt(Math.random()*100000)+j;
                    con += '<div class="userlist no-border" id="tcs_'+ i +'">'+
                        '<span class="title">'+(j+1)+'</span>'+
                        /*'<select  class="form-control" style="width:12%"  name="data['+i+'][guide_kind_id]" id="se_'+i+'" onchange="getPrice('+i+')">'+
                        '<foreach name="guide_kind" key="k" item="v">'+
                        '<option value="{$k}" <?php if('+msg[j].guide_kind_id+'== $k) echo "selected"; ?>>{$v}</option>'+
                        '</foreach>'+
                        '</select>'+
                        '<select  class="form-control gpk" style="width:12%"  name="data['+i+'][gpk_id]" id="gpk_id_'+i+'" onchange="getPrice('+i+')">'+
                        '</select>'+*/
                        '<select  class="form-control" style="width:22%"  name="data['+i+'][field]">'+
                        '<foreach name="fields" key="key" item="value">'+
                        '<option value="{$key}" <?php if('+msg[j].field+'==$key) echo "selected"; ?>>{$value}</option>'+
                        '</foreach>'+
                        '</select>'+
                        '<input type="text"  class="form-control" style="width:5%" name="data['+i+'][days]" id="days_'+i+'" onblur="getTotal('+i+')" value="'+msg[j].days+'"  >'+
                        '<input type="text" class="form-control" style="width:5%" name="data['+i+'][num]" id="num_'+i+'" onblur="getTotal('+i+')" value="'+msg[j].num+'">'+
                        '<input type="text" class="form-control" style="width:10%" name="data['+i+'][price]" id="dj_'+i+'" onblur="getTotal('+i+')" value="'+msg[j].price+'">'+
                        '<input type="text" class="form-control" style="width:10%" name="data['+i+'][total]" id="total_'+i+'" value="'+msg[j].total+'">'+
                        '<input type="text" class="form-control" style="width:28%" name="data['+i+'][remark]" value="'+msg[j].remark+'">'+
                        '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'tcs_'+i+'\')">删除</a>'+
                        '<div id="tcs_val">1</div></div>';
                }
                $('#tcs_id').hide();
                var tcs_title = '<div class="userlist form-title" id="tcs_title">'+$('#tcs_title').html()+'</div>';
                $('#tcs').html(tcs_title);
                $('#tcs').append(con);
                // get_gpk();
            }
        })

    }

    function timestampToDay(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = (date.getDate() < 10 ? '0'+(date.getDate()) : date.getDate());
        h = (date.getHours() < 10 ? '0'+(date.getHours()) : date.getHours()) + ':';
        m = (date.getMinutes() < 10 ? '0'+(date.getMinutes()) : date.getMinutes()) + ':';
        s = (date.getSeconds() < 10 ? '0'+(date.getSeconds()) : date.getSeconds());
        //return Y+M+D+h+m+s;
        return Y+M+D;
    }

    function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = (date.getDate() < 10 ? '0'+(date.getDate()) : date.getDate()) + ' ';
        h = (date.getHours() < 10 ? '0'+(date.getHours()) : date.getHours()) + ':';
        m = (date.getMinutes() < 10 ? '0'+(date.getMinutes()) : date.getMinutes()) + ':';
        s = (date.getSeconds() < 10 ? '0'+(date.getSeconds()) : date.getSeconds());
        //return Y+M+D+h+m+s;
        return h+m+s;
    }

</script>
