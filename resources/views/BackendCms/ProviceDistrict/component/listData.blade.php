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
                <select  class="form-control input-sm" name="IS_ACTIVE" id="IS_ACTIVE">
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
            <div class="table-responsive">
                <ul id="ft-id-1" class="ui-fancytree fancytree-container fancytree-plain" tabindex="0" role="tree" aria-multiselectable="true" aria-activedescendant="ui-id-2">
                    <div id="blockListProvice" data-children=".item">
                        <div class="item">
                            <li role="treeitem" aria-expanded="true" aria-selected="false" id="ui-id-1" class="">
                                <button type="button" aria-expanded="true" aria-controls="" data-toggle="collapse" href="#childListProvice1" class="m-0 p-0 btn btn-link">
                                    <b>Tỉnh thành 1</b>
                                </button>
                                <div data-parent="#blockListProvice" id="childListProvice1" class="collapse">
                                    <ul role="group" style="">
                                        <div id="blockListDistrict" data-children=".itemDistrict">
                                            <div class="itemDistrict">
                                                <li role="treeitem" aria-selected="false" class="fancytree-lastsib">
                                                    <button type="button" aria-expanded="false" aria-controls="" data-toggle="collapse" href="#childListDistrict1" class="m-0 p-0 btn btn-link">
                                                        <b>Quận huyện 1</b>
                                                    </button>
                                                    <div data-parent="#blockListDistrict" id="childListDistrict1" class="collapse">
                                                        <ul role="group" style="">
                                                            <li role="treeitem" aria-selected="false" class="fancytree-lastsib">Phường xã 1</li>
                                                            <li role="treeitem" aria-selected="false" class="fancytree-lastsib">Phường xã 1</li>
                                                            <li role="treeitem" aria-selected="false" class="fancytree-lastsib">Phường xã 1</li>
                                                        </ul>
                                                    </div>
                                                 </li>
                                                <li role="treeitem" aria-selected="false" class="fancytree-lastsib">
                                                    <button type="button" aria-expanded="false" aria-controls="" data-toggle="collapse" href="#childListDistrict2" class="m-0 p-0 btn btn-link">
                                                        <b>Quận huyện 2</b>
                                                    </button>
                                                    <div data-parent="#blockListDistrict" id="childListDistrict2" class="collapse">
                                                        <ul role="group" style="">
                                                            <li role="treeitem" aria-selected="false" class="fancytree-lastsib">Phường xã 2</li>
                                                            <li role="treeitem" aria-selected="false" class="fancytree-lastsib">Phường xã 2</li>
                                                            <li role="treeitem" aria-selected="false" class="fancytree-lastsib">Phường xã 2</li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </li>

                        </div>
                    </div>
                </ul>
            </div>
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
</script>
