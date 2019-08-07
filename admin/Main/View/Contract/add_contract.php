<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('ScienceRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('Contract/public_save')}" name="myform" id="myform" onsubmit="return beforeSubmit(this)">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <input type="hidden" name="dosubmint" value="1" />
                                    <input type="hidden" name="savetype" value="2">
                                    <!--<input type="hidden" name="referer" value="<?php /*echo $_SERVER['HTTP_REFERER']; */?>" />-->
                                    <input type="hidden" name="id" value="{$row.id}" />

                                    <!-- text input -->

                                    <div class="form-group col-md-12">
                                        <h2 class="little-title">合同信息</h2>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>合同类型</label>
                                            <select name="info[type]" class="form-control" id="type">
                                                <option value="1">团内合同</option>
                                                <option value="2">非团合同</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>合同名称</label>
                                            <input type="text" class="form-control" name="info[title]">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>签约方</label>
                                            <input type="text" class="form-control" name="info[customer]">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>合同份数</label>
                                            <input type="text" class="form-control" name="info[num]">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>合同金额</label>
                                            <input type="text" name="info[contract_amount]" id="contract_amount"   value="{$row.contract_amount}" class="form-control" required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>承办人</label>
                                            <input type="hidden" class="form-control" name="info[create_user]" value="{:session('userid')}"  readonly />
                                            <input type="text" class="form-control" name="info[create_user_name]" value="{:session('nickname')}" readonly />
                                        </div>

                                        <div class="form-group col-md-4 op-contract">
                                            <label>项目团号（如无团号信息可暂不填写）</label>
                                            <div class="input-group">
                                                <input type="text"  name="info[group_id]" placeholder="团号" class="form-control" value="{$row.group_id}" id="groupid">
                                                <!--<span class="input-group-addon" style="width:32px;"><a href="javascript:;" onClick="getop();" >获取</a></span>-->
                                                <span class="input-group-addon" style="width:32px;"><a href="javascript:;" onClick="check_contract();" >获取</a></span>
                                            </div>
                                        </div>

                                        <div class="form-group  col-md-4 op-contract">
                                            <label>项目名称</label>
                                            <input type="text" name="info[pro_name]" class="form-control" id="proname" value="{$row.pro_name}" />
                                        </div>

                                        <div class="form-group col-md-4 op-contract">
                                            <label>出团人数</label>
                                            <input type="text" name="info[number]" id="number"   value="{$row.number}" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-4 op-contract">
                                            <label>出团时间</label>
                                            <input type="text" name="info[dep_time]" id="dep_time"   value="{$row.dep_time}" class="form-control inputdate" />
                                        </div>

                                        <div class="form-group col-md-4 op-contract">
                                            <label>结束时间</label>
                                            <input type="text"  name="info[end_time]" id="end_time"   value="{$row.end_time}" class="form-control inputdate" />
                                        </div>


                                        <div class="form-group col-md-12">
                                            <label>备注</label>
                                            <textarea class="form-control" name="info[remarks]">{$row.remarks}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <h2 class="little-title">合同模板/律师审核</h2>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group col-md-4">
                                            <label>是否需要律师审核</label>
                                            <select name="info[lawyer]" class="form-control">
                                                <option value="1">需要律师审核</option>
                                                <option value="2">不需要律师审核</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4" id="need_tpl_or_not">
                                            <label>是否选择合同模板：</label>
                                            <div class="form-control no-border">
                                                <input type="radio" name="is_tpl" value="1" > &nbsp;选择 &#12288;&#12288;
                                                <input type="radio" name="is_tpl" value="0" checked> &nbsp;不选择
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4" id="tpl-box">
                                            <label>请选择模板</label>
                                            <select name="info[tpl_id]" class="form-control">
                                                <option value="">==请选择==</option>
                                                <foreach name="tpl_list" key="k" item="v">
                                                    <option value="{$k}">{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <h2 class="little-title">合同相关文件<small>（为了方便后期审核,请尽量上传word类型文件）</small></h2>
                                    </div>
                                    <div class="form-group col-md-12">
                                        {:upload_m('uploadfile','files',$atts,'上传文件')}
                                    </div>


                                    <div class="form-group">&nbsp;</div>
                                </div>
                            </div><!-- /.box -->

                            <div class="form-group col-md-12" id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('myform','<?php echo U('Contract/public_save'); ?>');">保存</a>
                            </div>
                            </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>
            
<include file="Index:footer2" />

<script type="text/javascript">

    $(function () {
        $('#tpl-box').hide();
        //$('.op-contract').hide();

        $('#need_tpl_or_not').find('ins').each(function (index,ele) {
            $(this).click(function () {
                let is_tpl      = $(this).prev('input').val();
                if (is_tpl == 1){ //需要模板
                    $('#tpl-box').show();
                    $('select[name="info[tpl_id]"]').attr('required',true);
                }else{
                    $('#tpl-box').hide();
                    $('select[name="info[tpl_id]"]').removeAttr('required');
                    $('select[name="info[tpl_id]"]').val('');
                }
            })
        })
    })

    $('#type').on('change',function () {
        let type                = $(this).val();
        if (type == 1){ //团内合同
            $('.op-contract').show();
        }else{ //非团合同
            $('.op-contract').hide();
            $('#dep_time').val('');
            $('#end_time').val('');
            $('#group_id').val('');
            $('#proname').val('');
            $('#number').val('');
        }
    });

    function check_contract(){
        var gid = $('#groupid').val();
        if(gid){
            $.ajax({
                type: "POST",
                url: "{:U('Ajax/get_contract')}",
                dataType:'json',
                data: {gid:gid},
                success:function(data){
                    if (data.stu){
                        art_show_msg(data.msg,3);
                        return false;
                    }else{
                        getop();
                    }
                }
            });
        }else{
            art_show_msg('请输入团号');
        }
    }

    function getop(){
        var gid = $('#groupid').val();
        if(gid){
            $.ajax({
                type: "GET",
                url: "<?php echo U('Ajax/getop'); ?>",
                dataType:'json',
                data: {gid:gid},
                success:function(data){
                    if(data){
                        $('#proname').val(data.project);
                        $('#number').val(data.renshu?data.renshu:data.number);
                        $('#dep_time').val(data.dep_time);
                        $('#end_time').val(data.ret_time);
                        $('#contract_amount').val(data.shouru);
                    }else{
                        art_show_msg('未获取到项目信息');
                    }
                }
            });
        }else{
            art_show_msg('请输入团号');
        }
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
        let title   = $('input[name="info[title]"]').val();
        let customer= $('input[name="info[customer]"]').val();
        let num     = $('input[name="info[num]"]').val();
        let contract_amount = $('#contract_amount').val();
        let is_tpl  = $('#need_tpl_or_not').find('div[aria-checked="true"]').find('input[name="is_tpl"]').val();
        let tpl_id  = $('select[name="info[tpl_id]"]').val();

        if(!title) {  art_show_msg('合同名称不能为空',3); return false;};
        if(!customer) { art_show_msg('签约方不能为空',3); return false;};
        if(!num || parseInt(num) == 0) { art_show_msg('合同份数填写有误',3); return false;};
        if(!contract_amount || parseInt(contract_amount) == 0) { art_show_msg('合同金额填写有误',3); return false;};
        if(parseInt(is_tpl) == 1 && !tpl_id) { art_show_msg('请选择合同模板',3); return false;};

        $.ajax({
            type: "POST",
            url: url,
            dataType:'json',
            data: $('#'+id).serialize(),
            success:function(data){
                if(parseInt(data.num)>0){
                    art.dialog.alert(data.msg,'success');
                    window.location.href = "{:U('Contract/index')}";
                }else{
                    art.dialog.alert(data.msg,'warning');
                    return false;
                }
            },
            error:function () {
                alert('error');
            }
        });

        //setTimeout("history.go(0)",1000);
    }
    
</script>