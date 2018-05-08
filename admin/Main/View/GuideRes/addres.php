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
                        <li><a href="{:U('GuideRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form method="post" action="{:U('GuideRes/addres')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->
                                    
                                    <div class="form-group col-md-4">
                                        <label>姓名</label>
                                        <input type="text" name="info[name]" id="title" value="{$row.name}"  class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>类型</label>
                                        <select  class="form-control"  name="info[kind]" required>
                                        <foreach name="kinds" item="v">
                                            <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{$v.name}</option>
                                        </foreach>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>性别</label>
                                        <select  class="form-control"  name="info[sex]" required>
                                            <option value="男" <?php if ($row && ('男' == $row['sex'])) echo ' selected'; ?> >男</option>
                                            <option value="女" <?php if ($row && ('女' == $row['sex'])) echo ' selected'; ?> >女</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>学校</label>
                                        <input type="text" name="info[school]" id="school"   value="{$row.school}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>专业</label>
                                        <input type="text" name="info[major]" id="major"   value="{$row.major}" class="form-control" />
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-4">
                                        <label>学历</label>
                                        <input type="text" name="info[edu]" id="edu"   value="{$row.edu}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>年级</label>
                                        <input type="text" name="info[grade]" id="grade"   value="{$row.grade}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>生日</label>
                                        <input type="text" name="info[birthday]"  value="{$row.birthday}" onclick="laydate()" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>费用</label>
                                        <input type="text" name="info[fee]" id="fee"   value="{$row.fee}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>地区</label>
                                        <input type="text" name="info[area]" id="field"   value="{$row.area}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>电话</label>
                                        <input type="text" name="info[tel]" id="field"   value="{$row.tel}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>邮箱</label>
                                        <input type="text" name="info[email]" id="field"   value="{$row.email}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-8">
                                        <label>擅长领域</label>
                                        <input type="text" name="info[field]" id="field"   value="{$row.field}" class="form-control" />
                                    </div>
                                    
                                    
                                    <div class="form-group col-md-4">
                                        <label>性质</label>
                                        <select  class="form-control"  name="info[type]" required>
                                            <option value="0" <?php if ($row && $row['type'] == 0) echo ' selected'; ?>>兼职</option>
                                            <option value="1" <?php if ($row && $row['type'] == 1) echo ' selected'; ?>>专职</option>
                                        </select>
                                    </div>

                                    <!-------------------------------------------start----------------------------------------------------->
                                    <!--<div class="content" style="padding-top:0px;">
                                            <div id="pretium">
                                                <div class="userlist">
                                                    <div class="unitbox">价格名称</div>
                                                    <div class="unitbox">销售价</div>
                                                    <div class="unitbox">同行价</div>
                                                    <div class="unitbox">包含成人人数</div>
                                                    <div class="unitbox">包含儿童人数</div>
                                                    <div class="unitbox">备注</div>
                                                </div>
                                                <?php /*if($pretium){ */?>
                                                    <foreach name="pretium" key="k" item="v">
                                                        <div class="userlist" id="pretium_id_{$v.id}">
                                                            <span class="title"><?php /*echo $k+1; */?></span>
                                                            <input type="hidden" name="resid[888{$v.id}][id]" value="{$v.id}" >
                                                            <input type="text" class="form-control" name="pretium[888{$v.id}][pretium]" value="{$v.pretium}">
                                                            <input type="text" class="form-control" name="pretium[888{$v.id}][sale_cost]" value="{$v.sale_cost}">
                                                            <input type="text" class="form-control" name="pretium[888{$v.id}][peer_cost]" value="{$v.peer_cost}">
                                                            <input type="text" class="form-control" name="pretium[888{$v.id}][adult]" value="{$v.adult}">
                                                            <input type="text" class="form-control" name="pretium[888{$v.id}][children]" value="{$v.children}">
                                                            <input type="text" class="form-control" name="pretium[888{$v.id}][remark]" value="{$v.remark}">
                                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id_{$v.id}')">删除</a>
                                                        </div>
                                                    </foreach>
                                                <?php /*}else{ */?>
                                                    <div class="userlist" id="pretium_id">
                                                        <span class="title">1</span>
                                                        <input type="text" class="form-control" name="pretium[888{$v.id}][pretium]" value="基础价">
                                                        <input type="text" class="form-control" name="pretium[888{$v.id}][sale_cost]" value="">
                                                        <input type="text" class="form-control" name="pretium[888{$v.id}][peer_cost]" value="">
                                                        <input type="text" class="form-control" name="pretium[888{$v.id}][adult]" value="">
                                                        <input type="text" class="form-control" name="pretium[888{$v.id}][children]" value="">
                                                        <input type="text" class="form-control" name="pretium[888{$v.id}][remark]" value="">
                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                                    </div>
                                                <?php /*} */?>
                                            </div>
                                            <div id="pretium_val">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_pretium()"><i class="fa fa-fw fa-plus"></i> 新增价格信息</a>
                                                <a href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_info_price','<?php echo U('Op/public_save_price'); ?>',{$op.op_id});">保存</a>
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                        </div>-->
                                    <!---------------------------------------------end----------------------------------------------------->

                                    
                                    <div class="form-group col-md-12">
                                        <label>经历</label>
                                        <?php 
                                             echo editor('content',$row['experience']); 
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


<include file="Index:footer2" />

<script>
    //新增价格政策
    function add_pretium(){
        var i = parseInt($('#pretium_val').text())+1;

        var html = '<div class="userlist" id="pretium_'+i+'"><span class="title"></span><input type="text" class="form-control" name="pretium['+i+'][pretium]"><input type="text"  class="form-control" name="pretium['+i+'][sale_cost]"><input type="text" class="form-control" name="pretium['+i+'][peer_cost]"><input type="number" class="form-control" name="pretium['+i+'][adult]"><input type="number" class="form-control" name="pretium['+i+'][children]"><input type="text" class="form-control" name="pretium['+i+'][remark]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a></div>';
        $('#pretium').append(html);
        $('#pretium_val').html(i);
        orderno();
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
    }

    //编号
    function orderno(){
        $('#mingdan').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#pretium').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#costacc').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }

</script>