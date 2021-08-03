@if(isset($listPacks) && !empty($listPacks))
    <?php
        $totalPack = count($listPacks);
    ?>
    <div @if($totalPack >=11)style="height: 600px; overflow: hidden; overflow-y: scroll" @endif>
        <table class="table table-bordered table-hover">
            <thead class="thin-border-bottom">
            <tr class="table-background-header">
                <th width="5%" class="text-center middle">{{viewLanguage('STT')}}</th>
                <th width="15%" class="text-center middle">{{viewLanguage('Mã gói')}}</th>
                <th width="35%" class="text-center middle">{{viewLanguage('Tên gói')}}</th>

                <th width="10%" class="text-center middle">{{viewLanguage('Phí')}}</th>
                <th width="30%" class="text-center middle">{{viewLanguage('Quyền lợi')}}</th>
                <th width="5%" class="text-center middle">{{viewLanguage('Upload')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($listPacks as $key => $infor_pack)
                <?php $pack_code = isset($infor_pack['PACK_CODE'])? $infor_pack['PACK_CODE']: 'PACK_CODE_'.$key;?>
                <tr>
                    <td class="text-center middle">
                        {{$key+1}}<br/>
                        <input class="check" type="checkbox" name="checkPack[]" @if(isset($infor_pack['IS_USED']) && $infor_pack['IS_USED']==1) checked @endif value="@if(isset($infor_pack['PACK_CODE'])){{$infor_pack['PACK_CODE']}}@endif">
                    </td>
                    <td class="text-left middle">@if(isset($infor_pack['PACK_CODE'])){{$infor_pack['PACK_CODE']}}@endif</td>
                    <td class="text-left middle">@if(isset($infor_pack['PACK_NAME'])){{$infor_pack['PACK_NAME']}}@endif</td>

                    <td class="text-right middle">@if(isset($infor_pack['FEES'])){{numberFormat($infor_pack['FEES'])}}@endif</td>
                    <td class="text-left middle">
                        @if(isset($infor_pack['BENEFIT_URL']) && trim($infor_pack['BENEFIT_URL']) != '')
                            <a class="color_hdi" target="_blank" href="{{$urlServiceFile.$infor_pack['BENEFIT_URL']}}" title="File quyền lợi: {{$infor_pack['BENEFIT_URL']}}">File quyền lợi</a>
                        @endif
                    </td>
                    <td class="text-left text-middle middle">
                        <div class="w-100">
                            <input type="hidden" name="p_pack_benefit_url_{{$pack_code}}" id="p_pack_benefit_url_{{$pack_code}}" @if(isset($infor_pack['BENEFIT_URL'])) value="{{$infor_pack['BENEFIT_URL']}}" @endif >
                            <label for="inputInterest_{{$pack_code}}" class="w-100 btn-transition btn btn-outline-success " style="padding-left: 0px!important; padding-right: 0px!important;" title="upload file quyền lợi PDF">
                                <input type="file" name="inputInterest_{{$pack_code}}" id="inputInterest_{{$pack_code}}" style="display:none">
                                <i class="fa fa-share-square"></i>
                            </label>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <input type="hidden" name="p_package_obj" id="p_package_obj" @if(isset($strPacksJson))value="{{$strPacksJson}}"@endif>
@endif
