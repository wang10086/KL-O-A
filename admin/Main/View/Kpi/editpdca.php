<include file="Index:header_art" />

	<script type="text/javascript">
    window.gosubmint= function(){
        var rs = new Array();
        var file = '';
        $('.selectdir').each(function(index, element) {
            var checked = $(this).parent().attr('aria-checked');
            if(checked=="true"){
                file += $(this).attr('value');
            }
        });	
        
        var obj = {};
            obj.files     = '{$fid}';
            obj.dir       = file;
            rs.push(obj);
        return rs;	
     } 
    </script>
    
    <div class="box-body">
    
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
        
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
        
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
        
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
        
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
        
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
        
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
        
        <div class="form-group col-md-4">
            <label>物资名称</label>
            <input type="text" name="info[material]" id="title" value="{$row.material}"  class="form-control" />
        </div>
                                
    </div>                  
    
    <include file="Index:footer" />
        
       