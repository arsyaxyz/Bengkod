<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Login' }}</title>

  {{-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
  @vite(['resources/js/app.js', 'resources/css/app.css'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-evvBwr4nqXGNSHgL/f7a1q0byQz0YrcdwfJTbhBSICR7PB8cF51ck+w/U6sJ4MZtVlXv9kVs9XAH9bg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" 
    integrity="sha384-aokWfHlElNP7g0PKvLlbCETPNea2dzpi95cMHq1GnbvLnLD6Np941vN4=" crossorigin="anonymous">

  @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed min-vh-100">
  {{ $slot }}

  {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" 
    integrity="sha512-894YEfQ6WH5J0eNi6u0GBjPT3DT6GkqbZo5SmRXp4YfRVH+8abtTE1Pi6jizoCdzlZ7YT1Nx1B4ez74O6+vEA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

  @stack('scripts')
</body>
</html>