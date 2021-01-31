<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.productlist').each(function(index, element) {
				if ($(element).find(".iradio_minimal").attr('aria-checked')=='true') {
					var obj = {};
					obj.id             = $(element).find("input[name=id]").val();
					obj.title          = $(element).find("input[name=title]").val();
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Op/public_select_standard_product')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main" />
            <input type="hidden" name="c" value="Op" />
            <input type="hidden" name="a" value="public_select_standard_product" />
            <input type="hidden" name="kind" value="{$kind}" />
            
            <input type="text" class="form-control" style="width: 200px" name="key"  placeholder="关键字">
                    
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="50" style="text-align:center">选择</th>
                    <th class="sorting" data="title">产品名称</th>
                    <th class="sorting" data="">使用时间</th>
                    <th class="sorting" data="">产品报价</th>
                    <th class="sorting" data="">发布者</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                    	<td align="center">
                        <input type="radio"  name="product" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="title" value="{$row.title}">
                        <input type="hidden" name="apply_year" value="{$row.apply_year}">
                        <input type="hidden" name="apply_time" value="{$row.apply_time}">
                        <input type="hidden" name="auth_name" value="{$row.auth_name}">
                        <input type="hidden" name="auth_id" value="{$row.auth_id}">
                        <input type="hidden" name="input_uname" value="{$row.input_uname}">
                        <input type="hidden" name="audit_status" value="{$row.audit_status}">
                        </td>
                        <td><a href="{:U('Product/standard_producted_detail', array('id'=>$row['id']))}" target="_blank">{$row.title}</a></td>
                        <td>{$row.apply_time_str}</td>
                        <td>{$row.sales_price}</td>
                        <td>{$row.input_uname}</td>
                    </tr>
                </foreach>										
            </table>
            </form>
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        