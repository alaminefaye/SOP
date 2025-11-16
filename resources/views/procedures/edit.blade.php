@extends('layouts.app')

@section('title', 'Modifier la Procédure - SOP')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0">Modifier la Procédure</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('procedures.update', $procedure) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $procedure->category_id) == $category->id ? 'selected' : '' }}>
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
                               value="{{ old('title', $procedure->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $procedure->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu de la Procédure <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="15" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $procedure->content) }}</textarea>
                        <small class="text-muted">Décrivez les étapes de la procédure en détail.</small>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="change_summary" class="form-label">Résumé des modifications</label>
                        <textarea name="change_summary" id="change_summary" rows="2" class="form-control" placeholder="Décrivez brièvement les modifications apportées..."></textarea>
                        <small class="text-muted">Ce résumé sera enregistré dans l'historique des versions.</small>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Priorité</label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="0" {{ old('priority', $procedure->priority) == 0 ? 'selected' : '' }}>Normale</option>
                            <option value="1" {{ old('priority', $procedure->priority) == 1 ? 'selected' : '' }}>Importante</option>
                            <option value="2" {{ old('priority', $procedure->priority) == 2 ? 'selected' : '' }}>Urgente</option>
                        </select>
                    </div>

                    <!-- Existing Attachments -->
                    @if($procedure->attachments->count() > 0)
                        <div class="mb-3">
                            <label class="form-label">Pièces jointes existantes</label>
                            <div class="list-group">
                                @foreach($procedure->attachments as $attachment)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="bx bx-file me-2"></i>
                                            {{ $attachment->file_name }}
                                            <small class="text-muted ms-2">({{ number_format($attachment->file_size / 1024, 2) }} KB)</small>
                                        </div>
                                        <a href="{{ Storage::url($attachment->file_path) }}" target="_blank" class="btn btn-sm btn-info me-2">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <form action="{{ route('procedures.attachments.destroy', [$procedure, $attachment]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette pièce jointe ?')">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- New File Attachments -->
                    <div class="mb-3">
                        <label class="form-label">Ajouter des pièces jointes</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.mp4,.avi">
                        <small class="text-muted">Vous pouvez sélectionner plusieurs fichiers. Taille max: 10MB par fichier.</small>
                    </div>

                    <!-- Checklist Items -->
                    <div class="mb-4">
                        <label class="form-label">Checklist de Conformité</label>
                        <div id="checklist-container">
                            @if($procedure->checklists->count() > 0)
                                @foreach($procedure->checklists as $index => $item)
                                    <div class="checklist-item mb-2 border p-3 rounded">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <input type="text" name="checklist_items[{{ $index }}][item]" class="form-control" value="{{ $item->item }}" placeholder="Item de checklist">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="checklist_items[{{ $index }}][description]" class="form-control" value="{{ $item->description }}" placeholder="Description (optionnel)">
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" name="checklist_items[{{ $index }}][is_required]" value="1" id="required-{{ $index }}" {{ $item->is_required ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="required-{{ $index }}">Requis</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
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
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="add-checklist-item">
                            <i class="bx bx-plus"></i> Ajouter un item
                        </button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('procedures.show', $procedure) }}" class="btn btn-label-secondary">
                            <i class="bx bx-arrow-back me-1"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i>
                            Enregistrer les modifications
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

