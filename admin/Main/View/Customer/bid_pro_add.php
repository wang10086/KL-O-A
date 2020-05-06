<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Rbac/index')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <include file="Customer:bid_navigate" />

                            <div class="box box-success mt20">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="content">
                                        <div class="form-group col-md-4">
                                            <label>投标项目</label>
                                            <select class="form-control" name="">
                                                <option value=""></option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>提交人</label>
                                            <input type="text" name="info[blame_name]" value="{$list['blame_name']}" class="form-control" placeholder="活动负责人" id="blame_name" readonly />
                                            <input type="hidden" name="info[blame_uid]" value="{$list['blame_uid']}" class="form-control" id="blame_uid" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>招标方</label>
                                            <input type="text" name="customer" value="{$list['customer']}" class="form-control" readonly />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>投标时间</label>
                                            <input type="text" name="info[bid_time]" class="form-control inputdate" value="<if condition="$list['bid_time']">{$list.bid_time|date='Y-m-d',###}</if>" readonly />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>投标小组组长</label>
                                            <input type="text" name="info[manager_name1]" value="{$list['manager_name1']}" class="form-control" id="manager_name1" />
                                            <input type="hidden" name="info[manager_uid1]" value="{$list['manager_uid1']}" class="form-control" id="manager_uid1" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>投标小组副组长</label>
                                            <input type="text" name="info[manager_name2]" value="{$list['manager_name2']}" class="form-control" id="manager_name2" />
                                            <input type="hidden" name="info[manager_uid2]" value="{$list['manager_uid2']}" class="form-control" id="manager_uid2" />
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>小组成员</label> <font color="#999">(多个成员请用空格隔开)</font>
                                            <input type="text" name="info[users]" value="{$list['users']}" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-4 ">
                                            <label>投标费用合计(元)</label>
                                            <input type="text" name="info[cost]" value="{$list['cost']}" class="form-control" />
                                        </div>

                                        <div class="form-group col-md-4 ">
                                            <label>是否需要借款</label>
                                            <input type="radio" name="jiekuan" value="0"  <?php if($list['jiekuan']==0){ echo 'checked';} ?>> &#8194;不需要 &#12288;&#12288;&#12288;
                                            <input type="radio" name="jiekuan" value="1"  <?php if($list['jiekuan']==1){ echo 'checked';} ?>> &#8194;需要
                                        </div>

                                        <div class="form-group col-md-12">
                                            <P class="border-bottom-line"> 活动安排</P>
                                            <div class="form-group col-md-12" id="project">
                                                <div class="userlist">
                                                    <div class="unitbox_15">事项</div>
                                                    <div class="unitbox_15">负责人</div>
                                                    <div class="unitbox_15">完成时间</div>
                                                    <div class="unitbox_25">活动内要求容</div>
                                                    <div class="unitbox_25">备注</div>
                                                </div>
                                                <?php if($timeLists){ ?>
                                                    <foreach name="timeLists" key="kk" item="pp">
                                                        <div class="userlist" id="project_box_8888{$pp.id}">
                                                            <span class="title"><?php echo $kk+1; ?></span>
                                                            <input type="hidden" name="project[8888{$pp.id}][reset_id]" value="{$pp.id}">

                                                            <div class="f_15">
                                                                <input type="text" class="form-control" name="project[8888{$pp.id}][title]" value="{$pp.title}">
                                                            </div>
                                                            <div class="f_15">
                                                                <input type="text" class="form-control" name="project[8888{$pp.id}][addr]" value="{$pp.addr}">
                                                            </div>
                                                            <div class="f_15">
                                                                <input type="text" class="form-control" name="project[8888{$pp.id}][blame_name]" value="" id="blame_name_8888{$pp.id}">
                                                                <input type="hidden" name="project[8888{$pp.id}][blame_uid]" value="" class="form-control" id="blame_uid_8888{$pp.id}" />
                                                            </div>
                                                            <div class="f_25">
                                                                <input type="text" class="form-control" name="project[8888{$pp.id}][content]" value="{$pp.content}">
                                                            </div>
                                                            <div class="f_25">
                                                                <input type="text" class="form-control" name="project[8888{$pp.id}][remark]" value="{$pp.remark}">
                                                            </div>

                                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('project_box_8888{$pp.id}')">删除</a>

                                                        </div>
                                                    </foreach>
                                                <?php }else{ ?>
                                                    <div class="userlist" id="project_box_id">
                                                        <span class="title">1</span>
                                                        <!--<input type="hidden" name="project[1][no]" class="payno" value="1">-->
                                                        <div class="f_15">
                                                            <input type="text" class="form-control" name="project[1][title]" value="">
                                                        </div>

                                                        <div class="f_15">
                                                            <input type="text" class="form-control" name="project[1][addr]" value="">
                                                        </div>

                                                        <div class="f_15">
                                                            <input type="text" class="form-control" name="project[1][blame_name]" value="" id="blame_name_1">
                                                            <input type="hidden" name="project[1][blame_uid]" value="" class="form-control" id="blame_uid_1" />
                                                        </div>
                                                        <div class="f_25">
                                                            <input type="text" class="form-control" name="project[1][content]" value="">
                                                        </div>
                                                        <div class="f_25">
                                                            <input type="text" class="form-control" name="project[1][remark]" value="">
                                                        </div>

                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('project_box_id')">删除</a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div id="project_val">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_pro()"><i class="fa fa-fw fa-plus"></i> 增加活动安排</a>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <P class="border-bottom-line"> 活动预算</P>
                                            <div class="form-group col-md-12" id="payment">
                                                <div class="userlist">
                                                    <div class="unitbox_12">项目</div>
                                                    <div class="unitbox_12">单位</div>
                                                    <div class="unitbox_12">单价</div>
                                                    <div class="unitbox_12">数量</div>
                                                    <div class="unitbox_12">费用</div>
                                                    <div class="unitbox_12">受款方</div>
                                                    <div class="unitbox_23">备注</div>
                                                </div>
                                                <?php if($timeLists){ ?>
                                                    <foreach name="timeLists" key="kk" item="pp">
                                                        <div class="userlist" id="pretium_8888{$pp.id}">
                                                            <span class="title"><?php echo $kk+1; ?></span>
                                                            <input type="hidden" name="payment[8888{$pp.id}][reset_id]" value="{$pp.id}">

                                                            <div class="f_12">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][title]" value="{$pp.title}">
                                                            </div>

                                                            <div class="f_12">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][unit]" value="{$pp.unit}">
                                                            </div>

                                                            <div class="f_12">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][unitcost]" value="{$pp.unitcost}">
                                                            </div>

                                                            <div class="f_12">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][num]" value="{$pp.num}">
                                                            </div>

                                                            <div class="f_12">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][total]" value="{$pp.total}">
                                                            </div>

                                                            <div class="f_12">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][supplierRes]" value="{$pp.supplierRes}">
                                                            </div>

                                                            <div class="f_23">
                                                                <input type="text" class="form-control" name="payment[8888{$pp.id}][remark]" value="{$pp.remark}">
                                                            </div>

                                                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_8888{$pp.id}')">删除</a>

                                                        </div>
                                                    </foreach>
                                                <?php }else{ ?>
                                                    <div class="userlist" id="pretium_id">
                                                        <span class="title">1</span>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="payment[1][title]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="payment[1][unit]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="payment[1][unitcost]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="payment[1][num]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="payment[1][total]" value="">
                                                        </div>

                                                        <div class="f_12">
                                                            <input type="text" class="form-control" name="payment[1][supplierRes]" value="">
                                                        </div>

                                                        <div class="f_23">
                                                            <input type="text" class="form-control" name="payment[1][remark]" value="">
                                                        </div>

                                                        <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('pretium_id')">删除</a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div id="payment_val">1</div>
                                            <div class="form-group col-md-12" id="useraddbtns">
                                                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_cost()"><i class="fa fa-fw fa-plus"></i> 增加活动安排</a>
                                            </div>
                                        </div>

                                        <div id="formsbtn">
                                            <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                            <button type="submit" class="btn btn-warning btn-lg" id="lrpd">提交</button>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </div>
                        </div>
                     </div>

                </section>
            </aside>

<include file="Index:footer2" />

<script type="text/javascript">
    const keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
        autocomplete_id('blame_name','blame_uid',keywords);
        autocomplete_id('manager_name1','manager_uid1',keywords);
        autocomplete_id('manager_name2','manager_uid2',keywords);
    })

    //编号
    function orderno(){
        $('#payment').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
        $('#payment').find('.payno').each(function(index, element) {
            $(this).val(parseInt(index)+1);
        });

        $('#project').find('.title').each(function(index, element) {
            $(this).text(parseInt(index)+1);
        });
    }

    //移除
    function delbox(obj){
        $('#'+obj).remove();
        orderno();
    }

    function add_pro(){
        var i = parseInt($('#project_val').text())+1;

        var html = '<div class="userlist" id="project_box_'+i+'">';
        html += '<span class="title"></span>';
        html += '<div class="f_15"><input type="text" class="form-control" name="project['+i+'][title]" value=""></div>';
        html += '<div class="f_15"><input type="text" class="form-control" name="project['+i+'][addr]" value=""></div>';
        html += '<div class="f_15"><input type="text" class="form-control" name="project['+i+'][blame_name]" value="" id="blame_name" /><input type="hidden" name="info[blame_uid]" value="{$list[\'blame_uid\']}" class="form-control" id="blame_uid" /></div>';
        html += '<div class="f_25"><input type="text" class="form-control" name="project['+i+'][content]" value=""></div>';
        html += '<div class="f_25"><input type="text" class="form-control" name="project['+i+'][long]" value=""></div>';
        html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(`project_box_'+i+'`)">删除</a>';
        $('#project').append(html);
        $('#project_val').html(i);
        orderno();
        //relaydate();
    }

    //新增
    function add_cost(){
        var i = parseInt($('#payment_val').text())+1;

        var html = '<div class="userlist" id="pretium_id_'+i+'">';
        html += '<span class="title"></span>';
        html += '<div class="f_12"><input type="text" class="form-control" name="payment['+i+'][title]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="payment['+i+'][unit]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="payment['+i+'][unitcost]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="payment['+i+'][num]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="payment['+i+'][total]" value=""></div>';
        html += '<div class="f_12"><input type="text" class="form-control" name="payment['+i+'][supplierRes]" value=""></div>';
        html += '<div class="f_23"><input type="text" class="form-control" name="payment['+i+'][remark]" value=""></div>';
        html += '<a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox(`pretium_id_'+i+'`)">删除</a>';
        html += '</div>'
        $('#payment').append(html);
        $('#payment_val').html(i);
        orderno();
        //relaydate();
    }
</script>


