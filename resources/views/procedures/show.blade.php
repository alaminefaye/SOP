@extends('layouts.app')

@section('title', $procedure->title . ' - SOP')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title m-0">{{ $procedure->title }}</h5>
                    <small class="text-muted">
                        <span class="badge" style="background-color: {{ $procedure->category->color }};">
                            {{ $procedure->category->name }}
                        </span>
                        @if($procedure->status == 'approved')
                            <span class="badge bg-success">Approuvé</span>
                        @elseif($procedure->status == 'pending')
                            <span class="badge bg-warning">En attente</span>
                        @elseif($procedure->status == 'draft')
                            <span class="badge bg-secondary">Brouillon</span>
                        @else
                            <span class="badge bg-dark">Archivé</span>
                        @endif
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('procedures.edit', $procedure) }}" class="btn btn-warning">
                        <i class="bx bx-edit me-1"></i>
                        Modifier
                    </a>
                    @if(auth()->user()->canApprove() && $procedure->status == 'pending')
                        <form action="{{ route('procedures.approve', $procedure) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-check me-1"></i>
                                Approuver
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('procedures.index') }}" class="btn btn-label-secondary">
                        <i class="bx bx-arrow-back me-1"></i>
                        Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($procedure->description)
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p class="text-muted">{{ $procedure->description }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <h6>Contenu de la Procédure</h6>
                    <div class="bg-light p-4 rounded">
                        {!! nl2br(e($procedure->content)) !!}
                    </div>
                </div>

                @if($procedure->attachments->count() > 0)
                    <div class="mb-4">
                        <h6>Fichiers joints (Photos, Vidéos, Documents)</h6>
                        <div class="row g-3">
                            @foreach($procedure->attachments as $attachment)
                                <div class="col-md-4">
                                    <div class="card">
                                        @if(in_array($attachment->file_type, ['image']))
                                            <img src="{{ Storage::url($attachment->file_path) }}" class="card-img-top" alt="{{ $attachment->file_name }}" style="max-height: 200px; object-fit: cover;">
                                        @elseif(in_array($attachment->file_type, ['video']))
                                            <div class="card-body text-center bg-light">
                                                <i class="bx bx-video fs-1 text-primary"></i>
                                                <p class="mb-0 mt-2">{{ $attachment->file_name }}</p>
                                            </div>
                                        @else
                                            <div class="card-body text-center bg-light">
                                                <i class="bx bx-file fs-1 text-secondary"></i>
                                                <p class="mb-0 mt-2">{{ $attachment->file_name }}</p>
                                                <small class="text-muted">{{ number_format($attachment->file_size / 1024, 2) }} KB</small>
                                            </div>
                                        @endif
                                        <div class="card-footer">
                                            <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="btn btn-sm btn-primary w-100">
                                                <i class="bx bx-show me-1"></i>
                                                Voir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($procedure->checklists->count() > 0)
                    <div class="mb-4">
                        <h6>Checklist de Conformité</h6>
                        <ul class="list-group">
                            @foreach($procedure->checklists as $item)
                                <li class="list-group-item d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input me-3" id="checklist-{{ $item->id }}">
                                    <label for="checklist-{{ $item->id }}" class="mb-0">
                                        <strong>{{ $item->item }}</strong>
                                        @if($item->description)
                                            <br><small class="text-muted">{{ $item->description }}</small>
                                        @endif
                                    </label>
                                    @if($item->is_required)
                                        <span class="badge bg-danger ms-auto">Requis</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6>Informations</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Version:</strong></td>
                                <td>{{ $procedure->version }}</td>
                            </tr>
                            <tr>
                                <td><strong>Créé par:</strong></td>
                                <td>{{ $procedure->creator->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date de création:</strong></td>
                                <td>{{ $procedure->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @if($procedure->approved_by)
                                <tr>
                                    <td><strong>Approuvé par:</strong></td>
                                    <td>{{ $procedure->approver->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date d'approbation:</strong></td>
                                    <td>{{ $procedure->approved_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td><strong>Vues:</strong></td>
                                <td>{{ $procedure->views_count }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('procedures.versions', $procedure) }}" class="btn btn-outline-info">
                                <i class="bx bx-history me-1"></i>
                                Historique des versions
                            </a>
                            <a href="{{ route('procedures.export', $procedure) }}" class="btn btn-outline-primary" target="_blank">
                                <i class="bx bx-file me-1"></i>
                                Exporter en PDF
                            </a>
                            <a href="{{ route('compliance.show', $procedure) }}" class="btn btn-outline-success">
                                <i class="bx bx-check-square me-1"></i>
                                Suivi de Conformité
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Checklist management
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('checklist-container');
        if (container) {
            let itemCount = container.querySelectorAll('.checklist-item').length;
            
            document.getElementById('add-checklist-item')?.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'checklist-item mb-2 border p-3 rounded';
                newItem.innerHTML = `
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="checklist_items[${itemCount}][item]" class="form-control" placeholder="Item de checklist">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="checklist_items[${itemCount}][description]" class="form-control" placeholder="Description (optionnel)">
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="checklist_items[${itemCount}][is_required]" value="1" id="required-${itemCount}" checked>
                                <label class="form-check-label" for="required-${itemCount}">Requis</label>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newItem);
                itemCount++;
            });
        }
    });
</script>
@endpush

