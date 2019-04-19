<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Kpi/crux')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                	<!--<div class="kjss">
                                    	<form action="" method="get" id="searchform">
                                        <input type="hidden" name="m" value="Main">
                                        <input type="hidden" name="c" value="Kpi">
                                        <input type="hidden" name="a" value="pdca">
                                        <input type="hidden" name="bkpr" id="bkpr" value="">
                                        <input type="hidden" name="kpr" id="kpr" value="">
                                    	<input type="text" name="month" class="form-control monthly" placeholder="月份" style="width:100px; margin-right:10px;" />
                                    	<input type="text" class="form-control keywords_bkpr" placeholder="被考评人"  style="width:180px; margin-right:10px;"/>
                                        <input type="text" class="form-control keywords_kpr" placeholder="考评人"  style="width:180px;"/>
                                        <button class="btn btn-info btn-sm" style="float:left;"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>-->
                                    <h3 class="box-title">
                                        {$_action_}
                                    </h3>
                                    <div class="box-tools pull-right">
                                    	 
                                         <if condition="rolemenu(array('Kpi/add_crux'))">
                                         <!--<a href="javascript:;" onclick="add_crux()" class="btn btn-sm btn-success" ><i class="fa fa-plus"></i> 添加关键事项</a>-->
                                         <a href="javascript:;" onclick="public_open('{:U('Kpi/add_crux')}','新建考核事项',800,400)" class="btn btn-sm btn-success" ><i class="fa fa-plus"></i> 添加关键事项</a>
                                         </if>
                                         
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
                                    <!--<div class="btn-group" id="catfont" style="padding-bottom:5px;">
										<?php /*if($prveyear>2019){ */?>
                                        <a href="{:U('Kpi/crux',array('year'=>$prveyear,'month'=>'01','show'=>$show))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                        <?php /*} */?>
                                        <?php
/*                                        for($i=1;$i<5;$i++){
                                            $par = array();
											$par['year']  = $year;
                                            $par['month'] = $year.str_pad($i,2,"0",STR_PAD_LEFT);
                                            $par['show']  = $show;
                                            if($month==$year.str_pad($i,2,"0",STR_PAD_LEFT)){
                                                echo '<a href="'.U('Kpi/crux',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'季度</a>';
                                            }else{
                                                echo '<a href="'.U('Kpi/crux',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'季度</a>';
                                            }
                                        }
                                        */?>
                                        <?php /*if($year<date('Y')){ */?>
                                        <a href="{:U('Kpi/crux',array('year'=>$nextyear,'month'=>'01','show'=>$show))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                        <?php /*} */?>
                                    </div>-->

                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th width="50" class="sorting" data="id">序号</th>
                                            <th width="" class="sorting" data="user_id">被考核人员</th>
                                            <th width="" class="sorting" data="cycle">考核周期</th>
                                            <th width="" class="sorting" data="title">考核事项</th>
                                            <th width="150" class="sorting" data="">相关月份</th>
                                            <th width="" class="sorting" data="">考核标准</th>
                                            <th width="80" class="sorting" data="">权重分</th>
                                            <th width="80" class="sorting" data="">考评得分</th>
                                            <if condition="rolemenu(array('Kpi/editcrux'))">
                                                <th width="50" class="taskOptions">编辑</th>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/scorecrux'))">
                                                <th width="50" class="taskOptions">评分</th>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/delcrux'))">
                                                <th width="50" class="taskOptions">删除</th>
                                            </if>
    
                                        </tr>
                                        <foreach name="lists" item="row"> 
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.user_name}</td>
                                            <td>{$row.cycle_stu}</td>
                                            <td><a href="javascript:;" onclick="public_open_nbutton('{$row.cruxinfo_url}','详情',800,500)">{$row.title}</a></td>
                                            <td>{$row.month}</td>
                                            <td>{$row.standard}</td>
                                            <td>{$row.weight}%</td>
                                            <td>{$row.score}</td>
                                            <if condition="rolemenu(array('Kpi/add_crux'))">
                                                <td class="taskOptions">
                                                    <if condition="$row['status'] eq 0">
                                                        <button onClick="public_open('{$row.addcrux_url}','编辑考核事项',800,400)" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                                    </if>
                                                </td>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/scorecrux'))">
                                                <td class="taskOptions">
                                                    <if condition="$row['status'] eq 0">
                                                        <button onClick="public_open('{$row.scorecrux_url}','关键事项评分',800,600)" title="评分" class="btn btn-info btn-sm"><i class="fa fa-check-circle-o"></i></button>
                                                    <else />
                                                        <button onClick="javascript:;" title="评分" class="btn btn-disable btn-sm"><i class="fa fa-check-circle-o"></i></button>
                                                    </if>
                                                </td>
                                            </if>
                                            <if condition="rolemenu(array('Kpi/delcrux'))">
                                                <td class="taskOptions"><button onClick="javascript:ConfirmDel('{$row.delcrux_url}','确定删除?')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button></td>
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


	<script>
    //新建关键事项
	function add_crux(id) {
		art.dialog.open('index.php?m=Main&c=Kpi&a=add_crux&id='+id,{
			lock:true,
			title: '新建考核事项',
			width:800,
			height:400,
			okValue: '提交',
			fixed: true,
			ok: function () {
				this.iframe.contentWindow.gosubmint();
				return false;
			},
			cancelValue:'取消',
			cancel: function () {
			}
		});	
	}


	//有确认/取消按钮
    function  public_open(url,title,width,height){
        art.dialog.open(url,{
            lock:true,
            title: title,
            width: width,
            height: height,
            okValue: '提交',
            fixed: true,
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }

    //无确认/取消按钮
    function  public_open_nbutton(url,title,width,height){
        art.dialog.open(url,{
            lock:true,
            title: title,
            width: width,
            height: height,
            fixed: true,
        });
    }

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
