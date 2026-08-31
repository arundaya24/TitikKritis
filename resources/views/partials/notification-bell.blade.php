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

    .notif-header-actions {
        display: flex;
        gap: 10px;
    }

    .notif-header-actions .btn-link {
        text-decoration: none;
    }

    .notif-item-wrapper {
        display: flex;
        align-items: stretch;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .notif-item-wrapper .notif-item {
        flex: 1 1 auto;
        white-space: normal;
        text-align: left;
        border: none;
    }

    .notif-item.notif-unread {
        background-color: rgba(13, 110, 253, 0.06);
    }

    .notif-delete-form {
        flex: 0 0 auto;
    }

    .notif-delete-btn {
        height: 100%;
        padding: 0 12px;
        border: none;
        background: transparent;
        color: #adb5bd;
    }

    .notif-delete-btn:hover {
        color: #dc3545;
    }

    body.dark-mode .notif-dropdown-menu {
        color: #e0e0e0;
    }

    body.dark-mode .notif-dropdown-menu .fw-bold {
        color: #e0e0e0 !important;
    }

    body.dark-mode .notif-dropdown-menu .text-muted {
        color: #8899a6 !important;
    }

    body.dark-mode .notif-item-wrapper {
        border-bottom-color: rgba(255, 255, 255, 0.08);
    }

    body.dark-mode .notif-item.notif-unread {
        background-color: rgba(79, 195, 247, 0.1);
    }

    body.dark-mode .notif-dropdown-menu .btn-link {
        color: #4fc3f7 !important;
    }

    body.dark-mode .notif-delete-btn {
        color: #6c7a89;
    }

    body.dark-mode .notif-delete-btn:hover {
        color: #ff6b6b;
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
            <div class="notif-header-actions">
                @if ($__unreadCount > 0)
                    <form action="{{ route('notifications.read.all') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link btn-sm p-0">Tandai semua dibaca</button>
                    </form>
                @endif
                @if ($__notifications->isNotEmpty())
                    <form action="{{ route('notifications.destroy.all') }}" method="POST" class="m-0"
                        onsubmit="return confirm('Hapus semua notifikasi?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-sm p-0 text-danger">Hapus semua</button>
                    </form>
                @endif
            </div>
        </li>
        <li>
            <hr class="dropdown-divider m-0">
        </li>
        @forelse ($__notifications as $notif)
            <li class="notif-item-wrapper">
                <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="m-0 flex-grow-1">
                    @csrf
                    <button type="submit"
                        class="dropdown-item notif-item {{ is_null($notif->read_at) ? 'notif-unread' : '' }} py-2">
                        <div class="small">{{ $notif->data['message'] ?? 'Notifikasi' }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">
                            {{ $notif->created_at->diffForHumans() }}
                        </div>
                    </button>
                </form>
                <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST"
                    class="m-0 notif-delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="notif-delete-btn" title="Hapus notifikasi">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </li>
        @empty
            <li><span class="dropdown-item-text text-muted small px-3 py-3 d-block">Belum ada notifikasi</span></li>
        @endforelse
    </ul>
</div>
