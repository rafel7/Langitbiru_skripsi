@php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

$user = Auth::user();
$status_tugas = DB::table('status_tugas')->where('user_id', $user->id)->first();

// Status:
// 0 = bisa diakses (belum dikerjakan)
// 1 = selesai, tidak bisa diakses, centang hijau
// 2 = review, tidak bisa diakses
// 3 = selesai, bisa diakses, centang hijau
function renderNavItem($routeName, $taskKey, $label, $status_tugas) {
$status = $status_tugas?->$taskKey ?? 0;

// Kelas untuk status
$completedClass = $status == 1 ? 'completed' : ($status == 2 ? 'review' : ($status == 3 ? 'completed' : ''));

// Status 1 dan 2 tidak bisa diakses
$isDisabled = in_array($status, [1, 2]);

// Icon status
$icon = '';
if ($status == 1 || $status == 3) {
$icon = '&#10003;'; // centang
} elseif ($status == 2) {
$icon = '?'; // tanda tanya
}

// Bangun HTML
$html = '<li class="nav-item ' . $completedClass . '">';
    if ($isDisabled) {
    $html .= '<a href="#" class="nav-link disabled" onclick="event.preventDefault();">';
        } else {
        $html .= '<a href="' . route($routeName) . '" class="nav-link">';
            }

            $html .= '<span class="task-name">' . $label . '</span>';

            if ($icon !== '') {
            $html .= '<span class="status-icon">' . $icon . '</span>';
            }

            $html .= '</a></li>';

return $html;
}
@endphp


<div class="d-flex">
    <nav id="sidebar" class="sidebar d-flex flex-column p-3">
        <button class="btn btn-light mb-3" id="toggleSidebar">☰</button>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}" class="nav-link">
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Daftar Tugas -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#tugasCollapseSidebar" role="button"
                    aria-expanded="false" aria-controls="tugasCollapseSidebar">
                    <span class="nav-text">Daftar Tugas</span>
                </a>

                <div class="collapse mt-2" id="tugasCollapseSidebar">
                    <ul class="task-list nav flex-column">
                        {!! renderNavItem('pretest.form', 'pretest', 'Pretest', $status_tugas) !!}
                        {!! renderNavItem('video1', 'pembelajaran', 'Pembelajaran', $status_tugas) !!}
                        {!! renderNavItem('game.wordsearch', 'cari_kata', 'Cari Kata', $status_tugas) !!}
                        {!! renderNavItem('game.teka-teki-silang', 'tts', 'Teka Teki Silang', $status_tugas) !!}
                        {!! renderNavItem('posttest.form', 'posttest', 'Posttest', $status_tugas) !!}
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('nilai.index') }}" class="nav-link">
                    <span class="nav-text">Nilai</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('profil.index') }}" class="nav-link">
                    <span class="nav-text">Profil</span>
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