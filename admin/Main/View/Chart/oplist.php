<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目列表
                    </h1>
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
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">项目列表-{$depname}</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,200);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Op/plans'))">
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="80" data="o.op_id">编号</th>
                                        <th class="sorting" data="o.status">团号</th>
                                        <th class="sorting" data="o.project" width="160">项目名称</th>
                                        <th class="sorting" data="o.number">人数</th>
                                        <th class="sorting" data="o.departure">出行时间</th>
                                        <!--<th class="sorting" data="o.days">天数</th>
                                        <th class="sorting" width="80" data="o.destination">目的地</th>-->
                                        <th class="sorting" data="">收入</th>
                                        <th class="sorting" data="">毛利</th>
                                        <th class="sorting" width="80" data="o.kind">类型</th>
                                        <th class="sorting" data="a.jidiao">计调</th>
                                        <th class="sorting" data="o.create_user_name">创建者</th>
                                        <th class="sorting" data="o.audit_status">状态</th>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td>{$row.op_id}</td>
                                        <td><?php if($row['status']==1){ echo "<span class='green'>".$row['group_id']."</span>";}elseif($row['status']==2){ echo "<span class='red' title='".$row['nogroup']."'>不成团</span>";}else{ echo '未成团';} ?></td>
                                        <td><div class="tdbox_long"><a href="{:U('Op/plans_follow',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>{$row.number}人</td>
                                        <td>{$row.departure}</td>
                                        <!--<td>{$row.days}天</td>
                                        <td><div class="tdbox_long" style="width:80px" title="{$row.destination}">{$row.destination}</div></td>-->
                                        <td>{$row.shouru}</td>
                                        <td>{$row.maoli}</td>
                                        <td><div class="tdbox_long" style="width:80px" title="<?php echo $kinds[$row['kind']]; ?>"><?php echo $kinds[$row['kind']]; ?></div></td>
                                        <td>{$row.jidiao}</td>
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.zhuangtai}</td>
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
                <input type="hidden" name="c" value="Chart">
                <input type="hidden" name="a" value="public_oplist">
                <input type="hidden" name="opids" value="{$opids}">
                <input type="hidden" name="depname" value="{$depname}">
                <input type="hidden" name="uids" value="{$uids}">
                <input type="hidden" name="dj" value="{$dj}">
                <input type="hidden" name="pin" value="{$pin}">
                <input type="hidden" name="st" value="{$st}">
                <input type="hidden" name="et" value="{$et}">

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="id" placeholder="编号">
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control" name="kind">
                        <option value="">项目类型</option>
                        <foreach name="kinds" key="k"  item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="jd" placeholder="计调">
                </div>
               	
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="ou" placeholder="立项人">
                </div>
                </form>
            </div>

<include file="Index:footer2" />
