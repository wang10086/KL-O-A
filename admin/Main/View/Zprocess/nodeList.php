<include file="Index:header2" />

<aside class="right-side">
    <section class="content-header" style="padding: 5px">
        <include file="Index:ZcontentHeaderFile" />
    </section>

    <section class="content">
        <div class="zpage-title">{$list.title}</div>
        <div class="row">
            <div class="col-md-12">
                <!--<div class="content">-->
                    <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                        <tr role="row" class="orders" >
                            <th class="taskOptions" width="60">序号</th>
                            <th class="taskOptions">工作事项</th>
                            <th class="taskOptions">责任人</th>
                            <th class="taskOptions">所需天数</th>
                            <th class="taskOptions">完成时点</th>
                            <th class="taskOptions">完成依据</th>
                            <th class="taskOptions">是否提前提醒</th>
                            <th class="taskOptions">是否超时提醒</th>
                            <th class="taskOptions">完成后反馈对象</th>
                            <th class="taskOptions">备注</th>
                        </tr>
                        <foreach name="lists" key="k" item="row">
                            <tr>
                                <td class="taskOptions">{$k + 1}</td>
                                <td><a href="javascript:;">{$row.title}</a></td>
                                <td class="taskOptions">{$row.job}（{$row.blame_name}）</td>
                                <td class="taskOptions">{$row.day}</td>
                                <td>{$row.time_data}</td>
                                <td>{$row.OK_data}</td>
                                <td class="taskOptions">{$row['before_remind']?'提醒':'不提醒'}</td>
                                <td class="taskOptions">{$row['after_remind']?'提醒':'不提醒'}</td>
                                <td>{$row.feedback_name}</td>
                                <td>{$row.remark}</td>
                            </tr>
                        </foreach>
                    </table>
                    <div class="box-footer clearfix">
                        <div class="pagestyle">{$pages}</div>
                    </div>
                <!--</div>-->


            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</aside><!-- /.right-side -->

            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Zprocess">
                <input type="hidden" name="a" value="node">

                <div class="form-group col-md-12">
                    <input type="text" class="form-control" name="title" placeholder="节点名称关键字">
                </div>
                </form>
            </div>

<include file="Index:footer2" />

<script>

    function ConfirmDel(url,msg) {
        /*
         if (confirm("真的要删除吗？")){
         window.location.href=url;
         }else{
         return false;
         }
         */

        if(!msg){
            var msg = '真的要删除吗？';
        }

        art.dialog({
            title: '提示',
            width:400,
            height:100,
            lock:true,
            fixed: true,
            content: '<span style="width:100%; text-align:center; font-size:18px;float:left; clear:both;">'+msg+'</span>',
            ok: function (msg) {
                window.location.href=url;
                //this.title('3秒后自动关闭').time(3);
                return false;
            },
            cancelVal: '取消',
            cancel: true //为true等价于function(){}
        });

    }
</script>
