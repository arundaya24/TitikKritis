@php
    $__notifications = auth()->user()->notifications()->latest()->take(10)->get();
    $__unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<style>
    .notif-bell-link {
        position: relative;
    }

    .notif-badge {
        position: absolute;
        top: 2px;
        right: -2px;
        font-size: 0.6rem;
        padding: 3px 5px;
    }

    .notif-dropdown-menu {
        width: 320px;
        max-height: 380px;
        overflow-y: auto;
        padding: 0;
    }

    .notif-item {
        white-space: normal;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .notif-item.notif-unread {
        background-color: rgba(13, 110, 253, 0.06);
    }

    body.dark-mode .notif-item.notif-unread {
        background-color: rgba(79, 195, 247, 0.1);
    }
</style>

<div class="dropdown">
    <a class="nav-link notif-bell-link d-inline-block" href="#" id="notifDropdown" role="button"
        data-bs-toggle="dropdown" aria-expanded="false" title="Notifikasi">
        <i class="fas fa-bell"></i>
        @if ($__unreadCount > 0)
            <span class="badge rounded-pill bg-danger notif-badge">
                {{ $__unreadCount > 9 ? '9+' : $__unreadCount }}
            </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end notif-dropdown-menu" aria-labelledby="notifDropdown">
        <li class="d-flex justify-content-between align-items-center px-3 py-2">
            <span class="fw-bold">Notifikasi</span>
            @if ($__unreadCount > 0)
                <form action="{{ route('notifications.read.all') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-link btn-sm p-0">Tandai semua dibaca</button>
                </form>
            @endif
        </li>
        <li>
            <hr class="dropdown-divider m-0">
        </li>
        @forelse ($__notifications as $notif)
            <li>
                <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit"
                        class="dropdown-item notif-item {{ is_null($notif->read_at) ? 'notif-unread' : '' }} py-2">
                        <div class="small">{{ $notif->data['message'] ?? 'Notifikasi' }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">
                            {{ $notif->created_at->diffForHumans() }}
                        </div>
                    </button>
                </form>
            </li>
        @empty
            <li><span class="dropdown-item-text text-muted small px-3 py-3 d-block">Belum ada notifikasi</span></li>
        @endforelse
    </ul>
</div>
