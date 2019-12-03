<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>客户管理</h1>
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
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">客户管理</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <if condition="rolemenu(array('Customer/GEC_edit'))">
                                         <a href="{:U('Customer/GEC_edit')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 录入客户</a>
                                         </if>
                                        <if condition="rolemenu(array('Customer/GEC_transfer'))">
                                            <a href="{:U('Customer/GEC_transfer')}" class="btn btn-sm btn-danger"><i class="fa fa-refresh"></i> 交接客户</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" data="company_name">单位名称</th>
                                        <th class="sorting" data="type">客户性质</th>
                                        <th class="sorting" data="contacts">联系人</th>
                                        <th class="sorting" data="contacts_phone">联系电话</th>
                                        <th class="sorting" data="province">所在地</th>
                                        <th>项目记录</th>
                                        <th>项目数</th>
                                        <!--<th class="sorting" data="level">级别</th>
                                        <th class="sorting" data="qianli">开发潜力</th>
                                        <th class="sorting" data="contacts_address">通讯地址</th>
                                        <th>结算记录</th>
                                        <th>结算次数</th>
                                        -->
                                        <th class="sorting" data="create_user_id">招募人</th>
                                        <th class="sorting" data="cm_id">维护人</th>
                                        <if condition="rolemenu(array('Customer/GEC_edit'))">
                                        <th width="50" class="taskOptions">维护</th>
                                        </if>
                                        <if condition="rolemenu(array('Customer/GEC_transfer'))">
                                            <th width="50" class="taskOptions">交接</th>
                                        </if>
                                        <if condition="rolemenu(array('Customer/delgec'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td><?php if (in_array($row['id'],$msg_gec_ids)){ echo "<span class='red'>*</span>"; } ?>{$row.id}</td>
                                        <td><a href="{:U('Customer/GEC_viwe',array('id'=>$row['id']))}" title="详情">{$row.company_name}</a></td>
                                        <td>{$row.type}</td>
                                        <td>{$row.contacts}</td>
                                        <td><?php echo (in_array(cookie('userid'),C('GEC_TRANSFER_UID')) || cookie('userid')== $row['cm_id']) ? $row['contacts_phone'] : $row['hide_mobile']; ?></td>
                                        <td>{$row.province} {$row.city} {$row.county}</td>
                                        <!-- <td><div class="tdbox_long">{$row.contacts_address}</div></td> -->
                                        <td>{$row.hezuo}</td>
                                        <td>{$row.hezuocishu}</td>
                                        <!--<td>{$row.level}</td>
                                        <td>{$row.qianli}</td>-->
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.cm_name}</td>
                                        <if condition="rolemenu(array('Customer/GEC_edit'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Customer/GEC_edit',array('id'=>$row['id']))}" title="维护" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Customer/GEC_transfer'))">
                                            <td class="taskOptions">
                                                <a href="javascript:;" onclick="open_change(`{:U('Customer/public_GEC_transfer',array('id'=>$row['id']))}`)" title="交接客户" class="btn btn-warning btn-smsm"><i class="fa fa-refresh"></i></a>
                                            </td>
                                        </if>
                                        <if condition="rolemenu(array('Customer/delgec'))">
                                        <td class="taskOptions">
                                        <button onclick="javascript:ConfirmDel('{:U('Customer/delgec',array('id'=>$row['id']))}')" title="删除" class="btn btn-danger btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="a" value="GEC">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="keywords" placeholder="关键字">
                </div>
                
                <div class="form-group col-md-4">
                    
                    <select  class="form-control"  name="type">
                        <option value="">客户类型</option>
                        <option value="支撑服务校">支撑服务校</option>
                        <option value="学校">学校</option>
                        <option value="机构">机构</option>
                        <option value="政府">政府</option>
                        <option value="团购客户">团购客户</option>
                        <option value="平台客户">平台客户</option>
                        <option value="其他">其他</option>
                    </select> 
                </div>
				
                <div class="form-group col-md-4">
                    
                    <select  class="form-control"  name="level">
                        <option value="">级别</option>
                        <option value="潜在客户">潜在客户</option>
                        <option value="一般客户">一般客户</option>
                        <option value="重要客户">重要客户</option>
                        <option value="VIP客户">VIP客户</option>
                    </select> 
                </div>
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="qianli">
                        <option value="">开发潜力</option>
                        <option value="无太大潜力">无太大潜力</option>
                        <option value="一般潜力">一般潜力</option>
                        <option value="潜力较大">潜力较大</option>
                        <option value="潜力巨大">潜力巨大</option>
                    </select> 
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="cm" placeholder="维护人">
                </div>

                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="create" placeholder="招募人">
                </div>
                
                <div class="form-group col-md-4">
                	<input type="text" class="form-control" name="province" placeholder="省份">
                </div>
                
                <div class="form-group col-md-4">
                	<input type="text" class="form-control" name="city" placeholder="城市">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="county" placeholder="区县">
                </div>
                
                </form>
            </div>
			
			<include file="Index:footer2" />

<script type="text/javascript">
    //客户交接
    function open_change (url) {
        art.dialog.open(url, {
            lock:true,
            id: 'audit_win',
            title: '客户交接',
            width:600,
            height:300,
            okVal: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                //location.reload();
                return false;
            },
            cancelVal:'取消',
            cancel: function () {},
            close: function () {
                window.location.href = "{:U('Customer/GEC')}";
            }
        });
    }
</script>
