<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Admin Dashboard' }}</title>
  {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
  @vite(['resources/js/app.js', 'resources/css/app.css'])
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.2/css/all.min.css" 
    integrity="sha512-EV8m4RR4KeQnA4GSLGfA1Dbq8dDXqCProvdkJFlsh8CSBRP8EacGR5HwU6S2LwlnVuk/SQABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" /> salah --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referer">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHb9D9EmMqIYdEnLMwlNLD69Npy4HI+N" crossorigin="anonymous">
  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    @include('components.partials.sidebar')
    <div class="content-wrapper">
      @include('components.partials.header')
      {{ $slot }}
    </div>
    @include('components.partials.footer')
  </div>

  {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" 
    integrity="sha512-894YE6QWDt5I9hZ0GReFyMdnWc1QSTnVSaNCoP+u1T9qvDvdn1z0PpISiqn/3e7Jo4EaG7TubfWGURMq==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>
  @stack('scripts')
</body>
</html>