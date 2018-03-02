<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>比价</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Op/relprice')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目编号：{$op.op_id}</h3>
                                    
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-12">
                                            <label>业务名称：</label><input type="text" name="info[business_name]" class="form-control" value="{$b_name}" />
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>顾客需求：</label>
                                            <textarea name="info[demand]"  class="form-control"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>比价后意见：</label>
                                            <textarea name="info[opinion]"  class="form-control"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-12" style="margin-top:10px;">
                                         <a href="javascript:;" class="btn btn-warning btn-sm" onclick="add()" ><i class="fa fa-fw  fa-plus"></i> 增加比价单位</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">参与比价单位</h3>
                                    
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-3">
                                            <label>公司名称：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>联系人：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>联系电话：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>邮箱地址：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                       
                                    </div>
                                    
                                    <div class="content" style="padding:0 30px; margin-top:-20px;">
                                    	<h2 style="font-size:16px; color:#ff9900; border-bottom:2px solid #dddddd; padding-bottom:10px;">比价项目</h2>
                                        <div id="payment">
                                            <div class="userlist">
                                                <div class="unitbox_20">比选项目</div>
                                                <div class="unitbox_20">价格</div>
                                                <div class="unitbox_60">内容标准</div>
                                            </div>
                                            <div class="userlist" id="pretium_id">
                                                <span class="title">1</span>
                                                <input type="hidden" name="payment[1][no]" class="payno" value="1">
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][amount]" value="">
                                                </div>
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][return_time]" value="">
                                                </div>
                                                <div class="f_60">
                                                    <input type="text" class="form-control" name="payment[1][remarks]" value="">
                                                </div>
                                               
                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12" id="useraddbtns">
                                            <a href="javascript:;" class="btn btn-success btn-sm" onclick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加比价项</a> 
                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            
                             <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">参与比价单位</h3>
                                    
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-3">
                                            <label>公司名称：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>联系人：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>联系电话：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>邮箱地址：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                       
                                    </div>
                                    
                                    <div class="content" style="padding:0 30px; margin-top:-20px;">
                                    	<h2 style="font-size:16px; color:#ff9900; border-bottom:2px solid #dddddd; padding-bottom:10px;">比价项目</h2>
                                        <div id="payment">
                                            <div class="userlist">
                                                <div class="unitbox_20">比选项目</div>
                                                <div class="unitbox_20">价格</div>
                                                <div class="unitbox_60">内容标准</div>
                                            </div>
                                            <div class="userlist" id="pretium_id">
                                                <span class="title">1</span>
                                                <input type="hidden" name="payment[1][no]" class="payno" value="1">
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][amount]" value="">
                                                </div>
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][return_time]" value="">
                                                </div>
                                                <div class="f_60">
                                                    <input type="text" class="form-control" name="payment[1][remarks]" value="">
                                                </div>
                                               
                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12" id="useraddbtns">
                                            <a href="javascript:;" class="btn btn-success btn-sm" onclick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加比价项</a> 
                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            
                             <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">参与比价单位</h3>
                                    
                                </div>
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-3">
                                            <label>公司名称：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>联系人：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>联系电话：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>邮箱地址：</label><input type="text" name="com[business_name]" class="form-control" value="" />
                                        </div>
                                       
                                    </div>
                                    
                                    <div class="content" style="padding:0 30px; margin-top:-20px;">
                                    	<h2 style="font-size:16px; color:#ff9900; border-bottom:2px solid #dddddd; padding-bottom:10px;">比价项目</h2>
                                        <div id="payment">
                                            <div class="userlist">
                                                <div class="unitbox_20">比选项目</div>
                                                <div class="unitbox_20">价格</div>
                                                <div class="unitbox_60">内容标准</div>
                                            </div>
                                            <div class="userlist" id="pretium_id">
                                                <span class="title">1</span>
                                                <input type="hidden" name="payment[1][no]" class="payno" value="1">
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][amount]" value="">
                                                </div>
                                                <div class="f_20">
                                                    <input type="text" class="form-control" name="payment[1][return_time]" value="">
                                                </div>
                                                <div class="f_60">
                                                    <input type="text" class="form-control" name="payment[1][remarks]" value="">
                                                </div>
                                               
                                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12" id="useraddbtns">
                                            <a href="javascript:;" class="btn btn-success btn-sm" onclick="add_payment()"><i class="fa fa-fw fa-plus"></i> 增加比价项</a> 
                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
		