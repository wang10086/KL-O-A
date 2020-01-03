<include file="header" />

<div class="staff">
    <div class="staff-con" style="background-color:  #eeeeee;">
        <div class="img-header">
            <img src="__HTML__/img/staff-header.png"  width="100%" height="100%">
        </div>

        <div class="actlbox">
            <div class="con-header">
                <h4 class="notice-tit">发帖规定：</h4>
                <p class="ml20">1.发布积极正能量信息，不允许发布负能量、只抱怨无改进建议、无事实根据、故意扰乱公司秩序的信息； </p>
                <p class="ml20">2.要文明用语，不准使用谩骂或对他人进行人身攻击的语言；</p>
                <p class="ml20">3.如发生上述情况，公司将一查到底，采取删帖、追踪IP按公司制度对发帖人处理措施。 </p>
            </div>

            <foreach name="list" item="v">
                <div class="lbox">
                    <?php if (time()-$v['send_time']<5*24*3600){ ?>
                        <img src="__HTML__/img/new.png" width="30rem"  alt="">
                    <?php } ?>
                    <span class="staff-name">『 {$v.username} 』</span>:
                    <a href="{:U('staff/info',array('id'=>$v['id']))}"><span class="note-con"><?php echo  $v['title']?$v['title']:$v['content']; ?></span></a>
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
                            <li><a href="{:U('staff/info',array('id'=>$v['id']))}">{$v.title}</a> <span class="note-time ">发布时间：{$v.send_time|date='Y-m-d H:i:s',###}</span></li>
                        </foreach>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>






<include file="footer" />

