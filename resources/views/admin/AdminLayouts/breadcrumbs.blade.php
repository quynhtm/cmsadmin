<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <span>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a class="a_none_color" href="{{URL::route('admin.dashboard')}}">Trang chủ</a>
            </span>
            <span>
                &nbsp;/&nbsp;
            </span>
            <span>
                <strong>
                    <a class="a_none_color" href="@if(isset($urlIndex)){{$urlIndex}}@else # @endif">{{$pageTitle}}</a>
                </strong>
            </span>
        </div>
    </div>
</div>