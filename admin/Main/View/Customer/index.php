<include file="Index:header2" />

<aside class="right-side">
    <!--<section class="content-header" style="padding: 5px">
        <include file="Index:ZcontentHeaderFile" />
    </section>-->

    <section class="content">
        <div class="row">
            <div class="col-md-12" style="overflow: hidden;">
                <div class="cus-div-left">
                    <div class="cus-box">
                        <div class="cus-box-title">宣传营销活动
                            <a href="javascript:;"><div class="cus-box-more">更多>></div></a>
                        </div>
                        <p class="cus-list">宣传营销活动宣传营销活动1 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">宣传营销活动宣传营销活动2 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">宣传营销活动宣传营销活动3 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">宣传营销活动宣传营销活动4 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">宣传营销活动宣传营销活动5 <span class="cus-list-time">2020-04-09</span></p>
                    </div>

                    <div class="cus-box">
                        <div class="cus-box-title">销售资料下载
                            <a href="javascript:;"><div class="cus-box-more"><a  href="javascript:;" onClick="moreCustomerFiles()">更多>></a></div></a>
                        </div>
                        <foreach name="customer_files" item="v">
                            <p class="cus-list"><?php if (in_array($v['id'],$msg_file_ids)){ echo "<span class='red'>*</span>"; } ?><a href="{$v.file_path}" target="_blank" onclick="read_file({$v.id},{$unread_type})"> {$v.file_name} </a> <span class="cus-list-time">{$v.create_time|date='Y-m-d',###}</span></p>
                        </foreach>
                        <!--<p class="cus-list">销售资料下载销售资料下载1 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售资料下载销售资料下载2 <span class="cus-list-time">2020-04-09</span></p>-->
                    </div>

                    <div class="cus-box">
                        <div class="cus-box-title">销售签约信息
                            <a href="javascript:;"><div class="cus-box-more">更多>></div></a>
                        </div>
                        <p class="cus-list">销售签约信息销售签约信息1 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售签约信息销售签约信息2 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售签约信息销售签约信息3 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售签约信息销售签约信息4 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售签约信息销售签约信息5 <span class="cus-list-time">2020-04-09</span></p>
                    </div>
                </div>
                <div class="cus-div-right">
                    <div class="cus-box">
                        <div class="cus-box-title">媒体宣传报道
                            <a href="javascript:;"><div class="cus-box-more">更多>></div></a>
                        </div>
                        <p class="cus-list">媒体宣传报道媒体宣传报道1 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">媒体宣传报道媒体宣传报道2 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">媒体宣传报道媒体宣传报道3 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">媒体宣传报道媒体宣传报道4 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">媒体宣传报道媒体宣传报道5 <span class="cus-list-time">2020-04-09</span></p>
                    </div>

                    <div class="cus-box">
                        <div class="cus-box-title">成功客户案例
                            <a href="javascript:;"><div class="cus-box-more">更多>></div></a>
                        </div>
                        <p class="cus-list">成功客户案例成功客户案例1 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">成功客户案例成功客户案例2 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">成功客户案例成功客户案例3 <span class="cus-list-time">2020-04-09</span></p>
                        <!--<p class="cus-list">成功客户案例成功客户案例4 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">成功客户案例成功客户案例5 <span class="cus-list-time">2020-04-09</span></p>-->
                    </div>

                    <div class="cus-box">
                        <div class="cus-box-title">销售技巧能力分享
                            <a href="javascript:;"><div class="cus-box-more">更多>></div></a>
                        </div>
                        <p class="cus-list">销售技巧能力分享销售技巧能力分享1 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售技巧能力分享销售技巧能力分享2 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售技巧能力分享销售技巧能力分享3 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售技巧能力分享销售技巧能力分享4 <span class="cus-list-time">2020-04-09</span></p>
                        <p class="cus-list">销售技巧能力分享销售技巧能力分享5 <span class="cus-list-time">2020-04-09</span></p>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <div class="pagestyle">{$pages}</div>
                </div>


            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->


<include file="Index:footer2" />

<script type="text/javascript">
    //更多销售资料下载
    function moreCustomerFiles() {
        art.dialog.open('<?php echo U('Customer/moreCustomerFiles'); ?>',{
            lock:true,
            title: '销售资料下载',
            width:1000,
            height:500,
            okVal: '提交',
            fixed: true,
            ok: function () { },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }

    function read_file(id,unread_type) {
        $.ajax({
            type: "POST",
            url : "{:U('Ajax/read_file')}",
            dataType : 'JSON',
            data: {id:id,unread_type:unread_type},
            success(){},
            error(){}
        })
    }
</script>
