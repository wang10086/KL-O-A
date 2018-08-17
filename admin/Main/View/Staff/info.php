<include file="header" />
<style>

</style>
<div class="staff">
    <div class="staff-con" style="background-color:  #eeeeee;">
        <div class="img-header">
            <img src="__HTML__/img/staff-header.png"  width="100%" height="100%">
        </div>

        <ol class="breadcrumb">
            <li><a href="{:U('Index/login')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="{:U('staff/index')}"><i class="fa fa-gift"></i> 员工心声</a></li>
            <li class="active">详情</li>
        </ol>

        <div class="actlbox">
            <section class="content">
                <div class="row">
                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- general form elements disabled -->

                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">发布帖子</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="form-group col-md-12">
                                        <label>帖子详情</label>
                                        {$list.content}
                                    </div>

                                    <div class="note-info">
                                        <span class="note-xq ml20">作者：匿名游客</span>
                                        |<span class="note-xq ml10">发布时间：{$v.send_time|date='Y-m-d H:i:s',###}</span>
                                        | <span class="note-xq ml10">点赞：<i class="fa fa- thumbs-o-up"></i></span>
                                        | <span class="note-xq ml10"><a href="javascript:;" onclick="show_form()">回复</a></span>
                                    </div>


                                    <form method="post" action="{:U('Staff/add')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="token" value="{$token}">
                                        <div class="form-group col-md-12">
                                            <label>回复内容</label>
                                            <?php echo editor('content',''); ?>
                                        </div>

                                        <div id="formsbtn">
                                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                        </div>
                                    </form>


                                    <div class="form-group">&nbsp;</div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
            </section><!-- /.content -->

        </div>

        <div class="actrbox">

            <div class="unrel mt20">
                <div class="reltit">
                    <h2> &nbsp;热门帖子</h2>
                </div>
                <div class="cont ml10">
                    <ul>
                        <foreach name="hot_tiezi" item="v">
                            <li><a href="{:U('staff/info',array('id'=>$v['id']))}">{$v.content}</a> <span class="note-time ">发布时间：{$v.send_time|date='Y-m-d H:i:s',###}</span></li>
                        </foreach>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>

<include file="footer" />

<script>
    $(function(){
        $('#myform').hide();
    })

    function show_form(){
        $('#myform').show();
    }
</script>
		 
