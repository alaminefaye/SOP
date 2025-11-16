@extends('layouts.app')

@section('title', 'Comparaison de Versions - ' . $procedure->title)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title m-0">Comparaison de Versions</h5>
                    <small class="text-muted">{{ $procedure->title }}</small>
                </div>
                <a href="{{ route('procedures.versions', $procedure) }}" class="btn btn-label-secondary">
                    <i class="bx bx-arrow-back me-1"></i>
                    Retour
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">Version {{ $v1->version_number }}</h6>
                                <small>Créée le {{ $v1->created_at->format('d/m/Y H:i') }} par {{ $v1->creator->name }}</small>
                            </div>
                            <div class="card-body">
                                @if($v1->change_summary)
                                    <p class="text-muted"><strong>Résumé:</strong> {{ $v1->change_summary }}</p>
                                @endif
                                <div class="bg-light p-3 rounded" style="max-height: 500px; overflow-y: auto;">
                                    {!! nl2br(e($v1->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">Version {{ $v2->version_number }}</h6>
                                <small>Créée le {{ $v2->created_at->format('d/m/Y H:i') }} par {{ $v2->creator->name }}</small>
                            </div>
                            <div class="card-body">
                                @if($v2->change_summary)
                                    <p class="text-muted"><strong>Résumé:</strong> {{ $v2->change_summary }}</p>
                                @endif
                                <div class="bg-light p-3 rounded" style="max-height: 500px; overflow-y: auto;">
                                    {!! nl2br(e($v2->content)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

