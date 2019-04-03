<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        项目分部门汇总
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> 数据统计</a></li>
                        <li class="active">项目分部门汇总</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">

                                    <div class="box-tools btn-group" id = "chart_btn_group">
                                        <a href="{:U('Chart/department',array('pin'=>0,'year'=>$year,'month'=>$month))}" class="btn btn-sm <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">预算及结算分部门汇总</a>
                                        <a href="{:U('Chart/department',array('pin'=>1,'year'=>$year,'month'=>$month))}" class="btn btn-sm <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-group-header';} ?>">已结算分部门汇总</a>
                                    </div>
                                    <!--<div class="box-tools pull-right">
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',800,160);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>-->
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="btn-group" id="catfont" style="padding-bottom:5px;">
                                        <?php if($prveyear>2016){ ?>
                                            <a href="{:U('Chart/department',array('year'=>$prveyear,'month'=>$month,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php } ?>
                                        <?php
                                        for($i=1;$i<13;$i++){
                                            if($year.$month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Chart/department',array('year'=>$year,'month'=>$i,'pin'=>$pin)).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                            }else{
                                                echo '<a href="'.U('Chart/department',array('year'=>$year,'month'=>$i,'pin'=>$pin)).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                            }
                                        }
                                        ?>
                                        <?php if($year<date('Y')){ ?>
                                            <a href="{:U('Chart/department',array('year'=>$nextyear,'month'=>$month,'pin'=>$pin))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php } ?>
                                    </div>
                                    <?php if ($pin==1){ ?>
                                        <p>提示：以下累计数据从{$year-1}年12月26日起已完成结算项目中采集</p>
                                    <?php }else{ ?>
                                        <p>提示：以下累计数据从{$year-1}年12月26日起已审批预算和已完成结算项目中采集</p>
                                    <?php } ?>
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr>
                                        <th class="sorting" style="text-align: center;" rowspan="2">部门</th>
                                        <th colspan="5" style="text-align: center;">{$year}年累计</th>
                                        <th colspan="5" style="text-align: center;">{$month}月累计</th>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions" data="">项目数</td>
                                        <td class="taskOptions" data="">人数</td>
                                        <td class="taskOptions" data="">收入合计</td>
                                        <td class="taskOptions" data="">毛利合计</td>
                                        <td class="taskOptions" data="">毛利率(%)</td>
                                        <td class="taskOptions" data="">项目数</td>
                                        <td class="taskOptions" data="" width="">人数</td>
                                        <td class="taskOptions" data="">收入合计</td>
                                        <td class="taskOptions" data="">毛利合计</td>
                                        <td class="taskOptions" data="">毛利率(%)</td>
                                    </tr>
                                    <foreach name="lists" item="row"> 
                                    <tr>
                                        <td class="taskOptions">{$row.depname}</td>
                                        <td class="taskOptions">{$row.yearxms}</td>
                                        <td class="taskOptions">{$row.yearrenshu}</td>
                                        <td class="taskOptions">{$row.yearzsr}</td>
                                        <td class="taskOptions">{$row.yearzml}</td>
                                        <td class="taskOptions">{$row.yearmll}</td>
                                        <td class="taskOptions">{$row.monthxms}</td>
                                        <td class="taskOptions">{$row.monthrenshu}</td>
                                        <td class="taskOptions">{$row.monthzsr}</td>
                                        <td class="taskOptions">{$row.monthzml}</td>
                                        <td class="taskOptions">{$row.monthmll}</td>
                                        <!--<if condition="rolemenu(array('Op/delpro'))">
                                        <td class="taskOptions">
                                        <button onClick="javascript:has_jiekuan('{$row.op_id}','{$row.id}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                        </td>
                                        </if>-->
                                    </tr>
                                    </foreach>
                                    <tr>
                                        <td class="taskOptions black" data="">地接合计</td>
                                        <td class="taskOptions black" data="">{$dj_heji.yearxms}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.yearrenshu}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.yearzsr}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.yearzml}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.yearmll}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.monthxms}</td>
                                        <td class="taskOptions black" data="" width="">{$dj_heji.monthrenshu}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.monthzsr}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.monthzml}</td>
                                        <td class="taskOptions black" data="">{$dj_heji.monthmll}</td>
                                    </tr>
                                    <tr>
                                        <td class="taskOptions black" data="">合计</td>
                                        <td class="taskOptions black" data="">{$heji.yearxms}</td>
                                        <td class="taskOptions black" data="">{$heji.yearrenshu}</td>
                                        <td class="taskOptions black" data="">{$heji.yearzsr}</td>
                                        <td class="taskOptions black" data="">{$heji.yearzml}</td>
                                        <td class="taskOptions black" data="">{$heji.yearmll}</td>
                                        <td class="taskOptions black" data="">{$heji.monthxms}</td>
                                        <td class="taskOptions black" data="" width="">{$heji.monthrenshu}</td>
                                        <td class="taskOptions black" data="">{$heji.monthzsr}</td>
                                        <td class="taskOptions black" data="">{$heji.monthzml}</td>
                                        <td class="taskOptions black" data="">{$heji.monthmll}</td>
                                    </tr>
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
                <input type="hidden" name="a" value="index">
                <input type="hidden" name="pin" value="{$pin}">
                
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="项目名称">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="id" placeholder="编号">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="oid" placeholder="团号">
                </div>
                
                 <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="dest" placeholder="目的地">
                </div>
                
                
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="status">
                        <option value="-1">成团状态</option>
                        <option value="0">未成团</option>
                        <option value="1">已成团</option>
                    </select>                   
                </div>
                
                <div class="form-group col-md-4">
                    <select  class="form-control"  name="as">
                         <option value="-1">状态</option>
                        <option value="0">未审批</option>
                        <option value="1">通过审批</option>
                        <option value="2">未通过审批</option>
                    </select>                   
                </div>
                
                <div class="form-group col-md-4">
                    <select class="form-control" name="kind">
                        <option value="">项目类型</option>
                        <foreach name="kinds" key="k"  item="v">
                        <option value="{$k}">{$v}</option>
                        </foreach>
                    </select>
                </div>
               	
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="ou" placeholder="立项人">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="jd" placeholder="计调">
                </div>
                
                <div class="form-group col-md-4">
                    <input type="text" class="form-control" name="su" placeholder="销售">
                </div>
                
                </form>
            </div>

<include file="Index:footer2" />

<script>
    function has_jiekuan(opid,id) {
        $.ajax({
            type: 'post',
            url : "{:U('Ajax/has_jiekuan')}",
            dataType : "JSON",
            data : {opid:opid,id:id},
            success: function (data) {
                ConfirmDel(data.url,data.msg);
            }
        })
    }

    function ConfirmDel(url,msg) {
        /*
         if (confirm("真的要删除吗？")){
         window.location.href=url;
         }else{
         return false;
         }
         */

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
