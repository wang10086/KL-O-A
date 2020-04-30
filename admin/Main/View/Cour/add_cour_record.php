<include file="Index:header2" />

        <aside class="right-side">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>{$_pagetitle_}</h1>
                <ol class="breadcrumb">
                    <li><a href="{:U('Index/index')}"><i class="fa fa-home"></i> 首页</a></li>
                    <li><a href="javascript:;"><i class="fa fa-gift"></i> {$_pagetitle_}</a></li>
                    <li class="active">{$_action_}</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
            <form method="post" action="{:U('Cour/add_plan')}" name="myform">
            <input type="hidden" name="dosubmint" value="1">
            <input type="hidden" name="id" value="{$list.id}">
                <div class="row">
                     <!-- right column -->
                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title">{$_action_}</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="content">
                                    <div class="form-group col-md-12">
                                        <label>培训标题：</label>
                                        <input type="hidden" name="info[plan_id]" value="{$list.plan_id}" id="plan_id">
                                        <select  class="form-control"  name="info[title]"  required>
                                            <option value="" selected disabled>请选择培训标题</option>
                                            <foreach name="lists" item="v">
                                                <option value="{$v.title}" <?php if ($list['plan_id'] == $v['id']) echo "selected"; ?>>{$v.title}</option>
                                            </foreach>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>培训目的：</label><input type="text" name="info[end]" class="form-control" value="{$list.end}" readonly />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>完成时间：</label><input type="text" name="info[time]" class="form-control" value="<?php echo $list['time'] ? date('Y-m-d',$list['time']) : ''; ?>" readonly />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>培训负责人：</label>
                                        <input type="text" name="info[blame_name]" class="form-control" value="{$list.blame_name}" readonly />
                                        <input type="hidden" name="info[blame_uid]" class="form-control" value="{$list.blame_uid}" readonly />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>培训类型：</label>
                                        <input type="text" name="info[time]" class="form-control" value="" readonly />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>培训人：</label><font color="#999">(点击匹配到的人员)</font>
                                        <input type="text" name="info[teacher_name]" value="{$list['teacher_name']}" class="form-control" placeholder="培训人" id="teacher_name" />
                                        <input type="hidden" name="info[teacher_uid]" value="{$list['teacher_uid']}" class="form-control" id="teacher_uid" />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <P class="border-bottom-line"> 培训对象</P>
                                        <div class="form-group col-md-12" id="user-container">
                                            <button type="button" class="user-box" onclick="javascript:select_all_user($(this))">
                                                全选
                                                <input type="hidden" id="all_user_type" value="1">
                                            </button>
                                            <foreach name="users" item="v">
                                                <button type="button" class="user-box <?php if (in_array($v['nickname'],$userNames)) echo "bg-light-blue"; ?>" onclick="javascript:select_user($(this))">
                                                    {$v.nickname}
                                                    <input type="hidden" <?php if (in_array($v['id'],$userIds)) echo "name='userids[]'"; ?> value="{$v.id}">
                                                </button>
                                            </foreach>
                                        </div>
                                        <div class="form-group">&nbsp;</div>
                                    </div>

                                    <div class="form-group col-md-12"></div>

                                    <div id="formsbtn">
                                        <button type="submit" class="btn btn-info btn-lg" id="lrpd">保存</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!--/.col (right) -->
                </div>   <!-- /.row -->
                </form>
            </section><!-- /.content -->

        </aside><!-- /.right-side -->

  </div>
</div>

<include file="Index:footer2" />
<script type="text/javascript">
    const keywords = <?php echo $userkey; ?>;
    $(document).ready(function(e){
        autocomplete_id('teacher_name','teacher_uid',keywords);
    })

    function select_user(index) {
        let checkClassName = 'bg-light-blue';
        let thisClassName  = index.attr('class');
        let checked        = thisClassName.indexOf(checkClassName);
        if (checked === -1){ //未选中
            index.addClass(checkClassName);
            index.find('input').attr('name','userids[]')
        }else{
            index.removeClass(checkClassName);
            index.find('input').attr('name','')
        }
    }

    //全选
    function select_all_user(index) {
        let checkClassName = 'bg-light-blue';
        let allUserType    = $('#all_user_type').val();
        if (allUserType == 1){ //全选
            $('#all_user_type').val(0);
            $('#user-container').find('.user-box').each(function () {
                let input_id       = $(this).find('input').attr('id');
                if (input_id != 'all_user_type'){
                    $(this).addClass(checkClassName);
                    $(this).find('input').attr('name','userids[]')
                }else{
                    $(this).addClass(checkClassName);
                }
            })
        }else{
            $('#all_user_type').val(1);
            $('#user-container').find('.user-box').each(function () {
                let input_id       = $(this).find('input').attr('id');
                if (input_id != 'all_user_type'){
                    $(this).removeClass(checkClassName);
                    $(this).find('input').attr('name','')
                }else{
                    $(this).removeClass(checkClassName);
                }
            })
        }
    }
</script>

