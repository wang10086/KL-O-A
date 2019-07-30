		<include file="Index:header" />
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
           
            <include file="Index:menu" />

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$pagetitle}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 导游辅导员</a></li>
                        <li class="active">{$pagetitle}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                   

                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                         <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$title}</h3>
                                    <!--<div class="pull-right box-tools">
                                        <button class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,160);"><i class="fa fa-search"></i> 搜索</button>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <?php if($type==3){ ?>
                                        <div class="btn-group" id="catfont">
                                            <a href="{:U('GuideRes/public_company_timely_detail',array('year'=>$year,'month'=>$month,'tit'=>$title,'type'=>3,'pin'=>1))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">应培训项目</a>
                                            <a href="{:U('GuideRes/public_cour_pptlist',array('year'=>$year,'month'=>$month,'tit'=>$title,'type'=>3,'pin'=>2))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">培训列表</a>
                                        </div>
                                    <?php } ?>

                                    <table class="table table-bordered dataTable fontmini" id="tablelist"  style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                        	<th class="sorting" data="id" width="60">编号</th>
                                            <th class="sorting" data="ppt_title">标题</th>
                                            <th class="sorting" data="lecture_date" width="100">培训日期</th>
                                            <th class="sorting" data="lecturer_uname" width="100">培训者</th>
                                            <th class="sorting" data="create_time" width="110">创建时间</th>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td><a href="javascript:;">{$row.ppt_title}</a></td>
                                            <td><?php echo $row['lecture_date'] ? date('Y-m-d',$row['lecture_date']) : ''; ?></td>
                                            <td>{$row.lecturer_uname}</td>
                                            <td><if condition="$row['create_time']">{$row.create_time|date='y-m-d H:i',###}</if></td>
                                        </tr>
                                        </foreach>		
                                        
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                            
                        </div><!-- right col -->
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->
		
        <div id="searchtext">
            <form action="" method="get" id="searchform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="GuideRes">
            <input type="hidden" name="a" value="public_cour_pptlist">
            
            <div class="form-group col-md-12">
                 <input type="text" name="keywords" placeholder="关键字" class="form-control">
            </div>
            
            </form>
        </div>

        <include file="Index:footer" />
        
        