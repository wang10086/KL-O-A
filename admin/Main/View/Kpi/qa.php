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

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <!--<a href="{:U('Kpi/qa',array('pin'=>0))}" class="btn <?php /*if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} */?>">全部</a>-->
                                <a href="{:U('Kpi/qa',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">品质报告</a>
                                <a href="{:U('Kpi/qa',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">不合格报告</a>
                            </div>

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',450,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <?php if (rolemenu(array('Kpi/addqa')) && $pin==1){ ?>
                                             <a href="{:U('Kpi/addqa')}" class="btn btn-danger btn-sm" ><i class="fa fa-plus"></i> 发布</a>
                                         <?php }elseif($pin==2){ ?>
                                             <a href="{:U('Kpi/public_addqa')}" class="btn btn-danger btn-sm" ><i class="fa fa-plus"></i> 发布</a>
                                         <?php } ?>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <?php if ($pin ==1){ ?>
                                        <table class="table table-bordered dataTable fontmini" id="tablelist">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" width="60" data="id">ID</th>
                                                <th class="sorting" data="title">标题</th>
                                                <th width="80" class="sorting" data="month">绩效月份</th>
                                                <th width="80" class="sorting" data="rp_user_name">责任人</th>
                                                <th width="80" class="sorting" data="inc_user_name">发布者</th>
                                                <th width="80" class="sorting" data="ex_user_name">审核者</th>
                                                <th width="80" class="sorting" data="status">状态</th>
                                                <th width="120" class="create_time" data="status">发布时间</th>
                                                <if condition="rolemenu(array('Kpi/addqa'))">
                                                    <th width="50" class="taskOptions">编辑</th>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/appqa'))">
                                                    <th width="50" class="taskOptions">审核</th>
                                                </if>
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
                                                    <td>{$row.inc_user_name}</td>
                                                    <td>{$row.ex_user_name}</td>
                                                    <td><span title="{$row.ex_reason}">{$row.statusstr}</span></td>
                                                    <td><if condition="$row['create_time']">{$row.create_time|date='Y-m-d H:i',###}</if></td>
                                                    <if condition="rolemenu(array('Kpi/addqa'))">
                                                        <td class="taskOptions">
                                                            <?php
                                                                if(in_array($row['status'],array(0,3)) && ( C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 ||  cookie('userid')==$row['inc_user_id'])) {
                                                                    ?>
                                                                    <a href="{:U('Kpi/addqa',array('id'=>$row['id']))}"  title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </if>

                                                    <if condition="rolemenu(array('Kpi/appqa'))">
                                                        <td class="taskOptions">
                                                            <?php
                                                                if(rolemenu(array('Kpi/appqa')) && (($row['status']==0 && $row['kind']==1) || ($row['status']==5 && $row['kind']==2))) {
                                                                    ?>
                                                                    <a href="{:U('Kpi/appqa',array('id'=>$row['id']))}"  title="审核" class="btn btn-success btn-smsm"><i class="fa fa-check"></i></a>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </if>
                                                    <if condition="rolemenu(array('Kpi/revoke'))">
                                                        <td class="taskOptions">
                                                            <?php
                                                                if(($row['status']==1 && in_array(cookie('userid'),array(12,13,26,38,32))) ||(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10)) {
                                                                    ?>
                                                                    <button onClick="javascript:ConfirmDel('{:U('Kpi/revoke',array('id'=>$row['id']))}','您真的要撤销吗？')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-reply"></i></button>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>

                                                    </if>

                                                </tr>
                                            </foreach>
                                        </table>
                                    <?php }elseif($pin == 2){ ?>
                                        <table class="table table-bordered dataTable fontmini" id="tablelist">
                                            <tr role="row" class="orders" >
                                                <th class="sorting" width="60" data="id">ID</th>
                                                <th class="sorting" data="title">标题</th>
                                                <th class="sorting" data="type">报告类型</th>
                                                <th width="80" class="sorting" data="inc_user_name">报告人员</th>
                                                <th width="120" class="sorting" data="status">状态</th>
                                                <th width="120" class="create_time" data="create_time">发布时间</th>
                                                <if condition="rolemenu(array('Kpi/addqa'))">
                                                    <th width="50" class="taskOptions">编辑</th>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/handle')) && in_array($pin,array(0,2))">
                                                    <th width="50" class="taskOptions">跟进</th>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/appqa'))">
                                                    <th width="50" class="taskOptions">审核</th>
                                                </if>
                                                <if condition="rolemenu(array('Kpi/revoke'))">
                                                    <th width="50" class="taskOptions">撤销</th>
                                                </if>
                                            </tr>
                                            <foreach name="lists" item="row">
                                                <tr>
                                                    <td>{$row.id}</td>
                                                    <td><a href="javascript:;" onClick="qadetail({$row.id})" >{$row.title}</a></td>
                                                    <td>{$qaqc_type[$row['type']]}</td>
                                                    <td>{$row.inc_user_name}</td>
                                                    <td><span title="{$row.ex_reason}">{$row.statusstr}</span></td>
                                                    <td><if condition="$row['create_time']">{$row.create_time|date='Y-m-d H:i',###}</if></td>
                                                    <if condition="rolemenu(array('Kpi/addqa'))">
                                                        <td class="taskOptions">
                                                            <?php
                                                                if(in_array($row['status'],array(0,3)) && ( C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10 ||  cookie('userid')==$row['inc_user_id'])) {
                                                                    ?>
                                                                    <a href="{:U('Kpi/addqa',array('id'=>$row['id']))}"  title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </if>

                                                    <?php if (rolemenu(array('Kpi/handle'))){ ?>
                                                        <td class="taskOptions">
                                                            <?php if (in_array($row['status'],array(4,5)) && $row['kind'] ==2){ ?>
                                                                <a href="{:U('Kpi/handle',array('id'=>$row['id']))}" title="跟进" class="btn btn-info btn-smsm"><i class="fa fa-wrench"></i></a>
                                                            <?php } ?>
                                                        </td>
                                                    <?php  } ?>

                                                    <if condition="rolemenu(array('Kpi/appqa'))">
                                                        <td class="taskOptions">
                                                            <?php
                                                                if(rolemenu(array('Kpi/appqa')) && (($row['status']==0 && $row['kind']==1) || ($row['status']==5 && $row['kind']==2))) {
                                                                    ?>
                                                                    <a href="{:U('Kpi/appqa',array('id'=>$row['id']))}"  title="审核" class="btn btn-success btn-smsm"><i class="fa fa-check"></i></a>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>
                                                    </if>
                                                    <if condition="rolemenu(array('Kpi/revoke'))">
                                                        <td class="taskOptions">
                                                            <?php
                                                                if(($row['status']==1 && in_array(cookie('userid'),array(12,13,26,38,32))) ||(C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10)) {
                                                                    ?>
                                                                    <button onClick="javascript:ConfirmDel('{:U('Kpi/revoke',array('id'=>$row['id']))}','您真的要撤销吗？')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-reply"></i></button>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </td>

                                                    </if>

                                                </tr>
                                            </foreach>
                                        </table>
                                    <?php } ?>
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
                <input type="hidden" name="pin" value="{$pin}">

                <?php if ($pin == 1){ ?>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="tit" placeholder="标题">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="month" placeholder="绩效月份">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="user" placeholder="奖惩人员">
                    </div>
                <?php }elseif($pin == 2){ ?>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="tit" placeholder="标题">
                    </div>
                    <div class="form-group col-md-12">
                        <select class="form-control" name="type">
                            <option value="" selected disabled>报告类型</option>
                            <foreach name="qaqc_type" item="v" key="k">
                                <option value="{$k}">{$v}</option>
                            </foreach>
                        </select>
                    </div>
                <?php } ?>
                
                </form>
            </div>
            
           

	<include file="Index:footer2" />

	
	<script>
    //新建PDCA
	function add_qa(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=addqa&id='+id,{
			lock:true,
			title: '发布品质报告信息',
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
			title: '品质报告详情',
			width:800,
			height:'90%',
			fixed: true,
			
		});	
	}
	</script>
