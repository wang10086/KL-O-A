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
            <form action="{:U('Op/select_product')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Op">
            <input type="hidden" name="a" value="select_product">
            
            <input type="text" class="form-control" name="key"  placeholder="关键字">
            <input type="text" class="form-control" name="mdd"  placeholder="目的地">
            <select class="form-control" name="kind">
                <option value="-1">类型</option>
                <foreach name="kindlist" item="v">
                    <option value="{$v.id}">{$v.name}</option>
                </foreach>
            </select>
                    
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="50" style="text-align:center">选择</th>
                    <th class="sorting" data="title">线路名称</th>
                    <th class="sorting" data="dest">目的地</th>
                    <th class="sorting" data="days">天数</th>
                    <th class="sorting" data="sales_price">参考价格</th>
                    <!-- <th class="sorting" data="peer_price">同行价</th> -->
                    <th class="sorting" data="input_uname">发布者</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                    	<td align="center">
                        <input type="radio"  name="product" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="title" value="{$row.title}">
                        <input type="hidden" name="business" value="{$business_depts[$row[business_dept]]}">
                        <input type="hidden" name="subject" value="{$subject_fields[$row[subject_field]]}">
                        <input type="hidden" name="age" value="{$ages[$row[age]]}">
                        <input type="hidden" name="sales_price" value="{$row.sales_price}">
                        <input type="hidden" name="peer_price" value="{$row.peer_price}">
                        </td>
                        <td><a href="{:U('Product/view_line', array('id'=>$row['id']))}" target="_blank">{$row.title}</a></td>
                        <td>{$row.dest}</td>
                        <td>{$row.days}</td>
                        <td>{$row.sales_price}</td>
                        <!-- <td>{$row.peer_price}</td> -->
                        <td>{$row.input_uname}</td>
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
        