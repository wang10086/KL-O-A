<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <foreach name="dir_path" item="v">
                        <li><a href="{:U('Files/index',array('pid'=>$v['id']))}">{$v.file_name}</a></li>
                        </foreach>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <if condition="C('RBAC_SUPER_ADMIN')==cookie('username') || in_array(cookie('userid'),array(11,77))">
                        <form action="{:U('File/departmentFile')}" method="post">
                            <div class="col-xs-12 content-neck">
                                <div class="content-neck-body">
                                    <lebal>部门</lebal>&emsp14;
                                    <select name="department" onchange="get_depart()" id="department">
                                        <option value="" selected disabled>请选择</option>
                                        <foreach name="departments" key="k" item="v">
                                            <option value="{$k}" <?php if ($department==$k) echo "selected"; ?>>{$v}</option>
                                        </foreach>
                                    </select>
                                </div>

                                <div class="content-neck-body">
                                    <lebal>岗位</lebal>&emsp14;
                                    <select name="posts" id="posts">
                                        <?php if ($department){ ?>
                                            <script type="text/javascript">
                                                $(function () {
                                                    get_depart();
                                                })
                                            </script>
                                        <?php }else{ ?>
                                            <option value="">请先选择部门</option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <input type="submit" class="btn btn-info search-btn" value="确定">
                            </div>
                        </form>
                    </if>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo $pin ? $fileTags[$pin] : '全部文件'; ?></h3>
                                    <div class="box-tools pull-right">
                                        <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',500,150);"><i class="fa fa-search"></i> 搜索</a>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                <div class="btn-group" id="catfont">
                                    <!--<a href="{:U('File/departmentFile',array('pin'=>0))}" class="btn <?php /*if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} */?>">全部文件</a>-->
                                    <foreach name="file_type" key="k" item="v">
                                        <a href="{:U('File/departmentFile',array('pin'=>$k,'department'=>$department,'posts'=>$posts))}" class="btn <?php if($pin==$k){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$v}</a>
                                    </foreach>
                                </div>

                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                    	<th width="40" style="text-align:center;">ID</th>
                                        <th class="sorting" data="file_name">文件名称</th>
                                        <th width="100" class="sorting" data="file_type">文件类型</th>
                                        <th width="100" class="sorting" data="file_ext">文件格式</th>
                                        <th width="100" class="sorting" data="file_size">文件大小</th>
                                        <th width="100" class="sorting" data="est_user">创建者</th>
                                        <th width="160" class="sorting" data="est_time">创建时间</th>
                                    </tr>
                                    <foreach name="lists" item="row">
                                    <tr>
                                    	<td align="center">{$row.id}</td>
                                        <td><a href="{$row.file_path}" target="_blank">{$row.file_name}</a></td>
                                        <td>{$fileTags[$row['file_tag']]}</td>
                                        <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                        <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                        <td>{$row.est_user}</td>
                                        <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
                                    </tr>
                                    </foreach>
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$zhize_pages}</div>
                                </div>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                     </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

<div id="searchtext">
    <form action="" method="get" id="searchform">
        <input type="hidden" name="m" value="Main">
        <input type="hidden" name="c" value="File">
        <input type="hidden" name="a" value="departmentFile">
        <input type="hidden" name="pin" value="{$pin}">
        <input type="hidden" name="department" value="{$department}">
        <input type="hidden" name="posts" value="{$posts}">

        <div class="form-group col-md-12"></div>
        <div class="form-group col-md-12">
            <input type="text" class="form-control" name="title" placeholder="文件名称">
        </div>
    </form>
</div>

<include file="Index:footer2" />

<script type="text/javascript">

    function get_depart() {
        var departmentid = $('#department').val();
        $.ajax({
            type: 'POST',
            url : "{:U('Ajax/get_this_posts')}",
            dataType: 'JSON',
            data:{departmentid:departmentid},
            success: function (msg) {
                if (msg){
                    var count   = msg.length;
                    var html    = '<option value=""  selected disabled>请选择</option>';
                    for(i=0;i<count;i++){
                        html += '<option value="'+msg[i].id+'">'+msg[i].post_name+'</option>';
                    }
                }else{
                    var html='<option value="" disabled selected>无数据</option>';
                }
                $('#posts').html(html);
            }
        })
    }
</script>
