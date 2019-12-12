<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>城市合伙人</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/GEC')}"><i class="fa fa-gift"></i> 城市合伙人</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">合伙人资料</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">审核状态：{$audit_stu[$partner['audit_stu']]} &emsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>合伙人名称：{$partner.name}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>代理级别：{$level[$partner[level]]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>合作金额(元)：&yen; {$partner.money}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>合伙人协议：{$agreement[$partner[agreement]]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>维护人：{$partner.cm_name}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>合伙协议开始时间：{$partner.start_date|date="Y-m-d",###}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>合伙协议结束时间：<?php if (time() > $partner['end_date']){ echo "<span class='red'>".date('Y-m-d',$partner['end_date'])."</span>"; }else{ echo date('Y-m-d',$partner['end_date']); } ?> </label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>通讯地址：{$partner.contacts_address}</label>
                                            </div>

                                            <if condition="$partner['remark']">
                                                <div class="form-group col-md-12">
                                                    <label>备注信息：{$partner.remark}</label>
                                                </div>
                                            </if>

                                            <if condition="$partner['audit_remark']">
                                                <div class="form-group col-md-12">
                                                    <label>审核备注信息：{$partner.audit_remark}</label>
                                                </div>
                                            </if>
                                        </div>

                                        <div class="form-group col-md-12" style="border-top:2px solid #dedede;padding-top:30px;">

                                            <div class="form-group col-md-4">
                                                <label>所在省份：{$city[$partner[province]]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>所在城市：{$city[$partner[city]]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>所在区县：{$city[$partner[country]]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>代理省份：{$city[$partner[agent_province]]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>代理城市：{$city[$partner[agent_city]]}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>代理区县：{$city[$partner[agent_country]]}</label>
                                            </div>

                                        </div>
                                        
                                        <div class="form-group col-md-12" style="border-top:2px solid #dedede;padding-top:30px;">
                                            <div class="form-group col-md-4">
                                                <label>负责人：{$partner.manager}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>负责人职务：{$partner.manager_post}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>负责人手机：{$partner.manager_phone}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>联系人：{$partner.contacts}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>联系人职务：{$partner.contacts_post}</label>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>联系人手机：{$partner.contacts_phone}</label>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            
       						<div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">合作保证金</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="form-group col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr role="row">
                                                	<th>开始时间</th>
                                                    <th>结束时间</th>
                                                    <th>金额</th>
                                                    <th>金额类型</th>
                                                    <th>录入时间</th>
                                                    <th>备注</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <foreach name="deposit" item="v">
                                                <tr>
                                                    <td><?php echo $v['start_date'] ? date('Y-m-d',$v['start_date']) : ''; ?></td>
                                                    <td><?php echo $v['end_date'] ? date('Y-m-d',$v['end_date']) : ''; ?></td>
                                                    <td>{$v.money}</td>
                                                    <td>{$cost_type[$v['type']]}</td>
                                                    <td><?php echo $v['input_time'] ? date('Y-m-d',$v['input_time']) : ''; ?></td>
                                                    <td>{$v.remark}</td>
                                                </tr>
                                                </foreach>
                                            </tbody>
                                        </table>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if (rolemenu(array('Customer/audit_partner')) && $partner['audit_stu']==1){ ?>
                                <div class="box box-success">
                                    <div class="box-header">
                                        <h3 class="box-title">审核城市合伙人</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="content">
                                            <form method="post" action="{:U('Customer/public_save')}" name="myform1">
                                                <input type="hidden" name="dosubmint" value="1">
                                                <input type="hidden" name="savetype" value="3">
                                                <input type="hidden" name="id" value="{$partner.id}">
                                                <div class="box-body">
                                                    <div class="form-group col-md-12" style="margin-top:10px;" id="auditPartnerRadio">
                                                        <input type="radio" name="info[audit_stu]" value="2" checked> 审核通过
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" name="info[audit_stu]" value="-1" > 审核不通过
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label>备注</label>
                                                        <textarea class="form-control" name="info[audit_remark]"></textarea>
                                                    </div>

                                                    <div class="form-group col-md-12"  style="margin-top:20px; padding-bottom:20px; text-align:left;">
                                                        <button class="btn btn-success">确认提交</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <include file="Index:public_record" />

                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">

	
</script>