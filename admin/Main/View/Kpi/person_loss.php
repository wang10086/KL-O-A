<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$title}
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><i class="fa fa-gift"></i> {$title}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">

                            <div class="btn-group" id="catfont"  style="padding-bottom:20px;">
                                <a href="{:U('Kpi/public_person_loss',array('pin'=>1,'st'=>$st,'et'=>$et))}" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">公司员工</a>
                                <a href="{:U('Kpi/public_person_loss',array('pin'=>2,'st'=>$st,'et'=>$et))}" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">流失员工</a>
                                <!--<a href="javascript:;" onclick="show_person_loss({$st},{$et})" class="btn btn-default">流失率</a>-->
                            </div>

                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">{$title}</h3>
                                    <h3 class="box-title pull-right green">被考核人员：王茜</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <div class="content black" style="margin-bottom: -30px;">
                                    <div class="form-group col-md-4">
                                        <p>公司人数：{$data.sum_num}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p>流失人数：{$data.loss_num}</p>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p>员工流失率：{$data.complete}</p>
                                    </div>
                                </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="taskOptions">姓名</th>
                                        <th class="taskOptions">员工类别</th>
                                        <th class="taskOptions">状态</th>
                                        <th class="taskOptions">是否被开除</th>
                                    </tr>
                                    <?php if ($pin==1){ ?>
                                    <foreach name="data['sum_lists']" item="row">
                                        <tr class="taskOptions">
                                            <td>{$row.nickname}</td>
                                            <td>{$formal_stu[$row['formal']]}</td>
                                            <td>{$status_stu[$row['status']]}</td>
                                            <td>{$expel_stu[$row['expel']]}</td>
                                        </tr>
                                    </foreach>
                                    <?php } ?>
                                    <?php if ($pin==2){ ?>
                                    <foreach name="data['loss_lists']" item="row">
                                        <tr  class="taskOptions">
                                            <td>{$row.nickname}</td>
                                            <td>{$formal_stu[$row['formal']]}</td>
                                            <td>{$status_stu[$row['status']]}</td>
                                            <td>{$expel_stu[$row['expel']]}</td>
                                        </tr>
                                    </foreach>
                                    <?php } ?>
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
    $(function () {
        var pin     = <?php echo $pin?$pin:0; ?>;
    })

    function show_person_loss(st,et) {
        art.dialog.open('index.php?m=Main&c=Kpi&a=public_person_loss_detail&st='+st+'&et='+et+'',{
            lock:true,
            title: '人员流失率详情',
            width:500,
            height:200,
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
</script>
