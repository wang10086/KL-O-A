<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>项目出团确认</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/confirm')}"><i class="fa fa-gift"></i> 项目结算</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <include file="Op:op_navigate" />
                             
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header" >
                                    <h3 class="box-title">
                                    <php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;"  id="print_1">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">

                                        <include file="op_pro" />

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <!--客户需求详情-->
                            <?php if ($op['kind'] == 60){ ?> <!--60=>科学课程-->
                                <include file="Product:customer_need_60_read" />
                            <?php }elseif ($op['kind'] == 82){ ?> <!--82=>科学博物园-->
                                <include file="Product:customer_need_82_read" />
                            <?php }elseif ($op['kind'] == 54){ ?> <!--54=>研学旅行-->
                                <include file="Product:customer_need_54_read" />
                            <?php }elseif ($op['kind'] == 90){ ?> <!--90=>背景提升-->
                                <include file="Product:customer_need_90_read" />
                            <?php }elseif ($op['kind'] == 67){ ?> <!--67=>实验室建设-->
                                <include file="Product:customer_need_67_read" />
                            <?php }elseif ($op['kind'] == 69){ ?> <!--69=>科学快车-->
                                <include file="Product:customer_need_69_read" />
                            <?php }elseif ($op['kind'] == 56){ ?> <!--56=>校园科技节-->
                                <include file="Product:customer_need_56_read" />
                            <?php }elseif ($op['kind'] == 61){ ?> <!--61=>小课题-->
                                <include file="Product:customer_need_61_read" />
                            <?php }elseif ($op['kind'] == 87){ ?> <!--87=>单进院所-->
                                <include file="Product:customer_need_87_read" />
                            <?php }elseif ($op['kind'] == 64){ ?> <!--64=>专场讲座-->
                                <include file="Product:customer_need_64_read" />
                            <?php }elseif ($op['kind'] == 57){ ?> <!--57=>综合实践-->
                                <include file="Product:customer_need_57_read" />
                            <?php }elseif ($op['kind'] == 65){ ?> <!--65=>教师培训-->
                                <include file="Product:customer_need_65_read" />
                            <?php } ?>
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">实际成团确认</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
									<?php if(!$jiesuan && (!$confirm || !$upd_num || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username'))){ ?>
                                    <include file="confirm_edit" />
                                    <?php }else{ ?>
                                    <include file="confirm_read" />	
                                    <?php }?>
                                </div>
                            </div>

                            <?php if ($guide_need){ ?>
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">辅导员/教师、专家需求</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body" >
                                        <?php if(!$jiesuan && ($op['create_user']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10)){ ?>
                                            <include file="confirm_tcs_need_edit" />
                                        <?php }else{ ?>
                                            <include file="confirm_tcs_need_read" />
                                        <?php }?>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">业务实施方案</h3>
                                    <?php if(project_list){ ?>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">  审核状态：{$audit_status[$project_list['audit_status']]}</h3>
                                    <?php } ?>
                                </div>
                                <div class="box-body">

                                    <?php if(project_list && in_array($project_list['audit_status'],array(1,2,3))){ ?>
                                        <div class="form-group ">
                                            <label>方案说明：</label>  {$project_list.remark}
                                        </div>

                                        <table class="table table-bordered dataTable fontmini" id="tablelist">
                                            <tr role="row" class="orders" >
                                                <th style="width: 50px">编号</th>
                                                <th>文件名</th>
                                                <th>文件类型</th>
                                                <th>文件大小</th>
                                                <th style="width: 80px">下载</th>
                                            </tr>
                                            <foreach name="atta_lists" key="k" item="row">
                                                <tr>
                                                    <td><?php echo $k+1; ?></td>
                                                    <td>{$row.filename}</td>
                                                    <td>{$row.fileext}</td>
                                                    <td><?php echo sprintf("%.1f", $row['filesize']/1024); ?>K</td>
                                                    <td><a href="{$row.filepath}" class="badge bg-red">下载</a></td>
                                                </tr>
                                            </foreach>
                                        </table>
                                    <?php }else{ ?>
                                        <div style="padding:25px;">暂未制定业务实施方案</div>
                                    <?php } ?>

                                    <?php if (in_array(cookie('userid'), array($project_list['audit_uid'],1,11)) && ($project_list['audit_status']==3)){ ?>
                                        <div class="content">
                                            <form method="post" action="{:U('Op/public_save')}" id="audit_form">
                                                <input type="hidden" name="dosubmint" value="1">
                                                <input type="hidden" name="savetype" value="27">
                                                <input type="hidden" name="id" value="{$project_list.id}">
                                                <input type="hidden" name="opid" value="{$list.op_id}">

                                                <div class="form-group box-float-12">
                                                    <label class="">审核意见：</label>
                                                    <input type="radio" name="status" value="1"> &#8194;审核通过 &#12288;&#12288;&#12288;
                                                    <input type="radio" name="status" value="2"> &#8194;审核不通过
                                                </div>

                                                <div class="form-group box-float-12">
                                                    <label>备注</label>
                                                    <textarea class="form-control" name="audit_remark"></textarea>
                                                </div>

                                                <div id="formsbtn">
                                                    <button type="button" class="btn btn-info btn-sm" onclick="$('#audit_form').submit()">保存</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>


                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">客户需求变更</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">审核状态: <?php echo $cneed_edit['audit_status']==1 ? "<span class='green'>审核通过</span>" : ($cneed_edit['audit_status']==2 ? "<span class='red'>审核未通过</span>" : "未审核") ?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if(!$jiesuan && ((NOW_TIME + 2*24*3600) < $confirm['dep_time']) && in_array(cookie('userid'),array(1,11,$op['create_user']))){ ?>
                                        <include file="customer_need_table_edit" />
                                    <?php }else{ ?>
                                        <?php if ($cneed_edit){ ?>
                                            <include file="customer_need_table_read" />
                                        <?php }else{ ?>
                                            <div class="content"> 距离实际出发时间已不足2天,客户需求信息不可更改!</div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">资源需求单</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">
                                        <?php  if((rolemenu(array('Op/public_save')) && $op['group_id'] && ($op['create_user'] == cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('userid') == 11 )) && ($resource  || $work_plan || $design)){ ?>
                                            <span id="res_but"><a href="javascript:;" onclick="hide_res_need()" style="color:#09F;">隐藏</a></span>
                                        <?php  } ?>
                                    </h3>
                                </div>
                                <div class="box-body" id="resource">
                                    <?php /*if(!$jiesuan && ($op['create_user']==cookie('userid') || C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10)){ */?>
                                    <?php if(!$jiesuan){ ?>  <!--各部门线控人员填写业务实施计划单-->
                                        <div class="form-group col-md-12 ml-12" id="res-need-or-not">
                                            <h2 class="tcs_need_h2">资源需求：</h2>
                                            <input type="radio" name="need-tcs-or-not" value="0"  <?php if($rad==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                                            <input type="radio" name="need-tcs-or-not" value="1"  <?php if($rad==1){ echo 'checked';} ?>> &#8194;需要
                                        </div>
                                        <div class="form-group col-md-12 ml-12" id="res_type" style="margin-top: -30px;">
                                            <h2 class="tcs_need_h2">资源需求单类型：</h2>
                                            <?php if ($op['kind'] == 87){ ?> <!--单进院所只显示"业务实施计划单"-->
                                                <input type="radio" name="res_type" value="3" checked> &nbsp;业务实施计划单
                                            <?php }else{ ?>
                                                <input type="radio" name="res_type" value="1"> &nbsp;业务实施需求单 &#12288;
                                                <input type="radio" name="res_type" value="2"> &nbsp;委托设计工作交接单 &#12288;
                                                <input type="radio" name="res_type" value="3"> &nbsp;业务实施计划单
                                            <?php } ?>
                                        </div>

                                        <include file="op_res_need" />
                                    <?php }else{ ?>
                                        <include file="op_res_nread" />
                                    <?php }?>
                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
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
    var opid        = <?php echo $op['op_id']; ?>;
    var fields      = <?php echo $fields; ?>;
    var group_id    = "<?php echo $op['group_id']; ?>";
    var op_kind     = <?php echo $op_kind;?>;
    var resource    = "<?php echo $resource['op_id']; ?>";
    var design      = "<?php echo $design['id']; ?>";
    var work_plan   = "<?php echo $work_plan['id']; ?>";

    $(function(){
       // get_gpk();

        if (resource || design || work_plan){
            if (op_kind == 60){ //科学课程
                $('#res-need-or-not').html('');
                $('#after_lession').show();
                $('#res_need_table').html('');
            }else if (op_kind == 87){ //单进院所
                $('#res-need-or-not').html('');
                $('#after_lession').html('');
                $('#work_plan').show();
            } else{
                $('#res-need-or-not').html('');
                $('#after_lession').html('');
                $('#res_need_table').show();
            }
            get_res_type();
        }else{
            $('#res_type').hide();
            $('#custom').hide();
            $('#handson').hide();
        }

        $('#res-need-or-not').find('ins').each(function (index,ele) {
            $(this).click(function () {
                if(index == 1){
                    if (!group_id){
                        art.dialog.alert('该项目未成团','warning');
                         return;
                    }else {
                        $('#res_type').show();
                        get_res_type();
                    }

                }else{
                    $('#after_lession').hide();
                    $('#res_need_table').hide();
                    $('#res_type').hide();
                    $('#design').hide();
                    $('#work_plan').hide();
                }
            })
        })

        $('#is_custom').find('ins').each(function (index,ele) {
            $(this).click(function () {
                if(index == 1){
                    $('#custom').hide();
                    $('input[name="res_name"]').val('');
                }else {
                    $('#custom').show();
                }
            })
        })

        $('#is_handson').find('ins').each(function (index,ele) {
            $(this).click(function () {
                if(index == 1){
                    $('#handson').hide();
                    $('input[name="info[lession_price]"]').val('');
                }else {
                    $('#handson').show();
                }
            })
        })

        $('#is_pingban').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var pingban = $(this).prev('input').val();
                if (pingban == 1){
                    $('#pingban').show();
                }else if(pingban == 0){
                    $('#pingban').hide();
                }
            })
        })

    })

    function get_res_type(){
        $('#res_type').find('ins').each(function (index,ele) {
            $(this).click(function () {
                var type = $(this).prev('input').val();
                if(type == 2){
                    //委托设计工作交接单
                    var pingban = <?php echo $design['pingban']?$design['pingban']:0; ?>;
                    if (pingban == 1) {
                        $('#pingban').show();
                    }else{
                        $('#pingban').hide();
                    }
                    $('#design').show();
                    $('#after_lession').hide();
                    $('#res_need_table').hide();
                    $('#work_plan').hide();
                }else if(type == 3) {
                    //业务实施计划单

                    $('#work_plan').show();
                    $('#after_lession').hide();
                    $('#res_need_table').hide();
                    $('#design').hide();
                }else{
                    //业务实施需求单
                    if (op_kind == 60) {
                        $('#after_lession').show();
                        $('#res_need_table').html('');
                    }else{
                        $('#after_lession').html('');
                        $('#res_need_table').show();
                    }
                    $('#design').hide();
                    $('#work_plan').hide();
                }
            })
        })
    }

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

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
    }

    //编号
    function orderno(){
        $('#tcs').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });

        $('#plans').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });

        $('#addGroupContent').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
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
                var begin_time  = msg[0].tcs_begin_time;
                var begin       = timestampToTime(begin_time);
                var end_time    = msg[0].tcs_end_time;
                var end         = timestampToTime(end_time);
                var time        = begin+' - '+end;
                $('#tcs_time').val(time);
                $('#address').val(msg[0].address);
                $('#confirm_id').val(msg[0].confirm_id);

                var con = '';
                for (var j=0; j<msg.length; j++){
                    var i = parseInt(Math.random()*100000)+j;
                    con += '<div class="userlist no-border" id="tcs_'+ i +'">'+
                        '<span class="title">'+(j+1)+'</span>'+
                        '<select  class="form-control" style="width:12%"  name="data['+i+'][guide_kind_id]" id="se_'+i+'" onchange="getPrice('+i+')">'+
                        '<foreach name="guide_kind" key="k" item="v">'+
                        '<option value="{$k}" <?php if('+msg[j].guide_kind_id+'== $k) echo "selected"; ?>>{$v}</option>'+
                        '</foreach>'+
                        '</select>'+
                        '<select  class="form-control gpk" style="width:12%"  name="data['+i+'][gpk_id]" id="gpk_id_'+i+'" onchange="getPrice('+i+')">'+
                        '</select>'+
                        '<select  class="form-control" style="width:12%"  name="data['+i+'][field]">'+
                        '<foreach name="fields" key="key" item="value">'+
                        '<option value="{$key}" <?php if('+msg[j].field+'==$key) echo "selected"; ?>>{$value}</option>'+
                        '</foreach>'+
                        '</select>'+
                        '<input type="text"  class="form-control" style="width:5%" name="data['+i+'][days]" id="days_'+i+'" onblur="getTotal('+i+')" value="'+msg[j].days+'"  >'+
                        '<input type="text" class="form-control" style="width:5%" name="data['+i+'][num]" id="num_'+i+'" onblur="getTotal('+i+')" value="'+msg[j].num+'">'+
                        '<input type="text" class="form-control" style="width:8%" name="data['+i+'][price]" id="dj_'+i+'" onblur="getTotal('+i+')" value="'+msg[j].price+'">'+
                        '<input type="text" class="form-control" style="width:8%" name="data['+i+'][total]" id="total_'+i+'" value="'+msg[j].total+'">'+
                        '<input type="text" class="form-control" style="width:18%" name="data['+i+'][remark]" value="'+msg[j].remark+'">'+
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
        D = (date.getDate() < 10 ? '0'+(date.getDate()) : date.getDate()) + ' ';
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

    //物资需求单
    function show_res_need(){
        if (op_kind != 60){
            $("#res_need_table").show();
        }else{
            $('#after_lession').show();
        }
        $('#res_but').html('<a href="javascript:;" onclick="hide_res_need()" style="color:#09F;">隐藏</a>');
    }

    function hide_res_need(){
        $('.hideAll').hide();
        $('#res_but').html('<a href="javascript:;" onclick="show_res_need()" style="color:#09F;">显示</a>');
    }

    //保存信息
    function save(id,url){
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

    function print_part(id){
        var viewid  = id ? id : $('#print_part_id').val();
        $('#'+id).css({"width":"90%"});
        document.body.innerHTML=document.getElementById(viewid).innerHTML;
        window.print();
    }
</script>
     


