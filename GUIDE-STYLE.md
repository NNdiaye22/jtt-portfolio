# Guide de Style et Responsive

Ce guide documente les choix de design, la typographie, les couleurs et les règles responsive du thème.

----

## 🎨 Palette de couleurs

### Couleurs principales

```css
--couleur-fond-principal: #0a0a0a;     /* Fond global très sombre */
--couleur-texte-principal: #e0e0e0;    /* Texte clair */
--couleur-accent: #fafafa;             /* Blanc cassé pour titres */
```

### Couleurs secondaires

```css
--couleur-gris-clair: #b0b0b0;         /* Texte secondaire */
--couleur-gris-moyen: #5a5a5a;         /* Bordures */
--couleur-hover: #ffffff;              /* Survol des liens */
```

----

## 📝 Typographie

### Polices

- **Police principale** : `'Libre Baskerville', serif`
  - Utilisée pour : titres de projets, sous-titres, texte éditorial
  - Rendu élégant, classique, adapté à un portfolio créatif

- **Police secondaire** : `'Montserrat', sans-serif`
  - Utilisée pour : navigation, métadonnées (année, sous-titres), textes courts
  - Rendu moderne et clean

### Tailles

```css
/* Titres */
h1 { font-size: 3rem; }       /* Titre principal page d'accueil */
h2 { font-size: 2rem; }       /* Titres de projets */
h3 { font-size: 1.5rem; }     /* Sous-titres de sections */

/* Texte */
body { font-size: 1rem; line-height: 1.6; }
.sous-titre { font-size: 0.9rem; }
```

### Hiérarchie visuelle

1. **Titre principal** (`<h1>`) — police serif, grande taille, couleur accent
2. **Titres de projets** (`<h2>`) — police serif, taille moyenne
3. **Sous-titres** (`<h3>`, `.sous-titre`) — police sans-serif, plus petit, gris clair
4. **Texte éditorial** — police serif, lisible, ligne espacée

----

## 📐 Mise en page

### Structure générale

- **Conteneur principal** : `max-width: 1200px; margin: 0 auto;`
- **Padding global** : `padding: 0 20px;` (sur mobile : `0 15px;`)
- **Espacement vertical** : sections espacées de `60px` à `80px`

### Grilles

#### Galerie de projets (page-projets.php)

```css
.galerie-projets {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 40px;
}
```

#### Sections d'un projet (single-projet.php)

- **Section avec images multiples** : grille flexible selon le nombre d'images
  - 1 image : pleine largeur
  - 2 images : 2 colonnes égales
  - 3 images : 3 colonnes
  - Plus de 3 : grille adaptative

```css
.section-images {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}
```

----

## 📱 Responsive

### Breakpoints

```css
/* Mobile */
@media (max-width: 768px) { ... }

/* Tablette */
@media (min-width: 769px) and (max-width: 1024px) { ... }

/* Desktop */
@media (min-width: 1025px) { ... }
```

### Règles responsive principales

#### Navigation (header.php)

- **Desktop** : menu horizontal
- **Mobile** : menu burger (hamburger)
  - Icône burger cliquable
  - Menu overlay plein écran
  - Animation d'ouverture/fermeture

#### Galerie de projets

- **Desktop** : 3 colonnes
- **Tablette** : 2 colonnes
- **Mobile** : 1 colonne

#### Images de projets

- Toutes les images sont **responsive** : `width: 100%; height: auto;`
- Ratio d'aspect maintenu
- Images lazy-loaded pour optimiser le chargement

#### Typographie responsive

```css
/* Titres plus petits sur mobile */
@media (max-width: 768px) {
    h1 { font-size: 2rem; }
    h2 { font-size: 1.5rem; }
    h3 { font-size: 1.2rem; }
}
```

#### Espacements responsive

```css
/* Réduction des marges sur mobile */
@media (max-width: 768px) {
    .conteneur { padding: 0 15px; }
    section { margin-bottom: 40px; }
}
```

----

## 🎯 Animations et interactions

### Survol (hover)

```css
/* Liens */
a:hover {
    color: var(--couleur-hover);
    transition: color 0.3s ease;
}

/* Images de projets */
.projet-item:hover img {
    opacity: 0.8;
    transition: opacity 0.3s ease;
}
```

### Transitions

- **Durée par défaut** : `0.3s`
- **Easing** : `ease` ou `ease-in-out`
- Appliqué aux : couleurs, opacités, transformations

### Scroll reveal (optionnel)

- Les sections apparaissent progressivement au scroll
- Utiliser `IntersectionObserver` en JavaScript

----

## ✅ Checklist responsive

Avant de publier, vérifier :

- [ ] Navigation fonctionne sur mobile (menu burger)
- [ ] Toutes les images sont responsive
- [ ] Textes lisibles sur petits écrans
- [ ] Espacements cohérents
- [ ] Pas de débordement horizontal
- [ ] Tester sur différents appareils (iPhone, iPad, desktop)
- [ ] Performance : images optimisées, CSS minifié

----

## 📦 Ressources

- **Polices** : Google Fonts (Libre Baskerville, Montserrat)
- **Icônes** : Font Awesome ou SVG custom
- **Optimisation images** : TinyPNG, ImageOptim

----

**Auteur** : Julien Terence Tegnan  
**Thème** : JTT Portfolio WordPress
