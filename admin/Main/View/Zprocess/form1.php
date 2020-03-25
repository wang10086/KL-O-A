<include file="Index:header2" />

<style>

</style>

            <aside class="right-side">
                <section class="content-header" style="padding: 5px">
                    <include file="Index:ZcontentHeaderFile" />
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="zpage-title">{$list.title}</div>
                    <div class="row">
                         <!-- right column -->
                        <div class="col-md-12">
                            <div class="zbox">

                                <div class="content">
                                    <div class="form-group col-md-12">
                                        <label>标题：</label><input type="text" name="info[project]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>业务季：</label>
                                        <select  class="form-control"  name="info[apply_to]" required>
                                            <option value="" selected disabled>==请选择==</option>
                                            <foreach name="apply_to" key="k" item="v">
                                                <option value="{$k}" <?php if ($row && ($k == $row['grade'])) echo ' selected'; ?> >{$v}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>客户数据：</label><input type="text" name="info[number]" class="form-control" required />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>销售：</label><input type="text" name="info[departure]"  class="form-control inputdate"  required />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <a href="javascript:;" id="pickupfile" class="btn btn-success btn-sm" style="margin-top:15px; float:left;"><i class="fa fa-upload"></i> 上传文件</a>
                                        <span style="line-height:30px; float:left;margin-left:15px; margin-top:15px; color:#999999;">请选择小于10M的文件，支持JPG / GIF / PNG / DOC / XLS / PDF / ZIP / RAR文件类型</span>

                                        <table id="flist" class="table" style="margin-top:15px; float:left; clear:both; border-top:1px solid #dedede;">
                                            <tr>
                                                <th align="left" width="">文件名称</th>
                                                <th align="left" width="100">大小</th>
                                                <th align="left" width="30%">上传进度</th>
                                                <th align="left" width="60">操作</th>
                                            </tr>

                                            <?php if($files){?>
                                                <foreach name="files" key="k" item="v">
                                                    <tr id="<?php echo $v['id']?>"  valign="middle" class="un_upload" >
                                                        <td class="iptval">
                                                            <input type="text" name="newname[{$v['id']}]" value="<?php echo $v['filename'];?>" class="form-control file_val" />
                                                            <input type="hidden" name="fileid[{$v['id']}]" value="{$v['id']}">
                                                        </td>
                                                        <td> <?php echo $v['filesize'];?></td>
                                                        <td>
                                                            <div class="progress sm">
                                                                <div class="progress-bar progress-bar-aqua" rel="o_1d1aj6qv6hneji21v471vah17u1c" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-danger btn-xs " href="javascript:;" onclick="removeThisFile(<?php echo $v['id']?>)">
                                                                <i class="fa fa-times"></i>删除
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </foreach>
                                            <?php } ?>

                                        </table>
                                        <div id="container" style="display:none;"></div>
                                    </div>
                                </div>
                            </div><!-- /.box -->


                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

  </div>
</div>

<script type="text/javascript">

</script>

<include file="Index:footer2" />
