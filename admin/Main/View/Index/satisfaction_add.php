<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>内部人员满意度</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">内部人员满意度</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">内部人员满意度</h3>
                                    <h3 class="box-title pull-right">
                                        <!--<span style="font-weight:normal; color:#ff3300;">被评分人：秦鸣</span>-->
                                    </h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <include file="satisfaction_add_content" />
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            
            
            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Work">
                <input type="hidden" name="a" value="record">
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="title" placeholder="标题">
                </div>
                
                
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="type">
                        <option value="0">选择类型</option>
                        <foreach name="kinds" item="v" key="k">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="status">
                        <option value="-1">状态</option>
                        <option value="0">正常</option>
                        <option value="1">已撤销</option>
                    </select>
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="month" placeholder="工作月份">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="uname" placeholder="工作人员">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="rname" placeholder="记录人员">
                </div>
                
                
                </form>
            </div>

<include file="Index:footer2" />
