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


                        <!--<li class="{:on('Chart')}">
                            <a href="{:U('Chart/pplist')}">
                                <i class="fa fa-signal"></i> <span>业绩排行</span>
                            </a>
                        </li>-->

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

                        <if condition="rolemenu(array('Op/index','Op/plans','Project/kind','Op/relpricelist'))">
                        <li class="treeview {:ison(CONTROLLER_NAME,'Op')} {:on('Project/addkind')}">
                            <a href="javascript:;">
                                <i class="fa fa-shopping-cart"></i>
                                <span>项目管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <if condition="rolemenu(array('Op/plans'))">
                                    <li><a href="{:U('Op/plans')}"><i class="fa fa-angle-right"></i> 我要立项</a></li>
                                </if>
                                <if condition="rolemenu(array('Op/index'))">
                                    <li><a href="{:U('Op/index')}"><i class="fa fa-angle-right"></i> 项目管理</a></li>
                                </if>
                                <if condition="rolemenu(array('Op/relpricelist'))">
                                        <li class="{:on('Op/relpricelist')} {:on('Op/relprice')}"><a href="{:U('Op/relpricelist')}"><i class="fa fa-angle-right"></i> 项目比价</a></li>
                                </if>
                                <if condition="rolemenu(array('Op/satisfaction'))">
                                    <li class="{:on('Op/satisfaction')} {:on('Op/')}"><a href="{:U('Op/satisfaction')}"><i class="fa fa-angle-right"></i> 研发满意度</a></li>
                                </if>

                            </ul>
                        </li>
                        </if>

                        <!--
                        <if condition="rolemenu(array('Project/index','Project/kind'))">
                        <li class="treeview {:on('Project')}">
                            <a href="javascript:;">
                                <i class="fa fa-pencil-square"></i>
                                <span>项目管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            	<if condition="rolemenu(array('Project/add'))">
                                		<li class="{:on('Project/add')}"><a href="{:U('Project/add')}"><i class="fa fa-angle-right"></i> 新建项目</a></li>
                                </if>
                                <if condition="rolemenu(array('Project/index'))">
                                		<li class="{:on('Project/index')}"><a href="{:U('Project/index')}"><i class="fa fa-angle-right"></i> 项目列表</a></li>
                                </if>
                                <if condition="rolemenu(array('Project/kind'))">
                                		<li class="{:on('Project/kind')} {:on('Project/addkind')}"><a href="{:U('Project/kind')}"><i class="fa fa-angle-right"></i> 项目类型</a></li>
                                </if>

                            </ul>
                        </li>
                        </if>
                        -->

                        <if condition="rolemenu(array('Product/index','Product/tpl','Product/line','Product/kind','Product/feedback','Project/lession','Project/fields','Project/types'))">
                        <li class="treeview {:on('Product')} {:on('Project')} {:on('Project/lession')} {:on('Project/fields')} {:on('Project/types')}">
                            <a href="javascript:;">
                                <i class="fa fa-globe"></i>
                                <span>产品管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

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
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                              	<if condition="rolemenu(array('ScienceRes/res','ScienceRes/addres','ScienceRes/reskind'))">
                                <li class="treeview {:on('ScienceRes')}">
                                    <a href=""><i class="fa  fa-flag"></i> 科普资源</a>
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


                                <if condition="rolemenu(array('SupplierRes/res','SupplierRes/addres','SupplierRes/reskind'))">
                                <li class="treeview  {:on('SupplierRes')}">
                                    <a href=""><i class="fa fa-plane"></i> 合格供方</a>
                                    <ul class="treeview-menu">

                                         <if condition="rolemenu(array('SupplierRes/addres'))">
                                         <li class="{:on('SupplierRes/addres')}"><a href="{:U('SupplierRes/addres')}"><i class="fa fa-angle-right"></i> 新增合格供方</a></li>
                                         </if>

                                    	 <if condition="rolemenu(array('SupplierRes/res','SupplierRes/res_view'))">
                                         <li class="{:on('SupplierRes/res')} {:on('SupplierRes/res_view')}"><a href="{:U('SupplierRes/res')}"><i class="fa fa-angle-right"></i> 合格供方管理</a></li>      									 </if>
                                         <if condition="rolemenu(array('SupplierRes/reskind','SupplierRes/addreskind'))">
                                         <li class="{:on('SupplierRes/reskind')} {:on('SupplierRes/addreskind')} "><a href="{:U('SupplierRes/reskind')}"><i class="fa fa-angle-right"></i> 合格供方分类</a></li>
                                         </if>
                                     </ul>
                                </li>
                                </if>


                                <if condition="rolemenu(array('GuideRes/res','GuideRes/addres','GuideRes/reskind'))">
                                <li class="treeview  {:on('GuideRes')}">
                                    <a href=""><i class="fa fa-female"></i> 导游辅导员</a>
                                    <ul class="treeview-menu">
                                    	<!--<if condition="rolemenu(array('GuideRes/addres'))">
                                        <li class="{:on('GuideRes/addres')} "><a href="{:U('GuideRes/addres')}"><i class="fa fa-angle-right"></i> 新增导游辅导员</a></li>
                                        </if>-->
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

                            </ul>
                        </li>


                        <if condition="rolemenu(array('Files/index','Approval/Approval_Index'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Files')} {:on('File')} {:on('Approval')}">
                            <a href="javascript:;">
                                <i class="fa  fa-folder-open"></i>
                                <span>文件管理</span>
                                <?php if($_SESSION['file_sum']){ ?>
                                    <small class="badge pull-right bg-red" style="margin-right:6px;"><?php echo $_SESSION['file_sum'];?></small>
                                <?php }else{ ?>
                                    <i class="fa fa-angle-left pull-right"></i>
                                <?php } ?>
<!--                                <i class="fa fa-angle-left pull-right"></i>-->
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
                                    <li>
                                        <a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)">
                                            <i class="fa fa-angle-right">
                                            </i> 公司管理手册
                                        </a>
                                    </li>
                                   <!-- <li class="{:on('File/company')}"><a href="{:U('File/company',array('pid'=>43))}"><i class="fa fa-angle-right"></i> 公司管理手册</a></li>-->
                                <if condition="rolemenu(array('Files/index'))">
                                    <li>
                                        <a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)">
                                            <i class="fa fa-angle-right">
                                            </i> 部门工作手册
                                        </a>
                                    </li>
                                    <!--<li class="{:on('Files/index')}"><a href="{:U('Files/index',array('pid'=>44))}"><i class="fa fa-angle-right"></i> 部门工作手册</a></li>-->
                                </if>
                                    <li class="{:on('File/instruction')}"><a href="{:U('File/instruction',array('pid'=>45))}">
                                            <i class="fa fa-angle-right">
                                            </i> 岗位作业指导书
                                        </a>
                                    </li>
                                <if condition="rolemenu(array('Approval/Approval_Index','Approval/Approval_list','Approval/approval_table','Approval/Approval_Upload','Approval/file_upload','Approval/Approval_Update','Approval/file_change','Approval/add_final_judgment','Approval/add_annotation'))">

                                    <li class="{:on('Approval/Approval_Index')}{:on('Approval/Approval_list')}{:on('Approval/approval_table')}{:on('Approval/Approval_Upload')}{:on('Approval/file_upload')}{:on('Approval/Approval_Update')}{:on('Approval/file_change')}{:on('Approval/add_final_judgment')}{:on('Approval/add_annotation')}">

                                        <a href="{:U('Approval/Approval_Index')}">
                                            <i class="fa fa-angle-right"></i> 文件审批
                                            <?php if($_SESSION['file_sum']){ ?>
                                                <small class="badge pull-right bg-red" style="margin-right:6px;"><?php echo $_SESSION['file_sum'];?></small>
                                            <?php }?>

                                        </a>
                                    </li>
                                </if>
                            </ul>
                        </li>
                        </if>

                        <if condition="rolemenu(array('Customer/GEC','Customer/IC'))">
                        <li class="treeview {:on('Customer')}">
                            <a href="javascript:;">
                                <i class="fa fa-group"></i>
                                <span>销售管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                            	<if condition="rolemenu(array('Customer/o2o'))">
                                	<li class="{:on('Customer/o2o')} {:on('Customer/o2o_apply')}"><a href="{:U('Customer/o2o')}"><i class="fa fa-angle-right"></i> 支撑服务校记录</a></li>
                                </if>

                            	<if condition="rolemenu(array('Customer/GEC'))">
                                	<li class="{:on('Customer/GEC')} {:on('Customer/GEC_edit')}"><a href="{:U('Customer/GEC')}"><i class="fa fa-angle-right"></i> 客户管理</a></li>
                                </if>

                                <if condition="rolemenu(array('Customer/IC'))">
                                	<li class="{:on('Customer/IC')} {:on('Customer/IC_edit')}"><a href="{:U('Customer/IC')}"><i class="fa fa-angle-right"></i> 营员管理</a></li>
                                </if>

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



                        <if condition="rolemenu(array('Inspect/record','Inspect/edit_ins','Inspect/score'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Inspect')} {:on('Index/public_satisfaction')} {:on('Index/public_satisfaction_add')}">
                            <a href="javascript:;">
                                <i class="fa fa-medkit"></i>
                                <span>品控巡检</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <if condition="rolemenu(array('Inspect/edit_ins'))">
                                	<li><a href="{:U('Inspect/edit_ins')}"><i class="fa fa-angle-right"></i> 发布巡检记录</a></li>
                                </if>
                                <if condition="rolemenu(array('Inspect/record'))">
                                	<li><a href="{:U('Inspect/record')}"><i class="fa fa-angle-right"></i> 巡检记录</a></li>
                                </if>
                                <!--<if condition="rolemenu(array('Inspect/score'))">
                                    <li><a href="{:U('Inspect/score')}"><i class="fa fa-angle-right"></i> 顾客满意度</a></li>
                                </if>-->
                                <li class="treeview {:on('Inspect/score')}">
                                    <if condition="rolemenu(array('Inspect/score','Inspect/score_statis'))">
                                        <a href=""><i class="fa fa-smile-o"></i> 顾客满意度</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Inspect/score'))">
                                            <li class="{:on('Inspect/score')}"><a href="{:U('Inspect/score')}"><i class="fa fa-angle-right"></i> 顾客满意度</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Inspect/score_statis'))">
                                            <li class="{:on('Inspect/score_statis')}"><a href="{:U('Inspect/score_statis')}"><i class="fa fa-angle-right"></i> 顾客满意度统计</a></li>
                                        </if>
                                    </ul>
                                </li>

                                <li><a href="{:U('Index/public_satisfaction')}"><i class="fa fa-angle-right"></i> 内部人员满意度</a></li>
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


                        <if condition="rolemenu(array('Sale/index','Sale/goods'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Sale')}">
                            <a href="javascript:;">
                                <i class="fa fa-flag"></i>
                                <span>计调操作</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            	<if condition="rolemenu(array('Sale/index'))">
                                	<li><a href="{:U('Sale/index')}"><i class="fa fa-angle-right"></i> 出团计划列表</a></li>
                                </if>
                                <if condition="rolemenu(array('Sale/order'))">
                                	<li><a href="{:U('Sale/order')}"><i class="fa fa-angle-right"></i> 销售记录</a></li>
                                </if>
                            </ul>
                        </li>
                        </if>


                        <if condition="rolemenu(array('Contract/index','Contract/statis','Contract/op_list'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Contract')}">
                            <a href="javascript:;">
                                <i class="fa fa-book"></i>
                                <span>合同管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <if condition="rolemenu(array('Contract/op_list'))">
                                    <li><a href="{:U('Contract/op_list')}"><i class="fa fa-angle-right"></i> 项目合同</a></li>
                                </if>

                            	<if condition="rolemenu(array('Contract/index'))">
                                    <li><a href="{:U('Contract/index')}"><i class="fa fa-angle-right"></i> 合同列表</a></li>
                                </if>
                                <if condition="rolemenu(array('Contract/statis'))">
                                    <li><a href="{:U('Contract/statis')}"><i class="fa fa-angle-right"></i> 合同统计</a></li>
                                </if>
                            </ul>
                        </li>
                        </if>

                        <if condition="rolemenu(array('Finance/costacclist','Finance/budget','Finance/settlementlist','Finance/payment','Finance/costlabour','Finance/sign','Finance/jiekuan','Finance/jk_detail','Finance/loan_nopjk','Finance/loan'))">
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

                                <li class="treeview {:on('Finance/costacclist')} {:on('Finance/budget')} {:on('Finance/settlementlist')} {:on('Finance/payment')}">
                                    <if condition="rolemenu(array('Finance/jiekuan'))">
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

                                        <if condition="rolemenu(array('Finance/payment'))">
                                            <li><a href="{:U('Finance/payment')}"><i class="fa fa-angle-right"></i> 回款管理</a></li>
                                            <!--<li><a href="{:U('Finance/public_payment_chart')}"><i class="fa fa-angle-right"></i> 回款统计</a></li>-->
                                        </if>

                                    </ul>
                                </li>

                                <li class="treeview {:on('Manage/Manage_month')}{:on('Manage/Manage_quarter')}{:on('Manage/Manage_year')}">
                                    <if condition="rolemenu(array('Manage/Manage_month','Manage/Manage_quarter','Manage/Manage_year'))">
                                        <a href=""><i class="fa fa-angle-right"></i> 经营管理</a>
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

                                <if condition="rolemenu(array('Finance/costlabour'))">
                                    <li><a href="{:U('Finance/costlabour')}"><i class="fa fa-angle-right"></i> 劳务费用</a></li>
                                </if>

                                <if condition="rolemenu(array('Finance/sign'))">
                                    <li class="{:on('Finance/sign')}"><a href="{:U('Finance/sign')}"><i class="fa fa-angle-right"></i> 签字管理</a></li>
                                </if>

                            </ul>
                        </li>
                        </if>


<!--                        <if condition="rolemenu(array('Kpi/pdca','Kpi/qa'))">-->
<!--                        <li class="treeview {:ison(CONTROLLER_NAME, 'Kpi')}">-->
<!--                            <a href="javascript:;">-->
<!--                                <i class="fa fa-trophy"></i>-->
<!--                                <span>绩效管理</span>-->
<!--                                <i class="fa fa-angle-left pull-right"></i>-->
<!--                            </a>-->
<!--                            <ul class="treeview-menu">-->
<!--                            	<if condition="rolemenu(array('Kpi/pdcaresult'))">-->
<!--                            	<li><a href="{:U('Kpi/pdcaresult')}"><i class="fa fa-angle-right"></i> 绩效考评结果</a></li>-->
<!--                                </if>-->
<!--                            	<if condition="rolemenu(array('Kpi/pdca'))">-->
<!--                                	<li><a href="{:U('Kpi/pdca')}"><i class="fa fa-angle-right"></i> PDCA</a></li>-->
<!--                                </if>-->
<!--                                <if condition="rolemenu(array('Kpi/qa'))">-->
<!--                                	<li><a href="{:U('Kpi/qa')}"><i class="fa fa-angle-right"></i> 品质检查</a></li>-->
<!--                                </if>-->
<!--                                <li><a href="{:U('Kpi/postkpi')}"><i class="fa fa-angle-right"></i> KPI</a></li>-->
<!--                                <!---->
<!--                                <li><a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)"><i class="fa fa-angle-right"></i> KPI</a></li>-->
<!--                                -->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        </if>-->

                        <if condition="rolemenu(array('Cour/courlist','Cour/courtype','Cour/pptlist'))">
                            <li class="treeview {:ison(CONTROLLER_NAME, 'Cour')}">
                                <a href="javascript:;">
                                    <i class="fa fa-file-text"></i>
                                    <span>培训管理</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
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

                                <if condition="rolemenu(array('Rbac/role','Rbac/index'))">
                                    <li class="treeview {:on('Rbac/role')} {:on('Rbac/addrole')} {:on('Rbac/priv')} {:on('Rbac/index')} {:on('Rbac/adduser')} {:on('Rbac/password')} {:on('Rbac/post')} {:on('Rbac/addpost')} {:on('Rbac/kpi_users')}">

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


                                <if condition="rolemenu(array('Kpi/pdca','Kpi/qa','kpi/pdcaresult','kpi/postkpi'))">
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
                                            <if condition="rolemenu(array('Kpi/qa'))">
                                                <li><a href="{:U('Kpi/qa')}"><i class="fa fa-angle-right"></i> 品质检查</a></li>
                                            </if>
                                            <li><a href="{:U('Kpi/postkpi')}"><i class="fa fa-angle-right"></i> KPI</a></li>

                                        </ul>
                                    </li>
                                </if>

                                <!--<if condition="rolemenu(array('Cour/courlist','Cour/courtype','Cour/pptlist'))">
                                    <li class="treeview {:ison(CONTROLLER_NAME, 'Cour')}">
                                        <a href="javascript:;">
                                            <i class="fa fa-file-text"></i>
                                            <span>培训管理</span>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <ul class="treeview-menu">
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
                                </if>-->

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
                                        <li><a href="{:U('worder/worder_list')}"><i class="fa fa-angle-right"></i> 管理工单</a></li>
                                    </if>
                                    <!--<if condition="rolemenu(array('worder/project'))">
                                        <li><a href="{:U('worder/project')}"><i class="fa fa-angle-right"></i> 项目工单</a></li>
                                    </if>-->
                                    <!--
                                    <li><a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)"><i class="fa fa-angle-right"></i> KPI</a></li>
                                    -->
                                </ul>
                            </li>
                        </if>

                        <!--
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Kpi')}">
                            <a href="javascript:;">
                                <i class="fa fa-trophy"></i>
                                <span>绩效管理</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                            	<li><a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)"><i class="fa fa-angle-right"></i> 考评结果</a></li>
                                <li><a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)"><i class="fa fa-angle-right"></i> PDCA</a></li>
                                <li><a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)"><i class="fa fa-angle-right"></i> 品质检查</a></li>
                                <li><a href="javascript:;" onClick="art_show_msg('加班开发中，稍后呈现...',5)"><i class="fa fa-angle-right"></i> KPI</a></li>
                            </ul>
                        </li>
                        -->



                        <if condition="rolemenu(array('Chart/index'))">
                        <li class="treeview {:ison(CONTROLLER_NAME, 'Chart')}">
                            <a href="javascript:;">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>数据统计</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class="treeview {:ison(CONTROLLER_NAME, 'Chart')}">
                                    <a href="javascript:;">
                                        <i class="fa fa-calendar"></i>
                                        <span>项目月度统计</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Chart/settlement'))">
                                            <li><a href="{:U('Chart/settlement')}"><i class="fa fa-angle-right"></i> 项目月度统计</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Chart/department'))">
                                            <li><a href="{:U('Chart/department')}"><i class="fa fa-angle-right"></i> 项目分部门汇总</a></li>

                                        </if>
                                        <if condition="rolemenu(array('Chart/summary_types'))">
                                            <!--<li><a href="{:U('Chart/kind')}"><i class="fa fa-angle-right"></i> 项目分部门分类型汇总</a></li>-->
                                            <li><a href="{:U('Chart/summary_types')}"><i class="fa fa-angle-right"></i> 项目分部门分类型汇总</a></li>
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



<!--                        <if condition="rolemenu(array('Rbac/role','Rbac/index'))">-->
<!--                            <li class="treeview {:on('Rbac/role')} {:on('Rbac/addrole')} {:on('Rbac/priv')} {:on('Rbac/index')} {:on('Rbac/adduser')} {:on('Rbac/password')}">-->
<!---->
<!--                                <a href="{:U('Rbac/index')}">-->
<!--                                    <i class="fa fa-user"></i>-->
<!--                                    <span>用户管理</span>-->
<!--                                    <i class="fa fa-angle-left pull-right"></i>-->
<!--                                </a>-->
<!--                                <ul class="treeview-menu">-->
<!---->
<!--                                    <if condition="rolemenu(array('Rbac/role'))">-->
<!--                                    	<li class="{:on('Rbac/role')} {:on('Rbac/addrole')} {:on('Rbac/priv')}"><a href="{:U('Rbac/role')}"><i class="fa fa-angle-right"></i> 组织结构</a></li>-->
<!--                                    </if>-->
<!--                                    <if condition="rolemenu(array('Rbac/index'))">-->
<!--                                    	<li  class="{:on('Rbac/index')} {:on('Rbac/adduser')} {:on('Rbac/password')}"><a href="{:U('Rbac/index')}"><i class="fa fa-angle-right"></i> 人员管理</a></li>-->
<!--                                    </if>-->
<!---->
<!--                                    <if condition="rolemenu(array('Rbac/post'))">-->
<!--                                    	<li class="{:on('Rbac/post')} {:on('Rbac/addpost')}"><a href="{:U('Rbac/post')}"><i class="fa fa-angle-right"></i> 岗位管理</a></li>-->
<!--                                    </if>-->
<!---->
<!--                                </ul>-->
<!--                            </li>-->
<!--                        </if>-->



                        <if condition="rolemenu(array('Rbac/node','Rbac/audit_config','Rbac/respriv_project','Rbac/respriv_product','Rbac/respriv_science','Rbac/respriv_supplier','Rbac/respriv_guide','Rbac/kpi_quota','Rbac/kpi_users'))">
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