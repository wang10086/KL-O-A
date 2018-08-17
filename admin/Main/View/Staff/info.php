<include file="header" />

<script>
    $(function(){
        $('#myform').hide();

    })
</script>

<style>
.straff-tit{font-weight: 600;}
    .mb0{margin-bottom: 0}
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
                                    <div class="form-group col-md-12 mb0">
                                        <label class="straff-tit">帖子详情</label>
                                        {$list.content}
                                    </div>

                                    <div class="note-info">
                                        <span class="note-xq ml20">作者：匿名游客</span>
                                        |<span class="note-xq ml10">发布时间：{$list.send_time|date='Y-m-d H:i:s',###}</span>
                                        | <span class="note-xq ml10">点赞：<a href="javascript:;" id="zan-logo_{$list.id}" onclick="zan({$list.id})"><i class="fa fa-thumbs-o-up"></i></a></span>
                                        | <span class="note-xq ml10"><a href="javascript:;" onclick="show_form()">回复</a></span>
                                    </div>


                                    <form method="post" action="{:U('Staff/save_staff')}" name="myform" id="myform">
                                        <input type="hidden" name="dosubmit" value="1" />
                                        <input type="hidden" name="token" value="{$token}">
                                        <input type="hidden" name="id" value="{$list.id}">
                                        <div class="form-group col-md-12">
                                            <label class="straff-tit">回复内容</label>
                                            <?php echo editor('content',''); ?>
                                        </div>

                                        <div id="formsbtn">
                                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                        </div>
                                    </form>


                                    <div class="form-group col-md-12" id="box">
                                        <label class="straff-tit">回帖信息</label>
                                        <foreach name="huifu" key="k" item="v">
                                            <div class="form-group col-md-12 mb0">
                                               {$k+1}、<span style="display: inline-block;">{$v.content}</span>
                                            </div>

                                            <div class="note-info" class="nei">
                                                <span class="note-xq ml20">作者：匿名游客</span>
                                                |<span class="note-xq ml10">发布时间：{$v.send_time|date='Y-m-d H:i:s',###}</span>
                                                | <span class="note-xq ml10">点赞：<a href="javascript:;" id="zan-logo_{$v.id}" onclick="zan({$v.id})"><i class="fa fa-thumbs-o-up"></i></a></span>
                                                <!--| <span class="note-xq ml10"><a href="javascript:;" onclick="show_form()">回复</a></span>-->
                                            </div>
                                        </foreach>
                                    </div>

                                    <!--<a href="javascript:void(0)" class="showa">展开</a>-->

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

    function zan(i){
        var a = $('#zan-logo_'+i).html();
        var b = '<i class="fa fa-thumbs-o-up"></i>';
        var id= i;

        if(a == b){
            $.ajax({
                type:"POST",
                url:"{:U('Ajax/staff')}",
                data:{id:id},
                success:function(msg){
                    if(msg){
                        $('#zan-logo_'+i).html('<i class="fa fa-thumbs-up"></i>');
                    }else{
                       alert('点赞失败');
                    }

                }
            })
        }else{

            $('#zan-logo_'+i).html('<i class="fa fa-thumbs-up"></i>');
        }
    }

    //更多,收起
    $(document).ready(function(){
        var oHeight = $('.nei').height();//获取里面div的高度
        oldHeight=oHeight;//把里面div的高度赋值给外面的div
        var newHeight = $("#box").css({height:"100px"});//这个是加载后给外面div设置的一个高度(显示内容的区域)
        if(oHeight<100){//如果里面div的高度小于100的话也就是说内容不多的时候把更多按钮隐藏
            $('.showa').css('display','none')
        }
        $(".showa").click(function(){
            if(parseInt($("#box").height())==oldHeight){
                $("#box").animate({height:"100px"});
                $(this).html("展开");
            }else{
                $("#box").animate({height:oldHeight});
                $(this).html("收起");
            }
        });
    });
</script>
		 
