<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>我要立项</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="{:U('Op/index')}"><i class="fa fa-gift"></i> 项目计划</a></li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Op/plans')}" name="myform" id="myform">
            <input type="hidden" name="dosubmint" value="1">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">


                        <div class="box box-warning">
                            <div class="box-header">
                                <h3 class="box-title">项目计划</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">

                                    <div class="form-group col-md-12">
                                        <label>项目名称(学校名称 + 地点 + 项目类型)：</label><input type="text" name="info[project]" class="form-control" required />
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label>项目类型：</label>
                                        <select  class="form-control"  name="info[kind]" id="kind" onchange="line_lession()" required>
                                        <!--<select  class="form-control"  name="info[kind]" id="kind"  required>-->
                                            <option value="" selected disabled>请选择项目类型</option>
                                            <foreach name="kinds" item="v">
                                                <option value="{$v.id}" >{:tree_pad($v['level'], true)} {$v.name}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div id="lession_or_line">

                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>预计人数：</label><input type="text" name="info[number]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label id="ctrq">出团日期：</label><input type="text" name="info[departure]"  class="form-control inputdate"  required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label id="xcts">行程天数：</label><input type="text" name="info[days]" class="form-control"  required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>目的地：</label><input type="text" name="info[destination]" class="form-control"  required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>立项时间：</label><input type="text" name="info[op_create_date]" class="form-control inputdate_a"  required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>业务部门：</label>
                                        <select  class="form-control" name="info[op_create_user]" >
                                            <option value="" selected disabled>请选择业务部门</option>
                                            <foreach name="rolelist" key="k" item="v">
                                                <option value="{$v}" <?php if($k==cookie('roleid')){ echo 'selected';} ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>客户单位：</label>
                                        <!--
                                        <input type="text" name="info[customer]" id="customer_name" value="" placeholder="您可以输入客户单位名称拼音首字母检索" class="form-control" />
                                        -->
                                        <select  name="info[customer]" class="form-control" required>
                                            <option value="" selected disabled>请选择客户单位</option>
                                            <foreach name="geclist"  item="v">
                                                <option value="{$v.company_name}"><?php echo strtoupper(substr($v['pinyin'], 0, 1 )); ?> - {$v.company_name}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4" id="sale">
                                        <label>销售人员：</label>
                                        <input type="text" class="form-control" name="info[sale_user]" value="{:session('nickname')}" readonly>
                                    </div>



                                    <div class="form-group col-md-12">
                                        <label>项目需求(对市场部 、研发部 、计调部 、资源管理部等部门的需求)：</label><textarea class="form-control"  name="info[context]" id="context" required></textarea>
                                        <span id="contextTip"></span>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>项目说明：</label><textarea class="form-control"  name="info[remark]"></textarea>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>工单接收部门：</label>
                                        <input type="checkbox" name="exe[]" value="45">&nbsp;市场部 &#12288;<!--市场部经理roleid-->
                                        <!--<input type="checkbox" name="exe[]" value="31">&nbsp;计调部 &#12288;--><!--计调部经理roleid-->
                                        <input type="checkbox" name="exe[]" value="15">&nbsp;研发部 &#12288;<!--研发部经理roleid-->
                                        <input type="checkbox" name="exe[]" value="52">&nbsp;资源管理部&#12288;<!--资源管理部经理roleid-->
                                    </div>

                                </div>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->


                        <div style="width:100%; text-align:center;">
                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">我要立项</button>
                        </div>
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->

        <!--------------------------------------------line_lession_start------------------------------------------------------>
        <div id="lession_con">
            <div class="form-group col-md-4">
                <label>课程领域：</label>
                <select  class="form-control"  name="field" id="field" onchange="check_type()">
                    <option value="" selected disabled>课程领域：</option>
                    <foreach name="field" item="v">
                        <option value="{$v.id}" >{:tree_pad($v['level'], true)} {$v.name}</option>
                    </foreach>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>学科分类：</label>
                <select  class="form-control"  name="type"  id="type" onchange="check_lession()">
                    <if condition="$row['type_id']">
                        <option value="{$row.type_id}" >{$row.type}</option>
                        <else />
                        <option value="" selected disabled>请选择学科分类</option>
                    </if>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label>课程名称：</label>
                <select  class="form-control"  name="info[lession_id]"  id="les_name">
                    <option value="" selected disabled>请选择课程名称</option>
                </select>
            </div>
        </div>

        <div  id="line_con">
            <div class="form-group col-md-4">
                <label>线路名称：</label>
                <input type="text" name="line" id="lineName" value="" placeholder="您可以输入名称或拼音首字母检索" class="form-control" />
                <input type="hidden" name="info[line_id]" id="line_id">
            </div>
        </div>

        <!----------------------------------------------line_lession_end------------------------------------------------------>
			
  </div>
</div>

<include file="Index:footer2" />
    <script type="text/javascript">
        laydate.render({
            elem: '.inputdate',theme: '#0099CC',type: 'datetime'
        });

        $(function(){
            $('#lession_or_line').hide();
            $('#lession_con').hide();
            $('#line_con').hide();
        })

        /*根据线路和课程显示不同模块*/
        function line_lession(){
            var kid = $("#kind").val();
            $.ajax({
                type:"POST",
                url:"{:U('Ajax/line_or_lession')}",
                data:{id:kid},
                success: function(msg){
                    if(msg.type == 1){
                        //线路
                        var line = $('#line_con').html();
                        $('#lession_or_line').html(line);
                        $('#lession_or_line').show();
                        $('#ctrq').html('出团日期');
                        $('#xcts').html('行程天数');
                        $('#sale').hide();  //凑ui样式
                        autocom();
                    }else if(msg.type == 2){
                        //课程
                        var lession = $('#lession_con').html();
                        $('#lession_or_line').html(lession);
                        $('#lession_or_line').show();
                        $('#sale').show();  //凑ui样式
                        $('#ctrq').html('开课日期');
                        $('#xcts').html('开课次数');
                        $("#type").empty();
                        if(msg.field){
                            var field = msg.field;
                            $("#field").empty();
                            var count = field.length;
                            var i= 0;
                            var b="";
                            b+='<option value="" disabled selected>请选择学科领域</option>';
                            for(i=0;i<count;i++){
                                b+="<option value='"+field[i].id+"'>"+field[i].fname+"</option>";
                            }
                            $("#field").append(b);
                        }else{
                            $("#field").empty();
                            var b='<option value="" disabled selected>无学科领域信息</option>';
                            $("#field").append(b);
                        }
                        check_type();
                    }
                }
            })
        }

        /*学科分类*/
        function check_type(){
            var kid = $("#kind").val();
            var fid = $("#field").val();
            $.ajax({
                type:"POST",
                url:"{:U('Ajax/types')}",
                data:{kid:kid,fid:fid},
                success:function(msg){
                    if(msg){
                        $("#type").empty();
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择学科分类</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].tname+"</option>";
                        }
                        $("#type").append(b);
                    }else{
                        $("#type").empty();
                        var b='<option value="" disabled selected>无学科分类信息</option>';
                        $("#type").append(b);
                    }
                    check_lession();

                }
            })

        }

        /*课程名称*/
        function check_lession(){
            var fid = $('#field').val();
            var tid = $('#type').val();
            $.ajax({
                type:"POST",
                url:"{:U('Ajax/lession')}",
                data:{fid:fid,tid:tid},
                success:function(msg){
                    $("#les_name").empty();
                    if(msg){
                        var count = msg.length;
                        var i= 0;
                        var b="";
                        b+='<option value="" disabled selected>请选择课程</option>';
                        for(i=0;i<count;i++){
                            b+="<option value='"+msg[i].id+"'>"+msg[i].name+"</option>";
                        }
                        $("#les_name").append(b);
                    }else{
                        $("#les_name").empty();
                        var b='<option value="" disabled selected>无课程信息</option>';
                        $("#les_name").append(b);
                    }

                }
            })
        }

        function autocom(e) {
            var keywords = <?php echo $linelist; ?>;

            $("#lineName").autocomplete(keywords, {
                matchContains: true,
                highlightItem: false,
                formatItem: function(row, i, max, term) {
                    return '<span style=" display:none">'+row.pinyin+'</span>'+row.title;
                },
                formatResult: function(row) {
                    return row.title;
                }
            }).result(function(event, item) {
                $('#lineName').val(item.title);
                $('#line_id').val(item.id);
            });

        }

    </script>
<script type="text/javascript">

</script>