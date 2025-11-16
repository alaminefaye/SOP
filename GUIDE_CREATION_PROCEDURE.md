# 📝 GUIDE : COMMENT CRÉER UNE PROCÉDURE

## 🎯 PROCESSUS SIMPLE

### Étape 1 : Aller sur la page de création

1. Connectez-vous : `admin@admin.com` / `passer123`
2. Cliquez sur **"Procédures"** dans le menu
3. Cliquez sur le bouton **"Créer une Nouvelle Procédure"**

**URL :** `http://sop.test/procedures/create`

---

## 📋 ÉTAPE 2 : REMPLIR LE FORMULAIRE

### Exemple : "Recette de Salade César"

#### 1. **Titre** (Obligatoire)
```
Recette de Salade César
```

#### 2. **Catégorie** (Obligatoire)
```
🍳 Cuisine  ← Vous choisissez "Cuisine"
```

#### 3. **Description** (Optionnel)
```
Comment préparer une salade César parfaite selon nos standards
```

#### 4. **Contenu** (Obligatoire) - Les instructions
```
ÉTAPE 1 : Préparation de la romaine
- Laver la romaine sous l'eau froide
- Sécher avec un torchon propre
- Couper en morceaux de 3 cm

ÉTAPE 2 : Préparation de la vinaigrette
- Mélanger 2 cuillères d'huile d'olive
- Ajouter 1 cuillère de vinaigre balsamique
- Ajouter 1 cuillère de moutarde
- Saler et poivrer

ÉTAPE 3 : Préparation des croûtons
- Couper le pain en cubes de 1 cm
- Faire revenir dans l'huile d'olive
- Ajouter de l'ail haché
- Faire dorer

ÉTAPE 4 : Assemblage
- Mettre la romaine dans un saladier
- Ajouter la vinaigrette
- Mélanger délicatement
- Ajouter les croûtons
- Râper le parmesan par-dessus
```

#### 5. **Priorité** (Optionnel)
```
Normal (0)  ou  Important (1)  ou  Urgent (2)
```

#### 6. **Fichiers joints** (Optionnel) - Photos, Vidéos, Documents
```
📷 photo-romaine.jpg
📷 photo-vinaigrette.jpg
🎥 video-assemblage.mp4
📄 fiche-technique.pdf
```

#### 7. **Checklist de Conformité** (Optionnel)
```
✅ Laver la romaine (Requis)
✅ Préparer la vinaigrette (Requis)
✅ Préparer les croûtons (Requis)
✅ Assembler la salade (Requis)
✅ Râper le parmesan (Requis)
```

#### 8. **Soumettre pour approbation** (Optionnel)
```
☑️ Cocher cette case si vous voulez que les managers l'approuvent
```

---

## ✅ ÉTAPE 3 : CRÉER LA PROCÉDURE

1. Cliquez sur le bouton **"Créer la Procédure"**
2. La procédure est créée
3. Vous êtes redirigé vers la page de la procédure

---

## 📊 RÉSULTAT

### Ce qui se passe :

1. ✅ **La procédure est créée** avec :
   - Titre : "Recette de Salade César"
   - Catégorie : "Cuisine"
   - Statut : "pending" (si vous avez coché "Soumettre pour approbation")
   - Statut : "draft" (si vous n'avez pas coché)

2. ✅ **Les fichiers sont uploadés** dans :
   - `storage/app/public/procedures/`

3. ✅ **La checklist est créée** avec tous les items

4. ✅ **Les notifications sont envoyées** :
   - Si "pending" → Les managers reçoivent une notification
   - Si "draft" → Pas de notification

---

## 🎬 EXEMPLE COMPLET VISUEL

```
┌─────────────────────────────────────────────────┐
│  CRÉER UNE NOUVELLE PROCÉDURE                    │
├─────────────────────────────────────────────────┤
│                                                  │
│  Titre *                                        │
│  ┌─────────────────────────────────────────┐    │
│  │ Recette de Salade César                │    │
│  └─────────────────────────────────────────┘    │
│                                                  │
│  Catégorie *                                     │
│  ┌─────────────────────────────────────────┐    │
│  │ 🍳 Cuisine                          ▼    │    │
│  └─────────────────────────────────────────┘    │
│                                                  │
│  Description                                     │
│  ┌─────────────────────────────────────────┐    │
│  │ Comment préparer une salade César...    │    │
│  └─────────────────────────────────────────┘    │
│                                                  │
│  Contenu *                                       │
│  ┌─────────────────────────────────────────┐    │
│  │ ÉTAPE 1 : Préparation de la romaine     │    │
│  │ - Laver la romaine...                    │    │
│  │                                          │    │
│  │ ÉTAPE 2 : Préparation de la vinaigrette │    │
│  │ ...                                      │    │
│  └─────────────────────────────────────────┘    │
│                                                  │
│  Fichiers joints                                 │
│  ┌─────────────────────────────────────────┐    │
│  │ [Choisir des fichiers]                   │    │
│  │ photo-romaine.jpg                         │    │
│  └─────────────────────────────────────────┘    │
│                                                  │
│  Checklist                                       │
│  ┌─────────────────────────────────────────┐    │
│  │ ✅ Laver la romaine (Requis)             │    │
│  │ ✅ Préparer la vinaigrette (Requis)      │    │
│  │ + Ajouter un item                        │    │
│  └─────────────────────────────────────────┘    │
│                                                  │
│  ☑️ Soumettre pour approbation                   │
│                                                  │
│  [Créer la Procédure]  [Annuler]                │
└─────────────────────────────────────────────────┘
```

---

## 💡 CONSEILS

### Pour une bonne procédure :

1. **Titre clair** : "Recette de Salade César" plutôt que "Salade"
2. **Contenu détaillé** : Expliquez chaque étape
3. **Photos utiles** : Ajoutez des photos pour chaque étape importante
4. **Checklist complète** : Listez toutes les étapes importantes
5. **Description** : Donnez un contexte (pourquoi cette procédure est importante)

---

## ✅ RÉSUMÉ

**OUI, c'est exactement ça !**

1. Vous allez sur **Procédures** → **Créer**
2. Vous choisissez **Catégorie : Cuisine**
3. Vous mettez **Titre : "Recette de Salade César"**
4. Vous remplissez le **Contenu** (les instructions)
5. Vous ajoutez des **Photos** (optionnel)
6. Vous créez une **Checklist** (optionnel)
7. Vous cliquez sur **"Créer"**

**C'est aussi simple que ça !** 🎉

