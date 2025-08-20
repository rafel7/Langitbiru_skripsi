<!doctype html>
<!--
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
-->
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <!--@vite(['resources/sass/app.scss', 'resources/js/app.js'])-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- navbar-->
    <!-- <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!--navbar-->


    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /*CSS fil the blank*/
        .game-container {
            max-width: 600px;
            margin: auto;
        }

        .feedback {
            margin-top: 20px;
        }

        .correct {
            color: green;
            font-weight: bold;
        }

        .incorrect {
            color: red;
            font-weight: bold;
        }

        .video-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .video-container iframe,
        .video-container video {
            width: 80%;
            max-width: 800px;
            height: 450px;
        }

        /*CSS word search*/
        .grid {
            display: grid;
            grid-template-columns:
                repeat(6, 40px);
            gap: 5px;
            justify-content:
                center;
        }

        .cell {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 20px;
            border: 1px solid black;
            background: #f9f9f9;
        }

        .word-list {
            text-align: center;
            margin-top: 20px;
        }

        /*CSS buat gambar*/
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
            /* Sesuaikan tinggi sesuai kebutuhan */
        }

        .image-container img {
            max-width: 70%;
            min-width: 60%;
            /* Bisa diganti sesuai kebutuhan */

            /* Supaya responsif */
            height: auto;

        }

        /* CSS untuk sidebar */
        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            height: 100%;
            background: #343a40;
            color: white;
            overflow-y: auto;
            transition: all 0.3s;


        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .nav-link {
            color: white;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar.collapsed .nav-text {
            display: none;
        }

        .content {
            margin-left: 250px;
            transition: margin-left 0.3s;
        }

        .content.collapsed {
            margin-left: 80px;
        }
    </style>
</head>



<!-- </head> -->

<body>

    <!-- <div class="container-fluid p-4" id="main-content" style=" transition: 0.3s;">
        @yield('content')
    </div> -->
    <div id="mainContent" class="content">
        @yield('content')
    </div>

</body>


</html>