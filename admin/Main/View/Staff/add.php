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
            <li class="active">畅言一下</li>
        </ol>

        <div class="actlbox">
            <section class="content">
                <div class="row">
                    <!-- right column -->
                    <div class="col-md-12">
                        <!-- general form elements disabled -->
                        <form method="post" action="{:U('Staff/add')}" name="myform" id="myform">
                            <input type="hidden" name="dosubmit" value="1" />
                            <input type="hidden" name="token" value="{$token}">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">发布帖子</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="form-group col-md-12">
                                        <label>内容</label>
                                        <?php echo editor('content',$row['content']); ?>
                                    </div>

                                    <div class="form-group">&nbsp;</div>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="formsbtn">
                                <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                            </div>
                        </form>
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
		 
