<div class="card">
    <div class="card-header-tab card-header text-left">
        <ul class="nav show-left">
            <li class="nav-item">
                <a href="{{$urlIndex}}" onclick="window.location.href('{{$urlIndex}}')" class="active nav-link">Tìm kiếm</a>
            </li>
            <li class="nav-item">
                <a data-toggle="tab" href="#tabCreateOrder" class="nav-link" @if($is_root || $permission_view)onclick="jqueryCommon.ajaxGetData(this);" @endif data-loading="1" data-show-id="tabCreateOrder" data-url="{{$urlActionFunction}}" data-function-action="_ajaxTabCreateOrder" data-input="{{json_encode([])}}" data-object-id="0">
                    Cấp đơn
                </a>
            </li>
        </ul>
    </div>

    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tabListData" role="tabpanel">
                @include('Sellings.ExtenActionHdi.OrdersInBatches.component.tabListData')
            </div>
            <div class="tab-pane" id="tabCreateOrder" role="tabpanel">
                {{--@include('Sellings.ExtenActionHdi.OrdersInBatches.component.tabCreateOrder')--}}
            </div>
        </div>
    </div>
</div>





