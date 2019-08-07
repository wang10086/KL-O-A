<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pagetitle}
                        <small>{$pagedesc}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('GuideRes/price')}"><i class="fa fa-gift"></i> {$pagetitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">价格体系</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('GuideRes/addprice')}"  class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建资源</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont">
                                        <a href="{:U('GuideRes/price',array('pin'=>0))}" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">价格体系</a>
                                        <a href="{:U('GuideRes/priceKind',array('pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">职能分类</a>
                                    </div>

                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="id">ID</th>
                                            <th class="sorting" data="gkname">职务</th>
                                            <th class="sorting" data="kname">项目类型</th>
                                            <th class="sorting" data="gpname">职能类型</th>
                                        	<th class="sorting" data="price">费用</th>
                                            <if condition="rolemenu(array('GuideRes/addprice'))">
                                                <th width="60" class="taskOptions">编辑</th>
                                            </if>
                                            <if condition="rolemenu(array('GuideRes/del_price'))">
                                                <th width="60" class="taskOptions">删除</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                            <td>{$row.id}</a></td>
                                            <td>{$row.gkname}</a></td>
                                            <td>{$row.kname}</a></td>
                                            <td>{$row.gpname}</a></td>
                                            <td>￥{$row.price}</a></td>
                                            <if condition="rolemenu(array('GuideRes/addprice'))">
                                                <td class="taskOptions">
                                                    <a href="{:U('GuideRes/addprice',array('id'=>$row['id']))}" ><button onClick="javascript:;" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button></a>
                                                </td>
                                            </if>
                                            <if condition="rolemenu(array('GuideRes/del_price'))">
                                                <td class="taskOptions">
                                                    <button onClick="javascript:ConfirmDel('{:U('GuideRes/del_price',array('id'=>$row['id'],'gpi_id'=>$row['gpi_id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
            <input type="hidden" name="a" value="price">

            <div class="form-group col-md-12">
                <input type="text" class="form-control" name="gkname" placeholder="职位">
            </div>

            <div class="form-group col-md-12">
                <input type="text" class="form-control" name="kname" placeholder="类型">
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