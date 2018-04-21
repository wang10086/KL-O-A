<include file="Index:header_mini" />

<script type="text/javascript">
    window.gosubmint= function(){
        $('#myform').submit();
    }
</script>

            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Project/fields_add')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="id" value="{$row['id']}">
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">学科领域</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        
                                        <div class="form-group col-md-4">
                                            <label>项目类型：</label>
                                            <select  class="form-control"  name="info[k_id]" required>
                                                <option value="" selected disabled>请选择项目类型</option>
                                                <foreach name="kinds" item="v">
                                                    <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['k_id'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                                </foreach>
                                                </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>学科领域：</label><input type="text" name="info[fname]" class="form-control" value="{$row.fname}" required />
                                        </div>

                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                           
                            <!--<div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">确认添加</button>
                            </div>-->
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