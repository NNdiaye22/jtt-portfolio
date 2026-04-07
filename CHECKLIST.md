# ✅ Checklist d'installation et de vérification

Ce document vous guide pour installer le thème WordPress et vérifier que tout fonctionne correctement.

----

## 📥 Étape 1 : Installation du thème

### 1.1 Télécharger le thème depuis GitHub

- [ ] Aller sur la page GitHub du projet : `https://github.com/NNdiaye22/jtt-portfolio`
- [ ] Cliquer sur **Code** > **Download ZIP**
- [ ] Décompresser le fichier ZIP sur votre ordinateur

### 1.2 Installer le thème dans WordPress

- [ ] Se connecter à l'administration WordPress
- [ ] Aller dans **Apparence** > **Thèmes**
- [ ] Cliquer sur **Ajouter**
- [ ] Cliquer sur **Téléverser un thème**
- [ ] Sélectionner le fichier ZIP du thème
- [ ] Cliquer sur **Installer maintenant**
- [ ] Cliquer sur **Activer**

### 1.3 Vérifier l'activation

- [ ] Le thème **JTT Portfolio** est activé
- [ ] Aucun message d'erreur n'apparaît

----

## 📋 Étape 2 : Créer les pages et contenus

### 2.1 Créer les pages de base

- [ ] **Page d'accueil** (Accueil)
  - Template : `Page d'accueil` (front-page.php)
  - Contenu : titre, sous-titre, lien vers projets

- [ ] **Page Projets** (Travaux)
  - Template : `Page des projets` (page-projets.php)
  - Affiche la galerie de tous les projets

- [ ] **Page Contact**
  - Template : `Contact` (template-parts/contact.php)
  - Formulaire de contact

### 2.2 Configurer la page d'accueil

- [ ] Aller dans **Réglages** > **Lecture**
- [ ] Choisir **Une page statique**
- [ ] Sélectionner la page **Accueil** comme page d'accueil
- [ ] Enregistrer les modifications

----

## 📦 Étape 3 : Ajouter des projets

### 3.1 Créer le Custom Post Type "Projets"

Le thème utilise un **Custom Post Type** pour les projets. Il est déjà configuré dans `functions.php`.

- [ ] Vérifier que **Projets** apparaît dans le menu admin WordPress

### 3.2 Ajouter un premier projet de test

- [ ] Aller dans **Projets** > **Ajouter**
- [ ] Remplir les champs :
  - **Titre** : ex. "The Suit"
  - **Année** : ex. "2025"
  - **Sous-titre** : ex. "ORANGE IS THE NEW BLACK - 2025"
  - **Texte éditorial** : description longue du projet
  - **Image mise en avant** : image héro (en haut de page)
  - **Catégorie de projet** : Reportage, Photo, Vidéo...

- [ ] Publier le projet

### 3.3 Ajouter les sections du projet (JSON)

Dans la **meta box "Détails du projet"**, coller le JSON suivant :

```json
[
  {
    "titre": "Moodboard",
    "type": "galerie",
    "images": ["url-image-1.jpg", "url-image-2.jpg"],
    "texte": ""
  },
  {
    "titre": "Editorial",
    "type": "texte",
    "images": [],
    "texte": "Long texte..."
  }
]
```

- [ ] Le JSON est valide (pas d'erreur de syntaxe)
- [ ] Enregistrer le projet

----

## 🔍 Étape 4 : Vérifications techniques

### 4.1 Vérifier le menu de navigation

- [ ] Aller dans **Apparence** > **Menus**
- [ ] Créer un menu "Menu principal"
- [ ] Ajouter les liens : Accueil, Travaux, Contact
- [ ] Assigner le menu à l'emplacement **Menu principal**
- [ ] Enregistrer

### 4.2 Vérifier les fichiers du thème

- [ ] `style.css` est présent et contient les styles
- [ ] `functions.php` est présent et contient les fonctions
- [ ] `header.php`, `footer.php`, `index.php` sont présents
- [ ] `single-projet.php` existe pour afficher un projet
- [ ] `page-projets.php` existe pour afficher la galerie
- [ ] `front-page.php` existe pour la page d'accueil

### 4.3 Vérifier les assets

- [ ] Le dossier `assets/` contient les fichiers JavaScript et CSS
- [ ] `assets/js/main.js` existe (pour le menu burger)
- [ ] Les images de test sont dans `assets/images/` (si nécessaire)

----

## 📱 Étape 5 : Tests responsive

### 5.1 Tester sur mobile

- [ ] Ouvrir le site sur un **smartphone** (ou mode responsive Chrome)
- [ ] Le menu burger s'affiche correctement
- [ ] Le menu burger s'ouvre/ferme au clic
- [ ] Les images sont responsive (pas de débordement)
- [ ] Les textes sont lisibles
- [ ] La galerie de projets s'affiche en 1 colonne

### 5.2 Tester sur tablette

- [ ] Ouvrir le site sur une **tablette** (ou mode responsive)
- [ ] La galerie de projets s'affiche en 2 colonnes
- [ ] Les images sont responsive
- [ ] La navigation fonctionne

### 5.3 Tester sur desktop

- [ ] Ouvrir le site sur un **ordinateur**
- [ ] La galerie de projets s'affiche en 3 colonnes
- [ ] Le menu horizontal s'affiche correctement
- [ ] Les images sont responsive
- [ ] Les transitions au survol fonctionnent (hover)

----

## 🎨 Étape 6 : Vérifications visuelles

### 6.1 Page d'accueil

- [ ] Le titre principal s'affiche
- [ ] Le sous-titre s'affiche
- [ ] Le lien "Voir mes travaux" fonctionne
- [ ] Les polices sont correctes (Libre Baskerville, Montserrat)
- [ ] Les couleurs correspondent au design (fond sombre, texte clair)

### 6.2 Page Projets

- [ ] La galerie de projets s'affiche
- [ ] Chaque projet affiche : image, titre, année, sous-titre
- [ ] Les projets sont cliquables
- [ ] Les images au survol changent d'opacité (hover)

### 6.3 Page Projet (single)

- [ ] L'image héro s'affiche en haut
- [ ] Le titre, l'année, le sous-titre s'affichent
- [ ] Le texte éditorial s'affiche
- [ ] Les sections JSON s'affichent correctement
  - Galeries d'images
  - Sections texte
- [ ] Le bouton "Retour aux projets" fonctionne

### 6.4 Page Contact

- [ ] Le formulaire de contact s'affiche
- [ ] Les champs sont fonctionnels
- [ ] Le bouton "Envoyer" fonctionne

----

## ⚡ Étape 7 : Optimisations et performances

### 7.1 Optimiser les images

- [ ] Compresser les images avec **TinyPNG** ou **ImageOptim**
- [ ] Utiliser des formats modernes (WebP si possible)
- [ ] Vérifier que les images ne sont pas trop lourdes (< 500 Ko)

### 7.2 Minifier le CSS et le JavaScript

- [ ] Minifier `style.css` (optionnel en production)
- [ ] Minifier `main.js` (optionnel en production)
- [ ] Utiliser un plugin de cache WordPress (ex. WP Rocket)

### 7.3 Tester la vitesse de chargement

- [ ] Tester le site avec **Google PageSpeed Insights**
- [ ] Vérifier que le score est > 80 sur mobile et desktop
- [ ] Corriger les recommandations si nécessaire

----

## 🔒 Étape 8 : Sécurité et mises à jour

### 8.1 Sécuriser WordPress

- [ ] Mettre à jour WordPress à la dernière version
- [ ] Mettre à jour tous les plugins
- [ ] Utiliser des mots de passe forts
- [ ] Installer un plugin de sécurité (ex. Wordfence)

### 8.2 Sauvegarder le site

- [ ] Installer un plugin de sauvegarde (ex. UpdraftPlus)
- [ ] Configurer des sauvegardes automatiques
- [ ] Tester la restauration d'une sauvegarde

----

## 🎉 Étape 9 : Mise en ligne

### 9.1 Vérifications finales

- [ ] Tous les liens fonctionnent
- [ ] Aucun message d'erreur
- [ ] Le site est responsive
- [ ] Les performances sont optimisées
- [ ] Les contenus sont complétés

### 9.2 Publier le site

- [ ] Désactiver le mode maintenance
- [ ] Vérifier que le site est accessible publiquement
- [ ] Partager le lien du site

----

## 📝 Notes

- **Documentation supplémentaire** : consultez `README.md`, `GUIDE-PROJETS.md`, `GUIDE-STYLE.md`
- **Support** : en cas de problème, ouvrir une issue sur GitHub

----

**Auteur** : Julien Terence Tegnan  
**Thème** : JTT Portfolio WordPress  
**Version** : 1.0
