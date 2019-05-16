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
                <form method="post" action="{:U('Customer/public_save')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="savetype" value="1">
                <input type="hidden" name="partner_id" value="{$partner.id}">
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
                                            <label>合伙协议结束时间：</label><input type="text" name="info[end_date]" class="form-control inputdate_a" value="<?php echo $partner['end_date']?date('Y-m-d',$partner['end_date']):''; ?>"/>
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
                                                    <option class="form-control" value="{$k}" <?php if ($partner && $partner['province']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>所在城市：</label>
                                            <select id="s_city" class="form-control" name="info[city]">
                                                <option class="form-control" value="">请先选择省份</option>
                                                <?php if ($partner){ ?>
                                                <foreach name="citys" key="k" item="v">
                                                    <option class="form-control" value="{$k}" <?php if ($partner && $partner['city']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                                </foreach>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>所在区县：</label>
                                            <select id="s_country" class="form-control" name="info[country]">
                                                <option class="form-control" value="">请先选择城市</option>
                                                <?php if ($partner){ ?>
                                                <foreach name="citys" key="k" item="v">
                                                    <option class="form-control" value="{$k}" <?php if ($partner && $partner['country']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                                </foreach>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>独家省份：</label>
                                            <select id="agent_province" class="form-control" name="info[agent_province]" required>
                                                <option class="form-control" value="" selected disabled>请选择</option>
                                                <foreach name="provinces" key="k" item="v">
                                                    <option class="form-control" value="{$k}" <?php if ($partner && $partner['agent_province']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>独家城市：</label>
                                            <select id="agent_city" class="form-control" name="info[agent_city]">
                                                <option class="form-control" value="">请先选择省份</option>
                                                <?php if ($partner){ ?>
                                                <foreach name="citys" key="k" item="v">
                                                    <option class="form-control" value="{$k}" <?php if ($partner && $partner['agent_country']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                                </foreach>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>独家区县：</label>
                                            <select id="agent_country" class="form-control" name="info[agent_country]">
                                                <option class="form-control" value="">请先选择城市</option>
                                                <?php if ($partner){ ?>
                                                <foreach name="citys" key="k" item="v">
                                                    <option class="form-control" value="{$k}" <?php if ($partner && $partner['agent_country']==$k) echo "selected"; ?>>{$citys[$k]}</option>
                                                </foreach>
                                                <?php } ?>
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
                                            <label>备注：</label>
                                            <input class="form-control" name="info[remark]" value="{$partner.remark}" />
                                        </div>

                                        <div class="content" style="padding-top:0px;">
                                            <div id="deposit">
                                                <div class="userlist">
                                                    <div class="unitbox">保证金（元/年）</div>
                                                    <div class="unitbox">开始时间</div>
                                                    <div class="unitbox">结束时间</div>
                                                    <div class="unitbox longinput">备注</div>
                                                </div>

                                                <foreach name="deposit" key="k" item="v">
                                                    <div class="userlist cost_expense" id="deposit_id_b_{$k}">
                                                        <span class="title"><?php echo $k+1; ?></span>
                                                        <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" >
                                                        <input type="text" class="form-control" name="deposit_data[888{$k}][money]" value="{$v.money}">
                                                        <input type="text" class="form-control inputdate_a" name="deposit_data[888{$k}][start_date]" value="<?php echo $v['start_date']?date('Y-m-d',$v['start_date']):''; ?>">
                                                        <input type="text" class="form-control inputdate_a" name="deposit_data[888{$k}][end_date]" value="<?php echo $v['end_date']?date('Y-m-d',$v['end_date']):''; ?>">
                                                        <input type="text" class="form-control longinput" name="deposit_data[888{$k}][remark]" value="{$v.remark}">
                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('deposit_id_b_{$k}')">删除</a>
                                                    </div>
                                                </foreach>
                                            </div>
                                            <div id="deposit_val" style="display: none">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns" style="margin-left:15px;">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_deposit()"><i class="fa fa-fw fa-plus"></i> 新增预算项</a>

                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>

                                    </div>
                                    
                                    <div style="width:100%; text-align:center; padding-bottom:40px;">
                                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                        <a  href="javascript:;" class="btn btn-info btn-lg" onClick="javascript:save('myform','<?php echo U('Customer/public_save'); ?>');">保存</a>
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
        var userkey     = {$userkey};
        autocomplete_id('cm_name','cm_id',userkey);
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
                    $("#s_country").html('<option class="form-control" value="">请先选择城市</option>');
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
                    $("#s_country").empty();
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
                    $("#s_country").append(b);
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
                    $("#agent_country").html('<option class="form-control" value="">请先选择城市</option>');
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
                    $("#agent_country").empty();
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
                    $("#agent_country").append(b);
                }
            })
        }else{
            art_show_msg('城市信息错误',3);
        }
    })

    //新成本核算项
    function add_deposit(){
        var i = parseInt($('#deposit_val').text())+1;

        var html = '<div class="userlist cost_expense" id="deposit_'+i+'">' +
            '<span class="title"></span>' +
            '<input type="text" class="form-control" name="deposit_data['+i+'][money]">' +
            '<input type="text"  class="form-control inputdate_a" name="deposit_data['+i+'][start_date]"  value="">' +
            '<input type="text" class="form-control inputdate_a" name="deposit_data['+i+'][end_date]" value="">' +
            '<input type="text" class="form-control longinput" name="deposit_data['+i+'][remark]">' +
            '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'deposit_'+i+'\')">删除</a></div>';
        $('#deposit').append(html);
        $('#deposit_val').html(i);
        var newjs   = "__HTML__/js/public.js?v=1.0.6";
        reload_jsFile(newjs,'reload_public'); //重新加载public.js文件
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
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


    //保存信息
    function save(id,url){
        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                var num         = data.num;
                var msg         = data.msg;
                if(parseInt(num)>0){
                    art.dialog.alert(msg,'success');
                }else{
                    art.dialog.alert(msg,'warning');
                }
            }
        });

        setTimeout("history.go(0)",1000);
    }
</script>
