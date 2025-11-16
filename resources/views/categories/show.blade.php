@extends('layouts.app')

@section('title', $category->name . ' - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="card-title m-0">{{ $category->name }}</h5>
                    <small class="text-muted">
                        <span class="badge" style="background-color: {{ $category->color }};">
                            {{ $category->procedures()->count() }} procédure(s)
                        </span>
                    </small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
                        <i class="bx bx-edit me-1"></i>
                        Modifier
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-label-secondary">
                        <i class="bx bx-arrow-back me-1"></i>
                        Retour
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($category->description)
                    <div class="mb-4">
                        <h6>Description</h6>
                        <p class="text-muted">{{ $category->description }}</p>
                    </div>
                @endif

                <div class="mb-4">
                    <h6>Procédures de cette catégorie</h6>
                    @if($category->procedures->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Statut</th>
                                        <th>Version</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->procedures as $procedure)
                                        <tr>
                                            <td>
                                                <a href="{{ route('procedures.show', $procedure) }}" class="text-decoration-none">
                                                    {{ $procedure->title }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($procedure->status == 'approved')
                                                    <span class="badge bg-success">Approuvé</span>
                                                @elseif($procedure->status == 'pending')
                                                    <span class="badge bg-warning">En attente</span>
                                                @elseif($procedure->status == 'draft')
                                                    <span class="badge bg-secondary">Brouillon</span>
                                                @else
                                                    <span class="badge bg-dark">Archivé</span>
                                                @endif
                                            </td>
                                            <td>{{ $procedure->version }}</td>
                                            <td>
                                                <a href="{{ route('procedures.show', $procedure) }}" class="btn btn-sm btn-info">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Aucune procédure dans cette catégorie.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

