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

      <form method="get">
        <div class="card mb-3">
          <h1 class="title"><i class="fa fa-search"></i> Box filter</h1>

          <div class="card-body">



            <div class="row">


              <div class="form-group col-lg-3">
                <label for="code">HAN ID</label>
                <div>
                  <input type="text" class="form-control" id="code" name="code" value="{{ isset($search['code']) ? $search['code'] : '' }}">
                </div>
              </div>


              <div class="form-group col-lg-3">
                <label for="name">Intern’s Full-name</label>
                <div>
                  <input type="text" class="form-control" id="name" name="name" value="{{ isset($search['name']) ? $search['name'] : '' }}">
                </div>
              </div>


              <div class="form-group col-lg-3">
                <label for="class">Class</label>
                <div>
                  <input type="text" class="form-control" id="class" name="class" value="{{ isset($search['class']) ? $search['class'] : '' }}">
                </div>
              </div>


              <div class="form-group col-lg-3">
                <label for="org">Employer’s name</label>
                <div>
                  <input type="text" class="form-control" id="org" name="org" value="{{ isset($search['org']) ? $search['org'] : '' }}">
                </div>
              </div>

              <div class="form-group col-lg-4">
                <label for="position">Employer’s position</label>
                <div>
                  <input type="text" class="form-control" id="position" name="position" value="{{ isset($search['position']) ? $search['position'] : '' }}">
                </div>
              </div>

              <div class="form-group col-lg-2">
                <label for="date">Created on</label>
                <div>
                  <input type="text" class="form-control datepicker" id="date" name="date" value="{{ isset($search['date']) ? $search['date'] : '' }}" autocomplete="off">
                </div>
              </div>

              <div class="form-group col-lg-2">
                <label for="date_to">to</label>
                <div>
                  <input type="text" class="form-control datepicker" id="date_to" name="date_to" value="{{ isset($search['date_to']) ? $search['date_to'] : '' }}" autocomplete="off">
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
            <a href="{{ route('evaluation.form') }}" class="btn btn-danger ml-2"><i class="fa fa-plus"></i> Add new</a>
          </div>

        </div>
      </form>

      <div class="card">
        <h1 class="title">Internship Evaluation List</h1>
        <div class="card-body">


          <div class="table-responsive">
            <table class="table">
              <thead>
              <tr>
                <th>No.</th>
                <th>HAN ID</th>
                <th>Intern’s Full-name</th>
                <th>Class</th>
                <th>Employer’s name</th>
                <th>Employer’s position</th>
                <th>Internship period (mm/yyyy)</th>
                <th>Created on</th>
                <th>Option</th>
              </tr>

              </thead>

              <tbody>
              @foreach($evaluation as $k=>$v)
                <tr>
                  <td>{{ $k+1 }}</td>
                  <td>{{ $v->code }}</td>
                  <td>{{ $v->name }}</td>
                  <td>{{ $v->class }}</td>
                  <td>{{ $v->org }}</td>
                  <td>{{ $v->position }}</td>
                  <td>{{ $v->period }} - {{ $v->period_to }}</td>
                  <td>{{ date('H:i d/m/Y') }}</td>
                  <td>
                    <p style="margin: 0 0 5px 0;padding: 0"><a href="{{ route('evaluation.download', ['id'=>$v->id]) }}"><i class="fa fa-download"></i> Evaluation form</a></p>
                    <p style="margin: 0 0 5px 0;padding: 0"><a href="{{ route('evaluation.certificate', ['id'=>$v->id]) }}"><i class="fa fa-download"></i> Certificate</a></p>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
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
            }, 5000);
        });
    </script>
  @endif

  <script type="text/javascript">
      $(function() {
          $(".datepicker").datepicker( {
              format: "dd-mm-yyyy"
              //startView: "months",
              //minViewMode: "months"
          });
      });
  </script>
@endsection
