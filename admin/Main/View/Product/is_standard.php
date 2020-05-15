<div class="form-group col-md-6" id="standard_box">
    <p><label>是否标准化产品</label></p>
    <input type="radio" name="info[standard]" value="1" <?php if ($list['standard'] == 1) echo "checked"; ?>> &#8194;标准化 &#12288;
    <input type="radio" name="info[standard]" value="2" <?php if (in_array($list['standard'], array(0,2))) echo "checked"; ?>> &#8194;非标准化
</div>

<div class="form-group col-md-6" style="clear: right;" id="line_or_product">
    <label style="display: block">标准化产品</label>
    <input type="text" name="producted_title" class="form-control" value="{$producted_list.title}" style="width: 75%; display: inline-block;" readonly>
    <input type="hidden" name="info[producted_id]" value="{$list.producted_id}">
    <span style="display: inline-block; width: 20%; margin-left: 3px">
        <a  href="javascript:;" class="btn btn-default btn-sm" >获取产品</a>
    </span>
</div>