<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>城市合伙人</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/partner')}"><i class="fa fa-gift"></i> 合伙人管理</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Customer/partner_edit')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="gec_id" value="{$partner.id}">
                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">合伙人管理</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-4">
                                            <label>合伙人名称：</label><input type="text" name="info[name]" class="form-control" value="{$partner.name}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>合伙人级别：</label>
                                            <select  class="form-control"  name="info[level]">
                                            	<option value="" selected disabled>==请选择==</option>
                                                <option value="1" <?php if($partner['level']=='1'){ echo 'selected';} ?>>省级</option>
                                                <option value="2" <?php if($partner['level']=='2'){ echo 'selected';} ?>>市级</option>
                                                <option value="3" <?php if($partner['level']=='3'){ echo 'selected';} ?>>区/县级</option>
                                            </select> 
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>是否签订合伙人协议：</label>
                                            <select  class="form-control"  name="info[agreement]">
                                            	<option value="" selected disabled>==请选择==</option>
                                            	<option value="1" <?php if($partner['agreement']=='1'){ echo 'selected';} ?>>已签订</option>
                                                <option value="0" <?php if($partner['agreement']=='0'){ echo 'selected';} ?>>未签订</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>合伙协议开始时间：</label><input type="text" name="info[start_date]" class="form-control inputdate_a" value="<?php echo $partner['start_date']?date('Y-m-d',$partner['start_date']):''; ?>"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>合伙协议结束时间：</label><input type="text" name="info[end_date]" class="form-control inputdate_a" value="<?php echo $partner['start_date']?date('Y-m-d',$partner['start_date']):''; ?>"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>通讯地址：</label><input type="text" name="info[contacts_address]" class="form-control" value="{$partner.contacts_address}"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>负责人：</label><input type="text" name="info[manager]" class="form-control" value="{$partner.manager}"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>负责人职务：</label><input type="text" name="info[manager_post]" class="form-control" value="{$partner.manager_post}"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>负责人手机：</label><input type="text" name="info[manager_phone]"  class="form-control" value="{$partner.manager_phone}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人：</label><input type="text" name="info[contacts]" class="form-control" value="{$partner.contacts}"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>联系人职务：</label><input type="text" name="info[contacts_post]" class="form-control" value="{$partner.contacts_post}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人手机：</label><input type="text" name="info[contacts_phone]"  class="form-control" value="{$partner.contacts_phone}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>所在省份：</label>
                                            <select id="s_province" class="form-control" name="info[province]" required>
                                                <option class="form-control" value="" selected disabled>请选择</option>
                                                <foreach name="provinces" key="k" item="v">
                                                    <option class="form-control" value="{$k}">{$citys[$k]}</option>
                                                </foreach>
                                                <!--<option value="{$v}" <?php /*if ($area && ($area['province'] == $v)) echo ' selected'; */?> >{$v}</option>-->
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>所在城市：</label>
                                            <select id="s_city" class="form-control" name="info[city]">
                                                <option class="form-control" value="">请先选择省份</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>所在区县：</label>
                                            <select id="s_county" class="form-control" name="info[county]">
                                                <option class="form-control" value="">请先选择城市</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>独家省份：</label>
                                            <select id="agent_province" class="form-control" name="info[agent_province]" required>
                                                <option class="form-control" value="" selected disabled>请选择</option>
                                                <foreach name="provinces" key="k" item="v">
                                                    <option class="form-control" value="{$k}">{$citys[$k]}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>独家城市：</label>
                                            <select id="agent_city" class="form-control" name="info[agent_city]">
                                                <option class="form-control" value="">请先选择省份</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>独家区县：</label>
                                            <select id="agent_county" class="form-control" name="info[agent_county]">
                                                <option class="form-control" value="">请先选择城市</option>
                                            </select>
                                        </div>

                                        <!--<div class="form-group col-md-4">
                                            <label>保证金：</label>
                                            <input class="form-control" name="info[deposit]" value="{$partner.deposit}" />
                                        </div>-->
                                        
                                        <div class="form-group col-md-4">
                                            <label>维护人：</label>
                                            <input type="text" class="form-control" id="cm_name" name="info[cm_name]" value="<?php echo $partner['cm_name']?$partner['cm_name']:session('nickname'); ?>" />
                                            <input type="hidden" id="cm_id" name="info[cm_id]" value="<?php echo $partner['cm_id']?$partner['cm_id']:session('userid');  ?>" />
                                        </div>

                                        <div class="form-group col-md-8">
                                            <!--<label>维护记录：</label><textarea class="form-control" style="height:300px" name="info[remark]">{$partner.remark}</textarea>-->
                                            <label>备注：</label>
                                            <input class="form-control" name="info[remark]" value="{$partner.remark}" />
                                        </div>

                                        <style>
                                            #deposit { padding:0 15px;}
                                            #deposit .form-control{ width:150px; float:left; margin-right:10px; border-radius:0;}
                                            #deposit .unitbox{ width:150px; margin-right:10px; float:left; clear:none; border:none; padding:0;}
                                            #deposit .title{ width:22px; float:left; height:30px; line-height:30px; margin-left:-30px; text-align:right;}
                                            #deposit .userlist { width:100%; height:auto !important; float:left; clear:both; padding-bottom:15px; border-bottom:1px solid #cccccc; margin-top:15px;}
                                            #deposit .btn{ padding:7px 12px; font-size:12px;}
                                            #deposit td{ line-height:34px;}
                                            #deposit_val{ display:none}
                                            #deposit .total{ color:#333333; font-size:14px;}
                                            #deposit .longinput{ width:260px;}
                                        </style>

                                        <div class="content" style="padding-top:0px;">
                                            <div id="deposit">
                                                <div class="userlist">
                                                    <div class="unitbox">保证金（元/年）</div>
                                                    <div class="unitbox">开始时间</div>
                                                    <div class="unitbox">结束时间</div>
                                                    <div class="unitbox longinput">备注</div>
                                                </div>

                                                <foreach name="costacc" key="k" item="v">
                                                    <div class="userlist cost_expense" id="costacc_id_b_{$k}">
                                                        <span class="title"><?php echo $k+1; ?></span>
                                                        <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" >
                                                        <input type="text" class="form-control" name="costacc[888{$k}][title]" value="{$v.title}">
                                                        <input type="text" class="form-control inputdate_a" name="costacc[888{$k}][unitcost]" value="{$v.unitcost}">
                                                        <input type="text" class="form-control inputdate_a" name="costacc[888{$k}][amount]" value="{$v.amount}">
                                                        <input type="text" class="form-control longinput" name="costacc[888{$k}][remark]" value="{$v.remark}">
                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_b_{$k}')">删除</a>
                                                    </div>
                                                </foreach>
                                            </div>
                                            <div id="costacc_val">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns" style="margin-left:15px;">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_costacc()"><i class="fa fa-fw fa-plus"></i> 新增预算项</a>

                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>

                                    </div>
                                    
                                    <div style="width:100%; text-align:center; padding-bottom:40px;">
                                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    $(function () {
        var userkey     = '';
        autocomplete_id();
    })

    //省市联动(所在地)
    $('#s_province').change(function () {
        var province    = $(this).val();
        if (province){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_city'); ?>",
                dataType : 'JSON',
                data : {province:province},
                success : function (msg) {
                    $("#s_city").empty();
                    $("#s_county").html('<option class="form-control" value="">请先选择城市</option>');
                    if (msg.length>0){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                    }else{
                        var b="";
                        b+='<option value="" disabled selected>暂无数据</option>';
                    }
                    $("#s_city").append(b);
                }
            })
        }else{
            art_show_msg('省份信息错误',3);
        }
    })

    //市县联动(所在地)
    $('#s_city').change(function () {
        var city     = $(this).val();
        if (city){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_country'); ?>",
                dataType : 'JSON',
                data : {city:city},
                success : function (msg) {
                    $("#s_county").empty();
                    if (msg.length>0){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                    }else{
                        var b="";
                        b+='<option value="" disabled selected>暂无数据</option>';
                    }
                    $("#s_county").append(b);
                }
            })
        }else{
            art_show_msg('城市信息错误',3);
        }
    })

    //省市联动(代理地)
    $('#agent_province').change(function () {
        var province    = $(this).val();
        if (province){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_city'); ?>",
                dataType : 'JSON',
                data : {province:province},
                success : function (msg) {
                    $("#agent_city").empty();
                    $("#agent_county").html('<option class="form-control" value="">请先选择城市</option>');
                    if (msg.length>0){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                    }else{
                        var b="";
                        b+='<option value="" disabled selected>暂无数据</option>';
                    }
                    $("#agent_city").append(b);
                }
            })
        }else{
            art_show_msg('省份信息错误',3);
        }
    })

    //市县联动(代理地)
    $('#agent_city').change(function () {
        var city     = $(this).val();
        if (city){
            $.ajax({
                type : 'POST',
                url : "<?php echo U('Ajax/get_country'); ?>",
                dataType : 'JSON',
                data : {city:city},
                success : function (msg) {
                    $("#agent_county").empty();
                    if (msg.length>0){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                    }else{
                        var b="";
                        b+='<option value="" disabled selected>暂无数据</option>';
                    }
                    $("#agent_county").append(b);
                }
            })
        }else{
            art_show_msg('城市信息错误',3);
        }
    })

    //新成本核算项
    function add_costacc(){
        var i = parseInt($('#costacc_val').text())+1;

        var html = '<div class="userlist cost_expense" id="costacc_'+i+'">' +
            '<span class="title"></span>' +
            '<input type="text" class="form-control" name="costacc['+i+'][title]">' +
            '<input type="text"  class="form-control inputdate_a" name="costacc['+i+'][unitcost]"  value="22">' +
            '<input type="text" class="form-control inputdate_b" name="costacc['+i+'][amount]" value="">' +
            '<input type="text" class="form-control longinput" name="costacc['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'costacc_'+i+'\')">删除</a></div>';
        $('#deposit').append(html);
        $('#costacc_val').html(i);
        var newjs   = "__HTML__/comm/laydate/laydate.js";
        reload_laydate(newjs);
        reloadAbleJSFn(reload_laydate,newjs);
    }

    function reload_laydate(file) {
        alert(file);
        var head = $("head").remove("script[role='reload_laydate']");
        $("<scri"+"pt>"+"</scr"+"ipt>").attr({
            role:'reload_laydate',src:file,type:'text/javascript'}).appendTo(head);

        /*$.getScript(file,function(){
            newFun('"Checking new script"');//这个函数是在new.js里面的，当点击click后运行这个函数
        });*/

    }

    function reloadAbleJSFn(id,newJS)
    {
        var oldjs = null;
        var t = null;
        var oldjs = document.getElementById(id);
        if(oldjs) oldjs.parentNode.removeChild(oldjs);
        var scriptObj = document.createElement("script");
        scriptObj.src = newJS;
        scriptObj.type = "text/javascript";
        scriptObj.id = id;
        document.getElementsByTagName("head")[0].appendChild(scriptObj);
    }


</script>
