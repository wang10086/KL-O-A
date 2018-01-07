<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>个人业绩排行榜</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">个人业绩排行榜</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">排行榜</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="{:U('Chart/pplist',array('order'=>1))}" class="btn btn-info btn-sm" > 按累计收入</a>
                                         <a href="{:U('Chart/pplist',array('order'=>2))}" class="btn btn-info btn-sm" > 按累计毛利</a>
                                         <a href="{:U('Chart/pplist',array('order'=>3))}" class="btn btn-info btn-sm" > 按累计毛利率</a>
                                         <a href="{:U('Chart/pplist',array('order'=>4))}" class="btn btn-info btn-sm" > 按当月收入</a>
                                         <a href="{:U('Chart/pplist',array('order'=>5))}" class="btn btn-info btn-sm" > 按当月毛利</a>
                                         <a href="{:U('Chart/pplist',array('order'=>6))}" class="btn btn-info btn-sm" > 按当月毛利率</a>
                                     </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th width="60" data="">名次</th>
                                            <th>姓名</th>
                                            <th>所在部门</th>
                                            <th>累计收入</th>
                                            <th>累计毛利</th>
                                         	<th>累计毛利率</th>
                                            <th>当月收入</th>
                                            <th>当月毛利</th>
                                         	<th>当月毛利率</th>
                                        </tr>
                                        <foreach name="lists" item="row" key="k">                      
                                        <tr>
                                            <td><?php echo $k+1; ?></td>
                                            <td>{$row.create_user_name}</td>
                                            <td>{$row.rolename}</td>
                                            <td>&yen; {$row.zsr}</td>
                                            <td>&yen; {$row.zml}</td>
                                            <td>{$row.mll}</td>
                                            <td>&yen; {$row.ysr}</td>
                                            <td>&yen; {$row.yml}</td>
                                            <td>{$row.yll}</td>
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