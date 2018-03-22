<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>我要立项</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Op/plans')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">项目计划</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <label>项目名称：</label><input type="text" name="info[project]" class="form-control" />
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label>
                                            <select  class="form-control"  name="info[kind]" required>
                                            <foreach name="kinds" item="v">
                                                <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                            </foreach>
                                            </select> 
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>预计人数：</label><input type="text" name="info[number]" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>出团日期：</label><input type="text" name="info[departure]"  class="form-control inputdate" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>行程天数：</label><input type="text" name="info[days]" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>目的地：</label><input type="text" name="info[destination]" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>立项时间：</label><input type="text" name="info[op_create_date]" class="form-control inputdate_a" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>业务部门：</label>
                                            <select  class="form-control" name="info[op_create_user]">
                                            <foreach name="rolelist" key="k" item="v">
                                                <option value="{$v}" <?php if($k==cookie('roleid')){ echo 'selected';} ?> >{$v}</option>
                                            </foreach>
                                            </select> 
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>客户单位：</label>
                                            <!--
                                            <input type="text" name="info[customer]" id="customer_name" value="" placeholder="您可以输入客户单位名称拼音首字母检索" class="form-control" />
                                            -->
                                            <select  name="info[customer]" class="form-control">
                                            	<option value="">请选择</option>
                                                <foreach name="geclist"  item="v">
                                                    <option value="{$v.company_name}"><?php echo strtoupper(substr($v['pinyin'], 0, 1 )); ?> - {$v.company_name}</option>
                                                </foreach>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>销售人员：</label>
                                            <input type="text" class="form-control" name="info[sale_user]" value="{:session('nickname')}" readonly>
                                        </div>
                                        
                                        

                                        <div class="form-group col-md-12">
                                            <label>项目背景：</label><textarea class="form-control"  name="info[context]"></textarea>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>项目说明：</label><textarea class="form-control"  name="info[remark]"></textarea>
                                        </div>
                                        
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">我要立项</button>
                            </div>
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
		<!--
		<script type="text/javascript">
            function sousuo(){
				var keywords = <?php echo $keywords; ?>;
                $("#customer_name").autocomplete(keywords, {
                     matchContains: true,
                     highlightItem: false,
                     formatItem: function(row, i, max, term) {
                         return '<span style=" display:none">'+row.pinyin+'</span>'+row.company_name;
                     },
                     formatResult: function(row) {
                         return row.company_name;
                     }
                });
            };
			
			$(document).ready(function(e) {
                sousuo();
            });
        </script>
        -->