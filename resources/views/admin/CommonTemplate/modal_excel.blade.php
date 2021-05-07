<?php use App\Library\AdminFunction\FunctionLib; ?>
<?php use App\Library\AdminFunction\Define; ?>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="modal fade" id="modal-csv-upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close bt_close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{\App\Library\AdminFunction\FunctionLib::viewLanguage('csv_download_upload')}}</h4>
            </div>
            <div class="modal-body" id="ajax-csv-upload">
                <form method="post" id="form-csv-upload" class="form-inline" enctype="multipart/form-data">
                    <div class="alert alert-info mg-b30 center">
                        {{FunctionLib::viewLanguage('lg_txt_member_modal_csv_upload01')}}
                        <div class="mg-t30">
                            <a href="#" class="btn btn-lg btn-primary">
                                <i class="fa fa-cloud-download"></i>{{FunctionLib::viewLanguage('csv_download')}}
                            </a>
                        </div>
                    </div>

                    <div class="alert alert-warning center">
                        <div class="mg-t30">
                            <input type="file" id="csv_file" name="csv" style="display: none;" onchange="upload_csv();" accept="text/csv">
                            <button type="button" class="btn btn-lg btn-warning" onClick="$('#csv_file').click();"><i class="fa fa-cloud-upload"></i>{{FunctionLib::viewLanguage('csv_upload')}}</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default bt_close" data-dismiss="modal">close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function upload_csv() {
        if ( confirm(lng['lg_txt_member_modal_csv_upload03']) ){
            var form_data = new FormData($("#form-csv-upload").get()[0]);
            //form_data['csv'] = $("#csv_file").val();
            //call_ajax("./ajax/csv_upload.php",form_data,"#ajax-csv-upload");

            $.ajax({
                url: "/manager/systemSetting/importString",
                type: 'POST',
                contentType: false,
                processData: false,
                data: form_data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'html',
                xhr : function(){
                    XHR = $.ajaxSettings.xhr();
                    if(XHR.upload){
                        XHR.upload.addEventListener('progress',function(e){
                            $("#overlay").fadeIn();
                            progress = parseInt(e.loaded/e.total*10000)/100 ;
                            $('#overlay_progress').css('width',progress + '%');
                        }, false);
                    }
                    return XHR;
                }
            })
                .done(function( data ) {	//成功の時の処理
                    debugger
                    if ( data != "") {
                        $("#overlay").fadeOut(function(){
                            $("#csv_file").val("");
                            alert(data);
                        });
                    } else {
                        location.reload();
                        alert("Import successful");
                    }


                })
                .fail(function( data ) {	//失敗の時の処理

                    alert("Something error");
                })
                .always(function( data ) {	//成功・失敗に関わらず通信が完了した時に呼ばれるコールバック関数
                    $("#overlay").fadeOut();
                });
        }

    }
</script>