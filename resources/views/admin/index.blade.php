@extends('layout')
@section('content')
@include('admin.header_admin')

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
                <label for="org">Employer’s</label>
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
          <button type="submit" class="btn btn-danger" name="sbm" value="1"><i class="fa fa-file-excel"></i> Export to excel</button>
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
                <th>Employer’s</th>
                <th>Position</th>
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
                  <td>{{ date('H:i d/m/Y', $v->date_c) }}</td>
                  <td>
                    <p style="margin: 0 0 5px 0;padding: 0"><a href="{{ route('evaluation.download', ['id'=>$v->id]) }}"><i class="fa fa-download"></i> Evaluation form</a></p>
                    <p style="margin: 0 0 5px 0;padding: 0"><a href="{{ route('evaluation.certificate', ['id'=>$v->id]) }}"><i class="fa fa-download"></i> Certificate</a></p>
                    <p style="margin: 0 0 5px 0;padding: 0"><a href="{{ route('evaluation.update', ['id'=>$v->id]) }}"><i class="fa fa-edit"></i> Edit</a></p>
                    <p style="margin: 0 0 5px 0;padding: 0"><a href="{{ route('evaluation.destroy', ['id'=>$v->id]) }}" onclick="return confirm('Are you sure you do this?')"><i class="fa fa-trash color-red"></i> Delete</a></p>
                  </td>
                </tr>
              @endforeach
              </tbody>

            </table>
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
