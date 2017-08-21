<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/pdca')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	 
                                         <if condition="rolemenu(array('Kpi/addpdca'))">
                                         <a href="javascript:;" onClick="add_pdca()" class="btn btn-info btn-sm" >新建PDCA</a>
                                         </if>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="120" data="month">月份</th>
                                        <th class="sorting" data="title">PDCA描述</th>
                                        <th width="100" class="sorting" data="tab_user_id">编制人</th>
                                        <th width="100" class="sorting" data="total_score">总分</th>
                                        <th width="100" class="sorting" data="status">状态</th>
                                        <if condition="rolemenu(array('Kpi/pdcainfo'))">
                                        <th width="50" class="taskOptions">项目</th>
                                        </if>
                                        <if condition="rolemenu(array('Kpi/editpdca'))">
                                        <th width="50" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Kpi/delpdca'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.month}</td>
                                        <td><a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" >{$row.title}</a></td>
                                        <td>{:username($row['tab_user_id'])}</td>
                                        <td>{$row.total_score}</td>
                                        <td>{$pdcasta.$row[status]}</td>
                                        <if condition="rolemenu(array('Kpi/pdcainfo'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Kpi/pdcainfo',array('id'=>$row['id']))}" title="项目" class="btn btn-success btn-smsm"><i class="fa fa-ellipsis-h"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Kpi/editpdca'))">
                                        <td class="taskOptions">
                                        <a href="javascript:;" onClick="add_pdca({$row.id})" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Kpi/delpdca'))">
                                        <td class="taskOptions">
                                        <button onclick="javascript:ConfirmDel('{:U('Kpi/delpdca',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                       
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
            
            
            <div id="mkdir">
                <form method="post" action="{:U('Files/mkdirs')}" name="myform" id="gosub">
            	<input type="hidden" name="dosubmit"  value="1">
                <input type="hidden" name="pid" value="{$pid}">
                <input type="hidden" name="level" value="{$level}">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="filename" placeholder="文件夹名称">
                </div>
                </form>
            </div>
            
            
           

	<include file="Index:footer2" />


	<script>
    //新建PDCA
	function add_pdca(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=addpdca&id='+id,{
			lock:true,
			title: '新建PDCA',
			width:800,
			height:200,
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
	}
	</script>
