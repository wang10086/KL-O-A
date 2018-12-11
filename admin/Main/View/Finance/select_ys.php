<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.yslist').each(function(index, element) {
				if ($(element).find(".icheckbox_minimal").attr('aria-checked')=='true') {
					var obj = {};
					obj.id         = $(element).find("input[name=id]").val();
					obj.op_id      = $(element).find("input[name=op_id]").val();
					obj.group_id   = $(element).find("input[name=group_id]").val();
					obj.title      = $(element).find("input[name=title]").val();
					obj.ctotal     = $(element).find("input[name=ctotal]").val();
					obj.type       = $(element).find("input[name=type]").val();
					obj.jiekuan    = $(element).find("input[name=jiekuan]").val();
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Op/select_guide')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Finance">
            <input type="hidden" name="a" value="select_ys">
            <input type="hidden" name="opid" value="{$opid}">
            <input type="text" class="form-control" name="tit" placeholder="费用项">
            <select class="form-control" name="ty" id="">
                <option value="">==请选择==</option>
                <foreach name="ctype" key="k" item="v">
                    <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            
            </div>
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="60" style="text-align:center">选择</th>
                    <th width="">费用项</th>
                    <th width="">单价</th>
                    <th width="">数量</th>
                    <th width="">合计</th>
                    <th width="">类型</th>
                    <th width="">已借款金额</th>
                </tr>
                <foreach name="lists" item="row">                      
                <tr class="yslist">
                	<td align="center">
                    <input type="checkbox" value="{$row.id}">
                    <input type="hidden" name="id" value="{$row.id}">
                    <input type="hidden" name="op_id" value="{$row.op_id}">
                    <input type="hidden" name="group_id" value="{$row.group_id}">
                    <input type="hidden" name="title" value="{$row.title}">
                    <input type="hidden" name="unitcost" value="{$row.unitcost}">
                    <input type="hidden" name="amount" value="{$row.amount}">
                    <input type="hidden" name="ctotal" value="{$row.ctotal}">
                    <input type="hidden" name="type" value="<?php echo $ctype[$row['type']]; ?>">
                    <input type="hidden" name="jiekuan" value="{$row.jiekuan}">
                    </td>
                    <td width="16.66%">{$row.title}</td>
                    <td width="16.66%">&yen; {$row.unitcost}</td>
                    <td width="16.66%">{$row.amount}</td>
                    <td width="16.66%">&yen; {$row.ctotal}</td>
                    <td width="16.66%"><?php echo $ctype[$row['type']]; ?></td>
                    <td>{$row.jiekuan}</td>
                </tr>
                </foreach>		
                
            </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        