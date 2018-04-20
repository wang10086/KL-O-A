<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h3>增加课程信息</h3>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Project/lines_add')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">课程信息</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-4">
                                            <label>课程名称：</label><input type="text" name="info[name]" class="form-control" required />
                                        </div>

                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label>
                                            <select  class="form-control"  name="info[kind]" required>
                                                <option value="" selected disabled>请选择项目类型</option>
                                                <foreach name="kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                                </foreach>
                                                </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>学科领域：</label><input type="text" name="info[field]" class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>学科分类：</label><input type="text" name="info[departure]"  class="form-control" />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>课时：</label><input type="text" name="info[days]" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>课程类型：</label>
                                            <select  name="info[les_type]" class="form-control">
                                                <option value="" selected disabled>请选择课程类型</option>
                                                <foreach name="les_types" key="k"  item="v">
                                                    <option value="{$k}">{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <!--<div class="form-group col-md-4">
                                            <label>立项时间：</label><input type="text" name="info[op_create_date]" class="form-control inputdate_a" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>业务部门：</label>
                                            <select  class="form-control" name="info[op_create_user]" >
                                                <option value="" selected disabled>请选择业务部门</option>
                                                <foreach name="rolelist" key="k" item="v">
                                                    <option value="{$v}" <?php /*if($k==cookie('roleid')){ echo 'selected';} */?> >{$v}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>客户单位：</label>

                                            <input type="text" name="info[customer]" id="customer_name" value="" placeholder="您可以输入客户单位名称拼音首字母检索" class="form-control" />

                                            <select  name="info[customer]" class="form-control">
                                                <option value="" selected disabled>请选择客户单位</option>
                                                <foreach name="geclist"  item="v">
                                                    <option value="{$v.company_name}"><?php /*echo strtoupper(substr($v['pinyin'], 0, 1 )); */?> - {$v.company_name}</option>
                                                </foreach>
                                            </select>
                                        </div>-->

                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认添加</button>
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