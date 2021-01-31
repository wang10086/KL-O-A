<include file="Index:header_art" />

        <section class="content">
        	<!--<div class="callout callout-danger">
                <h4>提示!</h4>
                <P></P>
            </div>-->
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th>项目编号</th>
                    <th>团号</th>
                    <th>项目名称</th>
                    <th>单价</th>
                    <th>天数</th>
                   	<th>应付金额</th>
                    <th>实付金额</th>
                    <th>教务核实时间</th>
                    <?php if (cookie('userid')==1){ ?>
                        <th>备注</th>
                    <?php } ?>
                </tr>
                <foreach name="lists" item="row">                      
                <tr>
                    <td>{$row.op_id}</td>
                    <td>{$row.group_id}</td>
                    <td>{$row.project}</td>
                    <td>{$row.price}</td>
                    <td>{$row.num}</td>
                    <td>{$row.total}</td>
                    <td>{$row.really_cost}</td>
                    <td>{$row.sure_time|date="Y-m-d H:i:s",###}</td>
                    <?php if (cookie('userid')==1){ ?>
                    <td>{$row.remark}</td>
                    <?php } ?>
                </tr>
                </foreach>
                <tr>
                    <td colspan="9">说明：带团补助是根据教务在辅导员系统核实数据为准，核实周期为上月26日至本月25日。</td>
                </tr>
            </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        