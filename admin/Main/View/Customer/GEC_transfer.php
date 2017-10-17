<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>交接客户</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/GEC')}"><i class="fa fa-gift"></i> 客户管理</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            <form method="post" action="{:U('Customer/GEC_transfer')}" name="myform" id="myform">
                            <input type="hidden" name="dosubmint" value="1">
                            <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">交接客户</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <div class="callout callout-danger">
                                                <h4>请注意！</h4>
                                                <p>客户信息一旦交接，将不可恢复，请谨慎操作！</p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>交接人：</label>
                                            <input type="text" name="fm" class="form-control keywords_a" />
                                            <input type="hidden" name="fmid" id="from_id"/>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>接收人：</label>
                                            <input type="text" name="to" class="form-control keywords_b"/>
                                            <input type="hidden" name="toid" id="to_id"/>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
       						<div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">客户资料</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="form-group col-md-12">
                                        <table class="table table-striped">
                                            <tr role="row" class="orders" >
                                            	<th width="60">选择</th>
                                                <th width="60">ID</th>
                                                <th>单位名称</th>
                                                <th>客户性质</th>
                                                <th>联系人</th>
                                                <th>联系电话</th>
                                                <th>所在地</th>
                                                <th>级别</th>
                                                <th>开发潜力</th>
                                            </tr>
                                            <tbody id="transferlist">
                                            
                                            </tbody>
                                        </table>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                            
                            <div style="width:100%; text-align:center; padding-bottom:40px; padding-top:30px;">
                            <button type="button" class="btn btn-info btn-lg" id="lrpd" onClick="Confirmtransfer()">确定交接</button>
                            </div>
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
          </div>
        </div>
        
        <include file="Index:footer2" />
        
        <script>
			$(document).ready(function(e) {
				userkeywords();
			});
			function userkeywords(){
				var keywords = <?php echo $userkey; ?>;
				
				$(".keywords_a").autocomplete(keywords, {
					 matchContains: true,
					 highlightItem: false,
					 formatItem: function(row, i, max, term) {
						 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
					 },
					 formatResult: function(row) {
						 return row.user_name;
					 }
				}).result(function(event, item) {
				   $('#from_id').val(item.id);
				   get_gec(item.user_name);
				});
				
				
				$(".keywords_b").autocomplete(keywords, {
					 matchContains: true,
					 highlightItem: false,
					 formatItem: function(row, i, max, term) {
						 return '<span style=" display:none">'+row.pinyin+'</span>'+row.text;
					 },
					 formatResult: function(row) {
						 return row.user_name;
					 }
				}).result(function(event, item) {
				   $('#to_id').val(item.id);
				});
			}
			
			
			function get_gec(nm){
				
				if(!nm){
					var nm = $('.keywords_a').val();
				}
				
				//提交表单
				$.ajax({
					type: "POST",
					url: "<?php echo U('Ajax/customer'); ?>",
					dataType:'html', 
					data: {nm:nm},
					success:function(data){
                   		$('#transferlist').html(data);
               		}
           		});	
			}
			
			
			function Confirmtransfer() {
				
				var fm  = $('.keywords_a').val();
				var to  = $('.keywords_b').val();
				
				if(!fm){
					art_show_msg('请输入交接人姓名');	
					return false;
				}
				
				if(!to){
					art_show_msg('请输入接收人姓名');	
					return false;
				}
				
				var msg = '您确定将'+fm+'的客户交接给'+to+'？';	
				var obj = 'myform';
				
				art.dialog({
					title: '提示',
					width:400,
					height:100,
					lock:true,
					fixed: true,
					content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
					ok: function () {
						//window.location.href=url;
						//this.title('3秒后自动关闭').time(3);
						$('#'+obj).submit();
						return false;
					},
					cancelVal: '取消',
					cancel: true //为true等价于function(){}
				});
			
			}

		</script>
