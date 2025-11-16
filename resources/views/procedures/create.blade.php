@extends('layouts.app')

@section('title', 'Créer une Procédure - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">Créer une Nouvelle Procédure</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('procedures.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu de la Procédure <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="15" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                        <small class="text-muted">Décrivez les étapes de la procédure en détail.</small>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Priorité</label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="0" {{ old('priority', 0) == 0 ? 'selected' : '' }}>Normale</option>
                            <option value="1" {{ old('priority') == 1 ? 'selected' : '' }}>Importante</option>
                            <option value="2" {{ old('priority') == 2 ? 'selected' : '' }}>Urgente</option>
                        </select>
                    </div>

                    <!-- File Attachments -->
                    <div class="mb-4">
                        <label class="form-label">Pièces jointes</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.mp4,.avi">
                        <small class="text-muted">Vous pouvez sélectionner plusieurs fichiers (PDF, images, vidéos, documents). Taille max: 10MB par fichier.</small>
                    </div>

                    <!-- Checklist Items -->
                    <div class="mb-4">
                        <label class="form-label">Checklist de Conformité</label>
                        <div id="checklist-container">
                            <div class="checklist-item mb-2 border p-3 rounded">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <input type="text" name="checklist_items[0][item]" class="form-control" placeholder="Item de checklist">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="checklist_items[0][description]" class="form-control" placeholder="Description (optionnel)">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" name="checklist_items[0][is_required]" value="1" id="required-0" checked>
                                            <label class="form-check-label" for="required-0">Requis</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-checklist-item">
                            <i class="bx bx-plus"></i> Ajouter un item
                        </button>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="submit_for_approval" id="submit_for_approval" value="1">
                            <label class="form-check-label" for="submit_for_approval">
                                Soumettre pour approbation (envoie une notification aux managers)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('procedures.index') }}" class="btn btn-label-secondary">
                            <i class="bx bx-arrow-back me-1"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Checklist management
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('checklist-container');
        if (container) {
            let itemCount = container.querySelectorAll('.checklist-item').length;
            
            document.getElementById('add-checklist-item')?.addEventListener('click', function() {
                const newItem = document.createElement('div');
                newItem.className = 'checklist-item mb-2 border p-3 rounded';
                newItem.innerHTML = `
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="checklist_items[${itemCount}][item]" class="form-control" placeholder="Item de checklist">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="checklist_items[${itemCount}][description]" class="form-control" placeholder="Description (optionnel)">
                        </div>
                        <div class="col-md-2">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="checklist_items[${itemCount}][is_required]" value="1" id="required-${itemCount}" checked>
                                <label class="form-check-label" for="required-${itemCount}">Requis</label>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newItem);
                itemCount++;
            });
        }
    });
</script>
@endpush

