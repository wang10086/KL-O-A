<form method="post" action="{:U('Product/public_save')}" name="myform" id="myForm">
    <input type="hidden" name="dosubmit" value="1">
    <input type="hidden" name="savetype" value="5">
    <input type="hidden" name="id" value="{$list.id}">
    <input type="hidden" name="opid" value="{$list.op_id}">
    <div class="form-group col-md-4">
        <label>项目名称：</label><input type="text" name="info[project]" value="{$list.project}" class="form-control" required />
    </div>

    <div class="form-group col-md-4">
        <label>项目类型：</label>
        <select  class="form-control"  name="info[kind]" id="kind"  required>
            <option value="">请选择项目类型</option>
            <foreach name="kinds" key="k" item="v">
                <option value="{$k}" <?php if ($list['kind'] == $k) echo "selected" ?> ><!--{:tree_pad($v['level'], true)}--> {$v}</option>
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
                <option value="{$k}" <?php if ($list && ($k == $list['apply_to'])) echo ' selected'; ?> >{$v}</option>
            </foreach>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label>预计人数：</label><input type="text" name="info[number]" value="{$list.number}" class="form-control" required />
    </div>

    <div class="form-group col-md-4">
        <label id="ctrq">计划出团日期：</label><input type="text" name="info[departure]"  value="{$list.departure}" class="form-control inputdate"  required />
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
        <label>详细地址：</label><input type="text" name="info[destination]" class="form-control" value="{$list.destination}" required />
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

    <div class="form-group col-md-4">
        <label>业务人员：</label>
        <input type="text" class="form-control" name="info[sale_user]" value="<?php echo $list['sale_user'] ? $list['sale_user'] : cookie('name'); ?>" readonly />
    </div>

    <div class="form-group col-md-4">
        <label>业务部门：</label>
        <input type="text" class="form-control" name="" value="<?php echo $list['create_user_department_id'] ? $departments[$list['create_user_department_id']] : $departments[cookie('department')]; ?>" readonly />
    </div>

    <div class="form-group col-md-12">
        <label>备注：</label><textarea class="form-control"  name="info[remark]">{$list.remark}</textarea>
    </div>

    <div id="formsbtn">
        <div class="callout callout-danger content" id="noSubmitDiv" style="display: none">
            <h4>提示：如果无法提交需求,请按要求及时完善客户信息！</h4>
        </div>
        <button type="button" onclick="save_form('myForm')" class="btn btn-info btn-sm" id="base_btn">保存</button>
    </div>
</form>

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
    /* function check_dijie_province_data() {
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
    } */

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

    function save_form(id) {
        let project     = $('input[name="info[project]"]').val().trim();
        let kind        = $('select[name="info[kind]"]').val();
        let number      = $('input[name="info[number]"]').val();
        let departure   = $('input[name="info[departure]"]').val();
        let days        = $('input[name="info[days]"]').val();
        let province    = $('select[name="info[province]"]').val();
        let destination = $('input[name="info[destination]"]').val();
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

        if (!project)   { art_show_msg('项目名称不能为空',3); return false; }
        if (!kind)      { art_show_msg('项目类型不能为空',3); return false; }
        if (!number)    { art_show_msg('预计人数不能为空',3); return false; }
        if (!departure) { art_show_msg('计划出团日期不能为空',3); return false; }
        if (!days)      { art_show_msg('行程天数不能为空',3); return false; }
        if (!province)  { art_show_msg('目的地省份不能为空',3); return false; }
        if (!destination) { art_show_msg('详细地址不能为空',3); return false; }
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