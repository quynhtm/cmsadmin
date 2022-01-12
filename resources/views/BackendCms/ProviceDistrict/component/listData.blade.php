<div class="ibox">
    <div class="ibox-title">
        <h5>{{viewLanguage('Tìm kiếm')}}</h5>
        <div class="ibox-tools marginDownT6">
            @if($is_root || $permission_view)
            <button class="btn btn-primary" type="submit" name="submit" value="1"><i class="fa fa-search"></i> {{viewLanguage('Search')}}</button>
                @if($permission_full || $permission_edit || $permission_add)
                    <a href="javascript:void(0);"  class="btn btn-success" onclick="jqueryCommon.getDataByAjax(this);" data-loading="1" data-show="2" data-div-show="content-page-right" data-form-name="addFormItem" data-url="{{$urlGetData}}" data-function-action="_functionGetData" data-method="post" data-input="{{json_encode(['funcAction'=>'getDetailItem','dataItem'=>[]])}}" data-objectId="0" title="{{viewLanguage('Thêm mới')}}">
                        <i class="fa fa-plus"></i>
                    </a>
                @endif
             @endif
        </div>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="form-group col-lg-4">
                <label for="depart_name">{{viewLanguage('Tìm kiếm')}}</label>
                <input type="text" class="form-control input-sm" id="p_keyword" name="p_keyword" autocomplete="off" @if(isset($search['p_keyword']))value="{{$search['p_keyword']}}"@endif>
            </div>
            <div class="form-group col-lg-2">
                <label for="status" class="control-label">{{viewLanguage('Trạng thái')}}</label>
                <select  class="form-control input-sm" name="status" id="status">
                    {!! $optionIsActive !!}}
                </select>
            </div>
        </div>
    </div>
</div>
<div class="main-card mb-3 card">
    <div class="card-body">
        @if($data && sizeof($data) > 0)
            <h5 class="clearfix">Danh sách Tỉnh thành, quận huyện, phường xã trên hệ thống </h5>

            <ul id="ft-id-1" class="ui-fancytree fancytree-container fancytree-plain" tabindex="0" role="tree" aria-multiselectable="true" aria-activedescendant="ui-id-2">
                <div id="blockListProvice" data-children=".item">
                    <div class="item row">
                        @foreach ($data as $key => $item)
                        <li role="treeitem" aria-expanded="true" aria-selected="false" id="ui-id-1" class="col-lg-6">
                            [{{$item->id}}]
                            <button type="button" aria-expanded="true" aria-controls="" data-toggle="collapse" href="#childListProvice{{$item->id}}" class="m-0 p-0 btn btn-link" onclick="clickGetChild('{{$item->id}}',1,'getDistrictByProviceId','{{$urlPostData}}')">
                                <b class="green"> {{$item->title}}</b>
                            </button>
                            <div data-parent="#blockListProvice" id="childListProvice{{$item->id}}" class="collapse" >
                                <ul role="group" style="" id="groupListDistrict{{$item->id}}">
                                    {{-----Call Ajax hiển thị danh sách con----}}
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </div>
                </div>
            </ul>

        @else
            <div class="alert">
                Không có dữ liệu
            </div>
        @endif
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var config = {
            '.chosen-select'           : {width: "100%"},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Không có kết quả'}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
    function clickGetChild(object_id,type_get, action_get, url_action) {

        if(type_get == 1){
            var divShowId = 'groupListDistrict'+object_id;
        }else {
            var divShowId = 'groupListWards'+object_id;
        }
        var isContentHtml = $('#' + divShowId).html();

        if (!$.trim(isContentHtml)) {
            var _token = $('input[name="_token"]').val();
            $('#loader').show();
            $.ajax({
                dataType: 'json',
                type: 'POST',
                url: url_action,
                data: {
                    '_token': _token,
                    'object_id': object_id,
                    'actionUpdate': action_get,
                },
                success: function (res) {
                    $('#loader').hide();
                    if (res.success == 1) {
                        $('#' + res.divShowChild).html(res.html);
                    } else {
                        jqueryCommon.showMsg('error', '', 'Thông báo lỗi', res.msg);
                    }
                }
            });
        }
    }
</script>
