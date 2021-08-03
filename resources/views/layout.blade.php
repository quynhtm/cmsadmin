<!-- Copyright (c) Microsoft Corporation.
     Licensed under the MIT License. -->

<!-- <LayoutSnippet> -->
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Internship Evaluation Form</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="{{ asset('/css/bootstrap-datepicker.css') }}">

  </head>
  <body>
    @yield('content')
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
  </body>
</html>
<!-- </LayoutSnippet> -->
