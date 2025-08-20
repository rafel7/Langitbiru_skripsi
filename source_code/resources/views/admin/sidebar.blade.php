@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$user = Auth::user();

@endphp


<div class="d-flex">
    <nav id="sidebar" class="sidebar d-flex flex-column p-3">
        <button class="btn btn-light mb-3" id="toggleSidebar">☰</button>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>


            @if (Auth::check())
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="nav-text">Logout</span>
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
            @endif
        </ul>
    </nav>
</div>

<style>
    .status-icon {
        float: right;
        font-weight: bold;
    }

    .completed .status-icon {
        color: green;
        /* untuk status 1 dan 3 */
    }

    .review .status-icon {
        color: orange;
    }

    .nav-link.disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>