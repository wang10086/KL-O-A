<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.departmentlist').each(function(index, element) {
				if ($(element).find(".icheckbox_minimal").attr('aria-checked')=='true') {
					var obj = {};
					obj.department         = $(element).find("input[name=department]").val();
					/*obj.depart_sum         = $(element).find("input[name=depart_sum]").val();
					obj.cw_remark          = $(element).find("input[name=remark]").val();*/
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">

            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="60" style="text-align:center">选择</th>
                    <th class="sorting" data="">部门名称</th>
                    <!--<th class="sorting" data="" width="150">分摊金额</th>
                    <th class="sorting" data="">备注</th>-->
                </tr>
                <foreach name="departments" item="v">
                <tr class="departmentlist">
                	<td align="center" id="chk">
                    <input type="checkbox" value="{$v}">
                    <input type="hidden" name="department" value="{$v}">
                    <!--<input type="hidden" name="depart_sum" >
                    <input type="hidden" name="remark" >-->
                    </td>
                    <td>{$v}</td>
                    <!--<td style="text-align: center;"><input type="text" class="tdInput" name="depart_sum" onblur="setSumValue(this)"></td>
                    <td style="text-align: center;"><input type="text" class="tdInput" name="remark" onblur="setRemarkValue(this)"></td>-->
                </tr>
                </foreach>		
                
            </table>
            </div><!-- /.box-body -->
            <!--<div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>-->
        </section>

    <script>
        function setSumValue(the) {
            let sumVal = $(the).val();
            $(the).parent('td').siblings('td[id="chk"]').find('input[name="depart_sum"]').val(sumVal);
        }

        function setRemarkValue(the) {
            let remarkVal = $(the).val();
            $(the).parent('td').siblings('td[id="chk"]').find('input[name="remark"]').val(remarkVal);
        }
    </script>

        <include file="Index:footer" />
        