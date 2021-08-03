@extends('layout_blank')
@section('title', 'Sign in')
@section('content')
  <div class="flex-fill d-flex flex-column justify-content-center">
    <div class="container-tight py-6">
      <div class="card bg-intro">
        <div class="card-body intro-head text-center" style="padding-top: 50px;padding-bottom: 15px!important;">
          <img src="{{ asset('images/buv-logo.png') }}" height="80" class="mb-20" alt="BUV logo">
          <h3 class="intro-title">Internship Evaluation Form</h3>
        </div>
        <div class="card-body" style="padding-bottom: 50px;">
          <div class="intro-body text-center">
            <a href="/signin" class="btn btn-danger font-weight-bold">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 53.59 64.356" width="22" height="25">
                <g transform="translate(-216.07358,-549.28882)">
                  <g transform="matrix(1.8232952,0,0,1.8232952,-597.71681,-124.12247)">
                    <g transform="translate(0,-91.137241)">
                      <g fill="#fff" transform="matrix(0.74069815,0,0,0.74069815,98.5698,-8.2505871)">
                        <path d="m469.87,671.03,0-28.52,25.229-9.3238,13.711,4.3877,0,38.392-13.711,4.133-25.229-9.0691,25.229,3.0361,0-33.201-16.454,3.8392,0,22.487z"/>
                      </g>
                    </g>
                  </g>
                </g>
              </svg>
              &nbsp;&nbsp;&nbsp;Sign in with Office 365
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection