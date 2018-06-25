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
                        	 
                             <div class="btn-group no-print" id="catfont">
                                <if condition="rolemenu(array('Op/plans_follow'))"><a href="{:U('Op/plans_follow',array('opid'=>$op['op_id']))}" class="btn btn-default">项目跟进</a></if>
                                <if condition="rolemenu(array('Finance/costacc'))"><a href="{:U('Finance/costacc',array('opid'=>$op['op_id']))}" class="btn btn-default">成本核算</a></if>
                                <if condition="rolemenu(array('Op/confirm'))"><a href="{:U('Op/confirm',array('opid'=>$op['op_id']))}" class="btn btn-info">成团确认</a></if>
                                <if condition="rolemenu(array('Finance/op'))"><a href="{:U('Finance/op',array('opid'=>$op['op_id']))}" class="btn btn-default">项目预算</a></if>
                                <if condition="rolemenu(array('Op/app_materials'))"><a href="{:U('Op/app_materials',array('opid'=>$op['op_id']))}" class="btn btn-default">申请物资</a></if>
                               
                                <!--
                                <if condition="rolemenu(array('Sale/goods'))"><a href="{:U('Sale/goods',array('opid'=>$op['op_id']))}" class="btn btn-default">项目销售</a></if>
                                -->
                                <if condition="rolemenu(array('Finance/settlement'))"><a href="{:U('Finance/settlement',array('opid'=>$op['op_id']))}" class="btn btn-default ">项目结算</a></if>

                                 <if condition="rolemenu(array('Finance/huikuan')) && (($op['create_time'] gt 1523980800) && $member) || ($op['create_time'] lt 1523980800)"><!--2018-04-15-->
                                     <a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn btn-default">项目回款</a>
                                     <else />
                                     <a href="javascript:;" onclick="alert('请先填写随团人员信息名单!');" class="btn btn-default">项目回款</a>
                                 </if>
                                <!--<if condition="rolemenu(array('Finance/huikuan'))"><a href="{:U('Finance/huikuan',array('opid'=>$op['op_id']))}" class="btn btn-default">项目回款</a></if>-->
                                <if condition="rolemenu(array('Op/evaluate'))"><a href="{:U('Op/evaluate',array('opid'=>$op['op_id']))}" class="btn btn-default">项目评价</a></if>
                            </div>
                            
                             
                             <div class="box box-warning" style="margin-top:15px;">
                                <div class="box-header" >
                                    <h3 class="box-title">
                                    <php> if($op['status']==1){ echo '<span class="green">项目已成团</span>&nbsp;&nbsp; <span style="font-weight:normal; color:#ff3300;"  id="print_1">（团号：'.$op['group_id'].'）</span>';}elseif($op['status']==2){ echo '<span class="red">项目不成团</span>&nbsp;&nbsp; <span style="font-weight:normal">（原因：'.$op['nogroup'].'）</span>';}else{ echo ' <span style=" color:#999999;">该项目暂未成团</span>';} </php>
                                    </h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                                        	<tr>
                                            	<td colspan="3">项目名称：{$op.project}</td>
                                            </tr>
                                            <tr>
                                            	<td width="33.33%">项目类型：<?php echo $kinds[$op['kind']]; ?></td>
                                                <td width="33.33%">预计人数：{$op.number}人</td>
                                                <td width="33.33%">预计出团日期：{$op.departure}</td>
                                            </tr>
                                            <tr>
                                            	<td width="33.33%">预计行程天数：{$op.days}天</td>
                                                <td width="33.33%">目的地：{$op.destination}</td>
                                                <td width="33.33%">立项时间：{$op.op_create_date}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">实际成团确认</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
									<?php if(!$confirm || !$upd_num || cookie('roleid')==10 || C('RBAC_SUPER_ADMIN')==cookie('username') ){ ?>
                                    <include file="confirm_edit" />
                                    <?php }else{ ?>
                                    <include file="confirm_read" />	
                                    <?php }?>
                                    
                                </div>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">辅导员/教师、专家需求</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" >
                                    <?php if($jiesuan ){ ?>
                                        <include file="op_tcs_need_edit" />
                                    <?php }else{ ?>
                                        <include file="op_tcs_need_edit" />
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

<script>
    /*laydate.render({
        elem: '.inputdate_a',theme: '#0099CC',type: 'datetime'
    });*/
    //时间范围
    /*laydate.render({
        elem: '.inputdate_a'
        ,type: 'time'
        ,range: true
    });*/


    var price_kind = '';
    var opid    = <?php echo $op['op_id']; ?>;
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


    //新增辅导员/教师、专家
    function add_tcs(){
        var i = parseInt($('#tcs_val').text())+1;
        var html = '<div class="userlist no-border" id="tcs_'+i+'">' +
            '<span class="title"></span> ' +
            '<select  class="form-control" style="width:12%" name="res[1]data['+i+'][guide_kind_id]" id="se_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="guide_kind" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<select  class="form-control gpk" style="width:12%" name="res[1]data['+i+'][gpk_id]" id="gpk_id_'+i+'" onchange="getPrice('+i+')"><option value="" selected disabled>请选择</option> <foreach name="hotel_start" key="k" item="v"> <option value="{$k}">{$v}</option></foreach></select> ' +
            '<select  class="form-control" style="width:12%"  name="res[1]data['+i+'][field]"><option value="" selected disabled>请选择</option> <foreach name="fields" key="key" item="value"> <option value="{$key}">{$value}</option> </foreach> </select>'+
            '<input type="text"  class="form-control" style="width:5%" name="res[1]data['+i+'][num]" id="num_'+i+'" value="1" onblur="getTotal('+i+')" > ' +
            '<input type="text"  class="form-control" style="width:8%" name="res[1]data['+i+'][price]" id="dj_'+i+'" value="" onblur="getTotal('+i+')">' +
            '<input type="text"  class="form-control" style="width:8%" name="res[1]data['+i+'][total]" id="total_'+i+'">' +
            '<input type="text"  class="form-control" style="width:18%" name="res[1]data['+i+'][remark]">' +
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

    //移除
    function deltcsbox(obj){
        $('#'+obj).remove();
        orderno();
    }

    //编号
    function orderno(){
        $('#tcs').find('.title').each(function(index, element) {
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



</script>
     


