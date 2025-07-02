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

    <!-- <title>{{ config('app.name', 'Laravel') }}</title> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- navbar-->
    <!-- <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!--navbar-->


    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">




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

        .card {
            margin-left: 20px;
            margin-right: 20px;
        }

        .video-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            margin-left: 20px;
            margin-right: 20px;

        }

        .video-container iframe {
            width: calc(100vw - 0px);
            position: relative;

        }

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
            -webkit-user-select: none;
            /* Chrome, Safari */
            -moz-user-select: none;
            /* Firefox */
            -ms-user-select: none;
            /* IE/Edge lama */
            user-select: none;
            /* Standard */

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
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.15);
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

        .task-list .nav-item {
            position: relative;
            margin-bottom: 15px;
            margin-left: 20px;
        }

        .task-list .nav-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            background: #fff;
            color: #333;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .task-list .nav-link:hover {
            background: #e2e6ea;
        }

        .task-list .status-icon {
            display: none;
            color: green;
            font-size: 18px;
        }

        .task-list .completed .status-icon {
            display: inline;
        }

        .task-list .completed .task-name {
            text-decoration: line-through;
            color: #6c757d;
        }



        .content {
            margin-left: 250px;
            transition: margin-left 0.3s;
            width: calc(100% - 250px);
        }

        .content.collapsed {
            margin-left: 80px;
        }

        #mainContent {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #pdf-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            max-width: 90%;
            /* biar tidak melebar full */
        }

        #pdf-render {
            width: 100%;
            height: auto;
            max-width: 900px;
            /* batasi supaya tidak terlalu besar di layar besar */
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>



<!-- </head> -->

<body>
    @include('admin.topbar')
    <div class="d-flex">
        @include('admin.sidebar')

        <div class="content p-4" id="mainContent" style="transition: 0.3s;">



            @yield('content')


        </div>
    </div>

</body>


</html>