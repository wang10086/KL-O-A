<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>最低毛利率</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">最低毛利率</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <!--<div class="btn-group" id="catfont" style="padding-bottom:20px;">
                                <?php /*if($prveyear>2018){ */?>
                                    <a href="{:U('Sale/gross',array('year'=>$prveyear))}" class="btn btn-default" style="padding:8px 18px;">上一年</a>
                                <?php /*} */?>
                                <?php
/*                                    for($i=2018;$i<=date('Y');$i++){
                                        $par            = array();
                                        $par['year']    = $i;
                                        if($year==$i){
                                            echo '<a href="'.U('Sale/gross',$par).'" class="btn btn-info" style="padding:8px 18px;">'.$i.'月</a>';
                                        }else{
                                            echo '<a href="'.U('Sale/gross',$par).'" class="btn btn-default" style="padding:8px 18px;">'.$i.'月</a>';
                                        }
                                    }
                                */?>
                                <?php /*if($year<date('Y')){ */?>
                                    <a href="{:U('Sale/gross',array('year'=>$nextyear))}" class="btn btn-default" style="padding:8px 18px;">下一年</a>
                                <?php /*} */?>
                            </div>-->

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">最低毛利率</h3>
                                    <div class="box-tools pull-right"></div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                        <tr role="row" class="orders" >
                                            <th class="taskOptions" width="" data="">业务类型</th>
                                            <th class="taskOptions" width="" data="">最低毛利率</th>
                                            <th class="taskOptions" width="" data="">录入时间</th>
                                            <if condition="rolemenu(array('Sale/order_viwe'))">
                                                <th width="80" class="taskOptions">编辑</th>
                                            </if>
                                        </tr>
                                        <foreach name="lists" item="row">
                                        <tr>
                                            <td class="taskOptions">{$row.name}</td>
                                            <td class="taskOptions">{$row.gross}</td>
                                            <td class="taskOptions"><?php if ($row['input_time']){ echo date('Y-m-d H:i:s',$row['input_time']); }?></td>
                                            <td class="taskOptions">
                                                <a href="javascript:;" onclick="open_edit_gross(`{:U('Sale/edit_gross',array('kid'=>$row['id']))}`)" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            </td>
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
    function open_edit_gross (obj) {
        art.dialog.open(obj, {
            lock:true,
            //id:'form-gross',
            title: '最低毛利率',
            width:600,
            height:350,
            okValue: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                //top.art.dialog({id:"form-gross"}).close();
                setTimeout("window.location.href='{:U('Sale/gross')}'",500);
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }
</script>
