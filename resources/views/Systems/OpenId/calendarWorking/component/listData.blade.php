<div class="ibox-content">
    @if(1== 1 || $data && sizeof($data) > 0)
        <h5 class="clearfix"> @if($total >0) Có tổng số <b>{{$total}}</b> item @endif </h5>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr class="">
                    <th width="2%" class="text-center"><input type="checkbox"></th>
                    <th width="3%" class="text-center">{{viewLanguage('STT')}}</th>
                    <th width="10%" class="text-center">{{viewLanguage('Thời gian')}}</th>
                    <th width="15%" class="text-center">{{viewLanguage('Địa điểm')}}</th>

                    <th width="20%" class="text-center">{{viewLanguage('Nội dung')}}</th>
                    <th width="24%" class="text-left">{{viewLanguage('Thành phần tham gia')}}</th>
                    <th width="8%" class="text-center">{{viewLanguage('Loại')}}</th>

                    <th width="8%" class="text-center">{{viewLanguage('Trạng thái')}}</th>
                    <th width="10%" class="text-center">{{viewLanguage('Thao tác')}}</th>
                </tr>
                </thead>
                <tbody>
                {{--@foreach ($data as $key => $item)--}}
                <tr style="background-color:#e0f3ff">
                    <td class="text-left middle" colspan="2"></td>
                    <td class="text-left middle" colspan="7"><b>Thứ 2 (22-07-2020)</b></td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">1</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">8:15 - 9:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-users fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-size="1" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a> &nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">2</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">10:30-11:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">3</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">13:00-14:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">4</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">14:00-17:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>

                <tr style="background-color:#e0f3ff">
                    <td class="text-left middle" colspan="2"></td>
                    <td class="text-left middle" colspan="7"><b>Thứ 3 (23-07-2020)</b></td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">1</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">8:15 - 9:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a> &nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">2</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">10:30-11:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">3</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">13:00-14:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">4</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">14:00-17:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>

                <tr style="background-color:#e0f3ff">
                    <td class="text-left middle" colspan="2"></td>
                    <td class="text-left middle" colspan="7"><b>Thứ 4 (24-07-2020)</b></td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">1</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">8:15 - 9:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a> &nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">2</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">10:30-11:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">3</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">13:00-14:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">4</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">14:00-17:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>

                <tr style="background-color:#e0f3ff">
                    <td class="text-left middle" colspan="2"></td>
                    <td class="text-left middle" colspan="7"><b>Thứ 5 (25-07-2020)</b></td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">1</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">8:15 - 9:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a> &nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">2</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">10:30-11:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr >
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">3</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">13:00-14:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">4</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">14:00-17:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>

                <tr style="background-color:#e0f3ff">
                    <td class="text-left middle" colspan="2"></td>
                    <td class="text-left middle" colspan="7"><b>Thứ 6 (26-07-2020)</b></td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">1</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">8:15 - 9:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a> &nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">2</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">10:30-11:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">3</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">13:00-14:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr >
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">4</td>
                    <td class="text-center middle" style="background-color: #F5BCA9">14:00-17:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp triển khai dự án mới</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>

                <tr style="background-color:#e0f3ff">
                    <td class="text-left middle" colspan="2"></td>
                    <td class="text-left middle" colspan="7"><b>Thứ 7 (27-07-2020)</b></td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">1</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">8:15 - 9:00</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Họp tổng kết tuần</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a> &nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailDepart" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="text-center middle"><input type="checkbox"></td>
                    <td class="text-center middle">2</td>
                    <td class="text-center middle" style="background-color: #A9F5A9">10:30-11:30</td>
                    <td class="text-center middle">Phòng họp 002</td>

                    <td class="text-center middle">Traning công nghệ</td>
                    <td class="text-left middle">
                        Chủ trì: Nguyễn Văn A <br/>
                        Thành phần: ban IT,phòng Vận Hành
                    </td>
                    <td class="text-center middle">
                        <i class="fa fa-plane fa-2x"></i>
                    </td>

                    <td class="text-center middle">Duyệt</td>
                    <td class="text-center middle">
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Cập nhật thông tin')}}" data-title="{{viewLanguage('Cập nhật thông tin')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-edit fa-2x"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0);"class="sys_show_popup_common" data-form-name="detailItem" data-businessLine="" data-positionCode=""  title="{{viewLanguage('Copy lịch')}}" data-title="{{viewLanguage('Copy lịch')}}" data-method="get" data-url="{{URL::route('calendarWorking.ajaxGetItem')}}" data-objectId="0">
                            <i class="ace-icon fa fa-files-o fa-2x"></i>
                        </a>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="dataTables_paginate paging_simple_numbers">
            {!! $paging !!}
        </div>
    @else
        <div class="alert">
            Không có dữ liệu
        </div>
    @endif
</div>
