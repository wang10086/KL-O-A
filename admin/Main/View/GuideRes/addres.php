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
                                        <label>电话</label>
                                        <input type="text" name="info[tel]" id="field"   value="{$row.tel}" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>邮箱</label>
                                        <input type="text" name="info[email]" id="field"   value="{$row.email}" class="form-control" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>性质</label>
                                        <select  class="form-control"  name="info[type]" required>
                                            <option value="0" <?php if ($row && $row['type'] == 0) echo ' selected'; ?>>兼职</option>
                                            <option value="1" <?php if ($row && $row['type'] == 1) echo ' selected'; ?>>专职</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>生日</label>
                                        <input type="text" name="info[birthday]"  value="{$row.birthday}" onclick="laydate()" class="form-control" />
                                    </div>

                                    <div class="form-group col-md-8">
                                        <label>地区</label>
                                        <input type="text" name="info[area]" id="field"   value="{$row.area}" class="form-control" />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <span class="lm_c"><strong>适合人群</strong></span>
                                        <foreach name="apply_to" key="k" item="v">
                                            <span class="lm_c"><input type="checkbox" name="grade[]" <?php if(in_array($k,$arr_apply)){ echo 'checked';} ?>  value="{$k}"> {$v}</span>
                                        </foreach>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <span class="lm_c"><strong>擅长领域</strong></span>
                                        <foreach name="fields" key="k" item="v">
                                            <span class="lm_c"><input type="checkbox" name="fields[]" <?php if(in_array($k,$arr_field)){ echo 'checked';} ?>  value="{$k}"> {$v}</span>
                                        </foreach>
                                    </div>

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
        var i = parseInt($('#costium_val').text())+1;
        var html = '<div class="userlist" id="pretium_'+i+'"><span class="title"></span><select  class="form-control"  name="cost['+i+'][kid]" required> <option value="" selected disabled>请选择费用类型</option> <foreach name="pro_kinds" item="v"> <option value="{$v.id}" >{:tree_pad($v["level"], true)} {$v.name}</option> </foreach> </select><input type="text"  class="form-control" name="cost['+i+'][price]"><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'pretium_'+i+'\')">删除</a></div>';
        $('#costium').append(html);
        $('#costium_val').html(i);
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
        $('#costium').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#costacc').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }

</script>