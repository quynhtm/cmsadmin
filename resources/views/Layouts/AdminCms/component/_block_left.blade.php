<div class="app-sidebar sidebar-shadow @if(isset($colorWithTab[$tab_top]['menu'])){{$colorWithTab[$tab_top]['menu']}} @else bg-vicious-stance @endif">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic is-active" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>

    {{----Menu left---}}
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner marginT25">
            <ul class="vertical-nav-menu">
                @if(!empty($menu))
                    @foreach($menu as $key => $item)
                        @if($is_boss || $item['show_menu'] == STATUS_SHOW)
                            @if($item['parent_id'] == STATUS_HIDE && $item['menu_type'] == STATUS_SHOW)
                                <li class="@if(trim($item['RouteName']) !='' && Route::currentRouteName()==$item['RouteName'])mm-active @endif">
                                    <a class="@if(trim($item['RouteName']) !='' && Route::currentRouteName()==$item['RouteName'])mm-active @endif" href="@if(trim($item['RouteName']) !== '#'){{URL::route($item['RouteName'])}}@endif" title="{{ $item['name'] }}">
                                        <i class="metismenu-icon {{$item['icon']}}"></i>
                                        <span class="nav-label">
                                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                            {{ $item['name'] }}
                                        @else
                                            {{ $item['name_en'] }}
                                        @endif
                                    </span>
                                    </a>
                                </li>
                                <!--<li class="app-sidebar__heading"></li>-->
                            @else
                                @if(isset($item['sub']) && !empty($item['sub']))
                                <li class="@if(!empty($item['arr_link_sub']) && in_array(Route::currentRouteName(),$item['arr_link_sub']) || !empty($item['arr_link_chirld']) && in_array(Route::currentRouteName(),$item['arr_link_chirld']))mm-active @endif">
                                    <a href="#" title="{{ $item['name'] }}" class="@if(!empty($item['arr_link_sub']) && in_array(Route::currentRouteName(),$item['arr_link_sub']) || !empty($item['arr_link_chirld']) && in_array(Route::currentRouteName(),$item['arr_link_chirld']))mm-active @endif">
                                        <i class="metismenu-icon {{$item['icon']}}"></i>
                                        <span class="nav-label">
                                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                                {{ $item['name'] }}
                                            @else
                                                {{ $item['name_en'] }}
                                            @endif
                                        </span>
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul class="nav nav-second-level">
                                        @foreach($item['sub'] as $sub)
                                            {{----menu cấp 2---}}
                                            @if(isset($sub['sub']))
                                                <li style="width: 100%" class="@if((strcmp(Route::currentRouteName(),$sub['RouteName']) == 0) || !empty($sub['arr_link_sub']) && in_array(Route::currentRouteName(),$sub['arr_link_sub'])) mm-active @endif">
                                                    <a href="#">
                                                        <i class="metismenu-icon"></i>
                                                        @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                                            {{ $sub['name'] }}
                                                        @else
                                                            {{ $sub['name_en'] }}
                                                        @endif
                                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                                    </a>
                                                    <ul class="@if((strcmp(Route::currentRouteName(),$sub['RouteName']) == 0) || !empty($sub['arr_link_sub']) && in_array(Route::currentRouteName(),$sub['arr_link_sub'])) mm-collapse mm-show @endif">
                                                        @foreach($sub['sub'] as $sub_item)
                                                        <li>
                                                            <a class="@if((strcmp(Route::currentRouteName(),$sub_item['RouteName']) == 0) || !empty($sub_item['url_chirld']) && isset($sub_item['url_chirld'][Route::currentRouteName()]) && (strcmp($sub_item['url_chirld'][Route::currentRouteName()],$sub_item['RouteName']) == 0)) mm-active @endif" title="{{ $sub_item['name'] }}" href="{{URL::route($sub_item['RouteName'])}}">
                                                                <i class="metismenu-icon"></i>{{$sub_item['name']}}
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                @if($is_boss || (!empty($aryPermissionMenu) && in_array($sub['menu_id'],$aryPermissionMenu)))
                                                    <li style="width: 100%">
                                                        <a class="@if((strcmp(Route::currentRouteName(),$sub['RouteName']) == 0) || !empty($sub['url_chirld']) && isset($sub['url_chirld'][Route::currentRouteName()]) && (strcmp($sub['url_chirld'][Route::currentRouteName()],$sub['RouteName']) == 0)) mm-active @endif" title="{{ $sub['name'] }}" href="{{URL::route($sub['RouteName'])}}">
                                                            @if(isset($languageSite) && $languageSite == VIETNAM_LANGUAGE)
                                                                {{ $sub['name'] }}
                                                            @else
                                                                {{ $sub['name_en'] }}
                                                            @endif
                                                        </a>
                                                        <b class="arrow"></b>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @endif
                            @endif
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
