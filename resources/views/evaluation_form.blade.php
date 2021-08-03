@extends('layout')
@section('content')
  <header class="wrap mb-20" style="background-color: #fafafa">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="{{ route('/') }}">
            <img src="{{ asset('images/buv-logo.png') }}" height="45" alt="">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <div class="col-lg-12">
              <div class="row">
                <div class="col-lg-8">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                      <a class="nav-link active" href="{{ route('evaluation') }}">Internship Evaluation</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-4">
                  <ul class="nav-account">
                    <li>Hello! @if(isset($user) && $user['name'] != '') {{ $user['name'] }} @endif</li>
                    <li>|</li>
                    <li><a href="/signout">Sign out</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="container mb-30">
    <div class="box col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <h1 class="title">Internship Evaluation Form</h1>
        <div class="card-body" style="min-height: 500px;padding-top: 30px;">
          <form id="form" action="{{ route('evaluation.form') }}" method="post">
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <ul style="padding: 0;margin: 0 0 0 15px;">
                  @foreach ($errors->all() as $error)
                    <li>
                      {{ $error }}
                    </li>
                  @endforeach
                </ul>
              </div>
            @endif
            <div class="row">
              @csrf
              <div class="col-lg-12 col-md-6 col-sm-12" style="padding-bottom: 50px;">

                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="name">Intern’s Full-name/ Họ & tên thực tập sinh</label>
                    <input type="text" class="form-control" name="name"  value="{{ isset($user['name']) ? $user['name'] : '' }}" disabled="disabled">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="code">HAN ID/ Mã sinh viên</label>
                    <input type="text" class="form-control" name="code"  value="{{ isset($user['student_id']) ? $user['student_id'] : '' }}" disabled="disabled">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="class">Class/ Lớp <i class="required">*</i> </label>
                    <select name="class" class="form-control">
                      @foreach($cohort as $v)
                        <option value="{{ $v->cohort }}" @if((old('class') != '' && old('class') == $v->cohort) || ($user['class'] == $v->cohort) ) selected @endif>{{ $v->cohort }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="section">Semester (break)/ (Kỳ nghỉ/học) <i class="required">*</i> </label>
                    <select name="section" class="form-control">
                      @foreach(cglobal::$semester as $k=>$v)
                        <option value="{{ $k }}" @if((old('section') != '' && old('section') == $k) || ($user['section'] == $k) ) selected @endif>{{ $v }}</option>
                      @endforeach
                    </select>
                  </div>

                </div>



                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="org">Employer’s name/ Tên đầy đủ của công ty <i class="required">*</i></label>
                    <input type="text" class="form-control" name="org"  value="{{ old('org') }}">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="position">Position/ Vị trí thực tập <i class="required">*</i></label>
                    <input type="text" class="form-control" name="position"  value="{{ old('position') }}">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="suppervisor">Supervisor’s name/ Họ & tên Cán bộ Giám sát <i class="required">*</i></label>
                    <input type="text" class="form-control" name="suppervisor"  value="{{ old('suppervisor') }}">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="supervisor_pos">Supervisor’s position/ Vị trí công tác của Cán bộ giám sát <i class="required">*</i></label>
                    <input type="text" class="form-control" name="supervisor_pos"  value="{{ old('supervisor_pos') }}">
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-lg-6">
                    <label for="period">Internship period (dd/mm/yyyy)/ Thời gian thực tập (tháng/năm): From/ Từ <i class="required">*</i></label>
                    <input type="text" class="form-control datepicker" name="period"  value="{{ old('period') }}" autocomplete="off">
                  </div>

                  <div class="form-group col-lg-6">
                    <label for="period_to">To/ Đến <i class="required">*</i></label>
                    <input type="text" class="form-control datepicker" name="period_to"  value="{{ old('period_to') }}" autocomplete="off">
                  </div>
                </div>

                <div class="form-group">
                  <label for="type_of_internship">Type of internship (Full/Part-time)/ Thực tập toàn thời gian/ bán thời gian <i class="required">*</i></label>
                  <div class="row">
                    <div class="col-lg-6">
                      <select id="type_of_internship" name="type_of_internship" class="form-control">
                        <option value="">Choose ...</option>
                        @foreach(cglobal::$type_of_internship as $k=>$v)
                          <option value="{{ $k }}" @if(old('type_of_internship') == $k) selected @endif>{{ $v }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group" style="padding-top: 20px;">
                  <p><span class="required">(*)</span> Please fill the information in English. Please check your information carefully before submitting, because the information that you provided will be used for your Internship Certificate.</p>
                </div>

                <div class="row">
                  <div class="col-lg-12" style="text-align: right">
                    <button type="submit" class="btn btn-primary color-white mr-3"><i class="fa fa-save"></i> Submit</button>
                    <button type="reset" class="btn btn-danger color-white"><i class="fa fa-trash"></i> Reset</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modal-success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body text-center" style="padding: 30px 0;">
          <i class="b-icon fa fa-check-circle"></i>
          <h3 class="text-message">Your action has been successfully.</h3>
        </div>
      </div>
    </div>
  </div>

  @if(session()->has('message'))
    <script>
        $(document).ready(function(){
            $('#modal-success').modal('show');
            setTimeout(function() {
                $('#modal-success').modal('hide');
            }, 2000);
        });
    </script>
  @endif

  <script type="text/javascript">
      $(function() {
          $(".datepicker").datepicker( {
              format: "dd/mm/yyyy"
          });
      });
  </script>
@endsection
