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

                        <!--<if condition="rolemenu(array('Index/index'))">
                            <li class="{:on('Index')}">
                                <a href="{:U('Zindex/index')}">
                                    <i class="fa fa-home"></i> <span>首页</span>
                                </a>
                            </li>
                        </if>-->

                        <li class="treeview {:ison(CONTROLLER_NAME,'Zprocess')}">
                            <a href="javascript:;">
                                <i class="fa fa-list-ol"></i>
                                <span>流程</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="javascript:;" onclick="art_show_msg('开发中...',3)"><i class="fa fa-angle-right"></i> 待办事宜</a></li>
                                <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-angle-right"></i> 新建流程</a></li>

                                <li class="treeview {:on('Zprocess/public_add')} {:on('Zprocess/public_setType')}">
                                    <if condition="rolemenu(array('Product/standard_product','Product/standard_module'))">
                                        <a href=""><i class="fa  fa-pencil"></i> 录入流程</a>
                                    </if>
                                    <ul class="treeview-menu">
                                        <if condition="rolemenu(array('Zprocess/public_add'))">
                                            <li class="{:on('Zprocess/public_add')}"><a href="{:U('Zprocess/public_add')}"><i class="fa fa-angle-right"></i> 录入流程</a></li>
                                        </if>
                                        <if condition="rolemenu(array('Zprocess/public_setType'))">
                                            <li class="{:on('Zprocess/public_setType')}"><a href="{:U('Zprocess/public_setType')}"><i class="fa fa-angle-right"></i> 流程类型管理</a></li>
                                        </if>
                                    </ul>
                                </li>
                                <!--<li><a href="{:U('Zprocess/public_add')}"><i class="fa fa-angle-right"></i> 新建流程</a></li>
                                <li><a href="{:U('Zprocess/public_setType')}"><i class="fa fa-angle-right"></i> 流程类型管理</a></li>-->
                            </ul>
                        </li>

                        <!--<if condition="rolemenu(array('Op/index','Op/plans','Project/kind','Op/relpricelist'))">
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
                            </ul>
                        </li>
                        </if>-->


                        <!--<if condition="rolemenu(array('Product/index','Product/tpl','Product/line','Product/kind','Product/feedback','Project/lession','Project/fields','Project/types','Product/add_standard_product','Product/product_chart'))">
                        <li class="treeview {:on('Product')} {:on('Project')} {:on('Project/lession')} {:on('Project/fields')} {:on('Project/types')}">
                            <a href="javascript:;">
                                <i class="fa fa-globe"></i>
                                <span>产品管理</span>
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
                            </ul>
                        </li>
                        </if>-->

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
