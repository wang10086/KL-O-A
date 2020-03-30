<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header">
        <h1>
            {$_pagetitle_}
            <small>{$_action_}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{:U('Zprocess/public_index')}"><i class="fa fa-home"></i> 首页</a></li>
            <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
            <li class="active">{$_action_}</li>
        </ol>
    </section>

    <style>
        .padding0{padding: 0;}
        .box-left-3{border-right: 1px solid #999; min-height: 800px;}
        .box-left-title{height: 45px; line-height: 45px; border: 1px solid red; background-color: #f5f5f5;}
        .menu-title-lc{height: 40px; line-height: 40px; border: 1px solid red; margin-bottom: 0; margin-left: 5px; }

        .box-right-title{height: 80px; line-height: 80px; border: 1px solid red;}
        .box-right-fa{ font-size: 50px; color: #fff;  }
        .box-right-tit-logo{float: left; height: 100%; display: inline-block; border: 1px solid green;}
        .box-right-tit-logo .faspan{display: inline-block; height: 57px; line-height: 57px; width: 57px; background-color: #9031af; padding: 3px; border-radius: 5px; margin: 12px 0 0 5px;}
        .box-right-tit-p{}
    </style>

    <section class="content padding0">
        <!--<div class="row" style="border: 1px solid green; min-height: 500px;">-->
            <div class="col-md-12 padding0">
                <!--<div class="content"></div>-->
                <div class="col-md-3 box-left-3 padding0">
                    <div class="box-left-title">
                        <span style="font-weight: 500; font-size: 20px; margin-left: 5px;"><i class="fa fa-th-list"></i> <span style="margin-left: 3px;">全部类型</span></span>
                    </div>
                    <p class="menu-title-lc"> <i class="fa fa-caret-right"></i> 测试流程</p>
                    <p class="menu-title-lc"> <i class="fa fa-caret-right"></i> 测试流程</p>
                </div>

                <div class="col-md-9 padding0" style="min-height: 500px;">
                    <div class="box-right-title">
                        <div class="box-right-tit-logo" style="width: 6%">
                            <span class="faspan"><i class="fa fa-map-signs box-right-fa"></i></span>
                        </div>

                        <div class="box-right-tit-p" style="float: right; height: 100%; border: 1px solid blue; width: 94%; ">
                            <p style="font-size: 22px; height: 40px; line-height: 40px; margin: 0 0 0 5px; border: 1px solid red;">待办事宜</p>
                            <div style="height: 40px; line-height: 40px; border: 1px solid green; margin-left: 5px;">
                                <a href="javascript:;">全部(100)</a> &nbsp;|&nbsp;
                                <a href="javascript:;">未读(100)</a> &nbsp;|&nbsp;
                                <a href="javascript:;">反馈(100)</a> &nbsp;|&nbsp;
                                <a href="javascript:;">超时(100)</a> &nbsp;|&nbsp;
                                <a href="javascript:;">被督办(100)</a> &nbsp;

                                <div style="float: right; padding: 0 20px 0 0; clear: both;">
                                    <input type="button" class="btn btn-info btn-sm" style="width: 80px; margin-right: 20px;" value="批量处理">
                                    <input type="text" class="" style="height: 30px;" placeholder="搜索关键字">
                                    <input type="button" class="btn btn-default btn-sm" value="提交">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!--/.col (right) -->
        <!--</div>-->   <!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->


<include file="Index:footer2" />

