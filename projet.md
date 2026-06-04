# CQPM Nador — Documentation Projet

> **Dernière mise à jour :** Juin 2026
> **Stack :** Laravel 12 · PHP 8.3 · MySQL · Tailwind CSS v4 · Vite 7
> **Environnement :** Local WAMP64 — `http://127.0.0.1:8000`

---

## 1. Présentation du projet

Site web institutionnel du **Centre de Qualification Professionnelle Maritime de Nador (CQPM)**, inspiré du portail [ITPM Larache](https://itpm-larache.ma/). L'application comprend :

- Un **site public** présentant l'institut, ses formations, les actualités et permettant le téléchargement de documents PDF officiels.
- Un **formulaire de candidature** complet (inscription au concours d'entrée).
- Un **panel d'administration** sécurisé pour gérer les candidatures, les documents PDF, les articles/actualités et le contenu dynamique de la homepage.

---

## 2. Accès & Credentials

| Élément | Valeur |
|---|---|
| URL locale (artisan serve) | `http://127.0.0.1:8000` |
| URL WAMP (Apache) | `http://localhost/cqpm-nador/public` |
| Admin login | `/admin/login` |
| Admin email | `admin@cqpm-nador.ma` |
| Admin password | `CqpmAdmin@2024` |
| DB MySQL | `cqpmnador` (root, no password) |

---

## 3. Architecture des fichiers

```
cqpm-nador/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── ApplicationController.php      # Formulaire public (create/store/success)
│   │   │   ├── DocumentController.php         # Upload PDF + suppression
│   │   │   ├── NewsController.php             # Vue publique d'un article (show)
│   │   │   └── Admin/
│   │   │       ├── AdminController.php        # Dashboard, candidatures, docs, settings
│   │   │       ├── AdminAuthController.php    # Login / logout admin
│   │   │       └── ArticleController.php      # CRUD complet articles (index/create/store/edit/update/destroy)
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php            # Vérifie session('admin_authenticated')
│   │   └── Requests/
│   │       └── StoreApplicationRequest.php   # Validation FR des 14 champs
│   │
│   ├── Models/
│   │   ├── Application.php    # Modèle candidature (+ accessor full_name, status_color)
│   │   ├── Article.php        # Modèle article/actualité (+ accessors file_url, isImage(), isPdf())
│   │   ├── Document.php       # Modèle document PDF (+ accessor public_url)
│   │   └── SiteSetting.php    # CMS léger key/value (méthodes get/set/all_settings)
│   │
│   └── Providers/
│       └── AppServiceProvider.php   # Builder::defaultStringLength(191) pour MySQL
│
├── database/migrations/
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000001_create_cache_table.php
│   ├── 0001_01_01_000002_create_jobs_table.php
│   ├── 2024_01_01_100000_create_applications_table.php
│   ├── 2024_01_01_100001_create_documents_table.php
│   ├── 2024_01_02_100000_add_status_to_applications_table.php
│   ├── 2024_01_02_100001_create_site_settings_table.php
│   └── 2026_06_04_100000_create_articles_table.php
│
├── resources/
│   ├── css/app.css             # Tailwind v4 + @theme avec palette maritime
│   ├── js/app.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php       # Layout public (top bar + header logos + nav + footer)
│       │   └── admin.blade.php     # Layout admin (sidebar + topbar)
│       ├── home.blade.php          # Page d'accueil complète (6 sections — voir §9)
│       ├── news/
│       │   └── show.blade.php      # Page article individuel (image/PDF + sidebar)
│       ├── candidature/
│       │   ├── form.blade.php
│       │   └── success.blade.php
│       └── admin/
│           ├── login.blade.php
│           ├── dashboard.blade.php
│           ├── applications/
│           │   ├── index.blade.php
│           │   └── show.blade.php
│           ├── articles/
│           │   ├── index.blade.php  # Liste articles + badges type + pagination
│           │   ├── create.blade.php # Formulaire création (titre + textarea + fichier)
│           │   └── edit.blade.php   # Formulaire édition + aperçu pièce jointe actuelle
│           ├── documents/
│           │   └── index.blade.php
│           └── settings/
│               └── index.blade.php
│
├── routes/web.php              # Toutes les routes publiques + admin
├── bootstrap/app.php           # Alias middleware 'admin'
├── .env                        # Config MySQL + credentials admin
└── vite.config.js              # Tailwind v4 via @tailwindcss/vite
```

---

## 4. Base de données

### Table `applications`
| Colonne | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `type_formation` | varchar(255) | Formation Initiale, Continue… |
| `nom` | varchar(255) | |
| `prenom` | varchar(255) | |
| `section_candidature` | varchar(255) | Navigation, Machine, Pêche… |
| `genre` | varchar(255) | Masculin / Féminin |
| `email` | varchar(255) | |
| `telephone` | varchar(255) | |
| `lieu_naissance` | varchar(255) | |
| `date_naissance` | date | |
| `niveau_scolaire` | varchar(255) | 3ème Collège → Master |
| `region` | varchar(255) | 12 régions du Maroc |
| `ville` | varchar(255) | |
| `adresse_postale` | text | |
| `declaration_honneur` | boolean | Obligatoire acceptée |
| `status` | varchar(20) | `En attente` / `Validé` / `Rejeté` (défaut : En attente) |
| `created_at` / `updated_at` | timestamp | |

### Table `documents`
| Colonne | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `title` | varchar(255) | Titre affiché publiquement |
| `file_path` | varchar(255) | Chemin relatif dans `storage/app/public/documents/` |
| `created_at` / `updated_at` | timestamp | |

### Table `articles`
| Colonne | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `title` | varchar(255) | Titre de l'article |
| `content` | text | Corps de l'article — texte brut uniquement (strip_tags appliqué à la saisie) |
| `file_path` | varchar(255) nullable | Pièce jointe optionnelle dans `storage/app/public/articles/` (image ou PDF) |
| `created_at` / `updated_at` | timestamp | |

**Méthodes du modèle `Article` :**
- `file_url` (accessor) — URL publique de la pièce jointe via `Storage::url()`
- `isImage(): bool` — détecte jpg/jpeg/png/gif/webp
- `isPdf(): bool` — détecte pdf

### Table `site_settings`
| Colonne | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `key` | varchar(100) unique | |
| `value` | text nullable | |

**Clés par défaut :**
- `annonce_active` → `"1"` (afficher le bandeau)
- `annonce_titre` → `"Concours d'Accès 2024/2025 — Inscriptions Ouvertes"`
- `annonce_texte` → texte long de présentation

---

## 5. Routes

### Publiques
| Method | URI | Nom | Action |
|---|---|---|---|
| GET | `/` | `home` | Homepage + documents + settings + articles (6 derniers) |
| GET | `/candidature` | `candidature.form` | Afficher le formulaire |
| POST | `/candidature` | `candidature.store` | Soumettre le formulaire |
| GET | `/candidature/succes` | `candidature.success` | Page de confirmation |
| GET | `/news/{article}` | `news.show` | Vue publique d'un article (route-model binding) |

### Admin (auth)
| Method | URI | Nom | Action |
|---|---|---|---|
| GET | `/admin/login` | `admin.login` | Formulaire login |
| POST | `/admin/login` | `admin.login.submit` | Traiter login |
| POST | `/admin/logout` | `admin.logout` | Déconnexion |

### Admin (protégées — middleware `admin`)
| Method | URI | Nom | Action |
|---|---|---|---|
| GET | `/admin/dashboard` | `admin.dashboard` | Tableau de bord |
| GET | `/admin/candidatures` | `admin.applications.index` | Liste + filtres |
| GET | `/admin/candidatures/{id}` | `admin.applications.show` | Détail dossier |
| PATCH | `/admin/candidatures/{id}/status` | `admin.applications.status` | Changer statut |
| DELETE | `/admin/candidatures/{id}` | `admin.applications.destroy` | Supprimer |
| GET | `/admin/documents` | `admin.documents.index` | Liste documents |
| POST | `/admin/documents` | `admin.documents.store` | Upload PDF |
| DELETE | `/admin/documents/{id}` | `admin.documents.destroy` | Supprimer PDF |
| GET | `/admin/parametres` | `admin.settings.index` | Page paramètres |
| POST | `/admin/parametres` | `admin.settings.update` | Sauvegarder |
| GET | `/admin/articles` | `admin.articles.index` | Liste articles |
| GET | `/admin/articles/create` | `admin.articles.create` | Formulaire création |
| POST | `/admin/articles` | `admin.articles.store` | Enregistrer article |
| GET | `/admin/articles/{article}/edit` | `admin.articles.edit` | Formulaire édition |
| PUT/PATCH | `/admin/articles/{article}` | `admin.articles.update` | Mettre à jour |
| DELETE | `/admin/articles/{article}` | `admin.articles.destroy` | Supprimer |

Les routes articles admin sont déclarées via `Route::resource('articles', ArticleController::class)`.

---

## 6. Authentification Admin

Mécanisme **custom session-based** (pas de Laravel Breeze/Sanctum) :

```php
// AdminAuthController::login()
if ($request->email === env('ADMIN_EMAIL') && $request->password === env('ADMIN_PASSWORD')) {
    session(['admin_authenticated' => true]);
}

// AdminMiddleware::handle()
if (! session('admin_authenticated')) {
    return redirect()->route('admin.login');
}
```

Les credentials sont dans `.env` :
```
ADMIN_EMAIL=admin@cqpm-nador.ma
ADMIN_PASSWORD=CqpmAdmin@2024
```

> **Pour la production :** remplacer la comparaison en clair par `Hash::check()` avec un hash bcrypt stocké en DB.

---

## 7. Palette de couleurs (Tailwind v4)

Définie dans `resources/css/app.css` via `@theme {}` :

| Variable CSS | Valeur HEX | Usage |
|---|---|---|
| `--color-navy` | `#0B3C5D` | Couleur principale (header, nav, titres) |
| `--color-navy-dark` | `#061E30` | Top bar, footer |
| `--color-navy-light` | `#1565A9` | Hover états, variante |
| `--color-gold` | `#C4992A` | Accents, CTA, sceau Maroc |
| `--color-gold-dark` | `#A07820` | Hover gold |
| `--color-gold-light` | `#F5E6C0` | Fond bandeau annonce |
| `--color-sea` | `#1A7FAE` | Liens, badges info |
| `--color-sea-light` | `#E8F4FB` | Fonds cards clairs |

Utilisation dans Blade : `bg-navy`, `text-gold`, `hover:bg-navy-light`, etc.

---

## 8. Structure du header public (3 couches)

Le layout public (`layouts/app.blade.php`) est composé de trois bandes empilées avant le contenu.

### 8.1 Top Contact Bar (`bg-navy-dark` — masquée sur mobile)
- Padding : `py-3` (~48 px de hauteur)
- Texte : `text-sm text-white/70`
- Icônes : `w-4 h-4`
- Gauche : téléphone + email avec icônes
- Droite : séparateur + icônes Facebook et YouTube

### 8.2 Middle Logo Bar (`bg-white border-b`)
- Padding : `py-6 md:py-7`
- **Gauche** — logos institutionnels :
  - Sceau Royaume du Maroc : cercle `w-16 h-16 md:w-20 md:h-20` avec SVG étoile gold/navy
  - Séparateur vertical : `h-16 md:h-20`
  - Texte Ministère : `text-xs font-bold uppercase` + deux lignes `text-xs text-gray-500`
- **Centre (mobile uniquement)** : nom du centre `text-lg font-bold text-navy` + sous-titre `text-sm`
- **Droite** — logo CQPM :
  - Texte (desktop) : `text-2xl font-extrabold text-navy` + `text-sm text-gray-500` + ligne arabe `text-sm`
  - Icône anchor dans cercle navy : `w-16 h-16 md:w-20 md:h-20`, SVG gold `w-8 h-8 md:w-10 md:h-10`

### 8.3 Navigation Bar (`bg-navy sticky top-0 z-50`)
- Hauteur : `h-16`
- **Liens desktop** : `text-sm font-medium px-4 border-b-2`, actif = `text-gold border-gold`, inactif = `text-white/80 hover:text-white hover:border-white/30`
- **6 liens** (dans l'ordre) :
  1. Accueil → `/`
  2. L'Institut → `#l-institut`
  3. Formations → `#formations`
  4. Mot du Directeur → `#mot-directeur`
  5. Actualités & News → `#actualites`
  6. Avis & Résultats → `#avis`
- **CTA Inscription** : `px-7 bg-gold text-navy font-bold text-sm`
- **Mobile** : burger (`w-6 h-6`) + menu déroulant `bg-navy-dark` avec tous les liens et bouton CTA gold

---

## 9. Structure de la homepage

Séquence exacte top → bottom dans `home.blade.php` :

| # | ID anchor | Section | Fond | Notes |
|---|---|---|---|---|
| 1 | — | **Hero Banner** | gradient navy | Titre, sous-titre, stats panel, 2 CTA buttons |
| 2 | — | **Annonce** | `bg-gold-light` | Bandeau admin-controlled via `site_settings` (conditionnel) |
| 3 | `#l-institut` | **Présentation du Centre** | `bg-white` | Texte + 4 badges + panel "Informations clés" (navy) |
| 4 | `#mot-directeur` | **Mot du Directeur** | `bg-gray-50` | 2 colonnes : photo placeholder (gauche) + message éditorial (droite) |
| 5 | `#formations` | **Filières de Formation** | `bg-white` | 6 cards (Navigation, Machine, Pêche, Sécurité, Aquaculture, Transformation) |
| 6 | `#actualites` | **Actualités & Événements** | `bg-gray-50` | Grid 3 colonnes — alimenté par le modèle `Article` (6 derniers) |
| 7 | `#avis` | **Avis & Résultats** | `bg-white` | Grid PDF cards rouges — alimenté par le modèle `Document` |
| 8 | — | **CTA Strip** | `bg-navy` | Bannière navy avec bouton inscription |

### Section "Mot du Directeur" (détail)
- Layout : `lg:grid-cols-5` (2/5 photo + 3/5 texte)
- Colonne gauche : frame gradient navy avec silhouette placeholder, name-plate overlay doré en bas. Remplacer par une vraie `<img>` quand la photo est disponible.
- Colonne droite : label "Éditorial" + titre h2 navy + séparateur triple gold + citation bordure-gauche + 2 paragraphes + signature avec avatar navy/gold

### Section "Actualités & Événements" (détail)
- Source : `Article::latest()->take(6)->get()` passé en vue via la route `/`
- Chaque card affiche : date en gold, titre, extrait 130 chars, badge "PDF joint" si applicable, miniature si la pièce jointe est une image
- Lien "Lire la suite" → `route('news.show', $article)`
- Vide : placeholder dashed border avec message

---

## 10. Page article individuel (`/news/{article}`)

Vue : `resources/views/news/show.blade.php`

- **Header** : gradient navy avec titre h1, date, source
- **Layout** : `lg:grid-cols-3` — 2/3 article + 1/3 sidebar
- **Corps** : texte brut affiché via `{!! nl2br(e($article->content)) !!}` (line breaks préservés, XSS protégé)
- **Si image jointe** : affichée en `aspect-video object-cover` au-dessus du texte
- **Si PDF joint** : bouton "Télécharger la pièce jointe" avec icône rouge, `download` attribute
- **Sidebar** : carte infos (date publication, source), bouton retour navy, mini CTA inscription

---

## 11. Formulaire de candidature

URL : `/candidature` — 4 sections visuelles :

| Section | Champs |
|---|---|
| 1 — Candidature | type_formation · section_candidature · niveau_scolaire |
| 2 — Identité | nom · prenom · genre · date_naissance · lieu_naissance |
| 3 — Coordonnées | email · telephone · region · ville · adresse_postale |
| 4 — Déclaration | checkbox declaration_honneur (obligatoire + texte légal complet) |

Validation dans `StoreApplicationRequest` — messages d'erreur en français, rule `before:-16 years` sur la date de naissance.

---

## 12. Panel Admin — Fonctionnalités

### Dashboard (`/admin/dashboard`)
- 4 stats cards : total candidatures · en attente · validées · documents PDF
- Tableau des 6 dernières candidatures avec statut color-coded
- Actions rapides + aperçu de l'annonce active

### Candidatures (`/admin/candidatures`)
- **Filtres :** recherche (nom/email) + type de formation + statut
- **Statut inline :** `<select>` dans le tableau → PATCH auto-submit
- **Actions :** Voir (détail) · Supprimer (avec confirm)

### Fiche candidature (`/admin/candidatures/{id}`)
- Toutes les données groupées par section
- Widget statut : radio buttons → PATCH `/status`
- Action : Contacter par email · Supprimer le dossier

### Documents PDF (`/admin/documents`)
- Upload : title + fichier PDF (max 15MB)
- Liste : tous les docs avec lien téléchargement + bouton supprimer
- La suppression efface aussi le fichier physique via `Storage::disk('public')->delete()`

### Articles / Actualités (`/admin/articles`)
- **Index** : tableau avec titre, aperçu contenu, badge type pièce jointe (Image / PDF), date, actions
- **Création** (`/admin/articles/create`) : formulaire minimaliste — `<input type="text">` pour le titre, `<textarea>` natif pour le contenu (pas de WYSIWYG), `<input type="file">` pour une image ou PDF optionnel (max 10 Mo)
- **Édition** (`/admin/articles/{id}/edit`) : même formulaire + aperçu de la pièce jointe actuelle + action supprimer intégrée
- **Validation** : `strip_tags()` appliqué sur `content` avant sauvegarde — aucun HTML accepté
- **Stockage fichiers** : `Storage::disk('public')->store('articles')` → `storage/app/public/articles/`
- **Suppression** : efface le fichier physique et l'enregistrement DB

### Paramètres (`/admin/parametres`)
- Toggle activer/désactiver le bandeau d'annonce
- Éditer le titre et le texte de l'annonce
- Aperçu live dans le sidebar

### Sidebar admin
Liens dans l'ordre : Tableau de bord · Candidatures (badge count) · Documents PDF · **Actualités** (badge count) · Paramètres · Voir le site public (nouvelle fenêtre)

---

## 13. Sécurité articles (XSS)

Le champ `content` des articles est protégé à deux niveaux :
1. **À la saisie** : `strip_tags($request->input('content'))` dans `ArticleController::store()` et `update()` — supprime toute balise HTML avant écriture en base
2. **À l'affichage** : `{!! nl2br(e($article->content)) !!}` — `e()` échappe les caractères spéciaux, `nl2br()` convertit les retours à la ligne en `<br>` (seule transformation HTML autorisée)

---

## 14. Config PHP importante

`C:\wamp64\bin\php\php8.3.28\php.ini` — modifié pour les uploads :
```ini
upload_max_filesize = 15M
post_max_size = 20M
```

`AppServiceProvider.php` — fix pour MySQL utf8mb4 :
```php
Builder::defaultStringLength(191);
```

`SESSION_DRIVER=file` dans `.env` — changé de `database` à `file` pour éviter les erreurs 419 avec `php artisan serve`.

---

## 15. Commandes utiles

```bash
# Démarrer le serveur de développement
php artisan serve

# Builder les assets (Tailwind + Vite)
npm run build

# Mode développement avec hot-reload
npm run dev

# Migrations
php artisan migrate
php artisan migrate:fresh   # Repart de zéro (⚠️ efface les données)

# Vider les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Lien storage (à exécuter une seule fois)
php artisan storage:link
```

---

## 16. Ce qui reste à faire (pistes Phase 3)

- [ ] **Export CSV** des candidatures depuis l'admin
- [ ] **Email de confirmation** automatique au candidat après soumission (config SMTP)
- [ ] **Pagination des filtres** : vérifier que `withQueryString()` fonctionne correctement
- [ ] **Logos officiels** : remplacer les SVG placeholders par les vraies images dans `public/img/` (`logo-royaume.png`, `logo-ministere.png`)
- [ ] **Photo du Directeur** : remplacer le placeholder dans la section `#mot-directeur` par une vraie `<img>` et mettre à jour le nom/titre
- [ ] **Galerie photos** ou slider pour le hero (actuellement CSS-only)
- [ ] **Multi-admin** : passer à la table `users` standard avec `bcrypt` + Laravel Auth
- [ ] **Déploiement production** : configurer `.env` de production, `APP_DEBUG=false`, storage S3 ou filesystem

---

## 17. Dépendances

### PHP (composer.json)
- `laravel/framework` ^12.0
- `laravel/tinker` ^2.10

### Node (package.json)
- `tailwindcss` ^4.0 (via `@tailwindcss/vite`)
- `laravel-vite-plugin` ^2.0
- `vite` ^7.0
- `axios` ^1.11
