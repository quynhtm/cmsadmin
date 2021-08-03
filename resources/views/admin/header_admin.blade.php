<header class="wrap mb-20" style="background-color: #fafafa">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{\Illuminate\Support\Facades\URL::route('home.index')}}">
                    <img src="{{ asset('images/buv-logo.png') }}" height="45" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('admin') }}">SE Management</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-6">
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
