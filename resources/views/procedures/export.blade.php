<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $procedure->title }} - SOP Restaurant</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            border-bottom: 2px solid #696cff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #696cff;
            margin: 0;
        }
        .info-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
        }
        .content {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .checklist {
            margin: 20px 0;
        }
        .checklist-item {
            padding: 10px;
            margin: 5px 0;
            border-left: 3px solid #696cff;
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $procedure->title }}</h1>
        <p><strong>Catégorie:</strong> {{ $procedure->category->name }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td>Version</td>
            <td>{{ $procedure->version }}</td>
        </tr>
        <tr>
            <td>Statut</td>
            <td>
                @if($procedure->status == 'approved')
                    Approuvé
                @elseif($procedure->status == 'pending')
                    En attente
                @elseif($procedure->status == 'draft')
                    Brouillon
                @else
                    Archivé
                @endif
            </td>
        </tr>
        <tr>
            <td>Créé par</td>
            <td>{{ $procedure->creator->name }}</td>
        </tr>
        <tr>
            <td>Date de création</td>
            <td>{{ $procedure->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @if($procedure->approved_by)
            <tr>
                <td>Approuvé par</td>
                <td>{{ $procedure->approver->name }}</td>
            </tr>
            <tr>
                <td>Date d'approbation</td>
                <td>{{ $procedure->approved_at->format('d/m/Y H:i') }}</td>
            </tr>
        @endif
    </table>

    @if($procedure->description)
        <div>
            <h3>Description</h3>
            <p>{{ $procedure->description }}</p>
        </div>
    @endif

    <div class="content">
        <h3>Contenu de la Procédure</h3>
        {!! nl2br(e($procedure->content)) !!}
    </div>

    @if($procedure->checklists->count() > 0)
        <div class="checklist">
            <h3>Checklist de Conformité</h3>
            @foreach($procedure->checklists as $item)
                <div class="checklist-item">
                    <strong>{{ $item->item }}</strong>
                    @if($item->description)
                        <br><small>{{ $item->description }}</small>
                    @endif
                    @if($item->is_required)
                        <span style="color: red;">[Requis]</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <div class="footer">
        <p>Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
        <p>SOP Restaurant - Système de Gestion des Procédures Opérationnelles Standard</p>
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #696cff; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Imprimer / Enregistrer en PDF
        </button>
    </div>
</body>
</html>

