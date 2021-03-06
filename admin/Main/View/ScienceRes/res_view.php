<include file="Index:header2" />



            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <span class="green">科普资源</span> - <span style="color:#333333">{$row.title}</span>
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
                         <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">资源属性</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                	
                                    <div class="content">
                                		
                                        
                                        <div class="form-group col-md-8 viwe">
                                            <p>资源名称：{$row.title}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>资源类型：{$reskind[$row[kind]]}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>发布时间：{$row.input_time|date='Y-m-d H:i:s',###}</p>
                                        </div>
                                         <div class="form-group col-md-4 viwe">
                                            <p>所在地区：{$row.diqu}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>资源地址：{$row.address}</p>
                                        </div>

                                        <?php if (rolemenu(array('ScienceRes/resContacts'))){ ?>
                                        <div class="form-group col-md-4">
                                            <p>联系人：{$row.contacts}</p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <p>联系人职务：{$row.contacts_tel}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>联系电话：{$row.tel}</p>
                                        </div>
                                        <?php } ?>

                                        <div class="form-group col-md-4 viwe">
                                            <p>审批状态：{$row.showstatus}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批人：{$row.show_user}</p>
                                        </div>
                                        <div class="form-group col-md-4 viwe">
                                            <p>审批时间：{$row.show_time}</p>
                                        </div>

                                        <!--<div class="form-group col-md-12">
                                            <label style="width:100%; border-bottom:1px solid #dedede; padding-bottom:10px; font-weight:bold;">适用项目信息</label>
                                        </div>-->

                                        <!--
                                        <div class="form-group col-md-4 viwe">
                                            <p>销售价格：<span class="red">&yen; {$row.sales_price}</span></p>
                                        </div>
                                        
                                        <div class="form-group col-md-4 viwe">
                                            <p>同行价格：<span class="green">&yen; {$row.peer_price}</span></p>
                                        </div>
                                        -->
                                        
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">适用项目信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div style="width:100%; margin-top: -10px;">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th width="10%">项目类型</th>
                                                    <th width="10%">适宜人群</th>
                                                    <th width="10%">活动时长</th>
                                                    <th width="10%">可实施时间</th>
                                                    <th width="10%">可接待规模</th>
                                                    <th width="10%">标准化产品/模块</th>
                                                    <th width="10%">费用</th>
                                                    <th width="10%">预约需提前时间</th>
                                                    <th width="10%">备注</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                <foreach name="cas_res_kind" item="v">
                                                    <tr class="expense">
                                                        <td style="vertical-align:middle">{$v.kind}</td>
                                                        <td>{$apply[$v['apply']]}</td>
                                                        <td>{$v.time_length}</td>
                                                        <td>{$v.use_time}</td>
                                                        <td>{$v.scale}</td>
                                                        <td>{$v.module}</td>
                                                        <td>{$v.money}</td>
                                                        <td>{$v.lead_time}</td>
                                                        <td>{$v.remark}</td>
                                                    </tr>
                                                </foreach>
                                                </tbody>
                                                <tfoot>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">资源介绍</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content" style="margin-top:10px;">
                                    	<div class="form-group col-md-12 viwe">{$row.content}</div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">合作记录</h3>
                                    <div class="box-tools pull-right"></div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist">
                                        <tr role="row" class="orders" >
                                            <th class="sorting" data="op_id">项目编号</th>
                                            <th class="" data="group_id">团号</th>
                                            <th class="" data="project">项目名称</th>
                                            <th class="" data="sale_user">销售</th>
                                            <th class="" data="">结算状态</th>
                                            <th class="">结算金额</th>
                                        </tr>
                                        <foreach name="oplist" item="row">
                                            <tr>
                                                <td>{$row.op_id}</td>
                                                <td>{$row.group_id}</td>
                                                <td><a href="{:U('Finance/settlement', array('opid'=>$row['op_id']))}">{$row.project}</a></td>
                                                <td>{$row.sale_user}</td>
                                                <td>{$status[$row[saudit_status]]}</td>
                                                <td>{$row.settlement_total}</td>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div>
                                <div class="box-footer clearfix">
                                    <div class="pagestyle">{$pages}</div>
                                </div>
                            </div>

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->

  </div>
</div>


            
<include file="Index:footer2" />