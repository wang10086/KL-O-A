<?php if ($pingfen != 'null'){ ?>
    <?php if ($post_id == 83){ ?>
        <!--京区业务中心平面设计专员-->
        <include file="score_read_1" />
    <?php }elseif($post_id ==102 ){ ?>
        <!--京区业务中心微信运营专员-->
        <include file="score_read_2" />
    <?php }elseif(in_array($post_id,array(63,64,96,80))){ ?>
        <!--研发部实施专家-->
        <include file="score_read_3" />
    <?php } ?>
<?php }else{ ?>
    <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">暂无评分信息</span></div>
<?php } ?>

<div class=""></div>



<script type="text/javascript">
    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);
            $('#bpfr').html(res.account_name);

            pingfen('AA',res.AA);
            pingfen('BB',res.BB);
            pingfen('CC',res.CC);
            pingfen('DD',res.DD);
            pingfen('EE',res.EE);
        }else{
            pingfen('AA',5);
            pingfen('BB',5);
            pingfen('CC',5);
            pingfen('DD',5);
            pingfen('EE',5);
        }

    });

    function pingfen(id,score) {
        $('#'+id+'_num').val(score);
        $('#'+id).raty({
            score: score ,
            click: function(score, evt) {
                //alert('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type)
                $('#'+id+'_num').val(score);
            }
        });
    }


</script>