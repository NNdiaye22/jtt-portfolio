# JTT Portfolio — Thème WordPress

Thème WordPress portfolio créatif pour **Julien Terence Tegnan**, Styliste de Mode.

---

## Structure des fichiers

```
jtt-portfolio/
├── style.css                  # Déclaration du thème WordPress
├── functions.php              # Enregistrement des scripts, CPT, Customizer
├── index.php                  # Fallback WordPress (obligatoire)
├── header.php                 # En-tête HTML + navigation
├── footer.php                 # Pied de page
├── front-page.php             # Page d'accueil (Hero + Projets + About + Contact)
├── page-projets.php           # Template : Page Projets
├── single-projet.php          # Template : Page projet individuel
├── assets/
│   ├── css/
│   │   └── global.css         # Variables CSS, reset, nav, footer, animations
│   └── js/
│       └── main.js            # Navigation mobile, scroll reveal, header sticky
└── template-parts/
    ├── nav.php                # Navigation (desktop + hamburger mobile)
    ├── hero.php               # Section hero (titre, CTA, flèche)
    ├── projets.php            # Grille de projets avec filtres
    ├── about.php              # Section à propos (photo, texte, compétences, CV)
    ├── contact.php            # Formulaire de contact + réseaux sociaux
    └── footer.php             # Contenu du footer
```

---

## Installation sur WordPress

### Étape 1 — Télécharger le thème

1. Sur GitHub, cliquez sur **Code** > **Download ZIP**
2. Renommez le dossier téléchargé en `jtt-portfolio` (sans le `-main`)
3. Dans WordPress : **Apparence > Thèmes > Ajouter > Téléverser un thème**
4. Sélectionnez le ZIP et cliquez **Installer maintenant**
5. **Activer** le thème

### Étape 1b - Importer le contenu exemple (optionnel)

Pour gagner du temps, vous pouvez importer le fichier `sample-content.xml` qui contient :
- Les pages de base (Accueil, Travaux, Contact)
- 3 projets exemples (The Suit, Negus, Stripology) avec leurs métadonnées et sections
- Les catégories de projets (Reportage, Photo, Vidéo)

**Comment importer :**

1. Aller dans **Outils** > **Importer**
2. Choisir **WordPress** (si pas installé, cliquer sur "Installer maintenant")
3. Cliquer sur **Lancer l'importateur**
4. Sélectionner le fichier `sample-content.xml` depuis le dossier du thème
5. **Important** : Cocher "Télécharger et importer les fichiers joints" si vous voulez les images
6. Cliquer sur **Soumettre**

**Note** : Les URLs des images dans le fichier exemple utilisent des placeholders (`placeholder.com`). Vous devrez les remplacer par vos vraies images dans l'éditeur WordPress.

### Étape 2 — Créer les pages

Dans **Pages > Ajouter** :

| Titre de la page | Template à choisir |
|---|---|
| Accueil | (aucun, làisse par défaut) |
| Projets | **Page Projets** |
| À propos | (aucun) |
| Contact | (aucun) |

Ensuite dans **Réglages > Lecture** : définir **«Accueil»** comme page d’accueil statique.

### Étape 3 — Ajouter des projets

Un type de contenu **Projet** est créé automatiquement.

1. Allez dans **Projets > Ajouter**
2. Remplissez le titre, le contenu, l'extrait et l'image mise en avant
3. Assignez une **Catégorie de projet** (reportage, photo, vidéo…)
4. Publiez

### Étape 4 — Personnaliser le site

Allez dans **Apparence > Personnaliser** pour modifier :

- **Hero** : titre, sous-titre, texte du bouton CTA
- **À propos** : photo, texte biographique, compétences (séparées par des virgules), lien CV
- **Contact** : email, lien vers un formulaire Contact Form 7 (optionnel)
- **Réseaux sociaux** : Instagram, LinkedIn, X (Twitter)

### Étape 5 — Menu de navigation

1. **Apparence > Menus**
2. Créez un menu, ajoutez vos pages
3. Assignez-le à l’emplacement **Menu principal**

---

## Plugin recommandé (optionnel)

- **Contact Form 7** : pour le formulaire de contact avancé. Installez-le, créez un formulaire, notez son ID, puis entrez cet ID dans **Personnaliser > Contact**.

---

## Développement

Le thème utilise des **variables CSS** définies dans `assets/css/global.css` :

```css
--primary     /* couleur principale */
--text        /* couleur du texte */
--bg          /* couleur de fond */
--grey        /* gris neutre */
--radius      /* arrondi des cartes */
```

Pour changer les couleurs, modifiez uniquement ces variables.

---

*Thème conçu et développé pour NNdiaye22/jtt-portfolio*
