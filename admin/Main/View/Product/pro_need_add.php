<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_action_}</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">基本信息</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">

                                    <form method="post" action="{:U('Product/public_save')}" name="myform" id="myForm">
                                        <input type="hidden" name="dosubmit" value="1">
                                        <input type="hidden" name="savetype" value="5">
                                        <input type="hidden" name="id" value="{$list.id}">
                                        <div class="form-group col-md-12">
                                            <label>项目名称：</label><input type="text" name="info[title]" value="{$list.title}" class="form-control" required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label>
                                            <select  class="form-control"  name="info[kind]" id="kind"  required>
                                                <option value="">请选择项目类型</option>
                                                <foreach name="kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($list['kind'] == $v['id']) echo "selected" ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>递交客户时间：</label><input type="text" name="info[time]"  value="<?php echo $list['time'] ? date('Y-m-d',$list['time']) : ''; ?>" class="form-control inputdatetime"  required />
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
                                            <label>预计人数：</label><input type="text" name="info[number]" value="{$list.number}" class="form-control" required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label id="ctrq">计划出团日期：</label><input type="text" name="info[departure]"  value="<?php echo $list['departure'] ? date('Y-m-d',$list['departure']) : ''; ?>" class="form-control inputdate"  required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label id="xcts">行程天数：</label><input type="text" name="info[days]" value="{$list.days}" class="form-control"  required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>目的地省份</label>
                                            <select  class="form-control"  name="info[province]" id="province" required >
                                                <option value="" disabled selected>--请选择--</option>
                                                <foreach name="provinces" key="k" item="v">
                                                    <option value="{$k}" <?php if ($list['province'] == $k) echo ' selected'; ?> >{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>详细地址：</label><input type="text" name="info[addr]" class="form-control" value="{$list.addr}" required />
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label>客户单位：</label>
                                            <input type="text" class="form-control" name="info[customer]" value="{$list.customer}" list="customer" onblur="check_customer($(this).val())" />
                                            <datalist id="customer">
                                                <foreach name="geclist" item="v">
                                                    <option value="{$v}" label="" />
                                                </foreach>
                                            </datalist>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>接待实施部门</label>
                                            <select  name="info[dijie_department_id]" class="form-control" onchange="get_line_blame_data()" required>
                                                <option value="" selected disabled>--请选择--</option>
                                                <foreach name="dijie_data" item="v">
                                                    <option value="{$v.id}" <?php if ($list['dijie_department_id'] == $v['id']) echo ' selected'; ?>>{$v.department}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>线控负责人：</label>
                                            <input type="hidden" class="form-control" name="info[line_blame_uid]" value="{$list.line_blame_uid}" />
                                            <input type="text" class="form-control" name="info[line_blame_name]" value="{$list.line_blame_name}" readonly />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>客户预算：</label>
                                            <input type="text" class="form-control" name="info[cost]" value="{$list.cost}" required />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>备注：</label><textarea class="form-control"  name="info[remark]">{$list.remark}</textarea>
                                        </div>

                                        <div id="formsbtn">
                                                <div class="callout callout-danger content" id="noSubmitDiv" style="display: none">
                                                    <h4>提示：如果无法提交需求,请按要求及时完善客户信息！</h4>
                                                </div>
                                            <button type="button" onclick="check_dijie_province_data()" class="btn btn-info btn-sm" id="base_btn">保存</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                        <?php if ($list['kind'] == 60){ ?> <!--60=>科学课程-->
                            <include file="pro_60_edit" />
                        <?php }elseif ($list['kind'] == 82){ ?> <!--82=>科学博物园-->
                            <include file="pro_82_edit" />
                        <?php }elseif ($list['kind'] == 54){ ?> <!--54=>研学旅行-->
                            <include file="pro_54_edit" />
                        <?php }elseif ($list['kind'] == 90){ ?> <!--90=>背景提升-->
                            <include file="pro_90_edit" />
                        <?php }elseif ($list['kind'] == 67){ ?> <!--67=>实验室建设-->
                            <include file="pro_67_edit" />
                        <?php } ?>

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
            </section><!-- /.content -->

        </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />
    <script type="text/javascript">

        $(function () {
            //是否标准化
            $('#standard_box').find('ins').each(function () {
                $(this).click(function () {
                    var is_standard = $(this).prev('input[name="info[standard]"]').val();
                    let html = ''
                    if (is_standard == 1){ //标准化
                        html = '<label style="display: block">标准化产品</label>' +
                            '<input type="text" name="producted_title" class="form-control" style="width: 75%; display: inline-block;" readonly>' +
                            '<input type="hidden" name="info[producted_id]">' +
                            '<span style="display: inline-block; width: 20%; margin-left: 3px">' +
                            '<a  href="javascript:;" class="btn btn-success btn-sm" onClick="select_standard_product()">获取产品</a>' +
                            '</span>'
                    }else{ //非标准化
                        html = '<label style="display: block">标准化产品</label>' +
                            '<input type="text" name="producted_title" class="form-control" style="width: 75%; display: inline-block;" readonly>' +
                            '<input type="hidden" name="info[producted_id]">' +
                            '<span style="display: inline-block; width: 20%; margin-left: 3px">' +
                            '<a  href="javascript:;" class="btn btn-default btn-sm">获取产品</a>' +
                            '</span>'
                    }
                    $('#line_or_product').html(html)
                    //relaydate();
                })
            })

        })

        // 判断填写数据是否正确
        function check_dijie_province_data() {
            let kind                = $('#kind').val();
            let province            = $('#province').val();
            let dijie_department_id = $('select[name="info[dijie_department_id]"]').val(); //地接部门ID

            if (!kind){ art_show_msg('项目类型填写有误',2000); return false; }
            if (!province){ art_show_msg('省份信息填写有误',2000); return false; }
            if (!dijie_department_id){ art_show_msg('接待部门信息填写有误',2000); return false; }

            $.ajax({
                type: 'POST',
                url: "{:U('Ajax/check_product_pro_need_data')}",
                data:{kind:kind,province:province,department_id:dijie_department_id},
                success:function (data) {
                    if (data.code == 'n'){
                        art_show_msg(data.msg,3);
                        return false;
                    }else{
                        save_form('myForm')
                    }
                },
                error:function (data) {
                    console.log('error');
                }
            })
        }

        //获取线控负责人
        function get_line_blame_data() {
            let department_id = $('select[name="info[dijie_department_id]"]').val();
            let kind    = $('#kind').val();
            if (department_id){
                if (!kind){ art_show_msg('项目类型信息错误',3); return false; }
                // if (!department_id){ art_show_msg('接待实施部门信息有误', 3); return false; }
                $.ajax({
                    type: 'POST',
                    url: "{:U('Ajax/get_line_blame_user_data')}",
                    data:{kind:kind,department_id:department_id},
                    success:function (data) {
                        $('input[name="info[line_blame_uid]"]').val(data.line_blame_uid);
                        $('input[name="info[line_blame_name]"]').val(data.line_blame_name);
                    },
                    error:function (data) {
                        console.log('error');
                    }
                })
            }
        }

       //设置研学旅行项目类型(是否地接)
       function set_yxlx_op_type(kind){
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
       }

        $('#kind').on('change',function () {
            var kind    = $(this).val();
            set_yxlx_op_type(kind) // 设置研学旅行项目类型(是否地接)
            $('input[name="producted_title"]').val('');
            $('input[name="info[producted_id]"]').val('');
            get_line_blame_data();
        })

        //选择行程线路
        /*function selectmodel() {
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
        }*/

        //标准化产品
        function select_standard_product() {
            let kind = $('#kind').val();
            if (!kind){ art_show_msg('请先选择项目类型',3); return false; }
            art.dialog.open('/index.php?m=Main&c=Op&a=public_select_standard_product&kind='+kind,{
                lock:true,
                title: '选择标准化产品',
                width:1000,
                height:500,
                okVal: '提交',
                fixed: true,
                ok: function () {
                    var origin          = artDialog.open.origin;
                    var producted_data  = this.iframe.contentWindow.gosubmint();
                    var title           = producted_data[0].title;
                    var producted_id    = producted_data[0].id;
                    $('input[name="producted_title"]').val(title);
                    $('input[name="info[producted_id]"]').val(producted_id);

                },
                cancelVal:'取消',
                cancel: function () {
                }
            });
        }

        function save_form(id) {
            let title       = $('input[name="info[title]"]').val().trim();
            let kind        = $('select[name="info[kind]"]').val();
            let number      = $('input[name="info[number]"]').val();
            let departure   = $('input[name="info[departure]"]').val();
            let days        = $('input[name="info[days]"]').val();
            let province    = $('select[name="info[province]"]').val();
            let addr        = $('input[name="info[addr]"]').val();
            let customer    = $('input[name="info[customer]"]').val();
            let dijie_dep_id= $('select[name="info[dijie_department_id]"]').val();
            let line_uid    = $('input[name="info[line_blame_uid]"]').val();
            let line_name   = $('input[name="info[line_blame_name]"]').val();
            let cost        = $('input[name="info[cost]"]').val();

            let geclist     = <?php echo $geclist_str; ?>;
            let customer_num = 0;
            if (in_array(customer,geclist)){
                customer_num++;
            }

            if (!title)   { art_show_msg('项目名称不能为空',3); return false; }
            if (!kind)      { art_show_msg('项目类型不能为空',3); return false; }
            if (!number)    { art_show_msg('预计人数不能为空',3); return false; }
            if (!departure) { art_show_msg('计划出团日期不能为空',3); return false; }
            if (!days)      { art_show_msg('行程天数不能为空',3); return false; }
            if (!province)  { art_show_msg('目的地省份不能为空',3); return false; }
            if (!addr)      { art_show_msg('详细地址不能为空',3); return false; }
            if (!customer_num){ art_show_msg('客户单位填写错误',3); return false; }
            if (!dijie_dep_id){ art_show_msg('接待实施部门错误',3); return false; }
            if (!cost)      { art_show_msg('客户预算信息错误',3); return false; }
            if (!line_uid || !line_name){ art_show_msg('线控负责人信息错误',3); return false; }
            $('#'+id).submit();
        }

        //检查客户信息是否完善
        function check_customer(customer){
            if (!customer){
                art_show_msg('客户单位不能为空',3); return false;
            }else{
                $.ajax({
                    type: 'POST',
                    url: "{:U('Ajax/check_customer')}",
                    data:{customer:customer},
                    success:function (data) {
                        if (data.stu == 0){
                            art_show_msg(data.msg,4);
                            $('#base_btn').hide();
                            $('#noSubmitDiv').show();
                            return false;
                        }else{
                            $('#base_btn').show();
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
