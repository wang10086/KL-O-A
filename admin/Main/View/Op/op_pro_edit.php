<form method="post" action="<?php echo U('Op/public_save'); ?>" name="myform" id="save_op_info">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="10">
    <div class="form-group col-md-4" >
        <label>项目名称：</label><input type="text" name="info[project]"  value="{$op.project}" class="form-control" />
    </div>

    <div class="form-group col-md-4">
        <label>适合人群：</label>
        <select  class="form-control"  name="info[apply_to]" required>
            <option value="" selected disabled>请选择适合人群</option>
            <foreach name="apply_to" key="k" item="v">
                <option value="{$k}" <?php if ($op && ($k == $op['apply_to'])) echo ' selected'; ?> >{$v}</option>
            </foreach>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label>项目类型：</label>
        <select  class="form-control"  name="info[kind]" required>
        <foreach name="kinds" key="k" item="v">
            <option value="{$k}" <?php if ($op && ($k == $op['kind'])) echo ' selected'; ?> >{$v}</option>
        </foreach>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label>预计人数：</label><input type="text" name="info[number]" value="{$op.number}" class="form-control" />
    </div>

    <div class="form-group col-md-4">
        <label>计划出团日期：</label><input type="text" name="info[departure]" value="{$op.departure}"  class="form-control inputdate"/>
    </div>

    <div class="form-group col-md-4">
        <label>行程天数：</label><input type="text" name="info[days]" value="{$op.days}" class="form-control" />
    </div>

    <div class="form-group col-md-4">
        <label>目的地：</label><input type="text" name="info[destination]" value="{$op.destination}" class="form-control" />
    </div>

    <div class="form-group col-md-4">
        <!--<label>立项时间：</label><input type="text" name="info[op_create_date]" value="{$op.op_create_date}"class="form-control inputdate_a" />-->
        <label>协助销售实施专家：</label>
        <select class="form-control" name="info[expert]">
            <option value="">==请选择==</option>
            <foreach name="expert" key="k" item="v">
                <option value="{$k}" <?php if($op['expert']==$k){ echo 'selected'; } ?>>{$v}</option>
            </foreach>
        </select>
    </div>



    <div class="form-group col-md-4">
        <label>业务部门：</label>
        <select  class="form-control" name="info[op_create_user]">
        <foreach name="rolelist" key="k" item="v">
            <option value="{$v}" <?php if($v==$op['op_create_user']){ echo 'selected';} ?> >{$v}</option>
        </foreach>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label>客户单位：</label>
        <select  name="info[customer]" class="form-control">
            <foreach name="geclist"  item="v">
                <option value="{$v.company_name}" <?php if($op['customer']==$v['company_name']){ echo 'selected';} ?> ><?php echo strtoupper(substr($v['pinyin'], 0, 1 )); ?> - {$v.company_name}</option>
            </foreach>
        </select>

    </div>

    <div class="form-group col-md-4">
        <label>是否本公司其他项目部地接</label>
        <select  name="info[in_dijie]" class="form-control" required id="dijie" onchange="is_or_not_dijie()">
            <option value="" disabled>--请选择--</option>
            <option value="1" <?php if ($op['in_dijie'] ==1){echo 'selected';} ?> >是</option>：
            <option value="2" <?php if ($op['in_dijie'] ==2 || !$op['in_dijie']){echo 'selected';} ?> >否</option>
        </select>
    </div>

    <div class="form-group col-md-4" id="dijie_or_sale"></div>

    <div class="form-group col-md-12">
        <label>备注：</label><textarea class="form-control"  name="info[context]">{$op.context}</textarea>
    </div>

    <div class="form-group col-md-12" id="addti_btn">
        <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_op_info','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>
    </div>
</form>

<script>
    var in_dijie = "<?php echo $op['in_dijie']; ?>";
    var dijie_name = '<label>地接单位名称：</label>'+
            '<select  name="info[dijie_name]" class="form-control" required>'+
            '<option value="" selected disabled>--请选择--</option>'+
            '<foreach name="dijie_names" key="k" item="v">'+
            '<option value="{$k}" <?php if ($op['dijie_name']==$k){echo 'selected';} ?>>{$v}</option>'+
            '</foreach>'+
            '</select>';
    var sale = '<label>销售人员：</label> ' +
        '<input type="text" class="form-control" name="info[sale_user]" value="{$op.sale_user}" readonly>';
    $(function () {
        if (in_dijie ==1){
            $('#dijie_or_sale').html(dijie_name);
        }else{
            $('#dijie_or_sale').html(sale);
        }
    })

    function is_or_not_dijie(){
        var dj = $('#dijie').val();
        if (dj == 1){
            $('#dijie_or_sale').html(dijie_name);
        }else{
            $('#dijie_or_sale').html(sale);
        }
    }

</script>