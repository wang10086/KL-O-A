<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>回款管理</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">回款管理</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">回款管理</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th class="sorting" data="p.op_id">项目编号</th>
                                        <th class="sorting" data="c.group_id">团号</th>
                                        <!-- <th class="sorting" data="c.contract_id">合同编号</th> -->
                                        <th class="sorting" data="o.project">项目名称</th>
                                        <th class="sorting" data="p.no">序号</th>
                                        <th class="sorting" data="p.amount">回款金额(元)</th>
                                        <th class="sorting" data="p.return_time">计划回款日期</th>
                                        <th class="sorting" data="p.pay_amount">已回款金额(元)</th>
                                        <th class="sorting" data="p.pay_time">最近回款日期</th>
                                        <th class="sorting" data="status">状态</th>
                                        <th class="sorting" data="o.create_user_name">销售</th>
                                        <if condition="rolemenu(array('Contract/detail'))">
                                        <th width="50" class="taskOptions">回款</th>
                                        </if>
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                    	<td>{$row.op_id}</td>
                                        <td>{$row.group_id}</td>
                                        <!-- <td>{$row.contract_id}</td> -->
                                        <td><div class="tdbox_long" style="width:150px;"><a href="{:U('Finance/huikuan',array('opid'=>$row['op_id']))}" title="{$row.project}">{$row.project}</a></div></td>
                                        <td>第{$row.no}笔</td>
                                        <td>{$row.amount}</td>
                                        <td><if condition="$row['return_time']">{$row.return_time|date='Y-m-d',###}</if></td>
                                        <td>{$row.pay_amount}</td>
                                        <td><if condition="$row['pay_time']">{$row.pay_time|date='Y-m-d',###}</if></td>
                                        
                                        <td>{$row.strstatus}</td>
                                        <td>{$row.create_user_name}</td>
                                        <if condition="rolemenu(array('Contract/detail'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Contract/detail',array('id'=>$row['cid']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
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
                <input type="hidden" name="c" value="Finance">
                <input type="hidden" name="a" value="payment">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="ou" placeholder="销售">
                </div>
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="as">
                        <option value="-1">回款状态</option>
                        <option value="0">未回款</option>
                        <option value="1">回款中</option>
                        <option value="2">已回款</option>
                    </select>                   
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="opid" placeholder="项目编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="cid" placeholder="合同编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="gid" placeholder="项目团号">
                </div>
                
                
               
                
                </form>
            </div>

<include file="Index:footer2" />
