@extends('admin.AdminLayouts.indexHDI')
@section('content')
    {{---breadcrumbs---}}
    @include('admin.AdminLayouts.breadcrumbs')

    {{---Content page---}}
    {{Form::open(array('method' => 'POST','class'=>$formName,'id'=>'form_'.$formName,'role'=>'form','files' => true))}}
    <div class="main-card mb-3 card">
        <div class="ibox-title">
            <h5>Profile - <span class="showInforItem" data-field="FULL_NAME"></span></h5>
        </div>
        <div class="ibox-content">
            <!-- PAGE CONTENT BEGINS -->

            {!! csrf_field() !!}
            <input type="hidden" id="data_item" name="data_item" value="{{json_encode($data)}}">
            @if(isset($error) && !empty($error))
                <div class="alert alert-danger" role="alert">
                    @foreach($error as $itmError)
                        <p>{{ $itmError }}</p>
                    @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-lg-3 text-center">
                    <span class="profile-picture">
                        @if(isset($data->IMAGE) && trim($data->IMAGE) != '')
                            <img class="editable img-responsive" src="{{getLinkFileToStore($data->IMAGE,false)}}" width="180" height="200" title="{{$data->IMAGE}}"/>
                        @else
                            <img class="editable img-responsive" alt="Alex's Avatar" id="avatar2" src="{{Config::get('config.WEB_ROOT')}}assets/backend/theme/assets/images/avatars/profile-pic.jpg" width="180" height="200"/>
                        @endif
                    </span>
                    <div class="space space-4"></div>
                    <input type="hidden" name="IMAGE" id="form_{{$formName}}_IMAGE">
                    <input type="hidden" name="USER_NAME" id="form_{{$formName}}_USER_NAME" class="form-control input-sm">

                    <label title="Upload ảnh đại diện" for="inputImage" class="btn btn-sm btn-block btn-light marginT10">
                        <input type="file" name="inputImage" id="inputImage" style="display:none">
                        Upload image
                    </label>
                </div>

                <div class="col-lg-9 text-left">
                    <div class="row">
                        <div class="profile-user-info col-lg-5">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Username </div>
                                <div class="profile-info-value">
                                    <span><b class="showInforItem" data-field="USER_NAME"></b></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"></div>
                                <div class="profile-info-value">
                                    <a href="javascript:void(0);"class="red" onclick="jqueryCommon.getDataByAjax(this)" data-form-name="changePass" data-load-page="1" data-input="{{json_encode(['item'=>$data])}}" title="{{viewLanguage('Đổi mật khẩu: ').$data->FULL_NAME}}" data-show="0" data-method="get" data-url="{{$urlAjaxChangePass}}" data-objectId="{{setStrVar($data->USER_CODE)}}">
                                        Reset mật khẩu
                                    </a>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> Chức vụ </div>
                                <div class="profile-info-value">
                                    <span>@if(isset($data->POSITION_CODE))@if(isset($arrChucVu[$data->POSITION_CODE])){{$arrChucVu[$data->POSITION_CODE]}} @endif @endif</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tổ chức </div>
                                <div class="profile-info-value">
                                    <span>@if(isset($data->ORG_CODE))@if(isset($arrOrg[$data->ORG_CODE])){{$arrOrg[$data->ORG_CODE]}} @endif @endif</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Phòng ban </div>
                                <div class="profile-info-value">
                                    <span>@if(isset($data->STRUCT_CODE))@if(isset($arrDepart[$data->STRUCT_CODE])){{$arrDepart[$data->STRUCT_CODE]}} @endif @endif</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Ngày làm việc </div>
                                <div class="profile-info-value">
                                    <span>@if(isset($data->EFFECTIVE_DATE)){{convertDateDMY($data->EFFECTIVE_DATE)}}@endif</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Trạng thái </div>
                                <div class="profile-info-value">
                                    <span>@if(isset($data->IS_ACTIVE))@if(isset($arrStatus[$data->IS_ACTIVE])){{$arrStatus[$data->IS_ACTIVE]}} @endif @endif</span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Last Online </div>
                                <div class="profile-info-value">
                                    @if(isset($user['time_last_login']) && trim($user['time_last_login']) != '')
                                    <span>{{date('H:i d-m-Y',strtotime($user['time_last_login']))}}</span>
                                    @endif
                                </div>
                            </div>
                            @if($user && $user['change_pass'] == STATUS_INT_MOT)
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> </div>
                                    <div class="profile-info-value">
                                        <button  class="btn btn-sm btn-block btn-primary marginTop15"><i class="fa fa-floppy-o"></i> {{viewLanguage('Cập nhật thông tin')}}</button>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="profile-user-info col-lg-7">
                            <div class="profile-info-row">
                                <div class="profile-info-name border-none"> Họ và tên <span class="red"> (*) </span></div>
                                <div class="profile-info-value border-none">
                                    <input type="text" name="FULL_NAME" required id="form_{{$formName}}_FULL_NAME" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name border-none"> Ngày sinh <span class="red"> (*) </span></div>
                                <div class="profile-info-value border-none">
                                    <input type="text" class="form-control input-sm input-date" data-valid = "text" required name="BIRTHDAY" id="form_{{$formName}}_BIRTHDAY">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name border-none"> Phone <span class="red"> (*) </span></div>
                                <div class="profile-info-value border-none">
                                    <input type="text" id="form_{{$formName}}_PHONE" name="PHONE" required class="form-control input-sm" @if(isset($data->PHONE))value="{{$data->PHONE}}"@endif>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name border-none"> Email <span class="red"> (*) </span></div>
                                <div class="profile-info-value border-none">
                                    <input type="text" id="form_{{$formName}}_EMAIL" name="EMAIL" required class="form-control input-sm" @if(isset($data->EMAIL))value="{{$data->EMAIL}}"@endif>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name border-none"> Giới tính </div>
                                <div class="profile-info-value border-none">
                                    <select name="GENDER" id="GENDER" class="form-control input-sm">
                                        {!! $optionGender !!}
                                    </select>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name border-none"> Số CMT </div>
                                <div class="profile-info-value border-none">
                                    <input type="text" class="form-control input-sm" data-valid = "text" name="ID_CARD" id="form_{{$formName}}_ID_CARD">
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name border-none"> Số hộ chiếu </div>
                                <div class="profile-info-value border-none">
                                    <input type="text" class="form-control input-sm" data-valid = "text" name="PASSPORT_NO" id="form_{{$formName}}_PASSPORT_NO">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id_hiden" name="id_hiden" value="{{$id}}"/>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    <script type="text/javascript">
        $(document).ready(function(){
            var date_time = $('.input-date').datepicker({dateFormat: 'dd/mm/yy'});
            showDataIntoForm('form_{{$formName}}');
        });
    </script>
@stop
