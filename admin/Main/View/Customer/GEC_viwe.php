<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>客户资料</h1>
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
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">客户资料</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>客户名称：{$gec.company_name}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>维护人：{$gec.cm_name}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>客户类型：{$gec.type}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>客户级别：{$gec.level}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                            <label>所在省份：{$gec.province}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>所在城市：{$gec.city}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>所在区县：{$gec.county}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-12">
                                                <label>通讯地址：{$gec.contacts_address}</label>
                                            </div>
                                        
                                        </div>
                                        
                                        <div class="form-group col-md-12" style="border-top:2px solid #dedede;padding-top:30px;">
                                            <div class="form-group col-md-4">
                                                <label>联系人：{$gec.contacts}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>职务：{$gec.post}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>手机：{$gec.contacts_phone}</label>
                                            </div>
                                            
                                            
                                            <div class="form-group col-md-4">
                                                <label>座机：{$gec.contacts_tel}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>传真：{$gec.contacts_fox}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>邮箱：{$gec.contacts_email}</label>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="form-group col-md-12" style="border-top:2px solid #dedede;padding-top:30px;">
                                        
                                            <div class="form-group col-md-4">
                                                <label>联系人：{$gec.contacts_b}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>职务：{$gec.post_b}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>手机：{$gec.contacts_phone_b}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>座机：{$gec.contacts_tel_b}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>传真：{$gec.contacts_fox_b}</label>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>邮箱：{$gec.contacts_email_b}</label>
                                            </div>
                                        
                                        </div>
                                        
                                        
                                        
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">维护记录</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <div style="width:100%">{$gec.remark}</div>
                                        </div>
                                        
                                       
                                    </div>
                                    
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
       						<div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">已结算合作记录</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	<div class="form-group col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr role="row">
                                                	<th>团号</th>
                                                    <th>项目名称</th>
                                                    <th>人数</th>
                                                    <th>收入</th>
                                                    <th>毛利</th>
                                                    <th>毛利率</th>
                                                    <th>人均毛利</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <foreach name="hezuo" item="v">
                                                <tr>
                                                    <td>{$v.group_id}</td>
                                                    <td>{$v.project}</td>
                                                    <td>{$v.renshu}</td>
                                                    <td>{$v.shouru}</td>
                                                    <td>{$v.maoli}</td>
                                                    <td>{$v.maolilv}</td>
                                                    <td>{$v.renjunmaoli}</td>
                                                </tr>
                                                </foreach>
                                            </tbody>
                                        </table>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
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