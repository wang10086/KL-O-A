<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>我要立项</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Op/plans')}" name="myform" id="save_plans">
            <input type="hidden" name="dosubmint" value="1">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">


                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">项目计划</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">

                                    <div class="form-group col-md-12">
                                        <label>项目名称(学校名称 + 地点 + 项目类型)：</label><input type="text" name="info[project]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4" style="clear: right;">
                                        <label style="display: block">行程方案</label>
                                        <input type="text" name="line_title" class="form-control" style="width: 75%; display: inline-block;">
                                        <input type="hidden" name="info[line_id]">
                                        <span style="display: inline-block; width: 20%">
                                            <a  href="javascript:;" class="btn btn-success btn-sm" onClick="selectmodel()">获取线路</a>
                                        </span>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>适合人群：</label>
                                        <select  class="form-control"  name="info[apply_to]" required>
                                            <option value="" selected disabled>请选择适合人群</option>
                                            <foreach name="apply_to" key="k" item="v">
                                                <option value="{$k}" <?php if ($row && ($k == $row['grade'])) echo ' selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>项目类型：</label>
                                        <select  class="form-control"  name="info[kind]" id="kind"  required>
                                            <option value="" selected disabled>请选择项目类型</option>
                                            <foreach name="kinds" item="v">
                                                <option value="{$v.id}" >{:tree_pad($v['level'], true)} {$v.name}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>预计人数：</label><input type="text" name="info[number]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label id="ctrq">计划出团日期：</label><input type="text" name="info[departure]"  class="form-control inputdate"  required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label id="xcts">行程天数：</label><input type="text" name="info[days]" class="form-control"  required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>目的地省份</label>
                                        <select  class="form-control"  name="province" id="province" required >
                                            <option value="" disabled selected>--请选择--</option>
                                            <foreach name="provinces" key="k" item="v">
                                                <option value="{$v}" <?php if ($area && ($area['province'] == $v)) echo ' selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>详细地址：</label><input type="text" name="addr" class="form-control"  required />
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>客户单位：</label>
<!--
                                        <input type="text" name="info[customer]" id="customer_name" value="" placeholder="您可以输入客户单位名称拼音首字母检索" class="form-control" />
-->
                                        <!--<select  name="info[customer]" class="form-control" required>
                                            <option value="" selected disabled>请选择客户单位</option>
                                            <foreach name="geclist"  item="v">
                                                <option value="{$v.company_name}"><?php /*echo strtoupper(substr($v['pinyin'], 0, 1 )); */?> - {$v.company_name}</option>
                                            </foreach>
                                        </select>-->

                                        <input type="text" class="form-control" name="info[customer]" value="" list="customer" onblur="check_customer($(this).val())" />
                                        <datalist id="customer">
                                            <foreach name="geclist" item="v">
                                                <option value="{$v}" label="" />
                                            </foreach>
                                        </datalist>
                                    </div>

                                    <div class="form-group col-md-4" style="padding: 0">
                                        <div class="col-md-12"  style="padding-right: 0">
                                            <span class="lm_c">协助销售实施专家：</span>
                                            <foreach name="expert" key="k" item="v">
                                                <span class="lm_c"><input type="checkbox" name="expert[]" value="{$k}"> {$v}</span>
                                            </foreach>
                                        </div>
                                        <div class="col-md-12"  style="padding-right: 0">
                                            <span class="lm_c">背景提升产品负责人：</span>
                                            <span class="lm_c"><input type="checkbox" name="expert[]" value="202"> 于洵</span>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>是否本公司其他项目部地接</label>
                                        <select  name="info[in_dijie]" class="form-control" id="dijie" onchange="is_or_not_dijie()" required>
                                            <option value="" selected disabled>--请选择--</option>
                                            <option value="1">是</option>：
                                            <option value="2">否</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4" id="dijie_name"></div>

                                    <div class="form-group col-md-4" id="sale">
                                        <label>销售人员：</label>
                                        <input type="text" class="form-control" name="info[sale_user]" value="{:session('nickname')}" readonly>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>备注：</label><textarea class="form-control"  name="info[context]" id="context"></textarea>
                                        <span id="contextTip"></span>
                                    </div>

                                    <div class="form-group col-md-12 ml-12" id="is_or_not_worder">
                                        <h2 class="tcs_need_h2">是否需要下工单：</h2>
                                        <input type="radio" name="need_worder_or_not" value="0"  <?php if($rad==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                                        <input type="radio" name="need_worder_or_not" value="1"  <?php if($rad==1){ echo 'checked';} ?>> &#8194;需要
                                    </div>

                                    <div class="form-group col-md-12 ml-12" id="wonder_department" style="margin-top: -30px;">
                                        <h2 class="tcs_need_h2">工单接收部门：</h2>
                                        <input type="checkbox" name="exe_user_id[]" value="12"> &nbsp;研发(公司大研发-秦总)&#12288;
                                        <input type="checkbox" name="exe_user_id[]" value="31"> &nbsp;研发(京区校内-魏春竹) &#12288;
                                        <input type="checkbox" name="exe_user_id[]" value="110"> &nbsp;研发(南京-李艳) &#12288;
                                        <input type="checkbox" name="exe_user_id[]" value="115"> &nbsp;资源(南京-桂小佩) &#12288;
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                        <div style="width:100%; text-align:center;">
                            <div class="callout callout-danger" id="noSubmitDiv" style="display: none">
                                <h4>提示：如果无法提交立项,请按要求及时完善客户信息！</h4>
                            </div>
                            <button type="button" onclick="save_form('save_plans')" class="btn btn-info btn-lg" id="lrpd">我要立项</button>
                        </div>

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
    <script type="text/javascript">
        laydate.render({
            elem: '.inputdate',theme: '#0099CC',type: 'datetime'
        });

        $(function () {
            $('#dijie_name').hide();
            $('#wonder_department').hide();

            var keywords = <?php echo $userkey; ?>;
            $(".userkeywords").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function(row, i, max, term) {
                    return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
                },
                formatResult: function(row) {
                    return row.user_name;
                }
            }).result(function(event, item) {
                $('#exe_user').val(item.id);
            });


            $('#is_or_not_worder').find('ins').each(function (index,ele) {
                $(this).click(function () {
                    var is_worder   = $(this).prev('input[name="need_worder_or_not"]').val();
                    if (is_worder == 1){    //需要下工单
                        $('#wonder_department').show();
                    }else{
                        $('#wonder_department').hide();
                        $('input[name="exe_user_id[]"]').parent('div').removeClass('checked');
                    }
                })
            })

        })

       function is_or_not_dijie(){
           var dj = $('#dijie').val();
           if (dj == 1){
               var HTML = '';
               HTML += '<label>地接单位名称</label>'+
                    '<select  name="info[dijie_name]" class="form-control" required>'+
                    '<option value="" selected disabled>--请选择--</option>'+
                    '<foreach name="dijie_names" key="k" item="v">'+
                    '<option value="{$k}">{$v}</option>'+
                    '</foreach>'+
                    '</select>';
               $('#dijie_name').html(HTML);
               $('#sale').hide();
               $('#dijie_name').show();
           }else{
               $('#dijie_name').hide();
               $('#dijie_name').html('');
               $('#sale').show();
           }
       }

        /*function autocom(e) {
            var keywords = <?php echo $linelist; ?>;

            $("#lineName").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function(row, i, max, term) {
                    return '<span style=" display:none">'+row.pinyin+'</span>'+row.title;
                },
                formatResult: function(row) {
                    return row.title;
                }
            }).result(function(event, item) {
                $('#lineName').val(item.title);
                $('#line_id').val(item.id);
            });

        }*/

        $('#kind').on('change',function () {
            var kind    = $(this).val();
            if (kind == 54 || kind == 84){
                $('#dijie').children('option[value="2"]').attr('selected',true);
                $('#dijie').attr('disabled',true);
            }else if(kind == 83){
                $('#dijie').children('option[value="1"]').attr('selected',true);
                $('#dijie').attr('disabled',true);
                $('#dijie_name').show();
            }else {
                $('#dijie').find('option[value="1"]').attr('selected',false);
                $('#dijie').find('option[value="2"]').attr('selected',false);
                $('#dijie').children('option:first-child').attr('selected',true).attr('disabled',true);
                $('#dijie').removeAttr('disabled');
            }
            is_or_not_dijie();
        })

        //重新选择模板
        function selectmodel() {
            art.dialog.open('<?php echo U('Op/select_product'); ?>',{
                lock:true,
                title: '选择行程线路',
                width:1000,
                height:500,
                okValue: '提交',
                fixed: true,
                ok: function () {
                    var origin      = artDialog.open.origin;
                    var line_data   = this.iframe.contentWindow.gosubmint();
                    var title       = line_data[0].title;
                    var line_id     = line_data[0].id;
                    $('input[name="line_title"]').val(title);
                    $('input[name="info[line_id]"]').val(line_id);

                },
                cancelValue:'取消',
                cancel: function () {
                }
            });
        }

        function save_form(id) {
            let project     = $('input[name="info[project]"]').val().trim();
            let line_id     = $('input[name="info[line_id]"]').val();
            let apply_to    = $('select[name="info[apply_to]"]').val();
            let kind        = $('select[name="info[kind]"]').val();
            let number      = $('input[name="info[number]"]').val();
            let departure   = $('input[name="info[departure]"]').val();
            let days        = $('input[name="info[days]"]').val();
            let province    = $('select[name="province"]').val();
            let addr        = $('input[name="addr"]').val();
            let customer    = $('input[name="info[customer]"]').val();
            let in_dijie    = $('select[name="info[in_dijie]"]').val();
            let dijie_name  = $('select[name="info[dijie_name]"]').val();

            let geclist     = <?php echo $geclist_str; ?>;
            let customer_num = 0;
            if (in_array(customer,geclist)){
                customer_num++;
            }

            if (!project)   { art_show_msg('项目名称不能为空',3); return false; }
            if (!line_id)   { art_show_msg('线路选择有误',3); return false; }
            if (!apply_to)  { art_show_msg('适合人群不能为空',3); return false; }
            if (!kind)      { art_show_msg('项目类型不能为空',3); return false; }
            if (!kind)      { art_show_msg('项目类型不能为空',3); return false; }
            if (!number)    { art_show_msg('预计人数不能为空',3); return false; }
            if (!departure) { art_show_msg('计划出团日期不能为空',3); return false; }
            if (!days)      { art_show_msg('行程天数不能为空',3); return false; }
            if (!province)  { art_show_msg('目的地省份不能为空',3); return false; }
            if (!addr)      { art_show_msg('详细地址不能为空',3); return false; }
            if (!customer_num){ art_show_msg('客户单位填写错误',3); return false; }
            if (!in_dijie)  { art_show_msg('是否内部地接不能为空',3); return false; }
            if (in_dijie == 1 && !dijie_name){ art_show_msg('内部地接名称不能为空',3); return false; }
            $('#'+id).submit();
        }

        //检查客户信息是否完善
        function check_customer(customer){
            if (!customer){
                art_show_msg('客户单位不能为空',2); return false;
            }else{
                $.ajax({
                    type: 'POST',
                    url: "{:U('Ajax/check_customer')}",
                    data:{customer:customer},
                    success:function (data) {
                        if (data.stu == 0){
                            art_show_msg(data.msg,3);
                            $('#lrpd').hide();
                            $('#noSubmitDiv').show();
                            return false;
                        }else{
                            $('#lrpd').show();
                            $('#noSubmitDiv').hide();
                        }
                    },
                    error:function (data) {
                        console.log(data.statusText);
                    }
                })
            }
        }

    </script>