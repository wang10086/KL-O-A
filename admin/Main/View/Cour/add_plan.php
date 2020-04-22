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
            <form method="post" action="{:U('Cour/add_plan')}" name="myform">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="id" value="{$list.id}">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">
                                    <div class="form-group col-md-12">
                                        <label>培训标题：</label><input type="text" name="info[title]" class="form-control" value="{$list.title}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>计划时间：</label><input type="text" name="info[time]" class="form-control inputdate" value="{$list.time}" required />
                                    </div>

                                    <!--<div class="form-group col-md-4">
                                        <label>所属流程：</label>
                                        <select  class="form-control"  name="info[processId]" id="processId"  required>
                                            <option value="" selected disabled>请先选择流程类型</option>
                                            <foreach name="processIds" key="k" item="v">
                                                <option value="{$k}" <?php /*if ($list['processId'] == $k) echo "selected"; */?>>{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>-->

                                    <div class="form-group col-md-4">
                                        <label>培训负责人：</label><font color="#999">(点击匹配到的人员)</font>
                                        <input type="text" name="info[blame_name]" value="{$list['blame_name']}" class="form-control" placeholder="培训负责人" id="blame_name" />
                                        <input type="hidden" name="info[blame_uid]" value="{$list['blame_uid']}" class="form-control" id="blame_uid" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>培训类型：</label><input type="text" name="info[day]" class="form-control" value="{$list.day}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>培训对象：</label><input type="text" name="info[time_data]" class="form-control" value="{$list.time_data}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>培训费用：</label><input type="text" name="info[OK_data]" class="form-control" value="{$list.OK_data}" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>培训方案：</label>
                                        <select  class="form-control"  name="info[before_remind]"  required>
                                            <option value=""></option>
                                           <!-- <option value="1">提醒</option>
                                            <option value="0">不提醒</option>-->
                                        </select>
                                    </div>

                                    <div class="form-group col-md-12"></div>

                                    <div id="formsbtn">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
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

