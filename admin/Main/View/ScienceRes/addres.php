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
                            <form method="post" action="{:U('ScienceRes/addres')}" name="myform" id="myform">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    
                                    <input type="hidden" name="dosubmit" value="1" />
                                    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                    <if condition="$row"><input type="hidden" name="id" value="{$row.id}" /></if>
                                    <!-- text input -->

                                    <div class="form-group col-md-8">
                                        <label>资源名称</label>
                                        <input type="text" name="info[title]" id="title" value="{$row.title}"  class="form-control" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>是否院内</label>
                                        <select name="info[in_cas]" class="form-control">
                                            <option value="0" <?php if ($row['in_cas'] ==0) echo 'selected'; ?>>否</option>
                                            <option value="1" <?php if ($row['in_cas'] ==1) echo 'selected'; ?>>是</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>资源类型</label>
                                        <select  class="form-control"  name="info[kind]" required>
                                        <foreach name="kinds" item="v">
                                            <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo 'selected'; ?> >{$v.name}</option>
                                        </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>所在地区</label>
                                        <input type="text" name="info[diqu]" id="diqu"   value="{$row.diqu}" class="form-control" />
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>地址</label>
                                        <input type="text" name="info[address]" id="address"   value="{$row.address}" class="form-control" />
                                    </div>

                                    <?php if (!$row['id'] || $row['id'] && /*in_array(cookie('userid'),array(11))*/ rolemenu(array('ScienceRes/resContacts'))){ ?>
                                    <!--<div class="form-group col-md-12">
                                        <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;"></label>
                                    </div>-->

                                    <div class="form-group col-md-4">
                                        <label>联系人</label>
                                        <input type="text" name="info[contacts]" id="contacts"   value="{$row.contacts}" class="form-control" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>联系人职务</label>
                                        <input type="text" name="info[contacts_tel]" id="contacts_tel"   value="{$row.contacts_tel}" class="form-control" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>电话</label>
                                        <input type="text" name="info[tel]" id="tel" value="{$row.tel}"  class="form-control" />
                                    </div>
                                    <?php } ?>

                                    <div class="form-group col-md-12">
                                        <label><a href="javascript:;" onClick="selectkinds()">选择适用项目类型</a> <span style="color:#999999">(选择后您可以点击删除)</span></label>
                                        <!--<div id="pro_kinds_text">-->

                                        <!--<foreach name="deptlist" item="v">
                                             <span class="unitbtns" title="点击删除该选项"><input type="hidden" name="business_dept[]" value="{$v.id}"><button type="button" class="btn btn-default btn-sm">{$v.name}</button></span>
                                        </foreach>-->
                                            <div class="content" id="kindlist" style="display: none">
                                                <table class="table table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">项目类型</th>
                                                        <th width="10%">适宜人群</th>
                                                        <th width="10%">活动时长</th>
                                                        <th width="10%">可实施时间</th>
                                                        <th width="10%">可接待规模</th>
                                                        <th width="10%">标准化产品/模块</th>
                                                        <th width="10%">费用</th>
                                                        <th width="10%">预约需提前时间</th>
                                                        <th width="10%">备注</th>
                                                        <th width="80">删除</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <foreach name="kindlist" item="v">
                                                        <tr class="expense" id="kind_8888{$v.id}">
                                                            <td style="vertical-align:middle">
                                                                <input type="hidden" name="data[8888{$v.id}][id]" value="{$v.id}">
                                                                <input type="hidden" name="data[8888{$v.id}][kind_id]" value="{$v.kind_id}">
                                                                <input type="hidden" name="data[8888{$v.id}][kind]" value="{$v.kind}">
                                                                {$v.kind}
                                                            </td>
                                                            <td>
                                                                <select name="data[8888{$v.id}][apply]" class="form-control">
                                                                    <foreach name="apply" key='key' item='value'><option value="{$key}" <?php if ($key == $v['apply']) echo "selected"; ?>>{$value}</option></foreach>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="data[8888{$v.id}][time_length]]" class="form-control">
                                                                    <foreach name="time_length" item="vv"><option value="{$vv}" <?php if ($vv == $v['time_length']) echo 'selected'; ?>>{$vv}</option></foreach>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="data[8888{$v.id}][use_time]" class="form-control">
                                                                    <foreach name="use_time" item="value"><option value="{$value}" <?php if($value == $v['use_time']) echo "selected"; ?>>{$value}</option></foreach>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="data[8888{$v.id}][scale]" class="form-control">
                                                                    <foreach name="scale" item="value"><option value="{$value}" <?php if($value == $v['scale']) echo "selected"; ?>>{$value}</option></foreach>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="data[8888{$v.id}][module]" value="{$v.module}" class="form-control" /></td>
                                                            <td><input type="text" name="data[8888{$v.id}][money]" value="{$v.money}" class="form-control" /></td>
                                                            <td>
                                                                <select name="data[8888{$v.id}][lead_time]" class="form-control">
                                                                    <foreach name="lead_time" item="value"><option value="{$value}" <?php if($value == $v['lead_time']) echo "selected"; ?>>{$value}</option></foreach>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="data[8888{$v.id}][remark]" value="{$v.remark}" class="form-control" /></td>
                                                            <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('kind_'+8888{$v.id})">删除</a></td>
                                                        </tr>
                                                    </foreach>
                                                    <tr id="reAddKind">
                                                        <td><a href="javascript:;" onclick="selectkinds()" class="btn btn-success btn-sm"><i class="fa fa-fw fa-plus"></i>添加项目类型</a></td>
                                                        <td colspan="9"></td>
                                                    </tr>

                                                    </tbody>
                                                    <tfoot>

                                                    </tfoot>
                                                </table>
                                            </div>

                                        <!--</div>-->
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>介绍</label>
                                        <?php
                                         echo editor('content',$row['content']);
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
<script type="text/javascript">
    $(function () {
        var id = {$row['id']?$row['id']:0};
        if (id){
            $('#kindlist').css('display','block');
        }
    })
	
	//选择适用项目类型
	function selectkinds() {
		art.dialog.open('<?php echo U('Product/select_kinds'); ?>',{
			lock:true,
			title: '选择适用项目类型',
			width:600,
			height:400,
			okValue: '提交',
			fixed: true,
			ok: function () {
				var origin = artDialog.open.origin;
				var data = this.iframe.contentWindow.gosubmint();
				var i=0;
				var str = "";
				for (i=0; i<data.length; i++) {
                    if (data[i].id){
                        var j = parseInt(Math.random()*10000)+i;
                        var aaa = '<input type="hidden" name="data['+j+'][kind_id]" value="'+data[i].id+'"><input type="hidden" name="data['+j+'][kind]" value="'+data[i].kind+'">';
                        str += '<tr class="expense" id="kind_'+j+'">' +
                            '<td style="vertical-align:middle">'+aaa+data[i].kind+'</td>' +
                            '<td><select name="data['+j+'][apply]" class="form-control"><foreach name="apply" key='k' item='v'><option value="{$k}">{$v}</option></foreach></select></td>' +
                            '<td><select name="data['+j+'][time_length]]" class="form-control"><foreach name="time_length" item="vv"><option value="{$vv}">{$vv}</option></foreach></select></td>'+
                            '<td><select name="data['+j+'][use_time]]" class="form-control"><foreach name="use_time" item="vv"><option value="{$vv}">{$vv}</option></foreach></select></td>'+
                            '<td><select name="data['+j+'][scale]]" class="form-control"><foreach name="scale" item="vv"><option value="{$vv}">{$vv}</option></foreach></select></td>'+
                            '<td><input type="text" name="data['+j+'][module]" value="" class="form-control" /></td>' +
                            '<td><input type="text" name="data['+j+'][money]" value="" class="form-control" /></td>' +
                            '<td><select name="data['+j+'][lead_time]]" class="form-control"><foreach name="lead_time" item="vv"><option value="{$vv}">{$vv}</option></foreach></select></td>'+
                            '<td><input type="text" name="data['+j+'][remark]" value="" class="form-control" /></td>' +
                            '<td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'kind_'+j+'\')">删除</a></td></tr>';
                    }
				}
                $('#kindlist').show();
                $('#kindlist').find('#reAddKind').before(str);
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}
	
	
	/*function closebtns(){
	    $('.unitbtns').each(function(index, element) {
              $(this).click(function(){
		       $(this).remove();
          	  })  
          });	
	}*/

	function delbox(id) {
        $('#'+id+'').remove();
    }

</script>	
