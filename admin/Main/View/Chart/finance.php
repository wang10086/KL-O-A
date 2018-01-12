<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>财务月度结算</h1>
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
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{$onmoon}</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                         <a href="{:U('Chart/finance',array('month'=>$moon['prevmonth'],'dept'=>$dept))}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i> {$moon.prevmonth}</a>
                                         <a href="{:U('Chart/finance',array('month'=>$moon['nextmonth'],'dept'=>$dept))}" class="btn btn-danger btn-sm">{$moon.nextmonth} <i class="fa fa-arrow-right"></i></a>
                                         <if condition="rolemenu(array('Export/chart_finance'))">
                                         <a href="{$exporturl}" class="btn btn-success btn-sm"><i class="fa fa-download"></i> 导出</a>
                                         </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <div class="btn-group" id="catfont">
                                    <a href="{:U('Chart/finance')}" <?php if(!$dept){ echo 'class="btn btn-info"';}else{ echo 'class="btn btn-default"';} ?> >所有部门</a>
                                    <a href="{:U('Chart/finance',array('month'=>$month,'dept'=>33))}" <?php if($dept==33){ echo 'class="btn btn-info"';}else{ echo 'class="btn btn-default"';} ?>>京区校外</a>
                                    <a href="{:U('Chart/finance',array('month'=>$month,'dept'=>35))}" <?php if($dept==35){ echo 'class="btn btn-info"';}else{ echo 'class="btn btn-default"';} ?>>京区校内</a>
                                    <a href="{:U('Chart/finance',array('month'=>$month,'dept'=>18))}" <?php if($dept==18){ echo 'class="btn btn-info"';}else{ echo 'class="btn btn-default"';} ?>>京外业务</a>
                                    <a href="{:U('Chart/finance',array('month'=>$month,'dept'=>19))}" <?php if($dept==19){ echo 'class="btn btn-info"';}else{ echo 'class="btn btn-default"';} ?>>常规旅游</a>
                                </div>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        
                                    </tr>
                                    <tr role="row" class="orders" >
                                        <th>团号</th>
                                        <th width="20%">线路名称</th>
                                        <th>实际人数</th>
                                        <th>目的地</th>
                                        <th>天数</th>
                                        <!--<th>人数</th>-->
                                        <th>结算收入</th>
                                        <th>结算毛利</th>
                                        <!-- <th>税后毛利</th> -->
                                        <th>销售人员</th>
                                        <th>结算时间</th>
                                    </tr>
                                    <foreach name="datalist" item="row"> 
                                    <tr>
                                        <td>{$row.group_id}</td>
                                        <td>{$row.name}</td>
                                        <td>{$row.renshu}人</td>
                                        <td>{$row.destination}</td>
                                        <td>{$row.days}天</td>
                                        <!-- <td>{$row.number}人</td>-->
                                        <td>{$row.shouru}</td>
                                        <td>{$row.maoli}</td>
                                        <!-- <td>{$row.shuihou}</td> -->
                                        <td>{$row.create_user_name}</td>
                                        <td>{$row.audit_time|date='Y-m-d',###}</td>
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
                <input type="hidden" name="a" value="finance">
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="st" onclick="laydate()" placeholder="开始时间">
                </div>
                
               	<div class="form-group col-md-6">
                    <input type="text" class="form-control" name="et" onclick="laydate()" placeholder="结束时间">
                </div>
                
                <div class="form-group col-md-6">
                    <select class="form-control"  name="dept">
                    	<option value="0">所有部门</option>
                        <option value="33" <?php if($dept==33){ echo 'selected';} ?>>京区校外</option>
                        <option value="35" <?php if($dept==35){ echo 'selected';} ?>>京区校内</option>
                        <option value="18" <?php if($dept==18){ echo 'selected';} ?>>京外业务</option>
                        <option value="19" <?php if($dept==19){ echo 'selected';} ?>>常规旅游</option>
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="xs" placeholder="销售人员">
                </div>
               
                
                </form>
            </div>

<include file="Index:footer2" />
