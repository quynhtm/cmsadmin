<div class="div-parent-background">
    <div class="div-background">
        <div class="div-block-right">
            <a href="javascript:void(0);" onclick="jqueryCommon.hideContentRightPageLayout();" class="btn-close-search-list btn btn-default" title="{{viewLanguage('Đóng lại')}}">
                <i class="pe-7s-close fa-w-16 fa-3x"></i>
            </a>
            {{-- Nội dung form search--}}
            <form method="POST" action="{{$urlCreateDigitallySigned}}" enctype="multipart/form-data">
            <div class="content-search-page" >
                <h3 class="themeoptions-heading">Tạo ký số</h3>
                <div class="ibox-content">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="depart_name">{{viewLanguage('Số chứng nhận')}}</label>
                            <input type="text" class="form-control input-sm" id="FILE_REFF" name="FILE_REFF">
                        </div>

                        <div class="form-group col-lg-12 form-file">
                            <label for="depart_name">{{viewLanguage('Upload file')}}</label><br>
                            <input type="file" id="inputFile" name="inputFile" >
                        </div>
                        <hr>
                        <div class="form-group col-lg-12">
                            @if($is_root || $permission_view)
                                <button class="mb-2 mr-2 btn-icon btn btn-success submitFormItem" type="submit" onclick="$('.submitFormItem').prop('disabled',true);"><i class="fa fa-search"></i> {{viewLanguage('Tạo ký số')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.form-file input').each(function () {
            $this = jQuery(this);
            $this.on('change', function() {
                var fsize = $this[0].files[0].size,
                    ftype = $this[0].files[0].type,
                    fname = $this[0].files[0].name,
                    fextension = fname.substring(fname.lastIndexOf('.')+1);
                validExtensions = ["doc","docx"];
                if ($.inArray(fextension, validExtensions) == -1){
                    alert("Up file .doc hoặc .docx! Hãy up lại");
                    this.value = "";
                    return false;
                }else{
                    if(fsize > 3145728){/*1048576-1MB(You can change the size as you want)*/
                        alert("File quá lớn, dung lương cho phép < 3MB");
                        this.value = "";
                        return false;
                    }
                    return true;
                }

            });
        });
    });
</script>
