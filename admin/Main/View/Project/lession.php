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
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">课程信息</h3>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Project/lession_add')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 录入新课程</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('Project/lession',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">课程信息</a>
                                        <a href="{:U('Project/fields',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">学科领域</a>
                                        <a href="{:U('Project/types',array('pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">学科分类</a>
                                    </div>

                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="id">ID</th>
                                            <th class="sorting" data="name">课程名称</th>
                                            <th class="sorting" data="kind">项目类型</th>
                                            <th class="sorting" data="field">所属领域</th>
                                            <th class="sorting" data="type">学科分类</th>
                                            <th class="sorting" data="les_hours">课时</th>

                                            <if condition="rolemenu(array('Project/lession_add'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                            <if condition="rolemenu(array('Project/del'))">
                                            <th width="60" class="taskOptions">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                            <tr>
                                                <td>{$row.id}</td>
                                                <td><a href="javascript:;">{$row.name}</a></td>
                                                <td>{$row.kind}</td>
                                                <td>{$row.field}</td>
                                                <td>{$row.type}</td>
                                                <td>{$row.les_hours}</td>

                                                <?php /*
                                                if($row['audit_status']== P::AUDIT_STATUS_NOT_AUDIT){
                                                    $show  = '<td>等待审批</td>';
                                                }else if($row['audit_status'] == P::AUDIT_STATUS_PASS){
                                                    $show  = '<td><span class="green">通过</span></td>';
                                                }else if($row['audit_status'] == P::AUDIT_STATUS_NOT_PASS){
                                                    $show  = '<td><span class="red">不通过</span></td>';
                                                }
                                                echo $show;
                                                */?>
                                                <if condition="rolemenu(array('Project/lession_add'))">
                                                <td class="taskOptions">
                                                <button onClick="javascript:window.location.href='{:U('Project/lession_add',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                                </td>
                                                </if>
                                                <if condition="rolemenu(array('Project/del'))">
                                                <td class="taskOptions">
                                                <button onClick="javascript:ConfirmDel('{:U('Project/lession_del',array('id'=>$row['id']))}');" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
        <input type="hidden" name="c" value="Project">
        <input type="hidden" name="a" value="lession">
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="key" placeholder="关键字">
        </div>
        <div class="form-group col-md-12">
            <select class="form-control" name="xmlx">
                <option value="">项目类型</option>
                <foreach name="kinds" item="v">
                    <option value="{$v.id}">{$v.name}</option>
                </foreach>
            </select>
        </div>
    </form>
</div>

<include file="Index:footer2" />
