<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_pagetitle_}
                        <small>{$_action_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('SupplierRes/public_save')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('SupplierRes/public_save')}" name="myform" id="myform" onsubmit="return submitBefore()">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="form-group col-md-12 mt10">
                                   <!-- <div class="callout callout-danger mb-0">
                                        <h4>提示！</h4>
                                        <p>1、</p>
                                    </div>-->
                                </div>

                                <!--

                                [id] => 3
    [supplier_id] => 1076
    [quota_id] => 17
    [year] => 2020
    [cycle] => 2020-3
    [type] => type
    [rule] => rule
    [unit] => unit
    [unitcost] => 0.00
    [business_unitcost] => 0.00
    [remark] => &lt;p&gt;啊速度发发生&lt;/p&gt;

    [input_uid] => 1
    [input_uname] => 系统管理员
    [input_time] => 1576661400
    [audit_status] => 0
                                -->

                                <div class="box-body">
                                    <input type="hidden" name="dosubmint" value="1" />
                                    <input type="hidden" name="savetype" value="2">
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <if condition="$list"><input type="hidden" name="id" value="{$list.id}" /></if>

                                    <div class="form-group col-md-8">
                                        <label>集中采购方名称</label>
                                        <select class="form-control" name="info[supplier_id]" required>
                                            <foreach name="supplier_data" item="v">
                                                <option value="{$v.id}" <?php if ($v['id']==$list['supplier_id']) echo "selected"; ?>>{$v.name}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>集中采购内容</label>
                                        <select class="form-control" name="info[quota_id]" required>
                                            <option value="" selected disabled>==请选择==</option>
                                            <foreach name="quota" item="v">
                                                <option value="{$v.id}" <?php if ($v['id']==$list['quota_id']) echo "selected"; ?>>{$v.title}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>集采年份</label>
                                        <select class="form-control" name="info[year]" onchange="set_type($(this).val())">
                                            <?php $year = date('Y'); for ($i=$year-1; $i <= $year+2; $i++){ ?>
                                                <option value="{$i}" <?php if ($i==$list['year']) echo "selected"; ?>>{$i}年</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>业务季</label>
                                        <select  class="form-control"  name="info[cycle]" id="cycle" required>
                                            <option value="{$list['year'].'-1'}" <?php if ($list['cycle'] == $year.'-1') echo "selected"; ?>>{$year}年寒假</option>
                                            <option value="{$list['year'].'-2'}" <?php if ($list['cycle'] == $year.'-2') echo "selected"; ?>>{$year}年春季</option>
                                            <option value="{$list['year'].'-3'}" <?php if ($list['cycle'] == $year.'-3') echo "selected"; ?>>{$year}年暑假</option>
                                            <option value="{$list['year'].'-4'}" <?php if ($list['cycle'] == $year.'-4') echo "selected"; ?>>{$year}年秋季</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>所属分类</label>
                                        <input type="text" name="info[type]" value="{$list.type}" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>计价规则</label>
                                        <input type="text" name="info[rule]" value="{$list.rule}" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>计价单位</label>
                                        <input type="text" name="info[unit]" value="{$list.unit}"  class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>集中采购单价</label>
                                        <input type="text" name="info[unitcost]" value="{$list.unitcost}"  class="form-control" required />
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label>备注</label>
                                        <?php 
                                             echo editor('remark',$list['remark']);
                                             ?>
                                    </div>

                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                            	<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                            </form>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>

<script type="text/javascript">
    $(function () {
        let id  = <?php echo $list['id'] ? $list['id'] : 0; ?>;
        let year = $('select[ name="info[year]"]').val();
        if (!id){ set_type(year); }
    })

    function set_type(year) {
        let  cycle = <?php echo $list['cycle'] ? $list['cycle'] : 0; ?>;
        if (!year){ art_show_msg('年份信息有误'); return false; }
        var html = '';
        html += '<option value="">==请选择==</option>';
        html += '<option value="'+year+'-1">'+year+'年寒假</option>';
        html += '<option value="'+year+'-2">'+year+'年春季</option>';
        html += '<option value="'+year+'-3">'+year+'年暑假</option>';
        html += '<option value="'+year+'-4">'+year+'年秋季</option>';
        $('#cycle').html(html)
    }

    function submitBefore() {
        let supplier_id     = $('select[name="info[supplier_id]"]').val(); //集中采购方名称
        let quota_id        = $('select[name="info[quota_id]"]').val(); //集中采购内容
        let year            = $('select[name="info[year]"]').val(); //集采年份
        let cycle           = $('#cycle').val(); //业务季
        let type            = $('input[name="info[type]"]').val().trim(); //所属分类
        let rule            = $('input[name="info[rule]"]').val().trim(); //计价规则
        let unit            = $('input[name="info[unit]"]').val().trim(); //计价单位
        let unitcost        = $('input[name="info[unitcost]"]').val().trim(); //集中采购单价
        if (!supplier_id){ art_show_msg('集中采购方名称不能为空',3); return false; }
        if (!quota_id){    art_show_msg('集中采购内容不能为空',3); return false; }
        if (!year){        art_show_msg('集采年份不能为空',3); return false; }
        if (!cycle){       art_show_msg('业务季不能为空',3); return false; }
        if (!type){        art_show_msg('所属分类不能为空',3); return false; }
        if (!rule){        art_show_msg('计价规则不能为空',3); return false; }
        if (!unit){        art_show_msg('计价单位不能为空',3); return false; }
        if (!unitcost){    art_show_msg('集中采购单价不能为空',3); return false; }
        $('#myform').submit();
    }
</script>
            
<include file="Index:footer2" />