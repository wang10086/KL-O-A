<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/public_sale')}"><i class="fa fa-gift"></i> {$_action_}</a></li>
                        <li class="active">{$list.title}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">

                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">销售支持计划</h3>
                                    <h3 class="box-title pull-right" style="font-weight:normal; color:#333333;">审核状态：{$audit_status[$list['status']]} &emsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                    	
                                        <div class="form-group col-md-12">
                                            <div class="form-group col-md-12">
                                                <label>活动标题：{$list.title}</label>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>销售支持类型：{$types[$list['type']]}</label>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>客户单位： {$list.customer}</label>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>开始时间：{$list.st_time|date='Y-m-d',###}</label>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>结束时间：{$list.et_time|date='Y-m-d',###}</label>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>活动负责人：{$list.blame_name}</label>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>计划费用(元)：{$list.cost}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php if ($list['status'] == 3 && in_array(cookie('userid'),array(1,11,$list['audit_uid']))){ ?>
                                <div class="box box-warning">
                                    <div class="box-header">
                                        <h3 class="box-title">审核</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="content">
                                            <form method="post" action="{:U('Customer/public_save_process')}" id="audit_form">
                                                <input type="hidden" name="dosubmint" value="1">
                                                <input type="hidden" name="saveType" value="4">
                                                <input type="hidden" name="id" value="{$list.id}">

                                                <div class="form-group box-float-12">
                                                    <label class="">审核意见：</label>
                                                    <input type="radio" name="status" value="1"> &#8194;审核通过 &#12288;&#12288;&#12288;
                                                    <input type="radio" name="status" value="2"> &#8194;审核不通过
                                                </div>

                                                <div class="form-group box-float-12">
                                                    <label>备注</label>
                                                    <textarea class="form-control" name="audit_remark"></textarea>
                                                </div>

                                                <div id="formsbtn">
                                                    <button type="button" class="btn btn-info btn-sm" onclick="$('#audit_form').submit()">保存</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div>
                            <?php } ?>


                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                    </form>
                </section><!-- /.content -->
                
            </aside><!-- /.right-side -->
			
  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">

	
</script>