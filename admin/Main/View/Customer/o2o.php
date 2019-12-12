<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>支撑服务校客户</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <div class="tip">
                                    	<div  id="catfont">
                                            <if condition="rolemenu(array('Customer/o2o_apply'))">
                                            <a href="javascript:;" onClick="apply()" class="btn btn-success" style="padding:6px 12px;">分配客户</a>
                                            </if>
                                            
                                        </div>
                                    
                                    
                                    </div>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,100);"><i class="fa fa-search"></i> 搜索</a>
                                        
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th width="40" style="text-align:center;"><input type="checkbox" id="accessdata"/></th>
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" data="company_name">单位名称</th>
                                        <th class="sorting" data="type">客户性质</th>
                                        <th class="sorting" data="contacts">联系人</th>
                                        <th class="sorting" data="contacts_phone">联系电话</th>
                                        <th class="sorting" data="province">所在地</th>
                                        <th>项目记录</th>
                                        <th>项目数</th>
                                        <th class="sorting" data="level">级别</th>
                                        <th class="sorting" data="qianli">开发潜力</th>
                                        <!-- <th class="sorting" data="contacts_address">通讯地址</th> 
                                        <th>结算记录</th>
                                        <th>结算次数</th>
                                        -->
                                        <th class="sorting" data="cm_name">维护人</th>
                                        <if condition="rolemenu(array('Customer/GEC_edit'))">
                                        <th width="50" class="taskOptions">维护</th>
                                        </if>
                                        <if condition="rolemenu(array('Customer/delgec'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                    	<td align="center">
                                        <input type="checkbox"  value="{$row.id}" class="accessdata" />
                                        </td>
                                        <td>{$row.id}</td>
                                        <td><a href="{:U('Customer/GEC_viwe',array('id'=>$row['id']))}" title="详情">{$row.company_name}</a></td>
                                        <td>{$row.type}</td>
                                        <td>{$row.contacts}</td>
                                        <td>{$row.contacts_phone}</td>
                                        <td>{$row.province} {$row.city} {$row.county}</td>
                                        <!-- <td><div class="tdbox_long">{$row.contacts_address}</div></td> -->
                                        <td>{$row.hezuo}</td>
                                        <td>{$row.hezuocishu}</td>
                                        <td>{$row.level}</td>
                                        <td>{$row.qianli}</td>
                                        <td>{$row.cm_name}</td>
                                        <if condition="rolemenu(array('Customer/GEC_edit'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Customer/GEC_edit',array('id'=>$row['id']))}" title="维护" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Customer/delgec'))">
                                        <td class="taskOptions">
                                        <button onclick="javascript:ConfirmDel('{:U('Customer/delgec',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                       
                                        </td>
                                        </if>
                                       
                                    </tr>
                                    </foreach>					
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            
            
            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Customer">
                <input type="hidden" name="a" value="o2o">
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="关键字">
                </div>
                
                
                
                
                
                <div class="form-group col-md-6">
                	<input type="text" class="form-control" name="province" placeholder="省份">
                </div>
                
                
                </form>
            </div>
			
            
            <script>
            $(document).ready(function(e) {
				//选择
				$('#accessdata').on('ifChecked', function() {
					$('.accessdata').iCheck('check');
				});
				$('#accessdata').on('ifUnchecked', function() {
					$('.accessdata').iCheck('uncheck');
				});
			});
			
			
			
			//审核
			function apply(){
				var fid = '';
				$('.accessdata').each(function(index, element) {
					var checked = $(this).parent().attr('aria-checked');
                    if(checked=='true'){
						fid += $(this).val() + '.';	
					}
                });	
				
				if(fid){
					//打开目录窗口
					art.dialog.open("index.php?m=Main&c=Customer&a=o2o_apply&fid="+fid,{
						lock:true,
						title: '分配给',
						width:900,
						height:500,
						okValue: '提交',
						fixed: true,
						ok: function () {
							this.iframe.contentWindow.gosubmint();
							return false;
						},
						cancelValue:'取消',
						cancel: function () {
						}
					});	
				}else{
					alert('请选择要分配的客户');	
				}
			}
            </script>
            
            
			<include file="Index:footer2" />
            
            
