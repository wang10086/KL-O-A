<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_action_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;">{$_action_}</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('')}" name="myform" id="save_plans">
            <input type="hidden" name="dosubmint" value="1">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">
                                    <div class="form-group col-md-6">
                                        <label>标题：</label><input type="text" name="info[title]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>流程类型：</label>
                                        <select  class="form-control"  name="info[kind]" id="kind"  required>
                                            <option value="" selected disabled>请选择流程类型</option>
                                            <option value="{$v.id}" >{:tree_pad($v['level'], true)} LTC主干流程</option>
                                            <option value="{$v.id}" >{:tree_pad($v['level'], true)} IPD主干流程</option>
                                        </select>
                                    </div>

                                    <!--<div class="form-group col-md-6">
                                        <label>流程类型：</label>
                                        <select  class="form-control"  name="info[kind]" id="kind"  required>
                                            <option value="" selected disabled>请选择流程类型</option>
                                        </select>
                                    </div>-->

                                    <!--<div class="form-group col-md-4">
                                        <label>申请人：</label><input type="text" name="info[number]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>所在部门：</label><input type="text" name="info[number]" class="form-control" required />
                                    </div>-->

                                    <div class="form-group col-md-12">
                                        <label>备注：</label><textarea class="form-control"  name="info[context]" id="context"></textarea>
                                        <span id="contextTip"></span>
                                    </div>

                                    <!--<div class="form-group col-md-12">
                                        <div class="callout callout-danger">
                                            <h4>流程说明：</h4>
                                            <p>此数据根据选择流程种类自动获取说明信息!</p>
                                        </div>
                                    </div>-->

                                    <div class="form-group col-md-12">
                                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 上传附件</a>
                                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于10M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>

                                        <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                            <tr>
                                                <th align="left" width="">文件名称</th>
                                                <th align="left" width="100">大小</th>
                                                <th align="left" width="30%">上传进度</th>
                                                <th align="left" width="60">操作</th>
                                            </tr>

                                        </table>
                                        <div id="container" style="display:none;"></div>
                                    </div>

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
