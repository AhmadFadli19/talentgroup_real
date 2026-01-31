<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href={{ asset('assets/css/home.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/blog.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/about.css') }}>
    <link rel="stylesheet" href={{ asset('assets/css/bartnerkolabolaborasi.css') }}>

    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />



    <title>TalentGroup</title>

</head>
<body>
    @include('Content/header')
    
    @yield('content')

@include('Content/footer')
    <!-- Scripts -->
    {{-- <script src={{ asset('vendor/jquery/jquery.min.js') }}></script>
    <script src={{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    <script src={{ asset('assets/js/owl-carousel.js') }}></script>
    <script src={{ asset('assets/js/animation.js') }}></script>
    <script src={{ asset('assets/js/imagesloaded.js') }}></script>
    <script src={{ asset('assets/js/templatemo-custom.js') }}></script> --}}
</body>

</html>