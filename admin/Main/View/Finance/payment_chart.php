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

                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2019){ ?>
                                    <a href="{:U('',array('year'=>$prveyear,'month'=>'01','post'=>$post))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par = array();
                                        $par['year']  = $year;
                                        $par['month'] = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $par['post']  = $post;
                                        if($month==$i){
                                            echo '<a href="'.U('',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('',array('year'=>$nextyear,'month'=>'01','post'=>$post))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">

                                <div class="box-header">
                                    <!--<h3 class="box-title">回款管理</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,160);"><i class="fa fa-search"></i> 搜索</a>
                                         
                                    </div>-->
                                    <div class="box-header">
                                        <div class="box-tools btn-group" id="chart_btn_group">
                                            <a href="{:U('',array('pin'=>0))}" class="btn btn-sm <?php if ($pin==0){ echo 'btn-info';}else{echo "btn-group-header";} ?>">回款统计</a>
                                            <a href="{:U('',array('pin'=>1))}" class="btn btn-sm <?php if ($pin==1){ echo 'btn-info';}else{echo "btn-group-header";} ?>">当月回款详情</a>
                                            <a href="{:U('',array('pin'=>2))}" class="btn btn-sm <?php if ($pin==2){ echo 'btn-info';}else{echo "btn-group-header";} ?>">历史回款详情</a>
                                        </div>
                                    </div><!-- /.box-header -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th class="sorting" data="p.">业务部门</th>
                                        <th class="sorting" data="c.">计划回款</th>
                                        <th class="sorting" data="o.">历史欠款金额</th>
                                        <th class="sorting" data="p.">实际回款金额</th>
                                        <th class="sorting" data="p.">汇款及时率</th>
                                        <!--<if condition="rolemenu(array('Contract/detail'))">
                                        <th width="50" class="taskOptions">回款</th>
                                        </if>-->
                                        
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                    	<td>{$row.op_id}</td>
                                        <td>{$row.group_id}</td>
                                        <td>第{$row.no}笔</td>
                                        <td>{$row.amount}</td>
                                        <td>{$row.amount}</td>
                                        <!--<if condition="rolemenu(array('Contract/detail'))">
                                        <td class="taskOptions">
                                        <a href="{:U('Contract/detail',array('id'=>$row['cid']))}" title="详情" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                        </td>
                                        </if>-->
                                       
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
