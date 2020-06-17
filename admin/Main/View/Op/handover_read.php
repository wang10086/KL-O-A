<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">客户需求详情</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="content">
            <div class="form-group col-md-12">
                <P class="border-bottom-line"> 交接清单是否交接</P>
                <foreach name="handover_types" key="kk" item="vv">
                    <div class="form-group col-md-4">
                        <label>{$vv}：</label>
                        <input type="radio" name="data[{$kk}]" value="1" <?php if ($handover_list && $handover_list[$kk]==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[{$kk}]" value="0" <?php if ($handover_list && $handover_list[$kk]==0) echo 'checked'; ?>> &#8194;否
                    </div>
                </foreach>

                <P class="border-bottom-line"> 交接清单是否交回</P>
                <foreach name="handover_types" key="kk" item="vv">
                    <div class="form-group col-md-4">
                        <label>{$vv}：</label>
                        <input type="radio" name="data[{$kk}1]" value="1" <?php $key= $kk.'1'; if ($handover_list && $handover_list[$key]==1) echo 'checked'; ?>> &#8194;是 &#12288;
                        <input type="radio" name="data[{$kk}1]" value="0" <?php $key= $kk.'1'; if ($handover_list && $handover_list[$key]==0) echo 'checked'; ?>> &#8194;否
                    </div>
                </foreach>

                <P class="border-bottom-line"> 项目交接实施表</P>
                <foreach name="days" key="k" item="v">
                    <div class="form-group col-md-4">
                        <label>活动日期 &nbsp;{$k+1}： {$v['day'] ? date('Y-m-d',$v['day']) : ''} </label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>活动时间： <?php echo $v['st_time'] && $v['et_time'] ? date('Y-m-d',$v['st_time']).' - '.date('Y-m-d',$v['et_time']) : ''; ?></label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>活动地点： {$v.addr} </label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>活动安排： {$v.plan}</label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>物资情况： {$v.material} </label>
                    </div>

                    <div class="form-group col-md-4">
                        <label>项目负责人： {$v.blame}</label>
                    </div>

                    <div class="form-group col-md-12">
                        <label>注意事项： {$v.note} </label>
                    </div>

                    <div class="form-group col-md-12">
                        <label>备注： {$v.remark} </label>
                    </div>
                </foreach>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>