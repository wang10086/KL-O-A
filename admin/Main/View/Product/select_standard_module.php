<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			//var rs = new Array();
            var obj = {};
            $('.productlist').each(function(index, element) {
				if ($(element).find(".iradio_minimal").attr('aria-checked')=='true') {
					obj.id             = $(element).find("input[name=id]").val();
					obj.title          = $(element).find("input[name=title]").val();
					/*obj.age            = $(element).find("input[name=age]").val();
					obj.type           = $(element).find("input[name=type]").val();
					obj.from           = $(element).find("input[name=from]").val();
					obj.subject_fields = $(element).find("input[name=subject_fields]").val();
					obj.sales_price    = $(element).find("input[name=sales_price]").val();
					obj.reckon_mode    = $(element).find("input[name=reckon_mode]").val();
					rs.push(obj);*/
				}
			});
			return obj;
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Product/public_select_standard_module')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Product">
            <input type="hidden" name="a" value="public_select_standard_module">
            <input type="hidden" name="projectKind" value="{$projectKind}">

            <input type="text" class="form-control" name="key"  placeholder="关键字">

            <select  class="form-control"  name="subject_field">
                <option value="">科学领域</option>
                <foreach name="subject_fields" key="k" item="v">
                    <option value="{$k}" <?php if ($row && ($k == $row['subject_field'])) echo ' selected'; ?> >{$v}</option>
                </foreach>
            </select>

            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="50" style="text-align:center">选择</th>
                    <th class="sorting" data="title">模块名称</th>
                    <th class="sorting" data="subject_field">科学领域</th>
                    <th class="sorting" data="age">适用年龄</th>
                    <th class="sorting" data="sales_price">参考价</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                    	<td align="center">
                        <!--<input type="checkbox"  name="product" value="{$row.id}">-->
                        <input type="radio"  name="product" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="title" value="{$row.title}">
                        <input type="hidden" name="from" value="{$product_from[$row[from]]}">
                        <input type="hidden" name="subject_fields" value="{$subject_fields[$row[subject_field]]}">
                        <input type="hidden" name="age" value="{$row['agelist']}">
                        <input type="hidden" name="reckon_mode" value="{$row['reckon_modelist']}">
                        <input type="hidden" name="sales_price" value="{$row.sales_price}">
                        </td>
                        <td><a href="{:U('Product/view', array('id'=>$row['id']))}" target="_blank">{$row.title}</a></td>
                        <td>{$subject_fields[$row[subject_field]]}</td>
                        <td>{$row['agelist']}</td>
                        <td>{$row['sales_price']}</td>
                    </tr>
                </foreach>										
            </table>
            </form>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        