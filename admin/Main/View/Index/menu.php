			<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php if(cookie('userid')==C('RBAC_SUPER_ADMIN')){  echo '__HTML__/img/avatar0.png'; }else{ echo '__HTML__/img/avatar5.png';} ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php  echo cookie('name'); ?></p>
                            <a href="#"><?php echo cookie('postname')?cookie('postname'):cookie('rolename');  ?></a>
                        </div>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">

                        <if condition="rolemenu(array('Index/index'))">
                            <li class="{:on('Index')}">
                                <a href="{:U('Index/index')}">
                                    <i class="fa fa-home"></i> <span>系统首页</span>
                                </a>
                            </li>
                        </if>

                        <li class="treeview {:ison(CONTROLLER_NAME,'Chart')} {:on('Kpi/kpiChart')}">
                            <a href="javascript:;">
                                <i class="fa fa-signal"></i>
                                <span>绩效排行</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{:U('Chart/pplist')}"><i class="fa fa-angle-right"></i> 业绩排行</a></li>
                                <li><a href="{:U('Kpi/kpiChart')}"><i class="fa fa-angle-right"></i> KPI排行</a></li>
                            </ul>
                        </li>

                        <if condition="rolemenu(array('Op/index','Op/plans','Project/kind','Op/relpricelist','Product/line'))">
                        <li class="treeview {:ison(CONTROLLER_NAME,'Op')} {:ison(CONTROLLER_NAME,'Product')} {:on('Project/addkind')}">
                            <a href="javascript:;">
                                <i class="fa fa-shopping-cart"></i>
                                <span>项目管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <if condition="rolemenu(array('Product/line','Op/plans_follow'))">
                                    <li class="{:on('Product/public_pro_need')} {:on('Product/public_pro_need_follow')} {:on('Op/plans_follow')} {:on('Product/public_pro_need_add')} {:on('Product/public_pro_need_detail')} {:on('Product/public_scheme')} {:on('Product/add_scheme')} {:on('Product/public_view_scheme')} {:on('Product/public_customer_need')} {:on('Op/public_project')}"><a href="{:U('Product/public_pro_need')}"><i class="fa fa-angle-right"></i> 项目方案</a></li>
                                </if>
                                <!--<if condition="rolemenu(array('Op/plans'))">
                                    <li><a href="{:U('Op/plans')}"><i class="fa fa-angle-right"></i> 我要立项</a></li>
                                </if>-->
                                <if condition="rolemenu(array('Op/index'))">
                                    <li><a href="{:U('Op/index')}"><i class="fa fa-angle-right"></i> 项目管理</a></li>
                                </if>
                                <if condition="rolemenu(array('Op/relpricelist'))">
                                        <li class="{:on('Op/relpricelist')} {:on('Op/relprice')}"><a href="{:U('Op/relpricelist')}"><i class="fa fa-angle-right"></i> 项目比价</a></li>
                                </if>

                            </ul>
                        </li>
                        </if>

                        <if condition="rolemenu(array('Product/index','Product/tpl','Product/kind','Product/feedback','Project/lession','Project/fields','Project/types','Product/add_standard_product','Product/product_chart'))">
                        <li class="treeview {:on('Product')} {:on('Project')} {:on('Project/lession')} {:on('Project/fields')} {:on('Project/types')}">
                            <a href="javascript:;">
                                <i class="fa fa-globe"></i>
                                <span onclick="window.location.href = '{:U('Product/public_view')}'">产品管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview {:on('Product/standard_product')} {:on('Product/standard_module')} {:on('Product/add_standard_product')} {:on('Product/add_standard_module')} {:on('Product/view')} {:on('Product/public_product_chart')} {:on('Product/public_product_chart_detail')}">
                                    <if condition="rolemenu(array('Product/standard_product','Product/standard_module'))">
                                        <a href=""><i class="fa  fa-indent"></i> 标准化管理</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Product/standard_product'))">
                                            <li class="{:on('Product/standard_product')} {:on('Product/add_standard_product')}"><a href="{:U('Product/standard_product')}"><i class="fa fa-angle-right"></i> 标准化产品</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Product/standard_module'))">
                                            <li class="{:on('Product/standard_module')} {:on('Product/view')} {:on('Product/add_standard_module')}"><a href="{:U('Product/standard_module')}"><i class="fa fa-angle-right"></i> 标准化模块</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Product/product_chart'))">
                                            <li class="{:on('Product/public_product_chart')} {:on('Product/public_product_chart_detail')}"><a href="{:U('Product/public_product_chart')}"><i class="fa fa-angle-right"></i> 标准化产品使用统计</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <if condition="rolemenu(array('Product/tpl'))">
                                    <li class="{:on('Product/tpl')} {:on('Product/addtpl')}"><a href="{:U('Product/tpl')}"><i class="fa fa-angle-right"></i> 产品模板管理</a></li>
                                </if>

                                <if condition="rolemenu(array('Product/index'))">
                                    <li class="{:on('Product/index')} {:on('Product/add')}"><a href="{:U('Product/index')}"><i class="fa fa-angle-right"></i> 产品模块管理</a></li>
                                </if>

                                <if condition="rolemenu(array('Product/line'))">
                                    <li class="{:on('Product/line')} {:on('Product/add_line')}"><a href="{:U('Product/line')}"><i class="fa fa-angle-right"></i> 行程方案管理</a></li>
                                </if>

                                <if condition="rolemenu(array('Project/lession'))">
                                    <li class="{:on('Project/lession')} {:on('Project/fields')}"><a href="{:U('Project/lession')}"><i class="fa fa-angle-right"></i> 课程信息管理</a></li>
                                </if>

                                <if condition="rolemenu(array('Project/kind'))">
                                    <li class="{:on('Project/kind')} {:on('Project/addkind')}"><a href="{:U('Project/kind')}"><i class="fa fa-angle-right"></i> 项目类型管理</a></li>
                                </if>

                                <!--
                                <if condition="rolemenu(array('Product/kind'))">
                                		<li class="{:on('Product/kind')} {:on('Product/addkind')}"><a href="{:U('Product/kind')}"><i class="fa fa-angle-right"></i> 线路类型管理</a></li>
                                </if>
                                -->
                                <!--
                                <if condition="rolemenu(array('Product/feedback'))">
                                		<li class="{:on('Product/feedback')}"><a href="{:U('Product/feedback')}"><i class="fa fa-angle-right"></i> 产品应用反馈</a></li>
                                </if>
                                -->

                            </ul>
                        </li>
                        </if>


                        <li class="treeview {:on('ScienceRes')} {:on('GuideRes')} {:on('SupplierRes')}">
                            <a href="javascript:;">
                                <i class="fa fa-archive"></i>
                                <span>资源管理</span>
                                <if condition="rolemenu(array('ScienceRes/res'))">
                                <if condition="$_no_read_cas_res"><small class="badge pull-right bg-red" style="margin-right:10px;">{$_no_read_cas_res}</small></if>
                                </if>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                              	<if condition="rolemenu(array('ScienceRes/res','ScienceRes/addres','ScienceRes/reskind'))">
                                <li class="treeview {:on('ScienceRes')}">
                                    <a href=""><i class="fa  fa-flag"></i> 科普资源<if condition="$_no_read_cas_res"><small class="badge pull-right bg-red" style="margin-right:10px;">{$_no_read_cas_res}</small></if></a>
                                    <ul class="treeview-menu">
                                    	 <if condition="rolemenu(array('ScienceRes/addres'))">
                                         <li class="{:on('ScienceRes/addres')}"><a href="{:U('ScienceRes/addres')}"><i class="fa fa-angle-right"></i> 新增科普资源</a></li>
                                         </if>
                                    	 <if condition="rolemenu(array('ScienceRes/res','ScienceRes/res_view'))">
                                         <li class="{:on('ScienceRes/res')} {:on('ScienceRes/res_view')}"><a href="{:U('ScienceRes/res')}"><i class="fa fa-angle-right"></i> 科普资源管理</a></li>
                                         </if>
                                         <if condition="rolemenu(array('ScienceRes/reskind','ScienceRes/addreskind'))">
                                         <li class="{:on('ScienceRes/reskind')} {:on('ScienceRes/addreskind')} "><a href="{:U('ScienceRes/reskind')}"><i class="fa fa-angle-right"></i> 科普资源分类</a></li>
                                         </if>
                                    </ul>
                                </li>
                                </if>


                                <if condition="rolemenu(array('SupplierRes/res','SupplierRes/addres','SupplierRes/reskind','GuideRes/res','SupplierRes/chart','SupplierRes/focus_buy','SupplierRes/focus_buy_list','SupplierRes/cost_save','SupplierRes/cost_save_detail','SupplierRes/cost_save_add','SupplierRes/cost_save_price'))">
                                <li class="treeview  {:on('SupplierRes')}">
                                    <a href=""><i class="fa fa-plane"></i> 供方管理</a>
                                    <ul class="treeview-menu">

                                         <if condition="rolemenu(array('SupplierRes/addres'))">
                                         <li class="{:on('SupplierRes/addres')}"><a href="{:U('SupplierRes/addres')}"><i class="fa fa-angle-right"></i> 新增供方</a></li>
                                         </if>

                                    	 <if condition="rolemenu(array('SupplierRes/res','SupplierRes/res_view'))">
                                         <li class="{:on('SupplierRes/res')} {:on('SupplierRes/res_view')}"><a href="{:U('SupplierRes/res')}"><i class="fa fa-angle-right"></i> 供方清单</a></li>      									 </if>
                                         <if condition="rolemenu(array('SupplierRes/reskind','SupplierRes/addreskind'))">
                                         <li class="{:on('SupplierRes/reskind')} {:on('SupplierRes/addreskind')} "><a href="{:U('SupplierRes/reskind')}"><i class="fa fa-angle-right"></i> 供方分类</a></li>
                                         </if>
                                     </ul>
                                </li>
                                </if>


                                <if condition="rolemenu(array('GuideRes/res','GuideRes/addres','GuideRes/reskind','GuideRes/timely','GuideRes/satisfaction'))">
                                <li class="treeview  {:on('GuideRes')}">
                                    <a href=""><i class="fa fa-female"></i> 导游辅导员</a>
                                    <ul class="treeview-menu">
                                    	<!--<if condition="rolemenu(array('GuideRes/addres'))">
                                        <li class="{:on('GuideRes/addres')} "><a href="{:U('GuideRes/addres')}"><i class="fa fa-angle-right"></i> 新增导游辅导员</a></li>
                                        </if>-->
                                        <if condition="rolemenu(array('GuideRes/timely'))">
                                            <li class="{:on('GuideRes/timely')} {:on('GuideRes/')} "><a href="{:U('GuideRes/timely')}"><i class="fa fa-angle-right"></i> 教务操作及时率</a></li>
                                        </if>
                                        <if condition="rolemenu(array('GuideRes/satisfaction'))">
                                            <li><a href="{:U('GuideRes/satisfaction')}"><i class="fa fa-angle-right"></i> 教务内部满意度</a></li>
                                        </if>
                                        <if condition="rolemenu(array('GuideRes/res'))">
                                            <li class="{:on('GuideRes/res')} {:on('GuideRes/res_view')} "><a href="{:U('GuideRes/res')}"><i class="fa fa-angle-right"></i> 导游辅导员管理</a></li>
                                        </if>
                                        <if condition="rolemenu(array('GuideRes/reskind'))">
                                            <li class="{:on('GuideRes/reskind')} {:on('GuideRes/addreskind')} "><a href="{:U('GuideRes/reskind')}"><i class="fa fa-angle-right"></i> 导游辅导员分类</a></li>
                                        </if>
                                        <if condition="rolemenu(array('GuideRes/price'))">
                                            <li class="{:on('GuideRes/price')} {:on('GuideRes/addprice')} "><a href="{:U('GuideRes/price')}"><i class="fa fa-angle-right"></i> 导游辅导员价格体系</a></li>
                                        </if>
                                    </ul>
                                </li>
                                </if>

                                <if condition="rolemenu(array('SupplierRes/chart','SupplierRes/focus_buy','SupplierRes/focus_buy_list','SupplierRes/focus_list_edit','SupplierRes/focus_list_del','SupplierRes/cost_save','SupplierRes/cost_save_detail','SupplierRes/cost_save_add','SupplierRes/cost_save_price','SupplierRes/cost_save_del','ScienceRes/province'))">
                                    <li class="treeview {:on('SupplierRes')}">
                                        <a href=""><i class="fa  fa-cubes"></i> 集中采购</a>
                                        <ul class="treeview-menu">
                                            <if condition="rolemenu(array('SupplierRes/chart'))">
                                                <li class="{:on('SupplierRes/chart')}"><a href="{:U('SupplierRes/chart')}"><i class="fa fa-angle-right"></i> 资源统计</a></li>
                                            </if>
                                            <if condition="rolemenu(array('SupplierRes/focus_buy','SupplierRes/focus_buy_list','SupplierRes/focus_list_edit','SupplierRes/focus_list_del'))">
                                                <li class="{:on('SupplierRes/public_focus_buy')} {:on('SupplierRes/focus_buy_list')}"><a href="{:U('SupplierRes/public_focus_buy')}"><i class="fa fa-angle-right"></i> 集中采购执行率</a></li>
                                            </if>
                                            <if condition="rolemenu(array('SupplierRes/cost_save','SupplierRes/cost_save_detail','SupplierRes/cost_save_add','SupplierRes/cost_save_price','SupplierRes/cost_save_del'))">
                                                <li class="{:on('SupplierRes/public_cost_save')} {:on('SupplierRes/')}"><a href="{:U('SupplierRes/public_cost_save')}"><i class="fa fa-angle-right"></i> 集中采购管理</a></li>
                                            </if>
                                        </ul>
                                    </li>
                                </if>

                                <if condition="rolemenu(array('ScienceRes/province'))">
                                    <li class="{:on('ScienceRes/province')}"><a href="{:U('ScienceRes/province')}" title="设置各省份资源所属项目部"><i class="fa fa-cog"></i> 资源设置</a></li>
                                </if>
                            </ul>
                        </li>


                        <if condition="rolemenu(array('Files/index','Approval/index'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Files')} {:ison(CONTROLLER_NAME, 'File')} {:ison(CONTROLLER_NAME, 'Approval')}">
                            <a href="javascript:;">
                                <i class="fa  fa-folder-open"></i>
                                <span>文件管理</span>
                                <?php if($_no_read_audit_file){ ?>
                                <if condition="rolemenu(array('Approval/index'))">
                                    <small class="badge pull-right bg-red" style="margin-right:6px;">{$_no_read_audit_file}</small>
                                </if>
                                <?php }else{ ?>
                                    <i class="fa fa-angle-left pull-right"></i>
                                <?php } ?>
                            </a>
                            <ul class="treeview-menu">
                            	<if condition="rolemenu(array('Files/index'))">
                                	<li class="{:on('Files/index')}">
                                        <a href="{:U('Files/index')}">
                                            <i class="fa fa-angle-right">
                                            </i> 文件管理
                                        </a>
                                    </li>
                                </if>
                                <if condition="rolemenu(array('Approval/index','Approval/file_upload','Approval/file_detail','Approval/file_audit','Approval/edit_record','Approval/file_re_upload','Approval/file_re_audit'))">
                                    <li class="{:on('Approval/index')} {:on('Approval/file_upload')} {:on('Approval/file_detail')} {:on('Approval/file_audit')} {:on('Approval/edit_record')} {:on('Approval/file_re_upload')} {:on('Approval/file_re_audit')}">
                                        <a href="{:U('Approval/index')}">
                                            <i class="fa fa-angle-right"></i> 文件流转
                                            <?php if($_no_read_audit_file){ ?>
                                                <small class="badge pull-right bg-red" style="margin-right:6px;">{$_no_read_audit_file}</small>
                                            <?php }?>
                                        </a>
                                    </li>
                                </if>

                                <if condition="rolemenu(array('Files/audit_list'))">
                                    <li class="{:on('Files/audit_list')} {:on('Files/public_audit_add')} {:on('Files/audit')} ">
                                        <a href="{:U('Files/audit_list')}">
                                            <i class="fa fa-angle-right"></i> 文件审批</a>
                                    </li>
                                </if>

                                <li class="treeview {:on('File/companyFile')} {:on('File/departmentFile')} {:on('File/postFile')}">
                                    <a href="javascript:;"><i class="fa  fa-file"></i> 我的文件</a>
                                    <ul class="treeview-menu">
                                        <li class="{:on('File/companyFile')}"><a href="{:U('File/companyFile')}"><i class="fa fa-angle-right"></i> 公司通用</a></li>
                                        <li class="{:on('File/departmentFile')}"><a href="{:U('File/departmentFile')}"><i class="fa fa-angle-right"></i> 部门通用</a></li>
                                        <li class="{:on('File/postFile')}"><a href="{:U('File/postFile')}"><i class="fa fa-angle-right"></i> 岗位专用</a></li>
                                    </ul>
                                </li>

                                <!--<li class="{:on('File/instruction')}">
                                    <a href="{:U('File/instruction',array('pid'=>45))}"><i class="fa fa-angle-right"></i> 岗位作业指导书</a>
                                </li>-->
                            </ul>
                        </li>
                        </if>

                        <if condition="rolemenu(array('Customer/o2o','Customer/GEC','Customer/IC','Customer/partner','Customer/widely'))">
                        <li class="treeview {:on('Customer')}">
                            <a href="javascript:;">
                                <i class="fa fa-group"></i>
                                <span onclick="window.location.href = '{:U('Customer/public_index')}'">市场营销</span>
                                <if condition="$_no_read_GEC_transfer"><small class="badge pull-right bg-red" style="margin-right:10px;"><?php echo $_no_read_GEC_transfer + $_no_read_sale_files; ?></small></if>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <if condition="rolemenu(array('Customer/widely'))">
                                    <li class="{:on('Customer/widely')} {:on('Customer/')}"><a href="{:U('Customer/widely')}"><i class="fa fa-angle-right"></i> 宣传营销</a></li>
                                </if>

                                <if condition="rolemenu(array('Customer/partner'))">
                                    <li class="{:on('Customer/partner')} {:on('Customer/partner_edit')} {:on('Customer/public_partner_map')} {:on('Customer/partner_detail')}"><a href="{:U('Customer/partner')}"><i class="fa fa-angle-right"></i> 城市合伙人</a></li>
                                </if>

                            	<if condition="rolemenu(array('Customer/o2o'))">
                                	<li class="{:on('Customer/o2o')} {:on('Customer/o2o_apply')}"><a href="{:U('Customer/o2o')}"><i class="fa fa-angle-right"></i> 支撑服务校</a></li>
                                </if>

                            	<if condition="rolemenu(array('Customer/GEC'))">
                                	<li class="{:on('Customer/GEC')} {:on('Customer/GEC_edit')}">
                                        <a href="{:U('Customer/GEC')}"><i class="fa fa-angle-right"></i>
                                            客户管理
                                            <?php if($_no_read_GEC_transfer){ ?> <small class="badge pull-right bg-red" style="margin-right:10px;">{$_no_read_GEC_transfer}</small> <?php } ?>
                                        </a>
                                    </li>
                                </if>

                                <if condition="rolemenu(array('Customer/IC'))">
                                	<li class="{:on('Customer/IC')} {:on('Customer/IC_edit')}"><a href="{:U('Customer/IC')}"><i class="fa fa-angle-right"></i> 营员管理</a></li>
                                </if>
                                <li class="{:on('Customer/public_sale')} {:on('Customer/public_sale_add')} {:on('Customer/public_sale_detail')} {:on('Customer/public_salePro_add')}"><a href="{:U('Customer/public_sale')}"><i class="fa fa-angle-right"></i> 销售支持</a></li>

                            </ul>
                        </li>
                        </if>



                        <if condition="rolemenu(array('Material/add','Material/stock','Material/into','Material/out'))">
                        <li class="treeview {:on('Material')}">
                            <a href="javascript:;">
                                <i class="fa fa-puzzle-piece"></i>
                                <span>物资管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                            	<if condition="rolemenu(array('Material/asset'))">
                                	<li class="{:on('Material/asset')} {:on('Material/addasset')}"><a href="{:U('Material/asset')}"><i class="fa fa-angle-right"></i> 固定资产</a></li>
                                </if>

                                <if condition="rolemenu(array('Material/stock'))">
                                	<li class="{:on('Material/stock')} {:on('Material/add')}"><a href="{:U('Material/stock')}"><i class="fa fa-angle-right"></i> 物资库存</a></li>
                                </if>

                                <if condition="rolemenu(array('Material/purchase_record'))">
                                	<li class="{:on('Material/purchase_record')} {:on('Material/purchase')}"><a href="{:U('Material/purchase_record')}"><i class="fa fa-angle-right"></i> 物资采购</a></li>
                                </if>

                                <if condition="rolemenu(array('Material/into_record'))">
                                	<li class="{:on('Material/into_record')} {:on('Material/into')}"><a href="{:U('Material/into_record')}"><i class="fa fa-angle-right"></i> 物资入库</a></li>
                                </if>

                                <if condition="rolemenu(array('Material/out_record'))">
                                	<li class="{:on('Material/out_record')} {:on('Material/out')}"><a href="{:U('Material/out_record')}"><i class="fa fa-angle-right"></i> 物资出库</a></li>
                                </if>

                                <if condition="rolemenu(array('Material/kind'))">
                                	<li class="{:on('Material/addkind')} {:on('Material/kind')}"><a href="{:U('Material/kind')}"><i class="fa fa-angle-right"></i> 物资类型</a></li>
                                </if>
                            </ul>
                        </li>
                        </if>


                        <li class="{:ison(CONTROLLER_NAME, 'Message')}">
                            <a href="{:U('Message/index',array('type'=>0))}">
                                <i class="fa fa-envelope"></i> <span>系统消息</span>
                                <?php $noread = no_read(); ?>
                                <if condition="$noread"><small class="badge pull-right bg-red" style="margin-right:10px;">{$noread}</small></if>
                            </a>
                        </li>

                        <li class="{:ison(CONTROLLER_NAME, 'Work')}">
                            <a href="{:U('Work/record')}">
                                <i class="fa fa-file"></i> <span>工作记录</span>
                            </a>
                        </li>


                        <if condition="rolemenu(array('Kpi/qa','Kpi/handle','Inspect/record','Inspect/edit_ins','Inspect/score','Inspect/score_statis','Inspect/public_user_kpi_statis','Inspect/satisfaction','Inspect/unqualify'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Inspect')} {:on('Kpi/public_addqa')} {:on('Kpi/qa')} {:on('Kpi/handle')} {:on('Kpi/addqa')} {:on('Inspect/satisfaction')} {:on('Inspect/satisfaction_add')}">
                            <a href="javascript:;">
                                <i class="fa fa-medkit"></i>
                                <span>品控巡检</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{:U('Kpi/public_addqa')}"><i class="fa fa-angle-right"></i> 提交不合格报告</a></li>

                                <if condition="rolemenu(array('Kpi/qa'))">
                                    <li><a href="{:U('Kpi/qa')}"><i class="fa fa-angle-right"></i> 品质报告</a></li>
                                </if>

                                <!--<if condition="rolemenu(array('Inspect/record'))">
                                	<li><a href="{:U('Inspect/record')}"><i class="fa fa-angle-right"></i> 巡检记录</a></li>
                                </if>-->
                                <li class="treeview {:on('Inspect/score')} {:on('Inspect/score_statis')} {:on('Inspect/public_user_kpi_statis')}">
                                    <if condition="rolemenu(array('Inspect/score','Inspect/score_statis','Inspect/public_user_kpi_statis'))">
                                        <a href=""><i class="fa fa-smile-o"></i> 顾客满意度</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Inspect/score'))">
                                            <li class="{:on('Inspect/score')}"><a href="{:U('Inspect/score')}"><i class="fa fa-angle-right"></i> 顾客满意度</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Inspect/score_statis'))">
                                            <li class="{:on('Inspect/score_statis')}"><a href="{:U('Inspect/score_statis')}"><i class="fa fa-angle-right"></i> 顾客满意度统计</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Inspect/public_user_kpi_statis'))">
                                            <li class="{:on('Inspect/public_user_kpi_statis')}"><a href="{:U('Inspect/public_user_kpi_statis')}"><i class="fa fa-angle-right"></i> 顾客满意度分项统计</a></li>
                                        </if>
                                    </ul>
                                </li>
                                <if condition="rolemenu(array('Inspect/satisfaction'))">
                                    <li><a href="{:U('Inspect/satisfaction')}"><i class="fa fa-angle-right"></i> 内部人员满意度</a></li>
                                </if>
                                <if condition="rolemenu(array('Inspect/unqualify'))">
                                    <li class="{:on('Inspect/unqualify')}"><a href="{:U('Inspect/unqualify')}"><i class="fa fa-angle-right"></i> 不合格处理率</a></li>
                                </if>
                            </ul>
                        </li>
                        </if>

                        <if condition="rolemenu(array('Rights/index','Rights/myreq'))">
                        <li class="treeview {:on('Rights')}">
                            <a href="javascript:;">
                                <i class="fa fa-check-circle-o"></i>
                                <span>审批申请</span>
                                <?php if($_sum_audit){ ?>
                                <small class="badge pull-right bg-red" style="margin-right:6px;">{$_sum_audit}</small>
                                <?php }else{ ?>
                                <i class="fa fa-angle-left pull-right"></i>
                                <?php } ?>
                            </a>
                            <ul class="treeview-menu">
                                <if condition="rolemenu(array('Rights/index'))">
                                		<li class="{:on('Rights/index')}"><a href="{:U('Rights/index',array('status'=>0))}"><i class="fa fa-angle-right"></i> 审批列表</a></li>
                                </if>
                                <if condition="rolemenu(array('Rights/myreq'))">
                                		<li class="{:on('Rights/myreq')}"><a href="{:U('Rights/myreq')}"><i class="fa fa-angle-right"></i> 我的申请</a></li>
                                </if>

                            </ul>
                        </li>
                        </if>


                        <if condition="rolemenu(array('Sale/index','Sale/goods','Sale/gross','Sale/edit_gross','Sale/chart_gross','Sale/satisfaction','Sale/timely','Op/op_cost_type','Manage/public_elevate','Sale/public_kpi_profit_set'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Sale')} {:on('Op/op_cost_type')} {:on('Manage/public_elevate')} {:on('Sale/public_kpi_profit_set')}">
                            <a href="javascript:;">
                                <i class="fa fa-flag"></i>
                                <span>计调操作</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class="treeview {:on('Sale/gross')} {:on('Sale/edit_gross')} {:on('Sale/chart_gross')} {:on('Sale/chart_jd_gross')} {:on('Sale/gross_jd_info')} {:on('Sale/gross_op_list')} {:on('Manage/public_elevate')} {:on('Sale/public_kpi_profit_set')}">
                                    <if condition="rolemenu(array('Sale/gross','Sale/edit_gross','Sale/chart_gross','Sale/chart_jd_gross','Sale/public_kpi_profit_set'))">
                                        <a href=""><i class="fa  fa-money"></i> 毛利率</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Sale/chart_gross'))">
                                            <li class="{:on('Sale/chart_gross')} {:on('Sale/chart_jd_gross')} {:on('Sale/gross_jd_info')} {:on('Sale/gross_op_list')}"><a href="{:U('Sale/chart_gross')}"><i class="fa fa-angle-right"></i> 毛利率统计</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Manage/public_elevate'))">
                                            <li class="{:on('Manage/public_elevate')}"><a href="{:U('Manage/public_elevate')}"><i class="fa fa-angle-right"></i> 毛利率提升比率</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Sale/gross'))">
                                            <li class="{:on('Sale/gross')}"><a href="{:U('Sale/gross')}"><i class="fa fa-angle-right"></i> 设置最低毛利率</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Sale/public_kpi_profit_set'))">
                                            <li class="{:on('Sale/public_kpi_profit_set')}"><a href="{:U('Sale/public_kpi_profit_set')}"><i class="fa fa-angle-right"></i> 最低毛利率设置合理性</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <if condition="rolemenu(array('Sale/satisfaction'))">
                                    <li><a href="{:U('Sale/satisfaction')}"><i class="fa fa-angle-right"></i> 计调内部满意度</a></li>
                                </if>

                                <if condition="rolemenu(array('Sale/timely'))">
                                    <li><a href="{:U('Sale/timely')}"><i class="fa fa-angle-right"></i> 计调工作及时率</a></li>
                                </if>

                                <if condition="rolemenu(array('Op/op_cost_type'))">
                                    <li><a href="{:U('Op/op_cost_type')}"><i class="fa fa-angle-right"></i> 结算费用项</a></li>
                                </if>

                            	<!--<if condition="rolemenu(array('Sale/index'))">
                                	<li><a href="{:U('Sale/index')}"><i class="fa fa-angle-right"></i> 出团计划列表</a></li>
                                </if>
                                <if condition="rolemenu(array('Sale/order'))">
                                	<li><a href="{:U('Sale/order')}"><i class="fa fa-angle-right"></i> 销售记录</a></li>
                                </if>-->
                            </ul>
                        </li>
                        </if>


                        <if condition="rolemenu(array('Contract/index','Contract/statis','Contract/op_list','Contract/add_contract','Contract/contract_tpl'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Contract')}">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>合同管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <!--<if condition="rolemenu(array('Contract/add_contract'))">
                                    <li><a href="{:U('Contract/add_contract')}"><i class="fa fa-angle-right"></i> 新建合同</a></li>
                                </if>-->

                                <if condition="rolemenu(array('Contract/op_list'))">
                                    <li><a href="{:U('Contract/op_list')}"><i class="fa fa-angle-right"></i> 项目合同</a></li>
                                </if>

                            	<if condition="rolemenu(array('Contract/index'))">
                                    <li><a href="{:U('Contract/index')}"><i class="fa fa-angle-right"></i> 合同列表</a></li>
                                </if>

                                <if condition="rolemenu(array('Contract/statis'))">
                                    <li><a href="{:U('Contract/public_statis')}"><i class="fa fa-angle-right"></i> 合同统计</a></li>
                                </if>

                                <if condition="rolemenu(array('Contract/contract_tpl'))">
                                    <li><a href="{:U('Contract/contract_tpl')}"><i class="fa fa-angle-right"></i> 合同模板</a></li>
                                </if>
                            </ul>
                        </li>
                        </if>

                        <if condition="rolemenu(array('Finance/costacclist','Finance/budget','Finance/settlementlist','Finance/payment','Finance/costlabour','Finance/sign','Finance/jiekuan','Finance/jk_detail','Finance/loan_nopjk','Finance/loan','Finance/timely'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Finance')} {:ison(CONTROLLER_NAME, 'Manage')}">
                            <a href="javascript:;">
                                <i class="fa  fa-yen"></i>
                                <span>财务管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class="treeview {:on('Finance/jiekuan')} {:on('Finance/jk_detail')} {:on('Finance/loan_op')} {:on('Finance/nopjk')} {:on('Finance/loan')} {:on('Finance/loan_jklist')} {:on('Finance/loan_nopjk')}">
                                    <if condition="rolemenu(array('Finance/jiekuan','Finance/loan_op','Finance/nopjk'))">
                                        <a href=""><i class="fa  fa-check-circle"></i> 财务审批</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Finance/jiekuan'))">
                                            <li class="{:on('Finance/jiekuan')}"><a href="{:U('Finance/jiekuan')}"><i class="fa fa-angle-right"></i> 团内支出借款</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Finance/loan_op'))">
                                            <li class="{:on('Finance/loan_op')}"><a href="{:U('Finance/loan_op')}"><i class="fa fa-angle-right"></i> 团内支出报销</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Finance/nopjk'))">
                                            <li class="{:on('Finance/nopjk')}"><a href="{:U('Finance/nopjk')}"><i class="fa fa-angle-right"></i> 非团支出借款</a></li>
                                        </if>

                                        <li class="treeview {:on('Finance/loan')} {:on('Finance/loan_nopjk')}">
                                            <if condition="rolemenu(array('Finance/loan','Finance/loan_nopjk'))">
                                                <a href=""><i class="fa  fa-angle-right"></i> 非团支出报销</a>
                                            </if>
                                            <ul class="treeview-menu">
                                                <if condition="rolemenu(array('Finance/loan'))">
                                                    <li class="{:on('Finance/loan')}"><a href="{:U('Finance/loan')}"><i class="fa fa-angle-right"></i> 直接报销</a></li>
                                                </if>
                                                <if condition="rolemenu(array('Finance/loan_nopjk'))">
                                                    <li class="{:on('Finance/loan_nopjk')}"><a href="{:U('Finance/loan_nopjk')}"><i class="fa fa-angle-right"></i> 借款报销</a></li>
                                                </if>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="treeview {:on('Finance/jiekuan_lists')} {:on('Finance/jiekuandan_info')} {:on('Finance/baoxiao_lists')}">
                                    <if condition="rolemenu(array('Finance/jiekuan_lists','Finance/baoxiao_lists'))">
                                        <a href=""><i class="fa fa-file-text-o"></i> 单据管理</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Finance/jiekuan_lists'))">
                                            <li class="{:on('Finance/jiekuan_lists')}"><a href="{:U('Finance/jiekuan_lists')}"><i class="fa fa-angle-right"></i> 借款单管理</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Finance/baoxiao_lists'))">
                                            <li class="{:on('Finance/baoxiao_lists')}"><a href="{:U('Finance/baoxiao_lists')}"><i class="fa fa-angle-right"></i> 报销单管理</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <li class="treeview {:on('Finance/costacclist')} {:on('Finance/budget')} {:on('Finance/settlementlist')} {:on('Finance/reimbursement')}">
                                    <if condition="rolemenu(array('Finance/costacclist','Finance/budget','Finance/settlementlist','Finance/reimbursement'))">
                                        <a href=""><i class="fa fa-bullseye"></i> 项目费用</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <!--<if condition="rolemenu(array('Finance/costacclist'))">
                                            <li><a href="{:U('Finance/costacclist')}"><i class="fa fa-angle-right"></i> 成本核算</a></li>
                                        </if>--><!--20181228----delete-->

                                        <if condition="rolemenu(array('Finance/budget'))">
                                            <li><a href="{:U('Finance/budget')}"><i class="fa fa-angle-right"></i> 项目预算</a></li>
                                        </if>

                                        <if condition="rolemenu(array('Finance/settlementlist'))">
                                            <li><a href="{:U('Finance/settlementlist')}"><i class="fa fa-angle-right"></i> 项目结算</a></li>
                                        </if>

                                        <if condition="rolemenu(array('Finance/reimbursement'))">
                                            <li><a href="{:U('Finance/reimbursement')}"><i class="fa fa-angle-right"></i> 项目报账</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <li class="treeview {:on('Finance/payment')} {:on('Finance/payment_quarter')} {:on('Finance/quarter_arrears_detail')}">
                                    <if condition="rolemenu(array('Finance/payment','Finance/payment_quarter'))">
                                        <a href=""><i class="fa fa-share"></i> 回款管理</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Finance/payment'))">
                                            <li><a href="{:U('Finance/payment')}"><i class="fa fa-angle-right"></i> 月度回款管理</a></li>
                                        </if>

                                        <if condition="rolemenu(array('Finance/payment_quarter'))">
                                            <li><a href="{:U('Finance/payment_quarter')}"><i class="fa fa-angle-right"></i> 季度回款管理</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <li class="treeview {:on('Manage/Manage_month')}{:on('Manage/Manage_quarter')}{:on('Manage/Manage_year')}">
                                    <if condition="rolemenu(array('Manage/Manage_month','Manage/Manage_quarter','Manage/Manage_year'))">
                                        <a href=""><i class="fa fa-signal"></i> 经营管理</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Manage/Manage_month'))">
                                            <li class="{:on('Manage/Manage_month')}"><a href="{:U('Manage/Manage_month')}"><i class="fa fa-angle-right"></i> 月度经营</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Manage/Manage_quarter'))">
                                            <li class="{:on('Manage/Manage_quarter')}"><a href="{:U('Manage/Manage_quarter')}"><i class="fa fa-angle-right"></i> 季度经营</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Manage/Manage_year'))">
                                            <li class="{:on('Manage/Manage_year')}"><a href="{:U('Manage/Manage_year')}"><i class="fa fa-angle-right"></i> 年度经营</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <if condition="rolemenu(array('Finance/timely'))">
                                    <li class="{:on('Finance/public_timely')} {:on('Finance/public_timely_detail')} {:on('Finance/timely_list')}"><a href="{:U('Finance/public_timely')}"><i class="fa fa-angle-right"></i> 财务工作及时率</a></li>
                                </if>

                                <if condition="rolemenu(array('Finance/costlabour'))">
                                    <li class="{:on('Finance/costlabour')}"><a href="{:U('Finance/costlabour')}"><i class="fa fa-angle-right"></i> 劳务费用</a></li>
                                </if>

                                <if condition="rolemenu(array('Finance/sign'))">
                                    <li class="{:on('Finance/sign')}"><a href="{:U('Finance/sign')}"><i class="fa fa-angle-right"></i> 签字管理</a></li>
                                </if>

                            </ul>
                        </li>
                        </if>


                        <if condition="rolemenu(array('Cour/courPlan','Cour/courNeed','Cour/courPro','Cour/courRecord','Cour/courlist','Cour/courtype','Cour/pptlist'))">
                            <li class="treeview {:ison(CONTROLLER_NAME, 'Cour')}">
                                <a href="javascript:;">
                                    <i class="fa fa-file-text"></i>
                                    <span>培训管理</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <if condition="rolemenu(array('Cour/courPlan','Cour/courNeed','Cour/courPro','Cour/courRecord'))">
                                        <li><a href="{:U('Cour/courPlan')}"><i class="fa fa-angle-right"></i> 公司培训</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Cour/courlist'))">
                                        <li><a href="{:U('Cour/courlist')}"><i class="fa fa-angle-right"></i> 培训课件</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Cour/courtype'))">
                                        <li><a href="{:U('Cour/courtype')}"><i class="fa fa-angle-right"></i> 课件类型</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Cour/pptlist'))">
                                        <li><a href="{:U('Cour/pptlist')}"><i class="fa fa-angle-right"></i> 培训记录</a></li>
                                    </if>

                                </ul>
                            </li>
                        </if>

                        <li class="treeview {:on('Kpi')} {:on('Rbac')} {:on('Salary')}">
                            <a href="javascript:;" onclick="displaynone()">
                                <i class="fa fa-sitemap"></i>
                                <span>人力资源</span>
                                <?php if($_SESSION['salary_satus']){ ?>
                                    <small class="badge pull-right bg-red" style="margin-right:6px;"><?php echo $_SESSION['salary_satus'];?></small>
                                <?php }else{ ?>
                                    <i class="fa fa-angle-left pull-right"></i>
                                <?php } ?>
                            </a>
                            <ul class="treeview-menu">

                                <if condition="rolemenu(array('Rbac/role','Rbac/index','Rbac/department','Rbac/add_department','Rbac/del_department'))">
                                    <li class="treeview {:on('Rbac/role')} {:on('Rbac/addrole')} {:on('Rbac/priv')} {:on('Rbac/index')} {:on('Rbac/adduser')} {:on('Rbac/password')} {:on('Rbac/post')} {:on('Rbac/addpost')} {:on('Rbac/kpi_users')} {:on('Rbac/department')} {:on('Rbac/add_department')} {:on('Rbac/del_department')} ">

                                        <a href="{:U('Rbac/index')}">
                                            <i class="fa fa-user"></i>
                                            <span>员工管理</span>
                                        </a>
                                        <ul class="treeview-menu">

                                            <if condition="rolemenu(array('Rbac/role'))">
                                                <li class="{:on('Rbac/role')} {:on('Rbac/addrole')} {:on('Rbac/priv')}"><a href="{:U('Rbac/role')}"><i class="fa fa-angle-right"></i> 组织结构</a></li>
                                            </if>
                                            <if condition="rolemenu(array('Rbac/index'))">
                                                <li  class="{:on('Rbac/index')} {:on('Rbac/adduser')} {:on('Rbac/password')}"><a href="{:U('Rbac/index')}"><i class="fa fa-angle-right"></i> 人员管理</a></li>
                                            </if>

                                            <if condition="rolemenu(array('Rbac/post'))">
                                                <li class="{:on('Rbac/post')} {:on('Rbac/addpost')}"><a href="{:U('Rbac/post')}"><i class="fa fa-angle-right"></i> 岗位管理</a></li>
                                            </if>

                                            <if condition="rolemenu(array('Rbac/department','Rbac/add_department','Rbac/del_department'))">
                                                <li class="{:on('Rbac/department')} {:on('Rbac/add_department')} {:on('Rbac/del_department')}"><a href="{:U('Rbac/department')}"><i class="fa fa-angle-right"></i> 部门管理</a></li>
                                            </if>

                                            <if condition="rolemenu(array('Rbac/kpi_users'))">
                                                <li class="{:on('Rbac/kpi_users')}" ><a href="{:U('Rbac/kpi_users')}"><i class="fa fa-angle-right"></i> 配置KPI数据</a></li>
                                            </if>

                                        </ul>
                                    </li>
                                </if>

                                <if condition="rolemenu(array('Salary/salaryindex','Salary/salarydetails','Salary/salary_attendance'))">
                                    <li class="treeview {:ison(CONTROLLER_NAME, 'Salary')}">
                                        <a href="javascript:;">
                                            <i class="fa fa-plane"></i>
                                            <span>薪资管理</span>
                                            <?php if($_SESSION['salary_satus']){ ?>
                                                <small class="badge pull-right bg-red" style="margin-right:6px;"><?php echo $_SESSION['salary_satus'];?></small>
                                            <?php }else{ ?>
                                                <i class="fa fa-angle-left pull-right"></i>
                                            <?php } ?>
                                        </a>
                                        <ul class="treeview-menu">

                                            <if condition="rolemenu(array('Salary/salaryindex','Salary/salary_attendance'))">
                                                <li class="{:on('Salary/salaryindex')}">
                                                    <a href="{:U('Salary/salaryindex')}">
                                                        <i class="fa fa-angle-right">
                                                        </i>员工薪资
                                                        <?php if($_SESSION['salary_satus']){ ?>
                                                            <small class="badge pull-right bg-red" style="margin-right:6px;"><?php echo $_SESSION['salary_satus'];?></small>
                                                        <?php }else{ ?>
                                                            <i class="fa fa-angle-left pull-right"></i>
                                                        <?php } ?>
                                                    </a>

                                                </li>
                                            </if>

                                            <if condition="rolemenu(array('Salary/salary_attendance'))">
                                                <li class="{:on('Salary/salary_attendance')}"><a href="{:U('Salary/salary_attendance')}"><i class="fa fa-angle-right"></i>员工考勤</a></li>
                                            </if>
                                        </ul>
                                    </li>
                                </if>


                                <if condition="rolemenu(array('Kpi/pdca','kpi/pdcaresult','kpi/postkpi','Inspect/satisfaction_config'))">
                                    <li class="treeview {:ison(CONTROLLER_NAME, 'Kpi')}">
                                        <a href="javascript:;">
                                            <i class="fa fa-trophy"></i>
                                            <span>绩效管理</span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <if condition="rolemenu(array('Kpi/pdcaresult'))">
                                                <li><a href="{:U('Kpi/pdcaresult')}"><i class="fa fa-angle-right"></i> 绩效考评结果</a></li>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/pdca'))">
                                                <li><a href="{:U('Kpi/pdca')}"><i class="fa fa-angle-right"></i> PDCA</a></li>
                                            </if>
                                            <li><a href="{:U('Kpi/postkpi')}"><i class="fa fa-angle-right"></i> KPI</a></li>
                                            <if condition="rolemenu(array('Kpi/crux'))">
                                                <li><a href="{:U('Kpi/crux')}"><i class="fa fa-angle-right"></i> 关键事项评价</a></li>
                                            </if>
                                            <if condition="rolemenu(array('Inspect/satisfaction_config'))">
                                                <li><a href="{:U('Inspect/satisfaction_config')}"><i class="fa fa-angle-right"></i> 内部满意度配置</a></li>
                                            </if>
                                        </ul>
                                    </li>
                                </if>

                                <if condition="rolemenu(array('Rbac/chart_personnel','Rbac/HR_cost'))">
                                    <li class="treeview {:on('Rbac/chart_personnel')} {:on('Rbac/HR_cost')}">
                                        <a href="javascript:;">
                                            <i class="fa fa-calculator"></i>
                                            <span>数据统计</span>
                                        </a>
                                        <ul class="treeview-menu">
                                            <if condition="rolemenu(array('Rbac/chart_personnel'))">
                                                <li><a href="{:U('Rbac/chart_personnel')}"><i class="fa fa-angle-right"></i> 员工统计</a></li>
                                            </if>
                                            <if condition="rolemenu(array('Rbac/HR_cost'))">
                                                <li><a href="{:U('Rbac/HR_cost')}"><i class="fa fa-angle-right"></i> 人力成本统计</a></li>
                                            </if>
                                        </ul>
                                    </li>
                                </if>
                            </ul>
                        </li>



                        <if condition="rolemenu(array('worder/new_worder','worder/worder_list','worder/project'))">
                            <li class="treeview {:ison(CONTROLLER_NAME, 'Worder')}">
                                <a href="javascript:;">
                                    <i class="fa fa-clipboard"></i>
                                    <span>工单管理</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <if condition="rolemenu(array('worder/dept_worder_list'))">
                                        <li><a href="{:U('worder/dept_worder_list')}"><i class="fa fa-angle-right"></i> 部门工单项管理</a></li>
                                    </if>
                                    <if condition="rolemenu(array('worder/new_worder'))">
                                        <li><a href="{:U('worder/new_worder')}"><i class="fa fa-angle-right"></i> 发起工单</a></li>
                                    </if>
                                    <if condition="rolemenu(array('worder/worder_list'))">
                                        <li><a href="{:U('worder/worder_list')}"><i class="fa fa-angle-right"></i> 工单列表</a></li>
                                    </if>
                                    <!--<if condition="rolemenu(array('worder/project'))">
                                        <li><a href="{:U('worder/project')}"><i class="fa fa-angle-right"></i> 项目工单</a></li>
                                    </if>-->
                                    <if condition="rolemenu(array('worder/worder_chart'))">
                                        <li><a href="{:U('worder/worder_chart')}"><i class="fa fa-angle-right"></i> 工单统计</a></li>
                                    </if>
                                </ul>
                            </li>
                        </if>

                        <if condition="rolemenu(array('Chart/index','Chart/department','Chart/summary_types','Chart/quarter_department','Chart/quarter_summary_types'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Chart')}">
                            <a href="javascript:;">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>数据统计</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class="treeview {:on('Chart/department')} {:on('Chart/summary_types')}">
                                    <a href="javascript:;">
                                        <i class="fa fa-calendar"></i>
                                        <span>项目月度统计</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Chart/department'))">
                                            <li><a href="{:U('Chart/department')}"><i class="fa fa-angle-right"></i> 项目分部门汇总</a></li>

                                        </if>
                                        <if condition="rolemenu(array('Chart/summary_types'))">
                                            <!--<li><a href="{:U('Chart/kind')}"><i class="fa fa-angle-right"></i> 项目分部门分类型汇总</a></li>-->
                                            <li><a href="{:U('Chart/summary_types')}"><i class="fa fa-angle-right"></i> 项目分部门分类型汇总</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <li class="treeview {:on('Chart/quarter_department')} {:on('Chart/quarter_summary_types')}">
                                    <a href="javascript:;">
                                        <i class="fa fa-calendar-o"></i>
                                        <span>项目季度统计</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Chart/quarter_department'))">
                                            <li><a href="{:U('Chart/quarter_department')}"><i class="fa fa-angle-right"></i> 项目分部门汇总</a></li>

                                        </if>
                                        <if condition="rolemenu(array('Chart/quarter_summary_types'))">
                                            <li><a href="{:U('Chart/quarter_summary_types')}"><i class="fa fa-angle-right"></i> 项目分部门分类型汇总</a></li>
                                        </if>
                                    </ul>
                                </li>

                            	<if condition="rolemenu(array('Chart/op'))">
                                    <li><a href="{:U('Chart/op')}"><i class="fa fa-angle-right"></i> 综合数据分析</a></li>
                                </if>
                                <if condition="rolemenu(array('Chart/cycle'))">
                                    <li><a href="{:U('Chart/cycle')}"><i class="fa fa-angle-right"></i> 结算周期分析</a></li>
                                </if>
                                <if condition="rolemenu(array('Chart/op_tc'))">
                                    <li><a href="{:U('Chart/op_tc')}"><i class="fa fa-angle-right"></i> 项目提成分析</a></li>
                                </if>

                                <if condition="rolemenu(array('Chart/finance'))">
                                    <li><a href="{:U('Chart/finance')}"><i class="fa fa-angle-right"></i> 项目结算统计</a></li>
                                </if>

                                <!--
                                <if condition="rolemenu(array('Chart/customer'))">
                                    <li><a href="{:U('Chart/customer')}"><i class="fa fa-angle-right"></i> 客户统计</a></li>
                                </if>
                                <if condition="rolemenu(array('Chart/product'))">
                                    <li><a href="{:U('Chart/product')}"><i class="fa fa-angle-right"></i> 产品统计</a></li>
                                </if>
                                <if condition="rolemenu(array('Chart/supplier'))">
                                    <li><a href="{:U('Chart/supplier')}"><i class="fa fa-angle-right"></i> 合格供方统计</a></li>
                                </if>
                                <if condition="rolemenu(array('Chart/guide'))">
                                    <li><a href="{:U('Chart/guide')}"><i class="fa fa-angle-right"></i> 专家辅导员统计</a></li>
                                </if>
                                <if condition="rolemenu(array('Chart/material'))">
                                    <li><a href="{:U('Chart/material')}"><i class="fa fa-angle-right"></i> 物资统计</a></li>
                                </if>
                                -->
                            </ul>
                        </li>
                        </if>



                        <if condition="rolemenu(array('Rbac/node','Rbac/audit_config','Rbac/respriv_project','Rbac/respriv_product','Rbac/respriv_science','Rbac/respriv_supplier','Rbac/respriv_guide','Rbac/pdca_auth','Rbac/worder_auth','Finance/jk_audit_user','Op/saleConfig','Rbac/kpi_quota','Rbac/kpi_users'))">
                            <li class="treeview {:on('Rbac/node')} {:on('Rbac/audit_config')} {:on('Rbac/respriv_project')} {:on('Rbac/respriv_product')} {:on('Rbac/respriv_science')} {:on('Rbac/respriv_supplier')} {:on('Rbac/respriv_guide')}">
                                <a href="javascript:;">
                                    <i class="fa fa-cog"></i>
                                		<span>系统管理</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <if condition="rolemenu(array('Rbac/node'))">
                                        <li class="{:on('Rbac/node')}"><a href="{:U('Rbac/node')}"><i class="fa fa-angle-right"></i> 节点管理</a></li>
                                    </if>
                                    <if condition="rolemenu(array('Rbac/audit_config'))">
                                    	<li  class="{:on('Rbac/audit_config')}"><a href="{:U('Rbac/audit_config')}"><i class="fa fa-angle-right"></i> 资源审核设置</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/respriv_project'))">
                                        <li class="{:on('Rbac/respriv_project')}"><a href="{:U('Rbac/respriv_project')}"><i class="fa fa-angle-right"></i> 项目默认权限</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/respriv_product'))">
                                        <li  class="{:on('Rbac/respriv_product')}" ><a href="{:U('Rbac/respriv_product')}"><i class="fa fa-angle-right"></i> 产品默认权限</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/respriv_science'))">
                                        <li  class="{:on('Rbac/respriv_science')}" ><a href="{:U('Rbac/respriv_science')}"><i class="fa fa-angle-right"></i> 科普资源默认权限</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/respriv_supplier'))">
                                        <li class="{:on('Rbac/respriv_supplier')}" ><a href="{:U('Rbac/respriv_supplier')}"><i class="fa fa-angle-right"></i> 合格供方默认权限</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/respriv_guide'))">
                                         <li class="{:on('Rbac/respriv_guide')}" ><a href="{:U('Rbac/respriv_guide')}"><i class="fa fa-angle-right"></i> 导游辅导员默认权限</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/pdca_auth'))">
                                         <li class="{:on('Rbac/pdca_auth')}" ><a href="{:U('Rbac/pdca_auth')}"><i class="fa fa-angle-right"></i> PDCA指定评分人</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/worder_auth'))">
                                        <li class="{:on('Rbac/worder_auth')}" ><a href="{:U('Rbac/worder_auth')}"><i class="fa fa-angle-right"></i> 工单系统指定指派人</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Finance/jk_audit_user'))">
                                        <li class="{:on('Finance/jk_audit_user')}" ><a href="{:U('Finance/jk_audit_user')}"><i class="fa fa-angle-right"></i> 部门借款审核人</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Op/saleConfig'))">
                                        <li class="{:on('Op/saleConfig')}" ><a href="{:U('Op/saleConfig')}"><i class="fa fa-angle-right"></i> 销售任务系数配置</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/kpi_quota'))">
                                         <li class="{:on('Rbac/kpi_quota')}" ><a href="{:U('Rbac/kpi_quota')}"><i class="fa fa-angle-right"></i> KPI考核指标管理</a></li>
                                    </if>

                                    <if condition="rolemenu(array('Rbac/kpi_lockdata'))">
                                         <li class="{:on('Rbac/kpi_users')}" ><a href="{:U('Rbac/kpi_lockdata')}"><i class="fa fa-angle-right"></i> 锁定KPI数据</a></li>
                                    </if>

                                    <!--
                                    <if condition="rolemenu(array('Rbac/node'))">
                                        <li><a href="{:U('Index/index')}"><i class="fa fa-angle-right"></i> 缓存清理</a></li>
                                    </if>
                                    -->
                                </ul>
                            </li>
                        </if>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <script>
                function displaynone(){
                    $('.treeview-menu').css('display','none');
                }
                function playnone(){
//                    $(this).parent('li').children('.treeview-menu').show();
                    $('#cour_id_show1').show();
//                    $('.playnone').show();
                }
            </script>
