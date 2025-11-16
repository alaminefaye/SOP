@extends('layouts.app')

@section('title', 'Historique des Versions - ' . $procedure->title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title m-0">Historique des Versions</h5>
                    <small class="text-muted">{{ $procedure->title }}</small>
                </div>
                <a href="{{ route('procedures.show', $procedure) }}" class="btn btn-label-secondary">
                    <i class="bx bx-arrow-back me-1"></i>
                    Retour
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Version</th>
                                <th>Date</th>
                                <th>Créé par</th>
                                <th>Résumé des modifications</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Current Version -->
                            <tr class="table-primary">
                                <td><strong>Version {{ $procedure->version }} (Actuelle)</strong></td>
                                <td>{{ $procedure->updated_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $procedure->creator->name }}</td>
                                <td>Version actuelle</td>
                                <td>
                                    <a href="{{ route('procedures.show', $procedure) }}" class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                </td>
                            </tr>
                            <!-- Previous Versions -->
                            @foreach($procedure->versions as $version)
                                <tr>
                                    <td>Version {{ $version->version_number }}</td>
                                    <td>{{ $version->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $version->creator->name }}</td>
                                    <td>{{ $version->change_summary ?? 'Aucun résumé' }}</td>
                                    <td>
                                        <a href="{{ route('procedures.compare', [$procedure, $version->version_number, $procedure->version]) }}" class="btn btn-sm btn-primary">
                                            <i class="bx bx-git-compare"></i> Comparer
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

