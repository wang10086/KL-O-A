<form method="post" action="{:U('Finance/save_costacc')}" name="myform" id="myform">
<!--<form method="post" action="{:U('Finance/save_costacc')}" name="myform" id="myform" onsubmit="return submintform()">-->
<input type="hidden" name="dosubmint" value="1">
<input type="hidden" name="opid" value="{$op.op_id}">
<input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" />
<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">成本核算</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content" style="padding-top:0px;">
            <div id="costacc">
                <div class="userlist">
                    <div class="unitbox">费用项</div>
                    <div class="unitbox">单价</div>
                    <div class="unitbox">数量</div>
                    <div class="unitbox">合计</div>
                    <div class="unitbox">类型</div>
                    <div class="unitbox longinput">备注</div>
                </div>
                <?php if($costacc){ ?>
                <foreach name="costacc" key="k" item="v">
                <div class="userlist cost_expense" id="costacc_id_c_{$k}">
                    <span class="title"><?php echo $k+1; ?></span>
                    <input type="hidden" name="resid[888{$k}][id]" value="{$v.id}" >
                    <input type="hidden" class="form-control" name="costacc[888{$k}][supplier_id]" value="{$v.supplier_id}">
                    <input type="hidden" class="form-control" name="costacc[888{$k}][supplier_name]" value="{$v.supplier_name}">
                    <input type="text" class="form-control" name="costacc[888{$k}][title]" value="{$v.title}">
                    <input type="text" class="form-control cost" name="costacc[888{$k}][unitcost]" value="{$v.unitcost}">
                    <input type="text" class="form-control amount" name="costacc[888{$k}][amount]" value="{$v.amount}">
                    <input type="text" class="form-control totalval" name="costacc[888{$k}][total]" value="{$v.total}">
                    <select class="form-control"  name="costacc[888{$k}][type]" onChange="bijia('costacc_bijia_{$k}',this)" >
                    	<foreach name="kind" key="kk" item="vv">
                    	<option value="{$kk}" <?php if($kk==$v['type']){ echo 'selected';} ?> >{$vv}</option>
                        </foreach>
                        
                    </select>
                    <input type="text" class="form-control longinput" name="costacc[888{$k}][remark]" value="{$v.remark}">
                    <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_c_{$k}')">删除</a>
                    <a href="javascript:;" class="btn btn-success btn-flat" id="costacc_bijia_{$k}" style="display:none;">比价</a>
                </div>
                </foreach>
                <?php }else{ ?>
                    <?php if($guide_price){ ?>
                        <foreach name="guide_price" key="k" item="v">
                            <div class="userlist cost_expense" id="costacc_id_gui_{$k}" >
                                <span class="title"><?php echo $k+1; ?></span>
                                <input type="text" class="form-control" name="costacc[888{$k}][title]" value="{$v.title}">
                                <input type="text" class="form-control cost" name="costacc[888{$k}][unitcost]" value="{$v.price}">
                                <input type="text" class="form-control amount" name="costacc[888{$k}][amount]" value="{$v.num}">
                                <input type="text" class="form-control totalval" name="costacc[888{$k}][total]" value="{$v.total}">
                                <select class="form-control"  name="costacc[888{$k}][type]" onChange="bijia('costacc_bijia_{$k}',this)" >
                                    <foreach name="kind" key="kk" item="vv">
                                        <option value="{$kk}" <?php if($kk==$v['type']){ echo 'selected';} ?> >{$vv}</option>
                                    </foreach>

                                </select>
                                <input type="text" class="form-control longinput" name="costacc[888{$k}][remark]" value="{$v.remark}">
                                <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_gui_{$k}')">删除</a>
                                <a href="javascript:;" class="btn btn-success btn-flat" id="costacc_bijia_{$k}" style="display:none;">比价</a>
                            </div>
                        </foreach>
                    <?php } ?>
                    <?php  if($mokuailist){  ?>
                        <foreach name="mokuailist" key="k" item="v">
                        <div class="userlist cost_expense" id="costacc_id_d_{$k}">
                            <span class="title"><?php echo $k+1; ?></span>
                            <input type="text" class="form-control" name="costacc[222{$k}][title]" value="{$v.material}">
                            <input type="text" class="form-control cost" name="costacc[222{$k}][unitcost]" value="{$v.unitprice}">
                            <input type="text" class="form-control amount" name="costacc[222{$k}][amount]" value="{$v.amount}">
                            <input type="text" class="form-control totalval" name="costacc[222{$k}][total]" value="<?php echo $v['unitprice']*$v['amount'];?>">
                            <select class="form-control"  name="costacc[222{$k}][type]" onChange="bijia('bijia_{$k}',this)" >
                                <foreach name="kind" key="kk" item="vv">
                                <option value="{$kk}" <?php if($kk==$v['type']){ echo 'selected';} ?> >{$vv}</option>
                                </foreach>
                            </select>
                            <input type="text" class="form-control longinput" name="costacc[222{$k}][remark]" value="{$v.remarks}">
                            <a href="javascript:;" class="btn btn-danger btn-flat" onclick="delbox('costacc_id_d_{$k}')">删除</a>
                            <a href="javascript:;" class="btn btn-success btn-flat" id="bijia_{$k}" style="display:none;">比价</a>
                        </div>
                        </foreach>
                <?php } } ?>
            </div>
            <div id="costacc_sum">
                <div class="userlist">
                    <div class="unitbox"></div>
                    <div class="unitbox"></div>
                    <div class="unitbox" style="  text-align:right;">合计</div>
                    <div class="unitbox" id="costaccsum"></div>
                    <div class="unitbox longinput"></div>
                </div>
            </div>
            <div id="costacc_val">1</div>
            <div class="form-group col-md-12" id="useraddbtns" style="margin-left:15px;">
                <a href="javascript:;" class="btn btn-success btn-sm" onClick="add_costacc()"><i class="fa fa-fw fa-plus"></i> 新增成本项</a> 
                
            </div>
            <div class="form-group">&nbsp;</div>
        </div>
        
       
        

        <div class="content">
        
        
        <div class="form-group col-md-4">
            <label>成本价格：</label>
            
            <div style=" width:100%;">
                <span style="width:65%; float:left;"><input type="text" name="info[costacc]" value="" class="form-control" id="costaccsumval" readonly value="{$op.costacc}" /></span>
                <span style="width:35%; float:left; margin-left:-1px;"><input type="text" name="" class="form-control" value="{$op.costacc_unit}" placeholder="元" /></span>
            </div>

            
        </div>
        
        <div class="form-group col-md-4">
            <label>建议最低报价：</label>
            <div style=" width:100%;">
                <span style="width:65%; float:left;"><input type="text" name="info[costacc_min_price]" value="{$op.costacc_min_price}" class="form-control" required /></span>
                <span style="width:35%; float:left; margin-left:-1px;"><input type="text" name="" class="form-control" value="{$op.costacc_min_price_unit}" placeholder="元" /></span>
            </div>
        </div>
        
        <div class="form-group col-md-4">
            <label>建议最高报价：</label>
            <div style=" width:100%;">
                <span style="width:65%; float:left;"><input type="text" name="info[costacc_max_price]" value="{$op.costacc_max_price}"  class="form-control" required /></span>
                <span style="width:35%; float:left; margin-left:-1px;"><input type="text" name="" value="{$op.costacc_max_price_unit}"  class="form-control" placeholder="元"/></span>
            </div>
        </div>
        
        
        
        </div>
    </div>
</div>


<div id="formsbtn" style="padding-bottom:10px;">
    <!--<button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>-->
    <a type="button" onclick="submintform()" class="btn btn-info btn-lg" id="lrpd">保存</a>
</div>

</form>