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
                            <div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php if($prveyear>2018){ ?>
                                    <a href="{:U('Inspect/satisfaction',array('year'=>$prveyear,'yearMonth'=>$yearMonth))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php } ?>
                                <?php
                                    for($i=1;$i<13;$i++){
                                        if (strlen($i)<2){ $i = str_pad($i,2,'0',STR_PAD_LEFT);}
                                        $par                = array();
                                        $par['year']        = $year;
                                        $par['month']       = $i;
                                        $par['yearMonth']   = $year.$i;
                                        if($month==$i){
                                            echo '<a href="'.U('Inspect/satisfaction',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Inspect/satisfaction',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                ?>
                                <?php if($year<date('Y')){ ?>
                                    <a href="{:U('Inspect/satisfaction',array('year'=>$nextyear,'yearMonth'=>$yearMonth))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php } ?>
                            </div>

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">评分记录</h3>
                                    <div class="box-tools pull-right">
                                        <!--<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',400,160);"><i class="fa fa-search"></i> 搜索</a>-->
                                        <?php /*if (in_array(date('d'),array(20,21,22,23,24))){ */?><!--
                                            <a href="{:U('Inspect/satisfaction_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 评分</a>
                                        <?php /*}else{ */?>
                                            <a href="javascript:;" onclick="art_show_msg('请于每月20至24日进行内部人员满意度评分')" class="btn btn-sm btn-default"><span style="color: grey"><i class="fa fa-plus"></i>评分</span></a>
                                        --><?php /*} */?>
                                        <a href="{:U('Inspect/satisfaction_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 评分</a>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="form-group col-md-12 mt10">
                                    <div class="callout callout-danger mb-0">
                                        <h4>提示！</h4>
                                        <p>1、为避免影响您的综合得分，请关注“未评价人员”一栏，如显示人员名单，请及时联系对方给您评分；逾期未评分，对未评分部分将默认按50%得分取值!</p>
                                    </div>
                                </div>

                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="80">评分月份</th>
                                        <th class="taskOptions">被评分人</th>
                                        <th class="taskOptions">综合得分</th>
                                        <th class="taskOptions" width="300">已评价人员</th>
                                        <th class="taskOptions">未评价人员</th>
                                        <if condition="rolemenu(array('Inspect/satisfaction_detail'))">
                                            <th width="80" class="taskOptions">得分详情</th>
                                        </if>
                                        <if condition="rolemenu(array('Inspect/satisfaction_info'))">
                                            <th width="80" class="taskOptions">评价详情</th>
                                        </if>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions">{$yearMonth}</td>
                                        <td class="taskOptions">{$row.account_name}</td>
                                        <td class="taskOptions">{$row.sum_average}</td>
                                        <td class="taskOptions">{$row.score_accounts}</td>
                                        <td class="taskOptions">{$row.unscore_users}</td>
                                        <if condition="rolemenu(array('Inspect/satisfaction_detail'))">
                                            <td class="taskOptions"><button onClick="javascript:show_detail({$row.account_id},{$row.monthly});" title="得分详情" class="btn btn-info btn-smsm"><i class="fa fa-search-plus"></i></button></td>
                                        </if>
                                        <if condition="rolemenu(array('Inspect/satisfaction_info'))">
                                            <td class="taskOptions">
                                                <?php if (in_array(session('userid'),array(1,11))){ ?>
                                                <a href="{:U('Inspect/satisfaction_info',array('uid'=>$row['account_id'],'month'=>$row['monthly']))}" title="评价详情" class="btn btn-info btn-smsm"><i class="fa fa-bars"></i></a>
                                                <?php } ?>
                                            </td>
                                        </if>
                                    </tr>
                                    </foreach>					
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
            
            
            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Inspect">
                <input type="hidden" name="a" value="satisfaction">
                
                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="uname" placeholder="被评分人">
                </div>
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="month" placeholder="评分月份：201901">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />

<script>
    //得分详情
    function show_detail(uid,month) {
        art.dialog.open('index.php?m=Main&c=Inspect&a=satisfaction_detail&uid='+uid+'&month='+month,{
            lock:true,
            title: '得分详情',
            width:600,
            height:400,
            fixed: true,

        });
    }

    //评价详情
    function show_info(uid,month) {
        art.dialog.open('index.php?m=Main&c=Inspect&a=satisfaction_info&uid='+uid+'&month='+month,{
            lock:true,
            title: '评价详情',
            width:800,
            height:'60%',
            fixed: true,

        });
    }

</script>
