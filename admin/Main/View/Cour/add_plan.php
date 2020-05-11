<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_pagetitle_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                    <li class="active">{$_action_}</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">

                                    <form method="post" action="{:U('Cour/public_save_process')}" name="myForm" id="myForm">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="saveType" value="1">
                                        <input type="hidden" name="id" value="{$list.id}">
                                        <div class="form-group col-md-6">
                                            <label>培训标题：</label><input type="text" name="info[title]" class="form-control" value="{$list.title}" required />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>计划时间：</label><input type="text" name="info[in_time]" class="form-control inputdate" value="<?php echo $list['in_time'] ? date('Y-m-d',$list['in_time']) : ''; ?>" required />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>培训负责人：</label><font color="#999">(点击匹配到的人员)</font>
                                            <input type="text" name="info[blame_name]" value="{$list['blame_name']}" class="form-control" placeholder="培训负责人" id="blame_name" />
                                            <input type="hidden" name="info[blame_uid]" value="{$list['blame_uid']}" class="form-control" id="blame_uid" />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>培训类型：</label>
                                            <select  class="form-control"  name="info[process_id]" >
                                                <option value="">==请选择==</option>
                                                <foreach name="process_data" item="v">
                                                    <option value="{$v.id}" <?php if ($list['process_id']==$v['id']) echo "selected"; ?>>{$v.title}</option>
                                                </foreach>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>培训对象：</label><input type="text" name="info[obj]" class="form-control" value="{$list.obj}" required />
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>培训费用(元)：</label><input type="text" name="info[cost]" class="form-control" value="{$list.cost}" />
                                        </div>

                                        <div class="form-group col-md-12"></div>
                                    </form>

                                    <form action="{:U('Cour/public_save_process')}" method="post" id="submitForm">
                                        <input type="hidden" name="dosubmint" value="1">
                                        <input type="hidden" name="saveType" value="2">
                                        <input type="hidden" name="id" value="{$list.id}">
                                    </form>
                                    <div id="formsbtn">
                                        <button type="button" class="btn btn-info btn-lg" onclick="$('#myForm').submit()" id="lrpd">保存</button>
                                        <?php if ($list['id'] && in_array($list['status'],array(0,2))){ ?>
                                            <button type="button" class="btn btn-warning btn-lg" onclick="$('#submitForm').submit()" id="lrpd">提交</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
            </section><!-- /.content -->

        </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">
    const keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
        autocomplete_id('blame_name','blame_uid',keywords);
    })
</script>

