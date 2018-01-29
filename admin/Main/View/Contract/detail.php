<include file="Index:header2" />

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>合同详情</h1>
            <ol class="breadcrumb">
                <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                <li><a href="{:U('Contract/index')}"><i class="fa fa-gift"></i> 合同管理</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
        
            <div class="row">
                 <!-- right column -->
                <div class="col-md-12">
                     
                     
                     
                     <div class="box box-warning" style="margin-top:15px;">
                        <div class="box-header">
                            <h3 class="box-title">
                            【{$row.group_id}】 合同信息
                            </h3>
                            <?php if($row['contract_id']){ ?>
                            <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">合同编号：{$row.contract_id}</span></h3>
                            <?php } ?>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content">
                            	<div class="form-group col-md-12">
                                    <h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">合同信息</h2>
                                </div>
                                <div class="form-group col-md-12">
                                <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
                                    <tr>
                                        <td colspan="3">项目名称：{$row.pro_name}</td>
                                    </tr>
                                    <tr>
                                        <td width="33.33%">项目团号：{$row.group_id}</td>
                                        <td width="33.33%">项目编号：{$row.op_id}</td>
                                        <td width="33.33%">出团人数：{$row.number}人</td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="33.33%">合同金额：&yen;{$row.contract_amount}</td>
                                        <td width="33.33%">出团时间：{$row.dep_time}</td>
                                        <td width="33.33%">结束时间：{$row.end_time}</td>
                                    </tr>
                                    <tr>
                                    	<td width="33.33%">回款金额：&yen;{$row.payment}</td>
                                        <td width="33.33%">创建时间：{$row.create_time|date='Y-m-d H:i:s',###}</td>
                                        <td width="33.33%">创建者：{$row.create_user_name}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">备注信息：{$row.remarks}</td>
                                    </tr>
                                </table>
                                </div>
                                
                                <div class="form-group col-md-12">
                                    <h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">合同电子扫描件</h2>
                                </div>
                                <div class="form-group col-md-12">
                                	<div id="showimglist">
                                        <foreach name="atts" key="k" item="v">
											<?php if($v['filepath']){ ?>
                                            <a href="{$v.filepath}" target="_blank"><img src="{:thumb($v['filepath'])}" style="margin-right:15px; margin-top:15px;"></a>
                                            <?php } ?>
                                        </foreach>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group col-md-12">
                                    <h2 style="font-size:16px; color:#ff3300; border-bottom:2px solid #dedede; padding-bottom:10px;">回款计划</h2>
                                </div>
                                
                                
                                <div class="form-group col-md-12">
                                    <table class="table table-bordered dataTable "  style="margin-top:-20px;" id="tablelist">
                                        <thead>
                                            <tr>
                                            	<th width="40" style="text-align:center;">序号</th>
                                                <th width="120">回款金额(元)</th>
                                                <th width="120">回款比例(%)</th>
                                                <th width="180">计划回款时间</th>
                                                <th>备注</th>
                                                <th width="120">已回款金额(元)</th>
                                                <th width="100">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <foreach name="pays" key="k" item="v">
                                                <tr class="userlist">
                                                    <td style="text-align:center;">{$v.no}</td>
                                                    <td>&yen; {$v.amount}</td>
                                                    <td>{$v.ratio}</td>
                                                    <td><if condition="$v['return_time']">{$v.return_time|date='Y-m-d',###}</if></td>
                                                    <td>{$v.remark}</td>
                                                    <td>&yen; {$v.pay_amount}</td>
                                                    <td><?php if($v['status']==2){ echo '<span class="green">已回款</span>';}else if($v['status']==1){ echo '<span class="blue">待回款</span>';}else if($v['status']==0){ echo '<span class="red">未回款</span>';} ?></td>
                                                </tr> 
                                            </foreach>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                    
                    
                    
                    
                </div><!--/.col (right) -->
                
                
                <div class="col-md-12">

                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">合同确认信息</h3>
                        </div>
                        <div class="box-body" style="padding-top:20px;" id="form_tip">
                        	
                            <?php if(rolemenu(array('Contract/confirm'))){ ?>
                        
                           	<form method="post" action="{:U('Contract/confirm')}" name="myform" id="save_huikuan">
                            <input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="id" value="{$row.id}">
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                                
                            <div class="form-group col-md-8" style="margin-top:10px;">
                                <div class="checkboxlist" id="applycheckbox" style="margin-top:10px;">
                                <input type="checkbox" name="status" value="1" <?php if($row['status']==1){ echo 'checked';} ?> > 确认通过
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" name="seal" value="1" <?php if($row['seal']==1){ echo 'checked';} ?> > 我司已盖章 
                               
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4" style="margin-top:10px;">
                            <select class="form-control" name="gbs" >
                            	<option value="0">选择返回状态</option>
                                <option value="1" <?php if($row['gbs']==1){ echo 'selected';} ?> >已返回综合部</option>
                                <option value="2" <?php if($row['gbs']==2){ echo 'selected';} ?> >已返回财务部</option>
                            </select>
                            </div>
                            
                            
                            <div class="form-group col-md-12">
                            	<div style="border-top:1px solid #dedede; margin-top:15px; padding-top:20px;">
                                    <label>合同编号</label>
                                    <input type="text" name="info[contract_id]" id="contract_id"   value="{$row.contract_id}" class="form-control" />
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label>审核意见</label>
                                <textarea class="form-control" name="info[confirm_remarks]" >{$row.confirm_remarks}</textarea>
                            </div>
                            
                            <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                <button class="btn btn-success btn-lg">确认提交</button>
                            </div>
                           	</form>
                            
                            <?php }else{ ?>
							<div class="content">
                                <table width="100%" id="font-14" rules="none" border="0" cellpadding="0" cellspacing="0">
                                   
                                    <tr>
                                        <td width="33.33%">确认状态：{$row.strstatus}</td>
                                        <td width="33.33%">确认者：{$row.confirm_user_name}</td>
                                        <td width="33.33%">确认时间：{$row.confirm_time|date='Y-m-d H:i:s',###}</td>
                                        
                                    </tr>
                                    <tr>
                                        <td width="33.33%">是否盖章： {$row.strseal}</td>
                                        <td width="33.33%">合同编号：{$row.contract_id}</td>
                                        <td width="33.33%">返回状态：{$row.gbstatus}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">审核意见：{$row.confirm_remarks}</td>
                                    </tr>
                                </table>
                            </div>	
							<?php } ?>
                            
                            <div class="form-group">&nbsp;</div>
                                   
                        </div>
                    </div><!-- /.box -->
                </div><!--/.col (right) -->
                
                
                <?php if(rolemenu(array('Finance/save_huikuan'))){ ?>
                <div class="col-md-12">
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">项目回款</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                        	<?php if($huikuanlist){ ?>
                            <form method="post" action="{:U('Finance/save_huikuan')}" name="myform" id="save_huikuan">
                            <input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="info[op_id]" value="{$op.op_id}">
                            <input type="hidden" name="info[name]" value="{$op.project}">
                            <input type="hidden" name="info[cid]" value="{$row.id}">
                            <input type="hidden" name="settlement" value="{$settlement.id}" />
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                            <div class="content" >
                                <div style="width:100%; float:left;">
                                	<div class="form-group col-md-12">
                                        <label>回款计划：</label>
                                        <select class="form-control" name="info[payid]">
                                            <foreach name="huikuanlist" key="k" item="v">
                                                <option value="{$v.id}">{$row.contract_id} / 第{$v.no}笔 / {$v.amount}元 / {$v.remark}</option>
                                            </foreach>
                                        </select>
                                    </div>
                                	
                                    <div class="form-group col-md-4">
                                        <label>本次回款金额：</label>
                                        <input type="text" name="info[huikuan]" id="renshu" class="form-control" value=""/>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>收款方式：</label>
                                        <select class="form-control" name="info[type]">
                                            <option value="">选择</option>
                                            <option value="转账">转账</option>
                                            <option value="支票">支票</option>
                                            <option value="现金">现金</option>
                                            <option value="其他">其他</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4">
                                        <label>收款日期：</label>
                                        <input type="text" name="info[huikuan_time]" class="form-control inputdate" value=""/>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label>备注：</label>
                                        <input type="text" name="info[remark]" id="remark" class="form-control" value=""/>
                                    </div>
                                    
                                    <div class="form-group col-md-12"  style="margin-top:50px; padding-bottom:20px; text-align:center;">
                                        <button class="btn btn-success btn-lg">保存并提交审核</button>
                                    </div>
                                </div>
                                
                            </div>
                            
                            </form>  
                            <?php }else{ ?>
                            <?php if($pays){ ?>
                            <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">已全部回款</span></div>
                            <?php }else{ ?>
                            <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">尚未制定回款计划</span></div>
                            <?php }} ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
                <?php if($huikuan){ ?>
                <div class="col-md-12">    
                     <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">回款记录</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="content" style="padding-top:0px;">
                                 <table class="table table-striped" id="font-14-p">
                                    <thead>
                                        <tr>
                                            <th width="120">回款金额</th>
                                            <th width="120">回款方式</th>
                                            <th width="180">申请时间</th>
                                            <th>回款备注</th>
                                            
                                            <th width="120">审批状态</th>
                                            <th width="120">审批者</th>
                                            <th width="">审批说明</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <foreach name="huikuan" key="k" item="v">
                                            <tr class="userlist">
                                                <td>&yen; {$v.huikuan}</td>
                                                <td>{$v.type}</td>
                                                <td>{$v.create_time|date='Y-m-d H:i:s',###}</td>
                                                <td>{$v.remark}</td>
                                                
                                                <td>{$v.showstatus}</td>
                                                <td>{$v.show_user}</td>
                                                <td>{$v.show_reason}</td>
                                            </tr> 
                                        </foreach>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div> 
                <?php } ?>           
                
            </div>   <!-- /.row -->
            
        </section><!-- /.content -->
        
    </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />

