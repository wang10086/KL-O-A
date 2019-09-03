<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$_action_}
                        <small>供方数据统计</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('SupplierRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                <?php if($prveyear>2018){ ?>
                                    <a href="{:U('SupplierRes/chart',array('year'=>$prveyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        $par            = array();
                                        $par['year']    = $year;
                                        $par['month']   = str_pad($i,2,"0",STR_PAD_LEFT);
                                        $par['pin']     = $pin;
                                        if($month==str_pad($i,2,"0",STR_PAD_LEFT)){
                                            echo '<a href="'.U('SupplierRes/chart',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('SupplierRes/chart',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('SupplierRes/chart',array('year'=>$nextyear,'month'=>'01','pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-success mt10">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	 <!--<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>-->
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <include file="navigate" />

                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="name">资源名称</th>
                                            <th class="sorting" data="kind"></th>
                                            <th class="sorting" data="country"></th>
                                            <th class="sorting" data="prov"></th>
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                            <td><a href="{:U('SupplierRes/res_view', array('id'=>$row['id']))}">{$row.name}</a></td>
                                            <td><?php echo $reskind[$row['kind']]; ?></td>
                                            <td>{$row.country}</td>
                                            <td>{$row.prov}</td>
                                            <td>{$row.city}</td>
                                            <td><if condition="$row['input_time']">{$row.input_time|date='Y-m-d H:i:s',###}</if></td>
                                            <td>{$row.input_uname}</td>
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
                                            
                                            <if condition="rolemenu(array('SupplierRes/addres'))">
                                            <td class="taskOptions">
                                            
                                            <button onClick="javascript:window.location.href='{:U('SupplierRes/addres',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            
                                            <!--
                                            <button onClick="openform('{:U('Rights/grant',array('res'=>'cas_res','resid'=>$row['id']))}');" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            -->
                                            </td>
                                            </if>
                                            <if condition="rolemenu(array('SupplierRes/delres'))">
                                            <td class="taskOptions">
                                            <button onClick="javascript:ConfirmDel('{:U('SupplierRes/delres',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
        
        <!--<div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="SupplierRes">
            <input type="hidden" name="a" value="res">
            <input type="hidden" name="pin" value="{$pin}">
            <div class="form-group col-md-12">
                <input type="text" class="form-control" name="key" placeholder="关键字">
            </div>
            
            <div class="form-group col-md-6">
                <input type="text" class="form-control" name="city" placeholder="城市">
            </div>

            <div class="form-group col-md-6">
                <select class="form-control" name="type">
                    <option value="0">供方类型</option>
                    <foreach name="reskind" key="k" item="v">
                    <option value="{$k}">{$v}</option>
                    </foreach>
                </select>
            </div>
            </form>
        </div>-->
        
        <!--<script type="text/javascript">
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
        </script>-->