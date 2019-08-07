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
                        <li><a href="{:U('Project/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>
				
                
                
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <form role="form" method="post" action="{:U('Project/add')}" name="myform" id="myform">        
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" id="tab_1">
                                    
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                        <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                        <!-- text input -->
                                        
                                        <div class="form-group col-md-4" style="position:relative;">
                                            <label>项目名称</label>
                                            <input class="form-control"  type="text" name="info[name]" value="{$row.name}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>立项人</label>
                                            <input class="form-control"  type="text" name="info[chief]" value="{$row.chief}" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型</label>
                                            <select  class="form-control"  name="info[kind]" required>
                                            <foreach name="kinds" item="v">
                                                <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                            </foreach>
                                            </select>  
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-12">
                                            <label>项目背景</label>
                                            <textarea class="form-control" rows="10" name="info[desc]"></textarea>
                                        </div>
                                       
                                       
                                        <div class="form-group" stype="height:0px;">&nbsp;</div>

                                        
                                           
                                        
                                        
                                        
                                </div><!-- /.box-body -->
                                
                            </div><!-- /.box -->
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">包含产品</h3>
                                    <div class="box-tools pull-right"><a href="javascript:;" onclick="selectmodel()" class="btn btn-success btn-sm">选择关联产品</a> </div>
                                </div><!-- /.box-header -->
                                <div class="box-body" >
                                
                                <div class="form-group ">
                                
                                     <table id="flist" class="table table-bordered" >
                                           <tr valign="middle">
                                                <th style="text-align: center;" width="80">ID</th>
                                                <th style="text-align: center;">产品名称</th>
                                                <th style="text-align: center;">业务部门</th>
                                                <th style="text-align: center;">科学领域</th>
                                                <th style="text-align: center;">适用年龄</th>
                                                <th style="text-align: center;">操作</th>
                                            </tr>   
                                            
                                            <foreach name="pids" item="v">
                        <tr id="pid_{$v.id}" valign="middle">
		                <td align="center">{$v.id}<input type="hidden" name="pids[]" value="{$v.id}" /></td>
		                <td align="center">{$v.title}</td>
		                <td align="center">{:C('BUSINESS_DEPT.'.$v['business_dept'])}</td>
		                <td align="center">{:C('SUBJECT_FIELD.'.$v['subject_field'])}</td>
		                <td align="center">{:C('AGE_LIST.'.$v['age'])}</td>
		                <td align="center"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeLine('pid_{$v.id}');"><i class="fa fa-times"></i>删除</a></td>
		                </tr> 
                                            
                                            </foreach> 
                                           
                                   </table>
                               </div> 
                 
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
<script type="text/javascript"> 

    $().ready(function(e) {
    	$('#myform').validate();
    });
	//重新选择模板
	function selectmodel() {
		art.dialog.open('<?php echo U('Product/select_product'); ?>',{
			lock:true,
			title: '选择产品',
			width:860,
			height:500,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var pro = this.iframe.contentWindow.gosubmint();
				var i=0;
				var str = "";
				for (i=0; i<pro.length; i++) {
					str = '<tr id="pid_'+ pro[i].id + '" valign="middle">'
		                +  '    <td align="center">' + pro[i].id + '<input type="hidden" name="pids[]" value="'+ pro[i].id +'" /></td>'
		                +  '    <td align="center">' + pro[i].title + '</td>'
		                +  '    <td align="center">' + pro[i].business + '</td>'
		                +  '    <td align="center">' + pro[i].subject + '</td>'
		                +  '    <td align="center">' + pro[i].age + '</td>'
		                +  '    <td align="center"><a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeLine(\'pid_' + pro[i].id + '\');"><i class="fa fa-times"></i>删除</a></td>'
		                +  '</tr>';  
                    $('#flist').append(str);
				}
				
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}

	function removeLine (s) {
        $('#' + s).empty().remove();
	}

	function checkForm() {
        if ($('#pname').val() == "") {
            alert('名称不能为空！');
            return false;
        }
        if ($('input[name^=pids]').length == 0) {
            alert('请至少选择一个产品!');
            return false;
        }
        return true;
	}
</script>