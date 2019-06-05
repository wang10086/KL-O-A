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
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <!--<div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('ScienceRes/addres')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建资源</a>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="title">资源名称</th>
                                            <th class="sorting" data="kind">类型</th>
                                            <th class="sorting" data="diqu">所在地</th>
                                            <th class="sorting" data="">录入时间</th>
                                        	<th>审批状态</th>
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                            <td><a href="{:U('ScienceRes/res_view', array('id'=>$row['id']))}">{$row.title}</a></td>
                                            <td><?php echo $reskind[$row['kind']]; ?></td>
                                            <td>{$row.diqu}</td>
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
            <input type="hidden" name="c" value="ScienceRes">
            <input type="hidden" name="a" value="res">
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="key" placeholder="关键字">
            </div>
            
           
            
            <div class="form-group col-md-4">
                <select class="form-control" name="type">
                    <option value="0">资源类型</option>
                    <foreach name="reskind" key="k" item="v">
                    <option value="{$k}">{$v}</option>
                    </foreach>
                </select>
            </div>
            
            <div class="form-group col-md-4">
                    <select class="form-control" name="pro">
                        <option value="0">适用业务类型</option>
                        <foreach name="kinds" key="k" item="v">
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