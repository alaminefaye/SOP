# 🎬 COMMENT ÇA MARCHE ? - GUIDE VISUEL

## 📖 ANALOGIE SIMPLE

**Imaginez un livre de recettes interactif pour le restaurant :**

```
📚 LIVRE DE RECETTES (Application SOP)
├── 📄 Recette 1 : "Préparation salade César" (Procédure)
├── 📄 Recette 2 : "Accueil client" (Procédure)
└── 📄 Recette 3 : "Nettoyage cuisine" (Procédure)

Chaque recette contient :
- 📝 Les instructions (Contenu)
- ✅ La checklist (Étapes à cocher)
- 📷 Les photos (Fichiers joints)
- 👤 Qui l'a créée (Auteur)
- ✅ Qui l'a approuvée (Approbateur)
```

---

## 🔄 LE CYCLE DE VIE D'UNE PROCÉDURE

```
┌─────────────────────────────────────────────────────────────┐
│                    ÉTAPE 1 : CRÉATION                        │
│                                                              │
│  👤 Manager crée une procédure                              │
│  📝 Remplit le formulaire                                   │
│  📎 Upload des fichiers                                     │
│  ✅ Ajoute une checklist                                    │
│  📤 Soumet pour approbation                                 │
│                                                              │
│  → Statut : "pending" (en attente)                         │
│  → Notification envoyée aux managers                        │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                  ÉTAPE 2 : APPROBATION                        │
│                                                              │
│  👑 Super Admin reçoit une notification                     │
│  📖 Lit la procédure                                        │
│  ✅ Clique sur "Approuver"                                  │
│                                                              │
│  → Statut : "approved" (approuvé)                          │
│  → Notification envoyée à TOUS les utilisateurs            │
│  → La procédure est maintenant visible par tous             │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                  ÉTAPE 3 : UTILISATION                        │
│                                                              │
│  👤 Employé cherche une procédure                           │
│  📖 Lit les instructions                                     │
│  📷 Consulte les photos/vidéos                              │
│  ✅ Suit la checklist                                        │
│  📝 Applique les instructions                               │
└─────────────────────────────────────────────────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                ÉTAPE 4 : VÉRIFICATION                       │
│                                                              │
│  👤 Employé enregistre la conformité                        │
│  ✅ Statut : "Conforme" ou "Non conforme"                  │
│  📝 Ajoute des notes                                        │
│                                                              │
│  → Si "Non conforme" → Alerte aux managers                 │
│  → Historique enregistré dans la base de données           │
└─────────────────────────────────────────────────────────────┘
```

---

## 🎯 EXEMPLE RÉEL : "PRÉPARATION SALADE CÉSAR"

### 1️⃣ CRÉATION (Manager)

**Page :** `/procedures/create`

**Formulaire rempli :**
```
Titre : "Préparation de la salade César"
Catégorie : "Cuisine"
Description : "Comment préparer une salade César parfaite"
Contenu :
  1. Laver et sécher la romaine
  2. Préparer la vinaigrette César
  3. Couper les croûtons
  4. Râper le parmesan
  5. Assembler la salade

Checklist :
  ✓ Laver la romaine (requis)
  ✓ Préparer la vinaigrette (requis)
  ✓ Couper les croûtons (requis)
  ✓ Râper le parmesan (requis)
  ✓ Assembler (requis)

Fichiers :
  - photo-romaine.jpg
  - video-preparation.mp4
```

**Action :** Coche "Soumettre pour approbation" → Clique "Créer"

**Résultat :**
- ✅ Procédure créée avec ID = 1
- 📊 Statut = "pending"
- 🔔 Notification envoyée aux managers

---

### 2️⃣ APPROBATION (Super Admin)

**Page :** `/procedures/1`

**Super Admin voit :**
- Le titre, la description, le contenu
- Les fichiers joints
- La checklist
- Bouton "Approuver"

**Action :** Clique sur "Approuver"

**Résultat :**
- ✅ Statut = "approved"
- 👤 approved_by = Super Admin
- 📅 approved_at = Date actuelle
- 🔔 Notification envoyée à TOUS les utilisateurs

---

### 3️⃣ UTILISATION (Employé)

**Page :** `/procedures`

**Employé :**
1. Cherche "salade" dans la barre de recherche
2. Trouve "Préparation de la salade César"
3. Clique dessus

**Page :** `/procedures/1`

**Employé voit :**
- Les instructions complètes
- Les photos et vidéos
- La checklist à suivre

**Employé :**
1. Lit les instructions
2. Regarde la vidéo
3. Suit la checklist étape par étape
4. Prépare la salade

---

### 4️⃣ VÉRIFICATION (Employé)

**Page :** `/compliance`

**Employé :**
1. Sélectionne "Préparation de la salade César"
2. Remplit le formulaire :
   ```
   Date : 16/11/2025
   Statut : Conforme
   Notes : "Salade préparée selon les instructions"
   ```
3. Clique "Enregistrer"

**Résultat :**
- ✅ Enregistrement créé dans `compliance_records`
- 📊 Statistiques mises à jour
- ✅ Pas d'alerte (car conforme)

---

## 🔔 LES NOTIFICATIONS

### Notification 1 : Nouvelle procédure à approuver

**Quand :** Une procédure est soumise pour approbation

**Qui reçoit :** Super Admin et Managers

**Message :** "Nouvelle procédure à approuver : Préparation de la salade César"

**Action :** Cliquer sur la notification → Va sur `/procedures/1`

---

### Notification 2 : Procédure approuvée

**Quand :** Une procédure est approuvée

**Qui reçoit :** TOUS les utilisateurs

**Message :** "Nouvelle procédure approuvée : Préparation de la salade César"

**Action :** Cliquer sur la notification → Va sur `/procedures/1`

---

### Notification 3 : Alerte de non-conformité

**Quand :** Un employé enregistre une non-conformité

**Qui reçoit :** Super Admin et Managers

**Message :** "Alerte de non-conformité : Préparation de la salade César"

**Action :** Cliquer sur la notification → Va sur `/compliance`

---

## 📊 LES STATISTIQUES (Dashboard)

**Page :** `/dashboard`

**Affiche :**
- 📈 Nombre total de procédures : 15
- ✅ Procédures approuvées : 12
- ⏳ En attente : 3
- 📁 Catégories : 8
- ✅ Taux de conformité : 95%

**Actions rapides :**
- ➕ Créer une procédure
- 📋 Voir toutes les procédures
- 📊 Voir les rapports

---

## 🔍 LA RECHERCHE

**Page :** `/procedures`

**Filtres disponibles :**
- 🔤 Recherche par mot-clé : "salade"
- 📁 Catégorie : "Cuisine"
- 📊 Statut : "Approuvé"
- 👤 Auteur : "Manager"
- 📅 Date : Du 01/11/2025 au 16/11/2025

**Résultat :** Liste filtrée des procédures correspondantes

---

## 📄 LES RAPPORTS

### Rapport des Procédures (`/reports/procedures`)

**Affiche :**
- Nombre de procédures par catégorie
- Procédures les plus consultées
- Procédures par statut

**Exemple :**
```
Cuisine : 5 procédures
Service : 4 procédures
Hygiène : 3 procédures
...
```

---

### Rapport de Conformité (`/reports/compliance`)

**Affiche :**
- Taux de conformité global : 95%
- Conformité par procédure
- Conformité par utilisateur

**Exemple :**
```
Préparation salade César : 98% conforme
Accueil client : 92% conforme
...
```

---

## 🎯 RÉSUMÉ EN 4 ÉTAPES

1. **📝 CRÉER** → Le manager écrit la procédure
2. **✅ APPROUVER** → Le super admin valide
3. **📖 UTILISER** → Les employés lisent et appliquent
4. **🔍 VÉRIFIER** → On s'assure que c'est bien fait

**C'est comme un manuel de formation interactif !** 📚

---

## 💡 POUR COMPRENDRE MIEUX

**Testez vous-même :**

1. Connectez-vous : `admin@admin.com` / `passer123`
2. Créez une procédure test
3. Approuvez-la
4. Enregistrez une conformité
5. Consultez les rapports

**Tout est fonctionnel et prêt à l'emploi !** ✅

