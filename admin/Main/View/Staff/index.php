<include file="header" />

<div class="staff">
    <div class="staff-con" style="background-color:  #eeeeee;">
        <div class="img-header">
            <img src="__HTML__/img/staff-header.png"  width="100%" height="100%">
        </div>

        <div class="actlbox">
            <div class="con-header">
                <h4 class="notice-tit">温馨提示 :</h4>
                <p class="ml20">1.本贴吧采用不记名方式！不记名方式！不记名方式！ </p>
                <p class="ml20">2.如果您在工作或生活中遇到任何愉快(或不愉快)的事情,欢迎来此吐槽 ! </p>
                <p class="ml20">3.本贴吧只在公司网络环境下有效！ </p>
            </div>

            <foreach name="list" item="v">
                <div class="lbox">
                    <?php if (time()-$v['send_time']<5*24*3600){ ?>
                        <img src="__HTML__/img/new.png" width="30rem"  alt="">
                    <?php } ?>
                    <span class="staff-name">『 {$v.username} 』</span>:
                    <a href="{:U('staff/info',array('id'=>$v['id']))}"><span class="note-con"><?php $v['title']?$v['title']:$v['content']; ?></span></a>
                    <div class="note-info">
                        <span class="note-xq">作者：{$v.username}</span>|<span class="note-xq ml10">发布时间：{$v.send_time|date='Y-m-d H:i:s',###}</span>| <span class="note-xq ml10">点赞数量：{$v.good_num}</span>
                    </div>
                </div>
            </foreach>

            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>

        </div>

        <div class="actrbox">
            <div class="rtop-box">
                <div class="small-box ">
                    <div class="rtop-left">
                        <i class="ion ion-chatbubble-working"></i>
                    </div>
                    <div class="rtop-right">
                        <a  href="{:U('Staff/add')}">畅言一下...</a>
                    </div>
                </div>
            </div>
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
		 
