@extends('layouts.app')

@section('title', 'Notifications - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Mes Notifications</h5>
                @if($unreadCount > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="bx bx-check-double me-1"></i>
                            Tout marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
            <div class="card-body">
                @forelse($notifications as $notification)
                    <div class="notification-item border-bottom p-3 {{ $notification->read_at ? '' : 'bg-light' }}">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar">
                                    <span class="avatar-initial rounded-circle bg-label-{{ $notification->data['type'] == 'compliance_alert' ? 'danger' : ($notification->data['type'] == 'procedure_approval' ? 'warning' : 'primary') }}">
                                        <i class="bx bx-{{ $notification->data['type'] == 'compliance_alert' ? 'x-circle' : ($notification->data['type'] == 'procedure_approval' ? 'check-circle' : 'file') }}"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    {{ $notification->data['message'] ?? 'Notification' }}
                                    @if(!$notification->read_at)
                                        <span class="badge bg-primary">Nouveau</span>
                                    @endif
                                </h6>
                                <p class="text-muted mb-1 small">
                                    @if(isset($notification->data['procedure_title']))
                                        <strong>Procédure:</strong> {{ $notification->data['procedure_title'] }}<br>
                                    @endif
                                    @if(isset($notification->data['created_by']))
                                        <strong>Par:</strong> {{ $notification->data['created_by'] }}<br>
                                    @endif
                                    <strong>Date:</strong> {{ $notification->created_at->format('d/m/Y à H:i') }}
                                </p>
                                <div class="d-flex gap-2 mt-2">
                                    @if(isset($notification->data['procedure_id']))
                                        <a href="{{ route('procedures.show', $notification->data['procedure_id']) }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-show"></i> Voir la procédure
                                        </a>
                                    @endif
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="bx bx-check"></i> Marquer comme lu
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette notification ?')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bx bx-bell-off fs-1 text-muted"></i>
                        <p class="text-muted mt-3">Aucune notification</p>
                    </div>
                @endforelse

                <div class="mt-3">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

