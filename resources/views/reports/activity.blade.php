@extends('layouts.app')

@section('title', 'Rapport d\'Activité - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Rapport d'Activité</h5>
                <a href="{{ route('reports.index') }}" class="btn btn-label-secondary">
                    <i class="bx bx-arrow-back me-1"></i>
                    Retour
                </a>
            </div>
            <div class="card-body">
                <!-- Monthly Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['procedures_created'] }}</h3>
                                <p class="mb-0">Procédures Créées (Ce mois)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['procedures_approved'] }}</h3>
                                <p class="mb-0">Procédures Approuvées (Ce mois)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['compliance_checks'] }}</h3>
                                <p class="mb-0">Vérifications (Ce mois)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Most Active Users -->
                <div class="mb-4">
                    <h6>Utilisateurs les Plus Actifs</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Procédures Créées</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['most_active_users'] as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $user->role ?? 'employee')) }}</td>
                                        <td>{{ $user->procedures_count }}</td>
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

