<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			var rs = new Array();
			$('.guidelist').each(function(index, element) {
				if ($(element).find(".icheckbox_minimal").attr('aria-checked')=='true') {
					var obj = {};
					obj.id         = $(element).find("input[name=id]").val();
					obj.name       = $(element).find("input[name=name]").val();
					obj.kind       = $(element).find("input[name=kind]").val();
					obj.country    = $(element).find("input[name=country]").val();
					obj.prov       = $(element).find("input[name=prov]").val();
					obj.city       = $(element).find("input[name=city]").val();
					rs.push(obj);
				}
			});
			return rs;		
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Op/select_supplier')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Op">
            <input type="hidden" name="a" value="select_supplier">
            <select class="form-control" name="kind">
                <option value="0">类型</option>
                <foreach name="reskind" key="k" item="v">
                <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <input type="text" class="form-control" name="key"  placeholder="关键字" value="">
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            
            </div>
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="60" style="text-align:center">选择</th>
                    <th class="sorting" data="name">供方名称</th>
                    <th class="sorting" data="kind">类型</th>
                    <th class="sorting" data="country">国家</th>
                    <th class="sorting" data="prov">省份</th>
                    <th class="sorting" data="city">城市</th>
                   	<!-- <th>好评</th> -->
                </tr>
                <foreach name="lists" item="row">                      
                <tr class="guidelist">
                	<td align="center">
                    <input type="checkbox" value="{$row.id}">
                    <input type="hidden" name="id" value="{$row.id}">
                    <input type="hidden" name="name" value="{$row.name}">
                    <input type="hidden" name="kind" value="<?php echo $reskind[$row['kind']]; ?>">
                    <input type="hidden" name="country" value="{$row.country}">
                    <input type="hidden" name="prov" value="{$row.prov}">
                    <input type="hidden" name="city" value="{$row.city}">
                    </td>
                    <td><a href="{:U('SupplierRes/res_view', array('id'=>$row['id']))}" target="_blank">{$row.name}</a></td>
                    <td><?php echo $reskind[$row['kind']]; ?></td>
                    <td>{$row.country}</td>
                    <td>{$row.prov}</td>
                    <td>{$row.city}</td>
                    <!-- <th class="sorting" data="fee">99%</th> -->
                </tr>
                </foreach>		
                
            </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        