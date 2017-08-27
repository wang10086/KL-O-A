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
					obj.sex        = $(element).find("input[name=sex]").val();
					obj.birthday   = $(element).find("input[name=birthday]").val();
					obj.fee        = $(element).find("input[name=fee]").val();
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
            <input type="hidden" name="c" value="Op">
            <input type="hidden" name="a" value="select_guide">
            <select class="form-control" name="kind">
                <option value="0">类型</option>
                <foreach name="reskind" key="k" item="v">
                <option value="{$k}">{$v}</option>
                </foreach>
            </select>
            <select class="form-control" name="sex">
                <option value="">性别</option>
                <option value="男">男</option>
                <option value="女">女</option>
            </select>
            <input type="text" class="form-control" name="key"  placeholder="关键字" value="">
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            
            </div>
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="60" style="text-align:center">选择</th>
                    <th class="sorting" data="name">姓名</th>
                    <th class="sorting" data="kind">类型</th>
                    <th class="sorting" data="sex">性别</th>
                    <th class="sorting" data="birthday">出生日期</th>
                    <th class="sorting" data="fee">费用</th>
                   	<th>擅长领域</th>
                </tr>
                <foreach name="lists" item="row">                      
                <tr class="guidelist">
                	<td align="center">
                    <input type="checkbox" value="{$row.id}">
                    <input type="hidden" name="id" value="{$row.id}">
                    <input type="hidden" name="name" value="{$row.name}">
                    <input type="hidden" name="kind" value="<?php echo $reskind[$row['kind']]; ?>">
                    <input type="hidden" name="sex" value="{$row.sex}">
                    <input type="hidden" name="birthday" value="{$row.birthday}">
                    <input type="hidden" name="fee" value="{$row.fee}">
                    </td>
                    <td><a href="{:U('GuideRes/res_view', array('id'=>$row['id']))}">{$row.name}</a></td>
                    <td><?php echo $reskind[$row['kind']]; ?></td>
                    <td>{$row.sex}</td>
                    <td>{$row.birthday}</td>
                    <td>{$row.fee}</td>
                    <td>{$row.field}</td>
                </tr>
                </foreach>		
                
            </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />
        