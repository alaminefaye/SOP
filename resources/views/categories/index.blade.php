@extends('layouts.app')

@section('title', 'Catégories - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Liste des Catégories</h5>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>
                    Nouvelle Catégorie
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($categories as $category)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar flex-shrink-0 me-3" style="background-color: {{ $category->color }}20;">
                                            <i class="{{ $category->icon ?? 'bx-folder' }} fs-4" style="color: {{ $category->color }};"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $category->name }}</h6>
                                            <small class="text-muted">{{ $category->procedures()->count() }} procédure(s)</small>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-label-secondary" type="button" data-bs-toggle="dropdown">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('categories.show', $category) }}"><i class="bx bx-show me-2"></i>Voir</a></li>
                                                <li><a class="dropdown-item" href="{{ route('categories.edit', $category) }}"><i class="bx bx-edit me-2"></i>Modifier</a></li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                                            <i class="bx bx-trash me-2"></i>Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if($category->description)
                                        <p class="text-muted small mb-0">{{ \Illuminate\Support\Str::limit($category->description, 100) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                Aucune catégorie trouvée. <a href="{{ route('categories.create') }}">Créer la première catégorie</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

