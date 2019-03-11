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
                                    <h3 class="box-title">评分记录</h3>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',400,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <a href="{:U('Op/satisfaction_add')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 评分</a>
                                    </div>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="80" data="o.status">评分月份</th>
                                        <?php if ($has_rd == 1){ ?>     <!--有研发-->
                                        <th class="sorting" data="timely">培训</th>
                                        <th class="sorting" data="accord">标准化</th>
                                        <th class="sorting" data="cost">支持、指导</th>
                                        <th class="sorting" data="train">及时性</th>
                                        <th class="sorting" data="service">工作态度</th>
                                        <?php }else{ ?>     <!--无研发-->
                                        <th class="sorting" data="timely">及时性</th>
                                        <th class="sorting" data="accord">符合性</th>
                                        <th class="sorting" data="cost">成本控制</th>
                                        <th class="sorting" data="train">培训</th>
                                        <th class="sorting" data="service">服务态度</th>
                                        <?php } ?>
                                        <th class="sorting" data="account_name" width="300">评价内容</th>
                                        <th class="sorting" data="content">评分人员</th>
                                        <th class="sorting" data="create_time">评分时间</th>
                                        <if condition="rolemenu(array('Op/del_satisfaction'))">
                                        <th width="40" class="taskOptions">删除</th>
                                        </if> 
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions">{$row.monthly}</td>
                                        <td class="taskOptions">{$row.timely}</td>
                                        <td class="taskOptions">{$row.accord}</td>
                                        <td class="taskOptions">{$row.cost}</td>
                                        <td class="taskOptions">{$row.train}</td>
                                        <td class="taskOptions">{$row.service}</td>
                                        <td class="taskOptions"><div class="text-overflow-lines-300"><a href="javascript:;" onclick="show_detail({$row.id});">{$row.content}</a></div></td>
                                        <td class="taskOptions">{$row.account_name}</td>
                                        <td class="taskOptions">{$row.create_time|date="Y-m-d H:i:s",###}</td>

                                        <if condition="rolemenu(array('Op/del_satisfaction'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel(`<?php echo U('Op/del_satisfaction',array('id'=>$row['id'])); ?>`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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
                <input type="hidden" name="c" value="Op">
                <input type="hidden" name="a" value="satisfaction">
                
                <div class="form-group col-md-12"></div>
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="uname" placeholder="评分人">
                </div>
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="month" placeholder="评分月份：201901">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />

<script>
    function show_detail(id) {
        art.dialog.open('index.php?m=Main&c=Op&a=satisfaction_detail&id='+id,{
            lock:true,
            title: '客户满意度详情',
            width:800,
            height:'60%',
            fixed: true,

        });
    }

    /*function ConfirmDel(url,msg) {

        if(!msg){
            var msg = '真的要删除吗？';
        }

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function (msg) {
                window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }*/

</script>
