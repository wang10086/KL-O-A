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
                        <li><a href="{:U('SupplierRes/res')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
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
                                        <if condition="rolemenu(array('SupplierRes/addres'))">
                                         <a href="{:U('SupplierRes/addres')}" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> 新建资源</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                        <a href="{:U('SupplierRes/res',array('pin'=>0))}" class="btn <?php if(!$pin){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">全部供方</a>
                                        <a href="{:U('SupplierRes/res',array('pin'=>1))}" class="btn <?php if($pin == 1){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">供方</a>
                                        <a href="{:U('SupplierRes/res',array('pin'=>2))}" class="btn <?php if($pin == 2){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">合格供方</a>
                                        <a href="{:U('SupplierRes/res',array('pin'=>3))}" class="btn <?php if($pin == 3){ echo "btn-info"; }else{ echo 'btn-default'; } ?>" style="padding:8px 18px;">集中采购方</a>
                                    </div>

                                	<table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="name">供方名称</th>
                                            <th class="sorting" data="kind">类型</th>
                                            <!--<th class="sorting" data="country">国家</th>
                                            <th class="sorting" data="prov">省份</th>
                                        	<th class="sorting" data="city">城市</th>-->
                                        	<th class="sorting" data="prov">区域</th>
                                            <th class="sorting" data="input_time">录入时间</th>
                                       		<th class="sorting" data="input_uname">录入人</th>
                                            <th class="sorting" data="type">供方等级</th>
                                        	<th>审批状态</th>
                                            <if condition="rolemenu(array('SupplierRes/addres'))">
                                            <th width="60" class="taskOptions">编辑</th>
                                            </if> 
                                            <if condition="rolemenu(array('SupplierRes/delres'))">
                                            <th width="60" class="taskOptions">删除</th>
                                            </if> 
                                        </tr>
                                        <foreach name="lists" item="row">                      
                                        <tr>
                                            <td><a href="{:U('SupplierRes/res_view', array('id'=>$row['id']))}">{$row.name}</a></td>
                                            <td><?php echo $reskind[$row['kind']]; ?></td>
                                            <!--<td>{$row.country}</td>
                                            <td>{$row.prov}</td>
                                            <td>{$row.city}</td>-->
                                            <td><?php echo $row['country'].'-'.$row['prov'].'-'.$row['city'] ?></td>
                                            <td><if condition="$row['input_time']">{$row.input_time|date='Y-m-d H:i:s',###}</if></td>
                                            <td>{$row.input_uname}</td>
                                            <td>{$types[$row['type']]}</td>
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
        
        <div id="searchtext">
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