@extends('layouts.app')

@section('title', 'Rapports - SOP')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h4 class="fw-bold">Rapports et Statistiques</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bx bx-file fs-1 text-primary mb-3"></i>
                <h5>Rapport des Procédures</h5>
                <p class="text-muted">Statistiques détaillées sur les procédures</p>
                <a href="{{ route('reports.procedures') }}" class="btn btn-primary">
                    <i class="bx bx-show me-1"></i>
                    Voir le rapport
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bx bx-check-circle fs-1 text-success mb-3"></i>
                <h5>Rapport de Conformité</h5>
                <p class="text-muted">Statistiques sur la conformité</p>
                <a href="{{ route('reports.compliance') }}" class="btn btn-success">
                    <i class="bx bx-show me-1"></i>
                    Voir le rapport
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bx bx-bar-chart fs-1 text-info mb-3"></i>
                <h5>Rapport d'Activité</h5>
                <p class="text-muted">Activité récente du système</p>
                <a href="{{ route('reports.activity') }}" class="btn btn-info">
                    <i class="bx bx-show me-1"></i>
                    Voir le rapport
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

