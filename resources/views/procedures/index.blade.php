@extends('layouts.app')

@section('title', 'Procédures SOP - Restaurant')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Liste des Procédures</h5>
                <a href="{{ route('procedures.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>
                    Nouvelle Procédure
                </a>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <form method="GET" action="{{ route('procedures.index') }}" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Catégorie</label>
                            <select name="category" class="form-select">
                                <option value="">Toutes</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <option value="">Tous</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvé</option>
                                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Auteur</label>
                            <select name="author" class="form-select">
                                <option value="">Tous</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Date début</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Date fin</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Procedures Table -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Catégorie</th>
                                <th>Statut</th>
                                <th>Version</th>
                                <th>Créé par</th>
                                <th>Vues</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($procedures as $procedure)
                                <tr>
                                    <td>{{ $procedure->id }}</td>
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
                                    <td>{{ $procedure->creator->name }}</td>
                                    <td>{{ $procedure->views_count }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('procedures.show', $procedure) }}" class="btn btn-sm btn-info">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('procedures.edit', $procedure) }}" class="btn btn-sm btn-warning">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            @if(auth()->user()->canApprove() && $procedure->status == 'pending')
                                                <form action="{{ route('procedures.approve', $procedure) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bx bx-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucune procédure trouvée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $procedures->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

