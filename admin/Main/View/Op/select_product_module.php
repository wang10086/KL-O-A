<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.productlist').each(function(index, element) {
				if ($(element).find(".icheckbox_minimal").attr('aria-checked')=='true') {
					var obj = {};
					obj.id             = $(element).find("input[name=id]").val();
					obj.title          = $(element).find("input[name=title]").val();
					obj.age            = $(element).find("input[name=age]").val();
					obj.type           = $(element).find("input[name=type]").val();
					obj.from           = $(element).find("input[name=from]").val();
					obj.subject_fields = $(element).find("input[name=subject_fields]").val();
					obj.sales_price    = $(element).find("input[name=sales_price]").val();
					obj.reckon_mode    = $(element).find("input[name=reckon_mode]").val();
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Op/select_module')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Op">
            <input type="hidden" name="a" value="select_module">
            <input type="hidden" name="opid" value="{$opid}">
            
            <input type="text" class="form-control" name="key"  placeholder="关键字">

            <select  class="form-control"  name="type">
                <option value="">类别</option>
                <foreach name="product_type" key="k" item="v">
                    <option value="{$k}" <?php if ($row && ($k == $row['type'])) echo ' selected'; ?> >{$v}</option>
                </foreach>
            </select>

            <select  class="form-control"  name="subject_field">
                <option value="">科学领域</option>
                <foreach name="subject_fields" key="k" item="v">
                    <option value="{$k}" <?php if ($row && ($k == $row['subject_field'])) echo ' selected'; ?> >{$v}</option>
                </foreach>
            </select>

            <select  class="form-control"  name="from">
                <option value="">来源</option>
                <foreach name="product_from" key="k" item="v">
                    <option value="{$k}" <?php if ($row && ($k == $row['from'])) echo ' selected'; ?> >{$v}</option>
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
                    <th class="sorting" data="type">类别</th>
                    <th class="sorting" data="subject_field">科学领域</th>
                    <th class="sorting" data="from">来源</th>
                    <th class="sorting" data="age">适用年龄</th>
                    <th class="sorting" data="sales_price">参考价</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                    	<td align="center">
                        <input type="checkbox"  name="product" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="title" value="{$row.title}">
                        <input type="hidden" name="type" value="{$product_type[$row[type]]}">
                        <input type="hidden" name="from" value="{$product_from[$row[from]]}">
                        <input type="hidden" name="subject_fields" value="{$subject_fields[$row[subject_field]]}">
                        <input type="hidden" name="age" value="{$row['agelist']}">
                        <input type="hidden" name="reckon_mode" value="{$row['reckon_modelist']}">
                        <input type="hidden" name="sales_price" value="{$row.sales_price}">
                        </td>
                        <td><a href="{:U('Product/view', array('id'=>$row['id']))}" target="_blank">{$row.title}</a></td>
                        <td>{$product_type[$row[type]]}</td>
                        <td>{$subject_fields[$row[subject_field]]}</td>
                        <td>{$product_from[$row[from]]}</td>
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
        