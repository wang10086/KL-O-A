<div class="box-body">
    <form method="post" action="<?php echo U('Finance/public_save'); ?>" id="save_guide">
    <input type="hidden" name="dosubmint" value="1">
    <input type="hidden" name="opid" value="{$op.op_id}">
    <input type="hidden" name="savetype" value="">
    <div class="content" id="guidelist" style="display:block;">
    <!--<h3 style="float:left; width:100px;">专家辅导员</h3>-->
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="">费用项</th>
                <th width="80">单价</th>
                <th width="20">&nbsp;</th>
                <th width="80">数量</th>
                <th width="100">合计</th>
                <th width="80">类型</th>
                <th width="160">备注</th>
                <th width="80">删除</th>
            </tr>
        </thead>
        <tbody>
            <foreach name="guide" item="v">
            <tr class="expense" id="guide_id_{$v.id}">
                <td>
                <input type="hidden" name="cost[20000{$v.id}][item]" value="{$v.kind}">
                <input type="hidden" name="cost[20000{$v.id}][cost_type]" value="2">
                <input type="hidden" name="cost[20000{$v.id}][remark]" value="{$v.name}">
                <input type="hidden" name="cost[20000{$v.id}][relevant_id]" value="{$v.guide_id}">
                <input type="hidden" name="resid[20000{$v.id}][id]" value="{$v.id}">
                <input type="hidden" name="guide[20000{$v.id}][guide_id]" value="{$v.guide_id}">
                <input type="hidden" name="guide[20000{$v.id}][name]" value="{$v.name}">
                <input type="hidden" name="guide[20000{$v.id}][kind]" value="{$v.kind}">
                <input type="hidden" name="guide[20000{$v.id}][sex]" value="{$v.sex}">
                <a href="javascript:;" onClick="open_guide({$v.guide_id},'{$v.name}')">{$v.name}</a> 
                <i class="fa  fa-calendar" style="color:#3CF; margin-left:8px; cursor:pointer;" onClick="course({$v.guide_id},{$op.op_id})"></i>
                </td>
                <td>{$v.kind}</td>
                <td>{$v.sex}</td>
                <td><input type="text" name="cost[20000{$v.id}][cost]" placeholder="价格" value="{$v.cost}" class="form-control min_input cost"></td>
                <td><span>X</span></td>
                <td><input type="text" name="cost[20000{$v.id}][amount]" placeholder="数量" value="{$v.amount}" class="form-control min_input amount" ></td>
                <td class="total">&yen;<?php echo $v['cost']*$v['amount']; ?></td>
                <td><input type="text" name="guide[20000{$v.id}][remark]" value="{$v.remark}" class="form-control"></td>
                <td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('guide_id_{$v.id}')">删除</a></td></tr>
            </foreach>
        </tbody>
        <tfoot>
            <tr>
                <td align="left" colspan="9">
                <input type="text" name="group_id" id="group_id" onblur="get_yusuan()" placeholder="请输入团号信息" style="width:200px;height: 33px; margin-right: 10px;">
                <a href="javascript:;" class="btn btn-success btn-sm" style="margin-left:-8px;"  onClick="show_group()"><i class="fa fa-fw  fa-plus"></i> 增加团号信息</a>
                <a  href="javascript:;" class="btn btn-info btn-sm" onClick="javascript:save('save_guide','<?php echo U('Op/public_save'); ?>',{$op.op_id});">保存</a>
               
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
    </form> 
</div>

<script>
    $(function () {
        $('#group_id').hide();
    })

    function show_group() {
        $('#group_id').show();
    }

    function get_yusuan() {
        var group_id    = $('#group_id').val();
        if (group_id){
            $.ajax({
                type: "post",
                url : "<?php echo U('Ajax/get_yslist'); ?>",
                dataType: "json",
                data: {group_id:group_id},
                success:function (data) {
                    var status  = data.status;
                    var msg     = data.msg;
                    if (status==1){
                        art.dialog.open("/index.php?m=Main&c=Finance&a=select_ys&opid="+msg,{
                            lock:true,
                            title: '选择预算信息',
                            width:1000,
                            height:500,
                            okVal: '提交',
                            fixed: true,
                            ok: function () {
                                var origin = artDialog.open.origin;
                                var guide = this.iframe.contentWindow.gosubmint();
                                var guide_html = '';
                                for (var j = 0; j < guide.length; j++) {
                                    if (guide[j].id) {
                                        var i = parseInt(Math.random()*100000)+j;
                                        /*var cost = '<input type="hidden" name="cost['+i+'][item]" value="'+guide[j].kind+'">' +
                                            '<input type="hidden" name="cost['+i+'][cost_type]" value="2">' +
                                            '<input type="hidden" name="cost['+i+'][remark]" value="'+guide[j].name+'">' +
                                            '<input type="hidden" name="cost['+i+'][relevant_id]" value="'+guide[j].id+'">';*/
                                        guide_html += '<tr class="expense" id="guide_'+i+'">' +
                                            '<td><input type="hidden" name="guide['+i+'][costacc_id]" value="'+guide[j].id+'">' +
                                            '<input type="hidden" name="guide['+i+'][op_id]" value="'+guide[j].op_id+'">' +
                                            '<input type="hidden" name="guide['+i+'][title]" value="'+guide[j].title+'">' +
                                            '<input type="hidden" name="guide['+i+'][unitcost]" value="'+guide[j].unitcost+'">' +
                                            '<input type="hidden" name="guide['+i+'][amount]" value="'+guide[j].amount+'">' +
                                            '<input type="hidden" name="guide['+i+'][amount]" value="'+guide[j].amount+'">' +
                                            '<input type="hidden" name="guide['+i+'][amount]" value="'+guide[j].amount+'">' +
                                            '</td>'+
                                            '<td>'+guide[j].kind+'</td><td>'+guide[j].sex+'</td>' +
                                            '<td><input type="text" name="cost['+i+'][cost]" placeholder="价格" value="'+guide[j].fee+'" class="form-control min_input cost" /></td>' +
                                            '<td><span>X</span></td><td><input type="text" name="cost['+i+'][amount]" placeholder="数量" value="1" class="form-control min_input amount" /></td>' +
                                            '<td class="total">&yen;'+guide[j].fee*1+'</td>' +
                                            '<td><input type="text" name="guide['+i+'][remark]" value="" class="form-control" /></td>' +
                                            '<td><a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(\'guide_'+i+'\')">删除</a></td></tr>';
                                    };
                                }
                                $('#guidelist').show();
                                $('#nonetext').hide();
                                $('#guidelist').find('tbody').append(guide_html);
                                total();
                            },
                            cancelValue:'取消',
                            cancel: function () {
                            }
                        });
                    }else{
                        art_show_msg(msg,3);
                        return false;
                    }
                }
            });
        }else{
            art_show_msg('团号输入有误,请重新输入',3);
            return  false;
        }
    }
</script>