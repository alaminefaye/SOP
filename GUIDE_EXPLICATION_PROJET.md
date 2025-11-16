# 📚 GUIDE D'EXPLICATION - APPLICATION SOP RESTAURANT

## 🎯 QU'EST-CE QUE C'EST ?

**SOP = Standard Operating Procedures (Procédures Opérationnelles Standard)**

C'est une application web pour gérer les **procédures de travail** d'un restaurant. Elle permet de :
- ✅ Documenter les procédures (comment faire chaque tâche)
- ✅ Former le personnel
- ✅ Vérifier que les procédures sont bien suivies
- ✅ Suivre la conformité (est-ce que tout est fait correctement ?)

---

## 🏗️ ARCHITECTURE SIMPLE

```
┌─────────────────────────────────────────┐
│         UTILISATEUR (Navigateur)        │
└─────────────────┬───────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────┐
│         LARAVEL (Backend)                │
│  - Routes (web.php)                      │
│  - Contrôleurs (logique métier)          │
│  - Modèles (base de données)             │
└─────────────────┬───────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────┐
│         BASE DE DONNÉES (SQLite)         │
│  - Utilisateurs                          │
│  - Procédures                           │
│  - Catégories                            │
│  - Checklists                            │
│  - Conformité                            │
└─────────────────────────────────────────┘
```

---

## 👥 LES RÔLES DANS L'APPLICATION

### 1. **Super Admin** 👑
- Peut TOUT faire
- Gère les utilisateurs
- Approuve les procédures
- Accès complet

### 2. **Manager** 📋
- Crée et modifie les procédures
- Approuve les procédures
- Consulte les rapports

### 3. **Chef de Cuisine** 👨‍🍳
- Gère les procédures de cuisine
- Valide les procédures cuisine

### 4. **Chef de Service** 🍽️
- Gère les procédures de service
- Valide les procédures service

### 5. **Formateur** 📚
- Crée et modifie les procédures
- Forme le personnel

### 6. **Employé** 👤
- Consulte les procédures
- Enregistre la conformité (checklist)

---

## 🔄 COMMENT ÇA FONCTIONNE ? (Flux de travail)

### 📝 CRÉER UNE PROCÉDURE

```
1. Utilisateur connecté → Va sur "/procedures/create"
2. Remplit le formulaire :
   - Titre : "Préparation de la salade César"
   - Catégorie : "Cuisine"
   - Description : "Comment préparer la salade César"
   - Contenu : "Étape 1, Étape 2, etc."
   - Upload de fichiers (photos, vidéos)
   - Checklist : "Laver la romaine", "Préparer la vinaigrette", etc.
3. Coche "Soumettre pour approbation"
4. Clique sur "Créer"
5. → La procédure est créée avec le statut "pending" (en attente)
6. → Les managers reçoivent une notification
```

### ✅ APPROUVER UNE PROCÉDURE

```
1. Manager connecté → Voit notification "Nouvelle procédure à approuver"
2. Va sur la page de la procédure
3. Lit le contenu
4. Clique sur "Approuver"
5. → La procédure passe au statut "approved"
6. → Tous les utilisateurs reçoivent une notification
7. → La procédure est maintenant visible par tous
```

### 📋 UTILISER UNE PROCÉDURE (Employé)

```
1. Employé connecté → Va sur "/procedures"
2. Cherche une procédure (ex: "salade César")
3. Clique sur la procédure
4. Lit les instructions
5. Consulte les fichiers joints (photos, vidéos)
6. Suit la checklist
```

### ✅ ENREGISTRER LA CONFORMITÉ

```
1. Employé → Va sur "/compliance"
2. Sélectionne une procédure
3. Remplit le formulaire :
   - Date de vérification
   - Statut : "Conforme" ou "Non conforme"
   - Notes
4. Clique sur "Enregistrer"
5. → Si "Non conforme" → Les managers reçoivent une alerte
```

---

## 📂 STRUCTURE DES FICHIERS

```
SOP/
├── app/
│   ├── Http/Controllers/     ← Logique métier
│   │   ├── ProcedureController.php    (Gère les procédures)
│   │   ├── CategoryController.php     (Gère les catégories)
│   │   ├── ComplianceController.php   (Gère la conformité)
│   │   ├── ReportController.php       (Gère les rapports)
│   │   └── NotificationController.php (Gère les notifications)
│   │
│   ├── Models/               ← Modèles (tables de la base)
│   │   ├── Procedure.php
│   │   ├── Category.php
│   │   ├── User.php
│   │   └── ...
│   │
│   └── Notifications/        ← Notifications
│       ├── ProcedureApprovalNotification.php
│       └── ...
│
├── database/
│   ├── migrations/           ← Structure de la base de données
│   └── seeders/              ← Données initiales
│       ├── CategorySeeder.php (8 catégories)
│       └── DatabaseSeeder.php (Admin user)
│
├── resources/
│   └── views/                ← Pages HTML (Blade)
│       ├── layouts/
│       │   └── app.blade.php (Template principal)
│       ├── procedures/       (Pages des procédures)
│       ├── compliance/       (Pages de conformité)
│       └── ...
│
└── routes/
    └── web.php               ← Routes (URLs)
```

---

## 🔍 EXPLICATION DES COMPOSANTS PRINCIPAUX

### 1. **ROUTES (web.php)**
Définit les URLs de l'application :
```php
Route::get('/procedures', ...)           → Liste des procédures
Route::get('/procedures/create', ...)    → Formulaire de création
Route::post('/procedures', ...)          → Sauvegarde d'une procédure
Route::get('/procedures/{id}', ...)      → Voir une procédure
```

### 2. **CONTRÔLEURS**
Contiennent la logique métier :
```php
ProcedureController@index()    → Récupère les procédures et les affiche
ProcedureController@create()   → Affiche le formulaire de création
ProcedureController@store()    → Sauvegarde une nouvelle procédure
ProcedureController@show()     → Affiche une procédure
```

### 3. **MODÈLES**
Représentent les tables de la base de données :
```php
Procedure::all()               → Récupère toutes les procédures
$procedure->category            → Récupère la catégorie
$procedure->checklists          → Récupère les items de checklist
```

### 4. **VUES (Blade)**
Les pages HTML affichées à l'utilisateur :
```blade
@extends('layouts.app')         → Utilise le template principal
@section('content')            → Contenu de la page
@foreach($procedures as $p)    → Boucle sur les procédures
```

---

## 🗄️ BASE DE DONNÉES (Tables principales)

### **users** (Utilisateurs)
- id, name, email, password, role

### **categories** (Catégories)
- id, name, slug, description, icon, color
- Exemples : "Cuisine", "Service", "Hygiène", etc.

### **procedures** (Procédures)
- id, title, content, status, category_id, created_by, approved_by
- Statuts : draft, pending, approved, archived

### **procedure_checklists** (Checklists)
- id, procedure_id, item, description, is_required
- Exemple : "Laver la romaine" (requis), "Ajouter des croûtons" (optionnel)

### **compliance_records** (Enregistrements de conformité)
- id, procedure_id, user_id, status, notes, checked_at
- Enregistre si une procédure a été suivie correctement

### **notifications** (Notifications)
- id, type, notifiable_id, data, read_at
- Notifications Laravel (système intégré)

---

## 🎬 EXEMPLE CONCRET : CRÉER UNE PROCÉDURE

### Étape 1 : L'utilisateur remplit le formulaire
```
URL : http://sop.test/procedures/create
Formulaire :
- Titre : "Préparation de la salade César"
- Catégorie : "Cuisine"
- Contenu : "1. Laver la romaine..."
- Upload : photo-salade.jpg
- Checklist : "Laver la romaine" ✓
```

### Étape 2 : Le contrôleur traite la requête
```php
// ProcedureController@store()
1. Valide les données
2. Crée la procédure dans la base
3. Upload les fichiers
4. Crée les items de checklist
5. Envoie des notifications aux managers
6. Redirige vers la page de la procédure
```

### Étape 3 : La base de données est mise à jour
```
Table "procedures" :
- id: 1
- title: "Préparation de la salade César"
- status: "pending"
- created_by: 1 (l'utilisateur)

Table "procedure_attachments" :
- file_name: "photo-salade.jpg"
- procedure_id: 1

Table "procedure_checklists" :
- item: "Laver la romaine"
- procedure_id: 1
```

### Étape 4 : Les notifications sont envoyées
```
Table "notifications" :
- type: "App\Notifications\ProcedureApprovalNotification"
- notifiable_id: 2 (manager)
- data: {procedure_id: 1, message: "Nouvelle procédure à approuver"}
```

---

## 🔔 SYSTÈME DE NOTIFICATIONS

### Types de notifications :

1. **ProcedureApprovalNotification**
   - Quand : Une procédure est soumise pour approbation
   - Qui reçoit : Les managers
   - Message : "Nouvelle procédure à approuver"

2. **NewProcedureNotification**
   - Quand : Une procédure est approuvée
   - Qui reçoit : Tous les utilisateurs
   - Message : "Nouvelle procédure approuvée"

3. **ComplianceAlertNotification**
   - Quand : Une non-conformité est enregistrée
   - Qui reçoit : Les managers
   - Message : "Alerte de non-conformité"

---

## 📊 RAPPORTS ET STATISTIQUES

### Rapport des Procédures
- Nombre de procédures par catégorie
- Procédures les plus consultées
- Procédures par statut

### Rapport de Conformité
- Taux de conformité global
- Conformité par procédure
- Conformité par utilisateur

### Rapport d'Activité
- Procédures créées/modifiées
- Approbations
- Vérifications de conformité

---

## 🚀 COMMENT DÉMARRER L'APPLICATION

### 1. Installation
```bash
cd SOP
composer install
php artisan migrate
php artisan db:seed
```

### 2. Démarrer le serveur
```bash
php artisan serve
```

### 3. Accéder à l'application
```
URL : http://localhost:8000
Email : admin@admin.com
Password : passer123
```

---

## 💡 RÉSUMÉ SIMPLE

**L'application permet de :**

1. **Créer des procédures** → Documenter comment faire chaque tâche
2. **Approuver les procédures** → Valider qu'elles sont correctes
3. **Consulter les procédures** → Le personnel peut les lire
4. **Vérifier la conformité** → S'assurer que les procédures sont suivies
5. **Recevoir des notifications** → Être informé des changements
6. **Générer des rapports** → Voir les statistiques

**C'est comme un manuel de formation interactif pour le restaurant !** 📚

---

## ❓ QUESTIONS FRÉQUENTES

**Q : Qui peut créer une procédure ?**
R : Super Admin, Manager, Chef de Cuisine, Chef de Service, Formateur, Employé

**Q : Qui peut approuver une procédure ?**
R : Super Admin et Manager

**Q : Où sont stockés les fichiers uploadés ?**
R : Dans `storage/app/public/procedures/`

**Q : Comment fonctionne le versioning ?**
R : Chaque modification crée une nouvelle version dans `procedure_versions`

**Q : Comment voir l'historique d'une procédure ?**
R : Cliquez sur "Versions" dans la page de la procédure

---

## 🎯 PROCHAINES ÉTAPES POUR COMPRENDRE

1. **Connectez-vous** avec admin@admin.com / passer123
2. **Créez une procédure** pour voir comment ça fonctionne
3. **Approuvez-la** pour voir les notifications
4. **Enregistrez une conformité** pour voir les alertes
5. **Consultez les rapports** pour voir les statistiques

**L'application est complète et fonctionnelle !** 🎉

