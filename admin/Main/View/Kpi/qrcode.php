		<include file="Index:header_mini" />
        <script src="__HTML__/js/jquery.qrcode.min.js"></script>
        


            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        
                        <!-- right column -->
                        <div class="col-md-12">
                            <!-- general form elements disabled -->
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3 class="box-title" id="bigtit">{$title}</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" style="padding-top:20px;">

                                    <div class="form-group col-md-12">
                                        <input type="hidden" id="url_info" value="{$url_info}">
                                        <button class="btn btn-info" onclick="show_code()">获取二维码</button>
                                    </div>

                                    <div style="padding-left: 100px;">
                                        <!--<img id="qrcode" style="width: 150px;">-->
                                        <div id="code"></div>
                                    </div>

                                    <div class="form-group">&nbsp;</div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                        
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->

        
        <include file="Index:footer" />

        <script type="text/javascript">
            function show_code(){
                var url = "{$url}";
                qrcode_js(url,150,150);
            }
        </script>
        
       
        