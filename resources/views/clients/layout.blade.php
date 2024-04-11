<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('assets/clients/bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/clients/fontawesome-free-6.5.1-web/css/all.min.css') }}">
  @yield('link')
</head>
<body>
  @yield('content')
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  @yield('script')
</body>
</html>