@extends('layouts.app')

@section('title', 'Suivi de Conformité - SOP')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-bold">Tableau de Bord de Conformité</h4>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-file fs-4"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block mb-1">Procédures</span>
                        <h3 class="mb-0">{{ $complianceStats['total_procedures'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-check-circle fs-4"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block mb-1">Vérifications</span>
                        <h3 class="mb-0">{{ $complianceStats['total_checks'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-double fs-4"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block mb-1">Conformes</span>
                        <h3 class="mb-0">{{ $complianceStats['compliant'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="bx bx-x-circle fs-4"></i>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-semibold d-block mb-1">Non Conformes</span>
                        <h3 class="mb-0">{{ $complianceStats['non_compliant'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Procedures List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">Procédures Approuvées</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Checklist Items</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($procedures as $procedure)
                                <tr>
                                    <td>
                                        <a href="{{ route('procedures.show', $procedure) }}" class="text-decoration-none">
                                            {{ $procedure->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge" style="background-color: {{ $procedure->category->color }};">
                                            {{ $procedure->category->name }}
                                        </span>
                                    </td>
                                    <td>{{ $procedure->checklists->count() }} item(s)</td>
                                    <td>
                                        <a href="{{ route('compliance.show', $procedure) }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-check-square"></i> Suivre la conformité
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune procédure approuvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Records -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">Derniers Enregistrements</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Procédure</th>
                                <th>Utilisateur</th>
                                <th>Item</th>
                                <th>Statut</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRecords as $record)
                                <tr>
                                    <td>{{ $record->checked_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $record->procedure->title }}</td>
                                    <td>{{ $record->user->name }}</td>
                                    <td>{{ $record->checklistItem->item ?? 'N/A' }}</td>
                                    <td>
                                        @if($record->is_compliant)
                                            <span class="badge bg-success">Conforme</span>
                                        @else
                                            <span class="badge bg-danger">Non Conforme</span>
                                        @endif
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($record->notes, 50) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Aucun enregistrement</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

