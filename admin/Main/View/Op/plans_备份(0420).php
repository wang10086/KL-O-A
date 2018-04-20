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
                                    <label>项目名称(学校名称 + 地点 + 项目类型)：</label><input type="text" name="info[project]" class="form-control" id="project" />
                                    <span class="form-group col-md-12"  id="projectTip"></span>
                                </div>


                                <div class="form-group col-md-4">
                                    <label>项目类型：</label>
                                    <select  class="form-control"  name="info[kind]" id="kind" required>
                                        <option value="" selected disabled>请选择项目类型</option>
                                        <foreach name="kinds" item="v">
                                            <option value="{$v.id}" <?php if ($row && ($v['id'] == $row['kind'])) echo ' selected'; ?> >{:tree_pad($v['level'], true)} {$v.name}</option>
                                        </foreach>
                                    </select>
                                    <span id="kindTip" style="margin-right: 5px;"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>预计人数：</label><input type="text" name="info[number]" class="form-control" id="number" />
                                    <div id="numberTip"></div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>出团日期：</label><input type="text" name="info[departure]"  class="form-control inputdate" id="departure" />
                                    <span id="departureTip"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>行程天数：</label><input type="text" name="info[days]" class="form-control" id="days" />
                                    <span id="daysTip"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>目的地：</label><input type="text" name="info[destination]" class="form-control" id="destination" />
                                    <span id="destinationTip"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>立项时间：</label><input type="text" name="info[op_create_date]" class="form-control inputdate_a" id="op_create_date" />
                                    <span id="op_create_dateTip"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>业务部门：</label>
                                    <select  class="form-control" name="info[op_create_user]" id="op_create_user">
                                        <option value="" selected disabled>请选择业务部门</option>
                                        <foreach name="rolelist" key="k" item="v">
                                            <option value="{$v}" <?php if($k==cookie('roleid')){ echo 'selected';} ?> >{$v}</option>
                                        </foreach>
                                    </select>
                                    <span id="op_create_userTip" style="margin-right: 5px;"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>客户单位：</label>
                                    <!--
                                    <input type="text" name="info[customer]" id="customer_name" value="" placeholder="您可以输入客户单位名称拼音首字母检索" class="form-control" />
                                    -->
                                    <select  name="info[customer]" class="form-control" id="customer">
                                        <option value="" selected disabled>请选择客户单位</option>
                                        <foreach name="geclist"  item="v">
                                            <option value="{$v.company_name}"><?php echo strtoupper(substr($v['pinyin'], 0, 1 )); ?> - {$v.company_name}</option>
                                        </foreach>
                                    </select>
                                    <span id="customerTip" style="margin-right: 5px;"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>销售人员：</label>
                                    <input type="text" class="form-control" name="info[sale_user]" value="{:session('nickname')}" readonly>
                                </div>



                                <div class="form-group col-md-12">
                                    <label>项目需求(对市场部 、研发部 、计调部 、资源管理部等部门的需求)：</label><textarea class="form-control"  name="info[context]" id="context"></textarea>
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

</div>
</div>

<include file="Index:footer2" />
<!--
		<script type="text/javascript">
            function sousuo(){
				var keywords = <?php echo $keywords; ?>;
                $("#customer_name").autocomplete(keywords, {
                     matchContains: true,
                     highlightItem: false,
                     formatItem: function(row, i, max, term) {
                         return '<span style=" display:none">'+row.pinyin+'</span>'+row.company_name;
                     },
                     formatResult: function(row) {
                         return row.company_name;
                     }
                });
            };

			$(document).ready(function(e) {
                sousuo();
            });
        </script>
        -->
<script type="text/javascript">
    $(function(){
        //初始化表单验证
        $.formValidator.initConfig({formID:"myform",debug:true,onSuccess:function(){
            $("#myform").submit();
        },onError:function(){
            alert("请完善相关信息")
        }});
        //项目名称
        $("#project").formValidator({onShow:"请输入项目名称",onFocus:"请按正确格式填写项目名称",onCorrect:"已输入项目名称"})
            .inputValidator({min:4,max:200,onErrorMin:"姓名长度太短",onError:"请按正确格式填写项目名称"});
        //项目类型 【下拉列表框】
        $("#kind").formValidator({onShow:"请选择项目类型",onFocus:"项目类型必须选择",onCorrect:"已选择",defaultValue:""})
            .inputValidator({min:1,onError: "请选择项目类型!"})
            .defaultPassed();
        //预计人数
        $("#number").formValidator({ onShow: "请输入预计人数", onCorrect: "格式正确", defaultValue:"0" })
            .inputValidator({min:1,onError:"输入的信息有误"})
        // .regexValidator({ regExp: "^\\d{1,5}$", onError: "格式不正确"});
        //验证出团日期
        $("#departure").formValidator({onShow:"请选择你的出团日期",onFocus:"请选择出团日期",onCorrect:"已选择出团日期"})
            .inputValidator({type:"string",min:"2018-01-01",onErrorMin:"日期不能早期2018-01-01"})
            .functionValidator({fun:isDate});
        //行程天数
        $("#days").formValidator({ onShow: "请输入行程天数", onCorrect: "格式正确", defaultValue:"0" })
            .inputValidator({min:1,onError:"输入的信息有误"})
        //.regexValidator({ regExp: "^[0-9]{1,3}$",dataType:"enum", onError: "格式不正确"});
        //目的地
        $("#destination").formValidator({onShow:"请输入目的地信息",onFocus:"请输入目的地信息",onCorrect:"已输入目的地信息"})
            .inputValidator({min:2,max:100,onErrorMin:"目的地信息长度太短",onError:"请输入有效的目的地信息"});
        //立项时间
        $("#departure").formValidator({onShow:"请选择你的立项时间",onFocus:"请选择立项时间",onCorrect:"已选择日期选择"})
            .inputValidator({type:"string",min:"2018-01-01",onErrorMin:"日期不能早期2018-01-01"})
            .functionValidator({fun:isDate});
        //业务部门
        $("#op_create_user").formValidator({onShow:"请选择业务部门",onFocus:"业务部门必须选择",onCorrect:"已选择",defaultValue:""})
            .inputValidator({min:1,onError: "请选择业务部门!"})
            .defaultPassed();
        //客户单位
        $("#customer").formValidator({onShow:"请选择业务部门",onFocus:"业务部门必须选择",onCorrect:"已选择",defaultValue:""})
            .inputValidator({min:1,onError: "请选择业务部门!"})
            .defaultPassed();
        //项目需求
        $("#context").formValidator({onShow:"请输入项目需求",onFocus:"请按正确格式填写项目需求",onCorrect:"已输入项目需求信息"})
            .inputValidator({min:4,max:500,onErrorMin:"姓名长度太短",onError:"请按正确格式填写项目需求"});

    });
</script>