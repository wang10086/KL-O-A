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

                                    <div class="form-group col-md-4">
                                        <label>项目名称(学校名称 + 地点 + 项目类型)：</label><input type="text" name="info[project]" class="form-control" required />
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

                                    <!--<div class="form-group col-md-4">
                                        <label>业务部门：</label>
                                        <select  class="form-control" name="info[op_create_user]" >
                                            <option value="" selected disabled>请选择业务部门</option>
                                            <foreach name="rolelist" key="k" item="v">
                                                <option value="{$v}" <?php /*if($k==cookie('roleid')){ echo 'selected';} */?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>-->

                                    <div class="form-group col-md-4">
                                        <label>客户单位：</label>
<!--
                                        <input type="text" name="info[customer]" id="customer_name" value="" placeholder="您可以输入客户单位名称拼音首字母检索" class="form-control" />
-->
                                        <select  name="info[customer]" class="form-control" required>
                                            <option value="" selected disabled>请选择客户单位</option>
                                            <foreach name="geclist"  item="v">
                                                <option value="{$v.company_name}"><?php echo strtoupper(substr($v['pinyin'], 0, 1 )); ?> - {$v.company_name}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <span class="lm_c">协助销售实施专家：</span>
                                        <foreach name="expert" key="k" item="v">
                                            <span class="lm_c"><input type="checkbox" name="expert[]" value="{$k}"> {$v}</span>
                                        </foreach>
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
                                        <!--<input type="checkbox" name="exe_user_id[]" value="26"> &nbsp;资源(公司资源-李岩)&#12288;-->
                                        <input type="checkbox" name="exe_user_id[]" value="31"> &nbsp;研发(京区校内-魏春竹) &#12288;
                                        <!--<input type="checkbox" name="exe_user_id[]" value="174"> &nbsp;资源(京区校内-李亚楠) &#12288;-->
                                        <input type="checkbox" name="exe_user_id[]" value="110"> &nbsp;研发(南京-李艳) &#12288;
                                        <input type="checkbox" name="exe_user_id[]" value="115"> &nbsp;资源(南京-桂小佩) &#12288;
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                        <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">我要立项</button>
                            <!--<a  href="javascript:;" class="btn btn-info btn-lg" id="lrpd" onClick="javascript:save('save_plans','<?php /*echo U('Op/plans'); */?>');">我要立项</a>-->
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

        function autocom(e) {
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

        }

    </script>
<script type="text/javascript">

</script>