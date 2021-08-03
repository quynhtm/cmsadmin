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
                      <a class="nav-link active" aria-current="page" href="{{ route('/') }}">Face Recognition</a>
                    </li>
                    {{--<li class="nav-item">--}}
                      {{--<a class="nav-link" href="{{ route('evaluation') }}">Internship Evaluation</a>--}}
                    {{--</li>--}}
                  </ul>
                </div>

                <div class="col-lg-4">
                  <ul class="nav-account">
                    <li><strong>Hello! @if(isset($user) && $user['name'] != '') {{ $user['name'] }} @endif</strong></li>
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
        <h1 class="title"><i class="fa fa-user"></i> Update photo for face recognition device</h1>
        <div class="card-body">


          <form id="form" method="post" enctype="multipart/form-data">
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <ul>
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
              <div class="col-lg-4 col-md-6 col-sm-12 pt-20">
                <div class="form-group text-center">
                  @if($user['image'] != '')
                    <img id="photo_preview" src="{{ asset('storage/app/files/' . $user['image']) }}?ver={{ rand(111, 999) }}" width="250" class="mb-20">
                  @else
                    <img id="photo_preview" src="{{ asset('images/no-avatar.png') }}" width="250" class="mb-20">
                  @endif
                  <input type="file" id="image" name="image" class="display-none" onchange="readURL(this);" accept=".png, .jpg, .jpeg">
                  <div class="col-lg-12 text-center">
                    <a href="javascript:void(0);" onclick="$('#image').click();" class="btn btn-danger btn-sm"><i class="fa fa-upload"></i> Choose photo</a>
                    <button type="submit" name="sbm" value="1" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save your photo</button>
                  </div>
                </div>
                <div class="form-group">
                  <p class="mb-5"><strong>Your photo must be:</strong></p>
                  <p class="mb-5">1. Clear and in focus</p>
                  <p class="mb-5">2. in colour</p>
                  <p class="mb-5">3. most recent photo</p>
                  <p class="mb-5">4. unaltered by computer software</p>
                  <p class="mb-5">5. At least 400 pixels wide and 400 pixels tall and at most 1000 pixels wide and 1000 pixels tall</p>
                  <p class="mb-5">6. At least 50KB and no more than 500KB</p>
                  <p class="mb-5">7. Only .jpg/.jpeg and .png files are allowed</p>
                  <p><img src="{{ asset('images/example.jpg') }}" width="100%"></p>
                </div>
              </div>
              <div class="mb-20 col-lg-8 col-md-6 col-sm-12">
                <div class="form-group">
                  <label>Student ID</label>
                  <input class="form-control" value="{{ isset($user['student_id']) ? $user['student_id'] : '' }}" disabled>
                </div>
                <div class="form-group">
                  <label>Student name</label>
                  <input class="form-control" value="{{ isset($user['name']) ? $user['name'] : '' }}" disabled>
                </div>
                <div class="row">
                  <div class="form-group col-lg-6">
                    <label>Date of birth</label>
                    <input class="form-control" value="{{ (isset($user['dob']) && $user['dob'] > 0) ? date('d/m/Y', $user['dob']) : '' }}" disabled>
                  </div>
                  <div class="form-group col-lg-6">
                    <label>Mobile phone</label>
                    <input class="form-control" value="{{ isset($user['mobile']) ? $user['mobile'] : '' }}" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label>Student email</label>
                  <input class="form-control" value="{{ isset($user['email']) ? $user['email'] : '' }}" disabled>
                </div>
                <div class="form-group">
                  <label for="address">Mailing Address</label>
                  <input class="form-control" id="address" name="address" value="{{ isset($user['address']) ? $user['address'] : '' }}" disabled>
                </div>
              </div>
            </div>
          </form>



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
  <script>
      function readURL(input) {
          if (input.files && input.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                  $('#photo_preview').attr('src', e.target.result);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
  </script>
@endsection
