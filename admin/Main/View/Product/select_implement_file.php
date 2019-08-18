<include file="Index:header_art" />

		<script type="text/javascript">
        window.gosubmint= function(){
			//var rs = new Array();
            var obj = {};
            $('.productlist').each(function(index, element) {
				if ($(element).find(".iradio_minimal").attr('aria-checked')=='true') {
					obj.id             = $(element).find("input[name=id]").val();
					obj.title          = $(element).find("input[name=title]").val();
                    /*rs.push(obj);*/
				}
			});
            console.log(obj);
			return obj;
		 } 
        </script>
       
        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Product/public_select_implement_file')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Product">
            <input type="hidden" name="a" value="public_select_implement_file">
            <input type="hidden" name="pid" value="{$pid}">

            <input type="text" class="form-control" style="width:180PX;" name="key"  placeholder="文件名称关键字">
            <input type="text" class="form-control" style="width:150PX;" name="uname"  placeholder="上传文件人姓名">
            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                	<th width="50" style="text-align:center">选择</th>
                    <th class="taskOptions" data="">文件名称</th>
                    <th class="taskOptions" data="">上传人员</th>
                    <th class="taskOptions" data="">上传时间</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                    	<td align="center">
                        <!--<input type="checkbox"  name="product" value="{$row.id}">-->
                        <input type="radio"  name="product" value="{$row.id}">
                        <input type="hidden" name="id" value="{$row.id}">
                        <input type="hidden" name="title" value="{$row.file_name}">
                        </td>
                        <td><a href="{$row.file_path}" target="_blank">{$row.file_name}</a></td>
                        <td>{$row[est_user]}</td>
                        <td>{$row.est_time|date="Y-m-d",###}</td>
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
        