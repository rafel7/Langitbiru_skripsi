<ul class="task-list nav flex-column">
    @foreach($timeline_status as $tugas => $status)
    <li class="nav-item {{ $status ? 'completed' : '' }}">
        <a href="#" class="nav-link">
            <span class="task-name">{{ ucfirst(str_replace('_', ' ', $tugas)) }}</span>
            @if($status)
            <span class="status-icon">&#10003;</span>
            @endif
        </a>
    </li>
    @endforeach
</ul>