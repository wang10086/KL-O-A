<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户满意度追责</h3>
        <!--<h3 class="box-title pull-right" style="font-weight:normal; color:#333333;"><span class="green">项目编号：{$op.op_id}</span> &nbsp;&nbsp;创建者：{$op.create_user_name}</h3>-->
    </div>
    <div class="box-body">
        <div class="content">
            <?php if ($row){ ?>
                <div class="form-group col-md-12">
                    <label>问题原因：</label>
                    <textarea name="info[problem]"  class="form-control problem" style="height:100px;" required>{$row['problem']}</textarea>
                </div>

                <div class="form-group col-md-12">
                    <label>解决方案：</label>
                    <textarea name="info[resolvent]"  class="form-control"  placeholder="解决方案" style="height:100px;">{$row.resolvent}</textarea>
                </div>

                <div style="width:100%; text-align:center; margin-top:30px;"></div>
            <?php }else{ ?>
                <div style="margin-left:15px;">该项目尚未追责！</div>
            <?php } ?>
        </div>
    </div>

</div><!--/.col (right) -->