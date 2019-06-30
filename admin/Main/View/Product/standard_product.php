<include file="Index:header2" />

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {$pageTitle}
                        <small>{$_pagedesc_}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="{:U('Product/standard_product')}"><i class="fa fa-gift"></i> {$pageTitle}</a></li>
                        <li class="active">{$_action_}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title">{$_action_}</h3>
                                    <div class="box-tools pull-right">
                                    	<a href="javascript:;" class="btn btn-info btn-sm" onclick="javascript:opensearch('searchtext',600,160);"><i class="fa fa-search"></i> 搜索</a>
                                        <if condition="rolemenu(array('Product/add_standard_product'))">
                                            <a href="{:U('Product/add_standard_product',array('pin'=>$pin))}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> 新建标准化产品</a>
                                        </if>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="btn-group" id="catfont">
                                        <button onClick="javascript:window.location.href='{:U('Product/standard_product',array('pin'=>0))}';" class="btn <?php if($pin==0){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$ltitle[0]['title']}</button>
                                        <button onClick="javascript:window.location.href='{:U('Product/standard_product',array('pin'=>1))}';" class="btn <?php if($pin==1){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$ltitle[1]['title']}</button>
                                        <button onClick="javascript:window.location.href='{:U('Product/standard_product',array('pin'=>2))}';" class="btn <?php if($pin==2){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$ltitle[2]['title']}</button>
                                        <button onClick="javascript:window.location.href='{:U('Product/standard_product',array('pin'=>3))}';" class="btn <?php if($pin==3){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$ltitle[3]['title']}</button>
                                        <button onClick="javascript:window.location.href='{:U('Product/standard_product',array('pin'=>4))}';" class="btn <?php if($pin==4){ echo 'btn-info';}else{ echo 'btn-default';} ?>">{$ltitle[4]['title']}</button>
                                    </div>
                                
                                <table class="table table-bordered dataTable fontmini" id="tablelist" style="margin-top:10px;">
                                    <tr role="row" class="orders" >
                                        <th>产品名称</th>
                                        <th>所属领域</th>
                                        <th>适合人群</th>
                                        <th>适用项目类型</th>
                                        <th >产品报价</th>
                                        <th>审批状态</th>
                                        <th width="80">编辑</th>
                                        <th width="80">删除</th>
                                    </tr>
                                    <foreach name="lists" item="row">
                                        <tr>
                                            <td>{$row.id}</td>
                                            <td>{$row.tpl_name}</td>
                                            <td>
                                            <?php foreach ($row['product'] as $v) { 
                                            echo '<span class="col-md-3"> '.$v[id].' - '.$v['title'].'</span>';
                                            }?>
                                            </td>
                                            <td>
                                            <button onClick="javascript:window.location.href='{:U('Product/addtpl',array('id'=>$row['id']))}';" title="修改" class="btn btn-info btn-smsm"><i class="fa fa-pencil"></i></button>
                                            &nbsp;&nbsp;
                                            <button onClick="javascript:ConfirmDel('{:U('Product/deltpl',array('id'=>$row['id']))}')" title="删除" class="btn btn-warning btn-smsm"><i class="fa fa-times"></i></button>
                                            </td>
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
            <input type="hidden" name="c" value="Product">
            <input type="hidden" name="a" value="standard_product">
            <input type="hidden" name="pro" value="{$pro}">
            <div class="form-group col-md-12">
                <input type="text" class="form-control" name="key" placeholder="关键字">
            </div>

            <div class="form-group col-md-12">
                <select class="form-control" name="type">
                    <option value="">类别</option>
                    <foreach name="ptype" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                    </foreach>
                </select>
            </div>

            <div class="form-group col-md-12">
                <select class="form-control" name="age">
                    <option value="">适用年龄</option>
                    <foreach name="ages" key="k" item="v">
                        <option value="{$k}">{$v}</option>
                    </foreach>
                </select>
            </div>

        </form>
    </div>

<include file="Index:footer2" />
