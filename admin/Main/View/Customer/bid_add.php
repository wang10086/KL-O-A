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
                                        <form action="{:U('Customer/public_bid_add')}" method="post">
                                            <input type="hidden" name="dosubmint" value="1">
                                            <input type="hidden" name="id" value="{$list['id']}">
                                            <div class="form-group col-md-12">
                                                <label>投标项目：</label>
                                                <input type="text" name="info[title]" value="{$list['title']}" class="form-control" required />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>招标方：</label>
                                                <input type="text" name="info[customer]" value="{$list['customer']}" class="form-control" required />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>投标时间：</label>
                                                <input type="text" name="info[bid_time]" class="form-control inputdate" value="<if condition="$list['bid_time']">{$list.bid_time|date='Y-m-d',###}</if>" required />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>提交人：</label><font color="#999">(点击匹配到的人员)</font>
                                                <input type="text" name="info[blame_name]" value="<?php echo $list['blame_name'] ? $list['blame_name'] : cookie('username'); ?>" class="form-control" id="blame_name" />
                                                <input type="hidden" name="info[blame_uid]" value="<?php echo $list['blame_uid'] ? $list['blame_uid'] : cookie('userid'); ?>" class="form-control" id="blame_uid" />
                                            </div>

                                            <div class="form-group col-md-6 ">
                                                <label>投标费用(元)</label>
                                                <input type="text" name="info[cost]" value="{$list['cost']}" class="form-control" required />
                                            </div>

                                            <div id="formsbtn">
                                                <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                            </div>
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


