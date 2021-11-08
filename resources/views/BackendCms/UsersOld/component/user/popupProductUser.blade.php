<div class="modal-content" id="{{$formChangePass}}"style="position: relative">
    <div id="loaderPopup"><span class="loadingAjaxPopup"></span></div>
    <form id="form_{{$formChangePass}}">
        <input type="hidden" id="objectId" name="objectId" value="{{$objectId}}">
        <input type="hidden" id="loadPage" name="loadPage" value="{{$loadPage}}">
        <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
        <input type="hidden" id="str_product_user" name="str_product_user" value="">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="sysTitleModalCommon">{{$title_popup}}</h4>
        </div>
        <div class="modal-body">
            <div class="form_group">
                <div class="form-group">
                <div class="table-responsive" style="height: 400px; overflow: hidden; overflow-y: scroll">
                    <table class="table table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr class="table-background-header">
                            <th width="3%" class="text-center">{{viewLanguage('STT')}}</th>
                            <th width="3%" class="text-center middle"><input type="checkbox" class="check" id="checkAllOrder"></th>
                            <th width="26%" class="text-center">{{viewLanguage('Product code')}}</th>
                            <th width="70%" class="text-left">{{viewLanguage('Product name')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $stt = 0;
                        ?>
                        {{------Check lên đầu-----}}
                        @if(!empty($productUser))
                            @foreach ($productUser as $key1 => $pro_code)
                                @foreach ($listProduct as $key => $product)
                                    @if($product->PRODUCT_CODE == $pro_code)
                                    <tr>
                                        <td class="text-center middle">{{$stt+1}}</td>
                                        <td class="text-center middle">
                                            <input class="check" type="checkbox" name="checkItems[]" @if(in_array($product->PRODUCT_CODE,$productUser)) checked @endif value="@if(isset($product->PRODUCT_CODE)){{$product->PRODUCT_CODE}}@endif">
                                        </td>
                                        <td class="text-left middle">
                                            {{$product->PRODUCT_CODE}}
                                        </td>
                                        <td class="text-left middle">
                                            {{$product->PRODUCT_NAME}}
                                        </td>
                                    </tr>
                                    <?php
                                    $stt = $stt+1;
                                    unset($listProduct[$key]);
                                    ?>
                                    @endif
                                @endforeach
                            @endforeach
                        @endif

                        @foreach ($listProduct as $key => $product)
                            <tr>
                                <td class="text-center middle">{{$stt+1}}</td>
                                <td class="text-center middle">
                                    <input class="check" type="checkbox" name="checkItems[]" @if(in_array($product->PRODUCT_CODE,$productUser)) checked @endif value="@if(isset($product->PRODUCT_CODE)){{$product->PRODUCT_CODE}}@endif">
                                </td>
                                <td class="text-left middle">
                                    {{$product->PRODUCT_CODE}}
                                </td>
                                <td class="text-left middle">
                                    {{$product->PRODUCT_NAME}}
                                </td>
                            </tr>
                            <?php
                            $stt = $stt+1;
                            ?>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="pe-7s-back"></i> {{viewLanguage('Cancel')}}</button>
            <button type="button" class="btn btn-primary" onclick=" getCheckProduct();jqueryCommon.doActionPopup('{{$formChangePass}}','{{$urlAjaxPostProductWithUser}}');"><i class="pe-7s-diskette"></i> {{viewLanguage('Save')}}</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#checkAllOrder").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });
    });
    function getCheckProduct(){
        var dataId = [];
        var i = 0;
        $("input[name*='checkItems']").each(function () {
            if ($(this).is(":checked")) {
                dataId[i] = $(this).val();
                i++;
            }
        });
        if(dataId.length > 0){
            var str_pro = dataId.join();
            $('#str_product_user').val(str_pro);
        }
    }
</script>