# Guide : Comment ajouter un projet avec sections

Ce guide explique **comment remplir les champs d'un projet** dans WordPress pour reproduire la structure des projets Adobe Portfolio (The Suit, Stripology, Negus, etc.).

---

## Étape 1 — Créer le projet

1. Dans WordPress, allez dans **Projets > Ajouter**
2. Saisissez le **titre** (ex. `THE SUIT`, `NEGUS`, `STRIPOLOGY`)
3. Ajoutez une **image mise en avant** (ce sera l'image héro en haut de page)
4. Assignez une **catégorie de projet** (Reportage, Photo, Vidéo…)

---

## Étape 2 — Remplir les champs de base

En dessous de l'éditeur WordPress, vous trouverez une meta box **«Détails du projet»** avec ces champs :

### **Année** (ex. `2025`, `2026`)
L'année de création. Affichée sous le titre si aucun sous-titre n'est saisi.

### **Sous-titre** (ex. `ORANGE IS THE NEW BLACK - 2025`)
Texte affiché juste sous le titre du projet. Si rempli, remplace l'affichage de l'année seule.

### **Texte éditorial**
La description/introduction longue du projet, affichée après l'image hero. Correspond au texte "EDITORIAL" sur Adobe Portfolio.

Exemple (The Suit) :
```
THIS PROJECT MARKS THE FINAL OUTCOME OF MY SECOND YEAR AT ESMOD.
THROUGH THIS TAILORED SILHOUETTE, I EXPLORE THE THEME OF REINTEGRATION AFTER INCARCERATION...
```

### **Collection en production**
Cochez cette case pour afficher la mention :
> "This collection is currently in production. New developments will be revealed soon."

---

## Étape 3 — Ajouter les sections (JSON)

Les sections (Moodboard, Squetches, Tech Pack, Shooting, etc.) sont stockées dans un champ JSON.

### **Structure JSON d'une section**

Chaque section a cette structure :

```json
{
  "titre": "Moodboard",
  "type": "galerie",
  "images": [
    { "url": "https://...", "alt": "Moodboard image 1" },
    { "url": "https://...", "alt": "Moodboard image 2" }
  ],
  "texte": ""
}
```

#### Champs :
| Champ | Description |
|---|---|
| `titre` | Nom de la section (ex. "Moodboard", "Shooting", "Tech Pack", "Squetches", "Toiles"...) |
| `type` | Type de section. Valeurs possibles : `"galerie"`, `"texte"`, `"galerie-texte"`, `"pdf"` |
| `images` | Tableau d'images avec `url` et `alt` (texte alternatif). Laissez vide `[]` si pas d'images. |
| `texte` | Texte à afficher dans la section. Laissez vide `""` si pas de texte. |

### **Exemple complet : THE SUIT**

```json
[
  {
    "titre": "Moodboard",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/moodboard1.jpg", "alt": "Moodboard 1" },
      { "url": "https://exemple.com/moodboard2.jpg", "alt": "Moodboard 2" }
    ],
    "texte": ""
  },
  {
    "titre": "Squetches",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/squetch1.jpg", "alt": "Squetch 1" },
      { "url": "https://exemple.com/squetch2.jpg", "alt": "Squetch 2" }
    ],
    "texte": ""
  },
  {
    "titre": "Tech Pack",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/techpack.jpg", "alt": "Tech Pack" }
    ],
    "texte": ""
  },
  {
    "titre": "Shooting",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/shoot1.jpg", "alt": "Shooting 1" },
      { "url": "https://exemple.com/shoot2.jpg", "alt": "Shooting 2" },
      { "url": "https://exemple.com/shoot3.jpg", "alt": "Shooting 3" }
    ],
    "texte": ""
  }
]
```

### **Exemple complet : NEGUS**

```json
[
  {
    "titre": "Moodboard",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/negus-mood.jpg", "alt": "Moodboard Negus" }
    ],
    "texte": ""
  },
  {
    "titre": "Sketches",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/sketch1.jpg", "alt": "Sketch 1" }
    ],
    "texte": ""
  },
  {
    "titre": "Figures of Influence",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/figures.jpg", "alt": "Figures" }
    ],
    "texte": ""
  },
  {
    "titre": "One Size System",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/onesize.jpg", "alt": "One Size" }
    ],
    "texte": ""
  },
  {
    "titre": "Toiles",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/toile1.jpg", "alt": "Toile 1" },
      { "url": "https://exemple.com/toile2.jpg", "alt": "Toile 2" }
    ],
    "texte": ""
  },
  {
    "titre": "Tech Pack",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/techpack.jpg", "alt": "Tech Pack" }
    ],
    "texte": ""
  },
  {
    "titre": "In Fabric",
    "type": "galerie",
    "images": [
      { "url": "https://exemple.com/fabric1.jpg", "alt": "In Fabric 1" },
      { "url": "https://exemple.com/fabric2.jpg", "alt": "In Fabric 2" }
    ],
    "texte": ""
  }
]
```

---

## Étape 4 — Publier

Une fois tous les champs remplis :
1. Cliquez **Publier**
2. Allez voir la page du projet sur le site

Toutes les sections s'afficheront dans l'ordre du JSON, avec leur titre et leur galerie d'images.

---

## Exemples de structures de projets

### **THE BUSTIER** (3 sections)
```json
[
  { "titre": "Moodboard", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Creative Direction", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Shooting", "type": "galerie", "images": [...], "texte": "" }
]
```

### **THE SUIT** (5 sections)
```json
[
  { "titre": "Moodboard", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Editorial", "type": "texte", "images": [], "texte": "Long texte..." },
  { "titre": "Squetches", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Tech Pack", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Shooting", "type": "galerie", "images": [...], "texte": "" }
]
```

### **NEGUS** (7 sections + en production)
```json
[
  { "titre": "Moodboard", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Sketches", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Figures of Influence", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "One Size System", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Toiles", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "Tech Pack", "type": "galerie", "images": [...], "texte": "" },
  { "titre": "In Fabric", "type": "galerie", "images": [...], "texte": "" }
]
```

+ Cocher la case **Collection en production**

---

## Conseils

- **Téléversez vos images** dans **Médias > Ajouter** dans WordPress pour obtenir leurs URLs.
- **Validez votre JSON** sur [jsonlint.com](https://jsonlint.com) avant de coller dans le champ.
- Si vous voyez une erreur **"JSON des sections invalide"**, c'est qu'il y a une erreur de syntaxe (virgule manquante, guillemet oublié, etc.).
- Vous pouvez créer autant de sections que vous voulez, dans l'ordre de votre choix.

---

*Guide créé pour le thème jtt-portfolio*
