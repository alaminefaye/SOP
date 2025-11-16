@extends('layouts.app')

@section('title', 'Suivi de Conformité - ' . $procedure->title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title m-0">Suivi de Conformité</h5>
                    <small class="text-muted">{{ $procedure->title }}</small>
                </div>
                <a href="{{ route('compliance.index') }}" class="btn btn-label-secondary">
                    <i class="bx bx-arrow-back me-1"></i>
                    Retour
                </a>
            </div>
            <div class="card-body">
                <!-- Checklist Form -->
                @if($procedure->checklists->count() > 0)
                    <div class="mb-4">
                        <h6>Enregistrer une Vérification de Conformité</h6>
                        <form action="{{ route('compliance.store', $procedure) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="checklist_item_id" class="form-label">Item de Checklist</label>
                                <select name="checklist_item_id" id="checklist_item_id" class="form-select">
                                    <option value="">Sélectionner un item (optionnel)</option>
                                    @foreach($procedure->checklists as $item)
                                        <option value="{{ $item->id }}">{{ $item->item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Statut de Conformité</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_compliant" id="compliant_yes" value="1" checked>
                                        <label class="form-check-label" for="compliant_yes">Conforme</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_compliant" id="compliant_no" value="0">
                                        <label class="form-check-label" for="compliant_no">Non Conforme</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Ajoutez des notes sur la vérification..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>
                                Enregistrer
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Compliance Records -->
                <div class="mb-4">
                    <h6>Historique des Vérifications</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Utilisateur</th>
                                    <th>Item</th>
                                    <th>Statut</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complianceRecords as $record)
                                    <tr>
                                        <td>{{ $record->checked_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $record->user->name }}</td>
                                        <td>{{ $record->checklistItem->item ?? 'N/A' }}</td>
                                        <td>
                                            @if($record->is_compliant)
                                                <span class="badge bg-success">Conforme</span>
                                            @else
                                                <span class="badge bg-danger">Non Conforme</span>
                                            @endif
                                        </td>
                                        <td>{{ $record->notes }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Aucun enregistrement de conformité</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $complianceRecords->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

