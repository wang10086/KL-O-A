<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>客户维护</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/GEC')}"><i class="fa fa-gift"></i> 客户管理</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <form method="post" action="{:U('Customer/GEC_edit')}" name="myform" id="myform">
                <input type="hidden" name="dosubmint" value="1">
                <input type="hidden" name="gec_id" value="{$gec.id}">
                <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                                  
                            
                            
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">客户管理</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <label><span class="red">*</span>客户名称：</label><input type="text" name="info[company_name]" class="form-control" value="{$gec.company_name}" required />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label><span class="red">*</span>客户级别：</label>
                                            <select  class="form-control"  name="info[level]" required>
                                                <option value="">请选择</option>
                                                <option value="潜在客户" <?php if($gec['level']=='潜在客户'){ echo 'selected';} ?>>潜在客户</option>
                                                <option value="一般客户" <?php if($gec['level']=='一般客户'){ echo 'selected';} ?>>一般客户</option>
                                                <option value="重要客户" <?php if($gec['level']=='重要客户'){ echo 'selected';} ?>>重要客户</option>
                                                <option value="VIP客户" <?php if($gec['level']=='VIP客户'){ echo 'selected';} ?>>VIP客户</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label><span class="red">*</span>客户类型：</label>
                                            <select  class="form-control"  name="info[type]" required>
                                                <option value="">请选择</option>
                                                <option value="学校" <?php if($gec['type']=='学校'){ echo 'selected';} ?>>学校</option>
                                                <option value="机构" <?php if($gec['type']=='机构'){ echo 'selected';} ?>>机构</option>
                                                <option value="政府" <?php if($gec['type']=='政府'){ echo 'selected';} ?>>政府</option>
                                                <option value="团购客户" <?php if($gec['type']=='团购客户'){ echo 'selected';} ?>>团购客户</option>
                                                <option value="平台客户" <?php if($gec['type']=='平台客户'){ echo 'selected';} ?>>平台客户</option>
                                                <option value="其他" <?php if($gec['type']=='其他'){ echo 'selected';} ?>>其他</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>开发潜力：</label>
                                            <select  class="form-control"  name="info[qianli]">
                                                <option value="">请选择</option>
                                                <option value="无太大潜力" <?php if($gec['qianli']=='无太大潜力'){ echo 'selected';} ?>>无太大潜力</option>
                                                <option value="一般潜力" <?php if($gec['qianli']=='一般潜力'){ echo 'selected';} ?>>一般潜力</option>
                                                <option value="潜力较大" <?php if($gec['qianli']=='潜力较大'){ echo 'selected';} ?>>潜力较大</option>
                                                <option value="潜力巨大" <?php if($gec['qianli']=='潜力巨大'){ echo 'selected';} ?>>潜力巨大</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label><span class="red">*</span>联系人（一）：</label><input type="text" name="info[contacts]" class="form-control" value="{$gec.contacts}" required />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label><span class="red">*</span>联系人（一）职务：</label><input type="text" name="info[post]" class="form-control" value="{$gec.post}" required />
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label><span class="red">*</span>联系人（一）手机：</label><input type="text" name="info[contacts_phone]"  class="form-control" value="{$gec.contacts_phone}" required />
                                        </div>
                                        
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人（一）座机：</label><input type="text" name="info[contacts_tel]" class="form-control" value="{$gec.contacts_tel}"/>
                                        </div>
                                        
                                        <!--<div class="form-group col-md-4">
                                            <label>联系人（一）传真：</label><input type="text" name="info[contacts_fox]" class="form-control" value="{$gec.contacts_fox}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人（一）邮箱：</label><input type="text" name="info[contacts_email]" class="form-control"  value="{$gec.contacts_email}"/>
                                        </div>-->
                                        
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人（二）：</label><input type="text" name="info[contacts_b]" class="form-control" value="{$gec.contacts_b}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人（二）职务：</label><input type="text" name="info[post_b]" class="form-control" value="{$gec.post_b}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人（二）手机：</label><input type="text" name="info[contacts_phone_b]"  class="form-control" value="{$gec.contacts_phone_b}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人（二）座机：</label><input type="text" name="info[contacts_tel_b]" class="form-control" value="{$gec.contacts_tel_b}"/>
                                        </div>
                                        
                                        <!--<div class="form-group col-md-4">
                                            <label>联系人（二）传真：</label><input type="text" name="info[contacts_fox_b]" class="form-control" value="{$gec.contacts_fox_b}"/>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>联系人（二）邮箱：</label><input type="text" name="info[contacts_email_b]" class="form-control"  value="{$gec.contacts_email_b}"/>
                                        </div>-->
                                        
                                        <div class="form-group col-md-4">
                                            <label><span class="red">*</span>所在省份：</label>
                                            <select id="s_province" class="form-control" name="info[province]" required></select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label><span class="red">*</span>所在城市：</label>
                                            <select id="s_city" class="form-control" name="info[city]" required></select>
                                        </div>
                                        
                                        <div class="form-group col-md-4">
                                            <label>所在区县：</label>
                                            <select id="s_county" class="form-control" name="info[county]"></select>
                                        </div>
                                        <script class="resources library" src="__HTML__/js/area.js" type="text/javascript"></script>
										<script type="text/javascript">
										var opt0 = ["{$gec.province}","{$gec.city}","{$gec.county}"];//初始值
										_init_area();
                                        </script>

                                        <div class="form-group col-md-4">
                                            <label>通讯地址：</label><input type="text" name="info[contacts_address]" class="form-control" value="{$gec.contacts_address}"/>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>是否转交给其他维护人</label>
                                            <div class="form-group" id="transfer">
                                                <input type="radio" name="info[transfer]" value="1"  <?php if($gec['transfer']==1 || !$gec){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                                                <input type="radio" name="info[transfer]" value="2"  <?php if($gec['transfer']==2){ echo 'checked';} ?>> &#8194;需要
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>招募人：</label>
                                            <input type="text" class="form-control" name="info[create_user_name]" value="{$gec['id']?$gec['create_user_name']:session('nickname')}" readonly>
                                            <input type="hidden" name="info[create_user_id]" value="{$gec['id']?$gec['create_user_id']:session('userid')}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>维护人 <font color="#999">(选择匹配到的信息)</font>：</label>
                                            <input type="text" class="form-control" name="info[cm_name]" id="cm_name" value="{$gec['id']?$gec['cm_name']:session('nickname')}" <?php if (!in_array(cookie('userid'),array(1,11))){ echo "readonly"; } ?>>
                                            <input type="hidden" name="info[cm_id]" value="{$gec['id']?$gec['cm_id']:session('userid')}" id="cm_id">
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label>维护记录：</label><textarea class="form-control" style="height:300px" name="info[remark]">{$gec.remark}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div style="width:100%; text-align:center; padding-bottom:40px;">
                                    <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php if($gec){ ?>
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
                            <?php } ?>
                            
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
  </div>
</div>

<include file="Index:footer2" />

<script type="text/javascript">
    const userkey = {$userkey};
    autocomplete_id('cm_name','cm_id',userkey);

    $(function () {
        //判断是否需要转交
        $('#transfer').find('ins').each(function (index,ele) {
            $(this).click(function () {
                let userid   = <?php echo $gec['cm_id'] ? $gec['cm_id'] : session('userid'); ?>;
                let username = "<?php echo $gec['cm_name'] ? $gec['cm_name'] : session('nickname'); ?>";
                let transfer = $(this).prev('input[name="info[transfer]"]').val();
                if (transfer ==2){ //需要
                    $('#cm_name').val('');
                    $('#cm_id').val(0);
                }else{
                    $('#cm_name').val(username);
                    $('#cm_id').val(userid);
                }
            })
        })
    })
</script>
