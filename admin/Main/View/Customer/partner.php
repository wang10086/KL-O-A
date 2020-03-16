<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>{$_action_}</h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Customer/partner')}"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	 <a href="{:U('Customer/public_partner_map')}" class="btn btn-primary btn-sm"><i class="fa fa-map-marker"></i> 合伙人分布</a>
                                    	 <a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',700,100);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Customer/partner_edit'))">
                                            <a href="{:U('Customer/partner_edit')}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 录入合伙人</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th class="sorting" width="60" data="id">ID</th>
                                        <th class="sorting" data="name">合伙人名称</th>
                                        <!--<th class="sorting" data="manager">负责人</th>
                                        <th class="sorting" data="contacts">联系人</th>
                                        <th class="sorting" data="contacts_phone">联系电话</th>-->
                                        <th class="sorting" data="province">合伙人所在地</th>
                                        <th class="sorting" data="agent_province">独家区域</th>
                                        <th class="sorting" data="money">保证金</th>
                                        <th class="sorting" data="end_date">协议期限</th>
                                        <th class="taskOptions" data="cm_name">维护人</th>
                                        <th class="taskOptions" data="audit_stu">审核状态</th>
                                        <if condition="rolemenu(array('Customer/change_cm'))">
                                            <th width="50" class="taskOptions">交接</th>
                                        </if>
                                        <if condition="rolemenu(array('Customer/partner_edit'))">
                                        <th width="50" class="taskOptions">编辑</th>
                                        </if>
                                        <if condition="rolemenu(array('Customer/del_partner'))">
                                        <th width="50" class="taskOptions">删除</th>
                                        </if>
                                    </tr>
                                    <!--
                                    <?php if (rolemenu(array('Customer/change_cm')) && $partner['id']){ ?>
                                            <span  style=" border: solid 1px #00acd6; padding: 0 5px; border-radius: 5px; background-color: #00acd6; color: #ffffff; margin-left: 20px" onClick="open_change()" title="交接维护人" class="">交接维护人</span>
                                        <?php } ?>
                                    -->
                                    <foreach name="lists" item="row">
                                    <tr>
                                        <td>{$row.id}</td>
                                        <td align="center"><a href="{:U('Customer/partner_detail',array('id'=>$row['id']))}" title="详情">{$row.name}</a><?php if (in_array($row['id'],$score_partner_ids)){ echo "<i class='fa  fa-qrcode' title='获取满意度二维码' style='color:#3CF; margin-left:8px; cursor:pointer;' onClick='get_qrcode(`/index.php?m=Main&c=Kpi&a=public_qrcode&uid=$kpi_more[user_id]&tit=$kpi_more[quota_title]&kpi_quota_id=$kpi_more[quota_id]&partner_id=$row[id]`)'></i>"; } ?></td>
                                        <!--<td>{$row.manager}</td>
                                        <td>{$row.contacts}</td>
                                        <td>{$row.contacts_phone}</td>-->
                                        <td>{$citys[$row[province]]} {$citys[$row[city]]} {$citys[$row[country]]}</td>
                                        <td>{$citys[$row[agent_province]]} {$citys[$row[agent_city]]} {$citys[$row[agent_country]]}</td>
                                        <td>{$row.money}</td>
                                        <td>{$row.start_date|date="Y-m-d",###} - <?php if (time() > $row['end_date']){ echo "<span class='red'>".date('Y-m-d',$row['end_date'])."</span>"; }else{ echo date('Y-m-d',$row['end_date']); } ?> </td>
                                        <td class="taskOptions">{$row.cm_name}</td>
                                        <td class="taskOptions">{$audit_stu[$row[audit_stu]]}</td>
                                        <if condition="rolemenu(array('Customer/change_cm'))">
                                            <td width="50" class="taskOptions">
                                                <a href="javascript:;" onclick="open_change({$row.id})"  title="交接维护人" class="btn btn-warning btn-smsm"><i class="fa fa-refresh"></i></a>
                                            </td>
                                        </if>
                                        <if condition="rolemenu(array('Customer/partner_edit'))">
                                        <td class="taskOptions">
                                            <?php if (($row['audit_stu'] != 2 && $row['create_user_id'] == cookie('userid')) || rolemenu(array('Customer/audit_partner'))){ ?>
                                                <a href="{:U('Customer/partner_edit',array('id'=>$row['id']))}" title="编辑" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></a>
                                            <?php }else{ ?>
                                                <button href="javascript:;" title="编辑" class="btn btn-disable btn-smsm"><i class="fa fa-pencil"></i></button>
                                            <?php } ?>
                                        </td>
                                        </if>
                                        <if condition="rolemenu(array('Customer/del_partner'))">
                                            <td class="taskOptions">
                                                <button onclick="javascript:ConfirmDel('{:U('Customer/del_partner',array('id'=>$row['id']))}')" title="删除" class="btn btn-danger btn-smsm"><i class="fa fa-times"></i></button>
                                            </td>
                                        </if>
                                    </tr>
                                    </foreach>
                                </table>
                                </div><!-- /.box-body -->
                                 <div class="box-footer clearfix">
                                	<div class="pagestyle">{$pages}</div>
                                </div>
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                     </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->


            <div id="searchtext">
                <form action="" method="get" id="searchform">
                <input type="hidden" name="m" value="Main">
                <input type="hidden" name="c" value="Customer">
                <input type="hidden" name="a" value="partner">

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="合作伙伴名称">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="联系人">
                </div>

                <div class="form-group col-md-6">
                	<input type="text" class="form-control" name="province" placeholder="省份">
                </div>

                <div class="form-group col-md-6">
                    <input type="text" class="form-control" name="keywords" placeholder="维护人">
                </div>

                </form>
            </div>

<script type="text/javascript">
    //交接维护人
    function open_change (id) {
        let url = '/index.php?m=Main&c=Customer&a=change_cm&id='+id;
        art.dialog.open(url, {
            lock:true,
            id: 'change',
            title: '交接维护人',
            width:600,
            height:300,
            okValue: '提交',
            ok: function () {
                this.iframe.contentWindow.gosubmint();
                //location.reload();
                return false;
            },
            cancelValue:'取消',
            cancel: function () {
            }
        });
    }

    //获取评分二维码
    function get_qrcode(url) {
        art.dialog.open(url,{
            id:'qrcode',
            lock:true,
            title: '二维码',
            width:600,
            height:400,
            fixed: true,
        });
    }
</script>


			<include file="Index:footer2" />


