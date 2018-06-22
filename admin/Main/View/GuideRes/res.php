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
                        <li><a href="{:U('GuideRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('GuideRes/addres')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建资源</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="name">姓名</th>
                                            <th class="sorting" data="kind">类型</th>
                                            <th class="sorting" data="sex">性别</th>
                                            <!--
                                            <th class="sorting" data="birthday">出生日期</th>
                                            -->
                                        	<th class="sorting" data="fee">费用</th>
                                            <th class="sorting" data="type">性质</th>
                                            <th class="sorting" data="">录入时间</th>

                                        	<th>审批状态</th>
                                            <if condition="rolemenu(array('GuideRes/addres'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                            <if condition="rolemenu(array('GuideRes/delres'))">
                                            <th width="60" class="taskOptions">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td><a href="{:U('GuideRes/res_view', array('id'=>$row['id']))}">{$row.name}</a></td>
                                            <td><?php echo $reskind[$row['kind']]; ?></td>
                                            <td>{$row.sex}</td>
                                            <!--
                                            <td>{$row.birthday}</td>
                                            -->
                                            <td>{$row.fee}</td>
                                            <td><?php if ($row['type']==1) {echo '专职'; } else {echo '兼职';} ?></td>
                                            <td><if condition="$row['input_time']">{$row.input_time|date='Y-m-d H:i:s',###}</if></td>
                                           <?php
                                            if($row['audit_status']== P::AUDIT_STATUS_NOT_AUDIT){
                                                $show  = '<td>等待审批</td>';
                                            }else if($row['audit_status'] == P::AUDIT_STATUS_PASS){
                                                $show  = '<td><span class="green">通过</span></td>';
                                            }else if($row['audit_status'] == P::AUDIT_STATUS_NOT_PASS){
                                                $show  = '<td><span class="red">不通过</span></td>';
                                            }
                                            echo $show;
                                            ?>

                                            <if condition="rolemenu(array('GuideRes/addres'))">
                                            <td class="taskOptions">

                                            <button onClick="javascript:window.location.href='{:U('GuideRes/addres',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>

                                            <!--
                                            <button onClick="openform('{:U('Rights/grant',array('res'=>'cas_res','resid'=>$row['id']))}');" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            -->
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('GuideRes/delres'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('GuideRes/delres',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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

        <include file="Index:footer2" />
        <div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="GuideRes">
            <input type="hidden" name="a" value="res">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="key" placeholder="姓名">
            </div>
            
            <div class="form-group col-md-4">
                <select class="form-control" name="sex">
                    <option value="">性别</option>
                    <option value="男">男</option>
                    <option value="女">女</option>
            	</select>
            </div>
            
            <div class="form-group col-md-4">
                <select class="form-control" name="type">
                    <option value="0">类型</option>
                    <foreach name="reskind" key="k" item="v">
                    <option value="{$k}">{$v}</option>
                    </foreach>
                </select>
            </div>
            
            
            </form>
        </div>
        <script type="text/javascript">
                function openform(obj){
                    art.dialog.open(obj,{
                        lock:true,
                        id:'respriv',
                        title: '权限分配',
                        width:600,
                        height:300,
                        okValue: '提交',
                        ok: function () {
                            this.iframe.contentWindow.myform.submit();
                            return false;
                        },
                        cancelValue:'取消',
                        cancel: function () {
                        }
                    });	
                } 
        </script>