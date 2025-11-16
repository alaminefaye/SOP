@extends('layouts.app')

@section('title', 'Rapport de Conformité - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0">Rapport de Conformité</h5>
                <a href="{{ route('reports.index') }}" class="btn btn-label-secondary">
                    <i class="bx bx-arrow-back me-1"></i>
                    Retour
                </a>
            </div>
            <div class="card-body">
                <!-- Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['total_records'] }}</h3>
                                <p class="mb-0">Total Vérifications</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['compliant'] }}</h3>
                                <p class="mb-0">Conformes</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h3>{{ $stats['non_compliant'] }}</h3>
                                <p class="mb-0">Non Conformes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- By Procedure -->
                <div class="mb-4">
                    <h6>Conformité par Procédure</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Procédure</th>
                                    <th>Conformes</th>
                                    <th>Non Conformes</th>
                                    <th>Taux de Conformité</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['by_procedure'] as $procedure)
                                    @php
                                        $total = $procedure->compliant_count + $procedure->non_compliant_count;
                                        $rate = $total > 0 ? round(($procedure->compliant_count / $total) * 100, 2) : 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $procedure->title }}</td>
                                        <td>{{ $procedure->compliant_count }}</td>
                                        <td>{{ $procedure->non_compliant_count }}</td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $rate }}%">{{ $rate }}%</div>
                                            </div>
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
</div>
@endsection

