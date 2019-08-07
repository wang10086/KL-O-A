<div class="content" style="padding-top:10px;">
    
    <div id="mingdan">
        <?php if($member){ ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="">编号</th>
                    <th width="">姓名</th>
                    <th width="">性别</th>
                    <th width="">证件号</th>
                    <th width="">联系电话</th>
                    <th width="">家长姓名</th>
                    <th width="">家长电话</th>
                    <th width="30%">单位</th>
                </tr>
            </thead>
            <tbody>
                <foreach name="member" key="k" item="v">
                <tr>
                    <td><?php echo $k+1; ?></td>
                    <td>{$v.name}</td>
                    <td>{$v.sex}</td>
                    <td>{$v.number}</td>
                    <td>{$v.mobile}</td>
                    <td>{$v.ecname}</td>
                    <td>{$v.ecmobile}</td>
                    <td>{$v.remark}</td>
                </tr>    
                </foreach>                                            
            </tbody>
        </table>
        <?php }else{ echo '<div class="form-group" style="padding:20px 0;">暂无人员名单！</div>';} ?>
    </div>
    
    
    
    <div class="form-group">&nbsp;</div>
</div>