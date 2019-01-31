
<?php if ($pingfen){ ?>
    <?php if ($post_id == 83){ ?>
        <!--京区业务中心平面设计专员-->
        <include file="score_read_1" />
    <?php }elseif($post_id ==102 ){ ?>
        <!--京区业务中心微信运营专员-->
        <include file="score_read_2" />
    <?php }elseif(in_array($post_id,array(63,64))){ ?>
        <!--研发部实施专家-->
        <include file="score_read_3" />
    <?php } ?>
<?php }else{ ?>
    <div class="content" ><span style="padding:20px 0; float:left; clear:both; text-align:center; text-align:center; width:100%;">暂无评分信息</span></div>
<?php } ?>



<script type="text/javascript">
    $(function() {
        $.fn.raty.defaults.path = "__HTML__/score/lib/img";
        var res = <?php echo $pingfen?$pingfen:0; ?>;

        if (res){
            $('#content').html(res.content);
            $('#bpfr').html(res.bpfr_name);

            pingfen('text',res.text);           //文字准确度
            pingfen('pic',res.pic);             //图片准确性；
            pingfen('article',res.article);     //文章要素完整性
            pingfen('habit',res.habit);         //设计考虑用户使用习惯、各类推广牵引效果、情感及体验感受
            pingfen('hot',res.hot);             //即时掌握相关热点，匹配专题策划、 活动，提高客户成交率
            pingfen('light',res.light);         //文章选题有创意、策划有亮点、符合客户需求
        }else{
            pingfen('text',5);                  //文字准确度
            pingfen('pic',5);                   //图片准确性；
            pingfen('article',5);               //文章要素完整性
            pingfen('habit',5);                 //设计考虑用户使用习惯、各类推广牵引效果、情感及体验感受
            pingfen('hot',5);                   //即时掌握相关热点，匹配专题策划、 活动，提高客户成交率
            pingfen('light',5);                 //文章选题有创意、策划有亮点、符合客户需求
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