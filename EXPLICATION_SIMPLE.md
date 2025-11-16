# 🎯 EXPLICATION SIMPLE DU PROJET SOP RESTAURANT

## 🤔 QU'EST-CE QUE C'EST ?

Imaginez que vous avez un restaurant et que vous voulez que tous vos employés fassent les choses de la même manière.

**Exemple :** Comment préparer une salade César ? Comment accueillir un client ? Comment nettoyer la cuisine ?

Cette application permet de :
- ✅ Écrire les procédures (les instructions)
- ✅ Les partager avec tout le monde
- ✅ Vérifier que tout le monde les suit correctement

---

## 🎬 EXEMPLE CONCRET

### Scénario : Créer une procédure "Préparation de la salade César"

**1. Vous (Manager) créez la procédure :**
```
- Titre : "Préparation de la salade César"
- Catégorie : "Cuisine"
- Contenu : 
  1. Laver la romaine
  2. Préparer la vinaigrette
  3. Couper les croûtons
  4. Assembler la salade
- Checklist :
  ✓ Laver la romaine (requis)
  ✓ Préparer la vinaigrette (requis)
  ✓ Ajouter des croûtons (optionnel)
- Photo : photo-salade.jpg
```

**2. Vous soumettez pour approbation**

**3. Le Super Admin reçoit une notification :**
```
🔔 "Nouvelle procédure à approuver : Préparation de la salade César"
```

**4. Le Super Admin approuve**

**5. Tous les employés reçoivent une notification :**
```
🔔 "Nouvelle procédure approuvée : Préparation de la salade César"
```

**6. Les employés peuvent maintenant :**
- Lire la procédure
- Voir la photo
- Suivre la checklist
- Enregistrer qu'ils l'ont fait correctement

---

## 🔄 LE FLUX COMPLET

```
┌─────────────────────────────────────────────────┐
│ 1. CRÉATION                                      │
│    Manager crée une procédure                    │
│    → Statut : "Brouillon" ou "En attente"       │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│ 2. APPROBATION                                   │
│    Super Admin/Manager approuve                  │
│    → Statut : "Approuvé"                        │
│    → Notification à tous                         │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│ 3. UTILISATION                                   │
│    Employés lisent la procédure                  │
│    Suivent les instructions                     │
│    Cochent la checklist                         │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│ 4. VÉRIFICATION                                  │
│    Employé enregistre la conformité              │
│    → "Conforme" ou "Non conforme"               │
│    → Si non conforme → Alerte aux managers     │
└─────────────────────────────────────────────────┘
```

---

## 📱 LES PAGES PRINCIPALES

### 1. **Dashboard** (`/dashboard`)
- Vue d'ensemble
- Statistiques (nombre de procédures, etc.)
- Actions rapides

### 2. **Procédures** (`/procedures`)
- Liste de toutes les procédures
- Recherche et filtres
- Bouton "Créer une procédure"

### 3. **Créer une procédure** (`/procedures/create`)
- Formulaire avec :
  - Titre, catégorie, description
  - Contenu (instructions)
  - Upload de fichiers
  - Checklist

### 4. **Voir une procédure** (`/procedures/{id}`)
- Détails complets
- Fichiers joints
- Checklist
- Bouton "Approuver" (si manager)

### 5. **Conformité** (`/compliance`)
- Enregistrer une vérification
- Voir l'historique
- Statistiques de conformité

### 6. **Rapports** (`/reports`)
- Statistiques
- Graphiques
- Export

---

## 🗂️ LES 8 CATÉGORIES

1. **🍳 Cuisine** - Préparation, cuisson, conservation
2. **🍽️ Service** - Accueil, commande, service client
3. **🧹 Hygiène & Nettoyage** - Nettoyage, désinfection
4. **🔒 Sécurité** - Sécurité alimentaire, incendie
5. **📦 Stock & Inventaire** - Réception, stockage
6. **💰 Gestion Financière** - Caisse, facturation
7. **👥 Ressources Humaines** - Formation, planning
8. **🏢 Administration** - Ouverture, fermeture

---

## 🔐 LES PERMISSIONS

| Rôle | Créer | Modifier | Approuver | Consulter |
|------|-------|----------|-----------|-----------|
| Super Admin | ✅ | ✅ | ✅ | ✅ |
| Manager | ✅ | ✅ | ✅ | ✅ |
| Chef Cuisine | ✅ | ✅ | ❌ | ✅ |
| Chef Service | ✅ | ✅ | ❌ | ✅ |
| Formateur | ✅ | ✅ | ❌ | ✅ |
| Employé | ✅ | ❌ | ❌ | ✅ |

---

## 💾 OÙ SONT LES DONNÉES ?

### Base de données SQLite
Fichier : `database/database.sqlite`

### Tables principales :
- `users` → Les utilisateurs
- `categories` → Les 8 catégories
- `procedures` → Les procédures
- `procedure_checklists` → Les checklists
- `procedure_attachments` → Les fichiers joints
- `compliance_records` → Les vérifications de conformité
- `notifications` → Les notifications

### Fichiers uploadés
Dossier : `storage/app/public/procedures/`
- Photos, PDFs, vidéos

---

## 🎯 RÉSUMÉ EN 3 POINTS

1. **Créer** → Documenter les procédures de travail
2. **Approuver** → Valider qu'elles sont correctes
3. **Vérifier** → S'assurer qu'elles sont suivies

**C'est un système de documentation et de formation pour le restaurant !** 📚

---

## 🚀 POUR TESTER

1. Connectez-vous : `admin@admin.com` / `passer123`
2. Créez une procédure test
3. Approuvez-la
4. Enregistrez une conformité
5. Consultez les rapports

**Tout est fonctionnel !** ✅

