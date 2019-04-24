<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        内部顾客满意度
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li class="active">内部顾客满意度</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">内部顾客满意度</h3>
                                    <!--<div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>-->
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"> &nbsp;&nbsp;被评价人：{$lists[0]['account_name']}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions" width="80">月份</th>
                                        <th class="taskOptions" width="80">评分人员</th>
                                        <th class="taskOptions" width="80">综合得分</th>
                                        <?php if ($dimension['AA']){ ?><th class="taskOptions" width="80">{$dimension.AA}</th><?php } ?>
                                        <?php if ($dimension['BB']){ ?><th class="taskOptions" width="80">{$dimension.BB}</th><?php } ?>
                                        <?php if ($dimension['CC']){ ?><th class="taskOptions" width="80">{$dimension.CC}</th><?php } ?>
                                        <?php if ($dimension['DD']){ ?><th class="taskOptions" width="80">{$dimension.DD}</th><?php } ?>
                                        <?php if ($dimension['EE']){ ?><th class="taskOptions" width="80">{$dimension.EE}</th><?php } ?>
                                        <th class="taskOptions">评论内容</th>
                                        <if condition="rolemenu(array('Inspect/del_satisfaction'))">
                                        <th class="taskOptions" width="80">删除</th>
                                        </if>
                                    </tr>

                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions">{$row.monthly}</td>
                                        <td class="taskOptions">{$row.input_username}</td>
                                        <td class="taskOptions">{$row.average}</td>
                                        <?php if ($dimension['AA']){ ?><td class="taskOptions">{$row.AA}</td><?php } ?>
                                        <?php if ($dimension['BB']){ ?><td class="taskOptions">{$row.BB}</td><?php } ?>
                                        <?php if ($dimension['CC']){ ?><td class="taskOptions">{$row.CC}</td><?php } ?>
                                        <?php if ($dimension['DD']){ ?><td class="taskOptions">{$row.DD}</td><?php } ?>
                                        <?php if ($dimension['EE']){ ?><td class="taskOptions">{$row.EE}</td><?php } ?>
                                        <td class="taskOptions">{$row.content}</td>

                                        <if condition="rolemenu(array('Inspect/del_satisfaction'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:ConfirmDel(`<?php echo U('Inspect/del_satisfaction',array('id'=>$row['id'])); ?>`)" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
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

<include file="Index:footer2" />

<script type="text/javascript">
    function ConfirmDel(url,msg) {

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

     }
</script>
