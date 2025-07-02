<nav class="navbar navbar-expand-lg navbar-dark px-4" style="background-color: #343a40; height:67px;box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.15);;">

    <div class="container-fluid">


        <div class="ms-auto d-flex align-items-center">
            @if(Auth::check())
            <span class="text-white me-3"> {{ Auth::user()->name }}</span>

            @endif
        </div>
    </div>
</nav>