@extends('layouts.app')

@section('title', 'Rapport des Procédures - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Rapport des Procédures</h5>
                <a href="{{ route('reports.index') }}" class="btn btn-label-secondary">
                    <i class="bx bx-arrow-back me-1"></i>
                    Retour
                </a>
            </div>
            <div class="card-body">
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['total'] }}</h3>
                                <p class="mb-0">Total Procédures</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['by_status']['approved'] ?? 0 }}</h3>
                                <p class="mb-0">Approuvées</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['by_status']['pending'] ?? 0 }}</h3>
                                <p class="mb-0">En Attente</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['by_status']['draft'] ?? 0 }}</h3>
                                <p class="mb-0">Brouillons</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- By Category -->
                <div class="mb-4">
                    <h6>Procédures par Catégorie</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Catégorie</th>
                                    <th>Nombre de Procédures</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['by_category'] as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->procedures_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Most Viewed -->
                <div class="mb-4">
                    <h6>Procédures les Plus Consultées</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Catégorie</th>
                                    <th>Vues</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['most_viewed'] as $procedure)
                                    <tr>
                                        <td>{{ $procedure->title }}</td>
                                        <td>{{ $procedure->category->name }}</td>
                                        <td>{{ $procedure->views_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

