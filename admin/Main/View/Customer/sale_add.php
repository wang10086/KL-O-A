<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/bid')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box box-success mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <form action="{:U('Customer/public_sale_add')}" method="post">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="id" value="{$list['id']}">
                                            <div class="form-group col-md-12">
                                                <label>销售支持标题：</label>
                                                <input type="text" name="info[title]" value="{$list['title']}" class="form-control" required />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>销售支持类型：</label>
                                                <select name="info[type]" class="form-control">
                                                    <foreach name="types" key="k" item="v">
                                                        <option value="{$k}" <?php if ($list['type']==$k) echo "selected"; ?>>{$v}</option>
                                                    </foreach>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>客户单位：</label>
                                                <input type="text" class="form-control" name="info[customer]" value="{$list.customer}" list="customer" />
                                                <datalist id="customer">
                                                    <foreach name="customers" key="k" item="v">
                                                        <option value="{$v}" label="">
                                                    </foreach>
                                                </datalist>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>申请人：</label><font color="#999">(点击匹配到的人员)</font>
                                                <input type="text" name="info[blame_name]" value="<?php echo $list['blame_name'] ? $list['blame_name'] : cookie('nickname'); ?>" class="form-control" id="blame_name" />
                                                <input type="hidden" name="info[blame_uid]" value="<?php echo $list['blame_uid'] ? $list['blame_uid'] : cookie('userid'); ?>" class="form-control" id="blame_uid" />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>开始时间：</label>
                                                <input type="text" name="info[st_time]" class="form-control inputdate" value="<if condition="$list['st_time']">{$list.st_time|date='Y-m-d',###}</if>" required />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>结束时间：</label>
                                                <input type="text" name="info[et_time]" class="form-control inputdate" value="<if condition="$list['et_time']">{$list.et_time|date='Y-m-d',###}</if>" required />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>计划费用：</label>
                                                <input type="text" name="info[cost]" class="form-control" value="{$list.cost}" />
                                            </div>

                                            <div id="formsbtn">
                                                <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                                <?php if ($list && in_array($list['status'],array(0,2))){ ?>
                                                <button type="button" onclick="$('#submitForm').submit()" class="btn btn-warning btn-lg" id="lrpd">提交</button>
                                                <?php } ?>
                                            </div>
                                        </form>

                                        <form method="post" action="{:U('Customer/public_save_process')}" name="myform" id="submitForm">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="saveType" value="3">
                                            <input type="hidden" name="id" value="{$list.id}">
                                        </form>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                     </div>

                </section>
            </aside>

<include file="Index:footer2" />

<script type="text/javascript">
    const keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
        autocomplete_id('blame_name','blame_uid',keywords);
    })

</script>


