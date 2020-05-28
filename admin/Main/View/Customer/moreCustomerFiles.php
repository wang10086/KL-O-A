<include file="Index:header_art" />

        <section class="content">
        	<div id="selectbox">
            <form action="{:U('Customer/moreCustomerFiles')}" method="get" id="feedbackform">
            <input type="hidden" name="m" value="Main">
            <input type="hidden" name="c" value="Customer">
            <input type="hidden" name="a" value="moreCustomerFiles">

            <input type="text" class="form-control" name="key"  placeholder="文件名称关键字" style="width: 300px" />

            <button type="submit" class="btn btn-success">搜索</button>
            </form>
            </div>
            <form action="" method="post" id="gosub">
            <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                <tr role="row" class="orders" >
                    <th class="sorting" data="title">文件名称</th>
                    <th class="sorting" data="dest">上传日期</th>
                </tr>
                <foreach name="lists" item="row">
                    <tr class="productlist">
                        <td><?php if (in_array($row['id'],$msg_file_ids)){ echo "<span class='red'>*</span>"; } ?><a href="{$row.file_path}" onclick="read_file({$row.id},{$unread_type})" target="_blank">{$row.file_name}</a></td>
                        <td>{$row.create_time|date='Y-m-d',###}</td>
                    </tr>
                </foreach>
            </table>
            </form>
            <div class="box-footer clearfix">
                <div class="pagestyle">{$pages}</div>
            </div>
        </section>


        <include file="Index:footer" />

<script type="text/javascript">
    function read_file(id,unread_type) {
        $.ajax({
            type: "POST",
            url : "{:U('Ajax/read_file')}",
            dataType : 'JSON',
            data: {id:id,unread_type:unread_type},
            success(){},
            error(){}
        })
    }
</script>