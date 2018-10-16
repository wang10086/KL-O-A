<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>岗位作业指导书</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Files/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <foreach name="dir_path" item="v">
                        <li><a href="{:U('Files/index',array('pid'=>$v['id']))}">{$v.file_name}</a></li>
                        </foreach>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <if condition="C('RBAC_SUPER_ADMIN')==cookie('username') || cookie('roleid')==10">
                        <form action="{:U('File/instruction')}" method="post">
                            <div class="col-xs-12 content-neck">
                                <div class="content-neck-body">
                                    <lebal>部门</lebal>&emsp14;
                                    <select name="department" onchange="get_depart()" id="department">
                                        <option value="" selected disabled>请选择</option>
                                        <foreach name="departments" key="k" item="v">
                                            <option value="{$k}" <?php if ($dep==$k) echo "selected"; ?>>{$v}</option>
                                        </foreach>
                                    </select>
                                </div>

                                <div class="content-neck-body">
                                    <lebal>岗位</lebal>&emsp14;
                                    <select name="posts" id="posts"></select>
                                </div>

                                <input type="submit" class="btn btn-info search-btn" value="确定">
                            </div>
                        </form>
                    </if>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">部门职责</h3>
                                </div><!-- /.box-header -->

                                <div class="box-body">
                                <!--<div class="fileRoute">
                                	<a href="{:U('Files/index')}" class="file_tips">文件管理</a>
                                    <foreach name="dir_path" item="v">
                                    &gt; <a href="{:U('Files/index',array('pid'=>$v['id']))}" class="file_tips">{$v.file_name}</a>
                                    </foreach>
                                </div>-->
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
                                    <foreach name="zhize" item="row">
                                    <tr>
                                    	<td align="center">{$row.id}</td>
                                        <td><a href="{$row.file_path}" target="_blank">{$row.file_name}</a></td>
                                        <td>{$row.file_type}</td>
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

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">岗位说明</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
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
                                        <foreach name="shuoming" item="row">
                                            <tr>
                                                <td align="center">{$row.id}</td>
                                                <td><a href="{$row.file_path}" target="_blank">{$row.file_name}</a></td>
                                                <td>{$row.file_type}</td>
                                                <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                                <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                                <td>{$row.est_user}</td>
                                                <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pagestyle">{$shuoming_pages}</div>
                                </div>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">相关规程</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
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
                                        <foreach name="guicheng" item="row">
                                            <tr>
                                                <td align="center">{$row.id}</td>
                                                <td><a href="{$row.file_path}" target="_blank">{$row.file_name}</a></td>
                                                <td>{$row.file_type}</td>
                                                <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                                <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                                <td>{$row.est_user}</td>
                                                <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pagestyle">{$guicheng_pages}</div>
                                </div>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">相关制度</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
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
                                        <foreach name="zhidu" item="row">
                                            <tr>
                                                <td align="center">{$row.id}</td>
                                                <td><a href="{$row.file_path}" target="_blank">{$row.file_name}</a></td>
                                                <td>{$row.file_type}</td>
                                                <td><if condition="$row['file_ext']">{$row.file_ext}</if></td>
                                                <td><if condition="$row['file_size']">{:fsize($row['file_size'])}</if></td>
                                                <td>{$row.est_user}</td>
                                                <td>{$row.est_time|date='Y-m-d H:i:s',###}</td>
                                            </tr>
                                        </foreach>
                                    </table>
                                </div><!-- /.box-body -->
                                <div class="box-footer clearfix">
                                    <div class="pagestyle">{$zhidu_pages}</div>
                                </div>
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->



<include file="Index:footer2" />

<script type="text/javascript">
    $(function () {
        get_depart();
    })

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
