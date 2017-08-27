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
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,120);"><i class="fa fa-search"></i> 搜索</a>
                                         <if condition="rolemenu(array('Kpi/addqa'))">
                                         <a href="javascript:;" onClick="add_qa()" class="btn btn-danger btn-sm" ><i class="fa fa-plus"></i> 发布</a>
                                         </if>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<div class="btn-group" id="catfont">
                                        
                                        <button onClick="window.location.href='{:U('Kpi/qa',array('type'=>2))}'" class="btn <?php if($type==2){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">全部</button>
                                        <button onClick="window.location.href='{:U('Kpi/qa',array('type'=>1))}'" class="btn <?php if($type==1){ echo 'btn-info';}else{ echo 'btn-default'; } ?>">处罚</button>
                                        <button onClick="window.location.href='{:U('Kpi/qa',array('type'=>0))}'" class="btn <?php if($type==0){ echo 'btn-info';}else{ echo 'btn-default'; } ?>" >奖励</button>
                                       
                                    </div>
                                   
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" data="title">标题</th>
                                        <th width="80" class="sorting" data="month">执行月份</th>
                                        <th width="80" class="sorting" data="rp_user_name">奖惩人员</th>
                                        <th width="140" class="sorting" data="rp_role_name">所属部门</th>
                                        <th width="80" class="sorting" data="status">类型</th>
                                        <th width="80">分数</th>
                                        <th width="120" class="ins_time" data="status">发布时间</th>
                                        <if condition="rolemenu(array('Kpi/revoke'))">
                                        <th width="50" class="taskOptions">撤销</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td><a href="javascript:;" onClick="qadetail({$row.id})" >{$row.title}</a></td>
                                        <td>{$row.month}</td>
                                        <td>{$row.rp_user_name}</td>
                                        <td>{$row.rp_role_name}</td>
                                        <td>{$row.statusstr}</td>
                                        <td>{$row.score}</td>
                                        <td><if condition="$row['ins_time']">{$row.ins_time|date='Y-m-d H:i',###}</if></td>
                                        <if condition="rolemenu(array('Kpi/revoke'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel('{:U('Kpi/revoke',array('id'=>$row['id']))}','您真的要撤销吗？')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-reply"></i></button>
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
                <input type="hidden" name="c" value="Kpi">
                <input type="hidden" name="a" value="qa">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="month" placeholder="月份">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="user" placeholder="奖惩人员">
                </div>
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="type">
                        <option value="2">类型</option>
                        <option value="0">奖励</option>
                        <option value="1">惩罚</option>
                    </select>                   
                </div>
                
                </form>
            </div>
            
           

	<include file="Index:footer2" />

	
	<script>
    //新建PDCA
	function add_qa(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=addqa&id='+id,{
			lock:true,
			title: '发布品质检查信息',
			width:1000,
			height:480,
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
	
	 //查看详情
	function qadetail(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=qadetail&id='+id,{
			lock:true,
			title: '品质检查详情',
			width:800,
			height:'90%',
			fixed: true,
			
		});	
	}
	</script>
