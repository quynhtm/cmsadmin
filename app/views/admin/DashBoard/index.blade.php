<div class="main-content-inner">
    <div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                Home
            </li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header">
                    <h3 class="box-title" style="text-align: center;">Quản lý CMS của {{CGlobal::web_name}} </h3>
                </div>
                @if(isset($error) && !empty($error))
                    <div class="alert alert-danger" role="alert">
                        @foreach($error as $itmError)
                            <p><b>{{ $itmError }}</b></p>
                        @endforeach
                    </div>
                @endif
                <div class="box-body" style="margin-top: 35px">

                    @if(!empty($menu))
                        @foreach($menu as $item)
                            @if(isset($item['sub']) && !empty($item['sub']))
                                @foreach($item['sub'] as $sub)
                                    @if($is_root || (isset($sub['permission']) && in_array($sub['permission'],$aryPermission)))
                                        @if(isset($sub['showcontent']) && $sub['showcontent'] == 1)
                                            <div class="col-sm-6 col-md-3">
                                                <a class="quick-btn a_control"  href="{{ URL::route($sub['RouteName']) }}">
                                                    <div class="thumbnail text-center">
                                                        <i class="{{ $sub['icon'] }} fa-5x"></i><br>{{ $sub['name'] }}
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                        @if(isset($sub['clear']) && $sub['clear'] == 1)
                                            <div class="clear"></div>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif

                    {{--@if($is_root || in_array('user_view',$aryPermission))
                    <div class="col-sm-6 col-md-3">
                        <a class="quick-btn a_control" href="{{URL::route('admin.user_view')}}">
                            <div class="thumbnail text-center">
                                <i class="fa fa-user fa-5x"></i><br/>
                                <span>Quản lý User</span>
                            </div>
                        </a>
                    </div>
                    @endif--}}

                    
                 </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div>