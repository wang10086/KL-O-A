
            <?php if ($post_id == 83){ ?>
                <!--京区业务中心平面设计专员-->
                <include file="score_form_1" />

            <?php }elseif($post_id ==102 ){ ?>
                <!--京区业务中心微信运营专员-->
                <include file="score_form_2" />
            <?php }elseif(in_array($post_id,array(63,64,96,80))){ ?>
                <!--研发部
                63=>研发部实施专家
                64=>研发部研发专员
                96=>南京项目部研发专员
                80=>京区业务中心研发专员
                -->
                <include file="score_form_3" />
            <?php }elseif($post_id == 92){ ?>
                <!--人资综合部PHP程序员-->
                <include file="score_form_4" />
            <?php } ?>





<script type="text/javascript">

    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);
            $('#zy_content').html(res.zy_content);

            pingfen('AA',res.AA);
            pingfen('BB',res.BB);
            pingfen('CC',res.CC);
            pingfen('DD',res.DD);
            pingfen('EE',res.EE);
            //pingfen('light',res.light);
        }else{
            pingfen('AA',5);
            pingfen('BB',5);
            pingfen('CC',5);
            pingfen('DD',5);
            pingfen('EE',5);
            //pingfen('light',5);
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
