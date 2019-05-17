<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>城市合伙人</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/partner')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">城市合伙人</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">城市合伙人</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,100);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" data="name">合伙人名称</th>
                                        <!--<th class="sorting" data="manager">负责人</th>
                                        <th class="sorting" data="contacts">联系人</th>
                                        <th class="sorting" data="contacts_phone">联系电话</th>-->
                                        <th class="sorting" data="province">合伙人所在地</th>
                                        <th class="sorting" data="agent_province">独家区域</th>
                                        <th class="sorting" data="money">保证金</th>
                                        <th class="sorting" data="end_date">协议期限</th>
                                        <th class="taskOptions" data="cm_name">维护人</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td align="center"><a href="{:U('Customer/partner_detail',array('id'=>$row['id']))}" title="详情">{$row.name}</a></td>
                                        <!--<td>{$row.manager}</td>
                                        <td>{$row.contacts}</td>
                                        <td>{$row.contacts_phone}</td>-->
                                        <td>{$citys[$row[province]]} {$citys[$row[city]]} {$citys[$row[country]]}</td>
                                        <td>{$citys[$row[agent_province]]} {$citys[$row[agent_city]]} {$citys[$row[agent_country]]}</td>
                                        <td>{$row.money}</td>
                                        <td>{$row.start_date|date="Y-m-d",###} - <?php if (time() > $row['end_date']){ echo "<span class='red'>".date('Y-m-d',$row['end_date'])."</span>"; }else{ echo date('Y-m-d',$row['end_date']); } ?> </td>
                                        <td class="taskOptions">{$row.cm_name}</td>
                                    </tr>
                                    </foreach>
                                    <tr class="black">
                                        <td colspan="7">
                                            <span style="display: inline-block; width: 33%; padding-left: 20px;">目标：{$info.target}</span>
                                            <span style="display: inline-block; width: 33%; padding-left: 20px;">完成：{$info.really}</span>
                                            <span style="display: inline-block; width: 33%; padding-left: 20px;">完成率：{$info.complete}</span>
                                        </td>
                                    </tr>
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
                <input type="hidden" name="a" value="kpi_partner">
                    <input type="hidden" name="uid" value="{$user_id}">
                    <input type="hidden" name="st" value="{$start_time}">
                    <input type="hidden" name="et" value="{$end_time}">
                    <input type="hidden" name="target" value="{$target}">

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="合作伙伴名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="联系人">
                </div>
                
                <div class="form-group col-md-6">
                	<input type="text" class="form-control" name="province" placeholder="省份">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="维护人">
                </div>
                
                </form>
            </div>
            
            
			<include file="Index:footer2" />
            
            
