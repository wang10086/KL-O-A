		
        <script>
        $(document).ready(function() {  
        	//interval = setInterval(lockscreen, "1000");  
        })
        function lockscreen(){  
			$.get("<?php echo U('Index/public_lock'); ?>", function(result){
				if(result==1){
					window.location.href='<?php echo U('Index/public_lockscreen','','',true); ?>';
				}
			});
        }  
        </script>


    </body>

</html>