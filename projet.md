# CQPM Nador — Documentation Projet

> **Dernière mise à jour :** Juin 2026
> **Stack :** Laravel 12 · PHP 8.3 · MySQL · Tailwind CSS v4 · Vite 7
> **Environnement :** Local WAMP64 — `http://127.0.0.1:8000`

---

## 1. Présentation du projet

Site web institutionnel du **Centre de Qualification Professionnelle Maritime de Nador (CQPM)**, inspiré du portail [ITPM Larache](https://itpm-larache.ma/). L'application comprend :

- Un **site public** présentant l'institut, ses formations dynamiques, les actualités, les documents téléchargeables et un formulaire de réclamation/renseignements.
- Un **formulaire de candidature** complet (inscription au concours d'entrée).
- Un **panel d'administration** sécurisé pour gérer les candidatures, les documents PDF, les articles/actualités, les filières de formation, les réclamations reçues et le contenu dynamique de la homepage.

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
│   │   │   ├── ComplaintController.php        # Réclamations public (create/store) + admin (index/show/archive/unarchive/archived)
│   │   │   ├── DocumentController.php         # Upload PDF + suppression
│   │   │   ├── NewsController.php             # Vue publique d'un article (show)
│   │   │   └── Admin/
│   │   │       ├── AdminController.php        # Dashboard, candidatures, docs, settings
│   │   │       ├── AdminAuthController.php    # Login / logout admin
│   │   │       ├── ArticleController.php      # CRUD complet articles
│   │   │       └── FiliereController.php      # CRUD complet filières + upload icône
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php            # Vérifie session('admin_authenticated')
│   │   └── Requests/
│   │       └── StoreApplicationRequest.php   # Validation FR des 14 champs candidature
│   │
│   ├── Models/
│   │   ├── Application.php    # Candidature (+ accessor full_name, status_color)
│   │   ├── Article.php        # Article/actualité (+ accessors file_url, isImage(), isPdf())
│   │   ├── Complaint.php      # Réclamation (+ cast is_archived boolean)
│   │   ├── Document.php       # Document PDF (+ accessor public_url)
│   │   ├── Filiere.php        # Filière de formation (+ accessor icon_url)
│   │   └── SiteSetting.php    # CMS léger key/value (méthodes get/set/all_settings)
│   │
│   └── Providers/
│       └── AppServiceProvider.php   # Builder::defaultStringLength(191) pour MySQL
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2024_01_01_100000_create_applications_table.php
│   │   ├── 2024_01_01_100001_create_documents_table.php
│   │   ├── 2024_01_02_100000_add_status_to_applications_table.php
│   │   ├── 2024_01_02_100001_create_site_settings_table.php
│   │   ├── 2026_06_04_100000_create_articles_table.php
│   │   ├── 2026_06_04_200000_create_complaints_table.php
│   │   ├── 2026_06_04_210000_add_is_archived_to_complaints_table.php
│   │   └── 2026_06_05_100000_create_filieres_table.php
│   └── seeders/
│       └── FiliereSeeder.php          # Seed des 6 filières maritimes par défaut
│
├── resources/
│   ├── css/app.css             # Tailwind v4 + @theme avec palette maritime
│   ├── js/app.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php       # Layout public (top bar + header logos + nav + footer)
│       │   └── admin.blade.php     # Layout admin (sidebar + topbar)
│       ├── home.blade.php          # Page d'accueil complète (8 sections — voir §9)
│       ├── complaints/
│       │   └── create.blade.php    # Formulaire public réclamations/renseignements
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
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   └── edit.blade.php
│           ├── complaints/
│           │   ├── index.blade.php    # Liste réclamations actives + bouton archiver
│           │   ├── show.blade.php     # Détail + répondre par email + archiver/désarchiver
│           │   └── archived.blade.php # Liste réclamations archivées + bouton désarchiver
│           ├── documents/
│           │   └── index.blade.php
│           ├── filieres/
│           │   ├── index.blade.php   # Liste filières avec aperçu icône
│           │   ├── create.blade.php  # Formulaire création filière + upload icône
│           │   └── edit.blade.php    # Formulaire édition + aperçu icône actuelle
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
| `cin` | varchar(20) nullable | Numéro de Carte d'Identité Nationale — ajouté le 05/06/2026 |
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
| `content` | text | Corps de l'article — texte brut uniquement (`strip_tags` appliqué à la saisie) |
| `file_path` | varchar(255) nullable | Pièce jointe optionnelle dans `storage/app/public/articles/` (image ou PDF) |
| `created_at` / `updated_at` | timestamp | |

**Méthodes du modèle `Article` :**
- `file_url` (accessor) — URL publique de la pièce jointe via `Storage::url()`
- `isImage(): bool` — détecte jpg/jpeg/png/gif/webp
- `isPdf(): bool` — détecte pdf

### Table `complaints`
| Colonne | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `full_name` | varchar(255) | Nom et prénom du déclarant |
| `email` | varchar(255) | |
| `phone` | varchar(255) | |
| `subject` | varchar(255) | Objet de la réclamation |
| `message` | text | Corps du message |
| `is_archived` | boolean | `false` = active · `true` = traitée/archivée (défaut : false) |
| `created_at` / `updated_at` | timestamp | |

**Méthodes du modèle `Complaint` :**
- `is_archived` — casté en `boolean`

### Table `filieres`
| Colonne | Type | Notes |
|---|---|---|
| `id` | bigint PK | |
| `title` | varchar(255) | Nom de la filière — ex. "Navigation Maritime" |
| `badge` | varchar(255) | Niveau/diplôme — ex. "Brevet de Patron" |
| `description` | text | Description affichée sur la card |
| `duration` | varchar(255) | Durée — ex. "24 mois", "6 semaines" |
| `icon_path` | varchar(255) nullable | Chemin relatif dans `storage/app/public/filieres/` |
| `created_at` / `updated_at` | timestamp | |

**Méthodes du modèle `Filiere` :**
- `icon_url` (accessor) — URL publique de l'icône via `Storage::url()` · retourne `null` si pas d'icône (affichage d'un SVG placeholder maritime)

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
| GET | `/` | `home` | Homepage — passe `documents`, `settings`, `articles` (6 derniers), `filieres` |
| GET | `/candidature` | `candidature.form` | Afficher le formulaire de candidature |
| POST | `/candidature` | `candidature.store` | Soumettre le formulaire |
| GET | `/candidature/succes` | `candidature.success` | Page de confirmation |
| GET | `/news/{article}` | `news.show` | Vue publique d'un article (route-model binding) |
| GET | `/reclamation` | `reclamation.form` | Formulaire de réclamation/renseignements |
| POST | `/reclamation` | `reclamation.store` | Soumettre la réclamation |

### Admin (auth — pas de middleware)
| Method | URI | Nom | Action |
|---|---|---|---|
| GET | `/admin/login` | `admin.login` | Formulaire login |
| POST | `/admin/login` | `admin.login.submit` | Traiter login |
| POST | `/admin/logout` | `admin.logout` | Déconnexion |

### Admin (protégées — middleware `admin`)
| Method | URI | Nom | Action |
|---|---|---|---|
| GET | `/admin/dashboard` | `admin.dashboard` | Tableau de bord |
| GET | `/admin/candidatures` | `admin.applications.index` | Liste par onglets (`?tab=en_attente\|accepte\|refuse`) |
| GET | `/admin/candidatures/liste-admis` | `admin.applications.pdf` | Télécharger la liste PDF des admis |
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
| GET | `/admin/complaints` | `admin.complaints.index` | Liste réclamations **actives** |
| GET | `/admin/complaints/archived` | `admin.complaints.archived` | Liste réclamations **archivées** |
| GET | `/admin/complaints/{complaint}` | `admin.complaints.show` | Détail réclamation |
| PATCH | `/admin/complaints/{complaint}/archive` | `admin.complaints.archive` | Archiver (marquer traitée) |
| PATCH | `/admin/complaints/{complaint}/unarchive` | `admin.complaints.unarchive` | Désarchiver (restaurer) |
| GET | `/admin/filieres` | `admin.filieres.index` | Liste filières |
| GET | `/admin/filieres/create` | `admin.filieres.create` | Formulaire création |
| POST | `/admin/filieres` | `admin.filieres.store` | Enregistrer filière |
| GET | `/admin/filieres/{filiere}/edit` | `admin.filieres.edit` | Formulaire édition |
| PUT/PATCH | `/admin/filieres/{filiere}` | `admin.filieres.update` | Mettre à jour |
| DELETE | `/admin/filieres/{filiere}` | `admin.filieres.destroy` | Supprimer |

> **Note routes complaints :** `GET /admin/complaints/archived` est déclaré **avant** `GET /admin/complaints/{complaint}` pour éviter que le segment statique `archived` soit capturé par le wildcard.

> Les routes articles et filières sont déclarées via `Route::resource(...)`.

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
| 5 | `#formations` | **Filières de Formation** | `bg-white` | Grid dynamique — alimenté par le modèle `Filiere` (toutes les filières) |
| 6 | `#actualites` | **Actualités & Événements** | `bg-gray-50` | Grid 3 colonnes — alimenté par le modèle `Article` (6 derniers) |
| 7 | `#avis` | **Avis & Résultats** | `bg-white` | Grid PDF cards rouges — alimenté par le modèle `Document` |
| 8 | — | **CTA Strip** | `bg-navy` | Bannière navy avec 2 boutons : "S'inscrire maintenant" (gold) + "Envoyer une réclamation" (outline blanc) |

### Section "Filières de Formation" (détail)
- Source : `Filiere::all()` passé en vue via la route `/`
- Chaque card affiche : icône uploadée (ou SVG maritime placeholder), titre bold navy, badge pill navy/10, description muted gray, durée avec icône horloge, lien "Postuler >" en gold → `route('candidature.form')`
- Structure card : bordure top accent navy/gold au hover, flex column, `object-cover` sur l'icône si présente
- Vide : placeholder dashed border avec message

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
| 2 — Identité | nom · prenom · **cin** · genre · date_naissance · lieu_naissance |
| 3 — Coordonnées | email · telephone · region · ville · adresse_postale |
| 4 — Déclaration | checkbox declaration_honneur (obligatoire + texte légal complet) |

Validation dans `StoreApplicationRequest` — messages d'erreur en français, rule `before:-16 years` sur la date de naissance.

---

## 12. Formulaire de réclamation / renseignements

URL publique : `/reclamation` — vue : `complaints/create.blade.php`

### Champs du formulaire
| Champ | Type | Validation |
|---|---|---|
| `full_name` | text | required, max 255 |
| `email` | email | required, max 255 |
| `phone` | text | required, max 30 |
| `subject` | text | required, max 255 |
| `message` | textarea | required, min 20 chars |

### Comportement
- Validation serveur avec messages d'erreur en français inline sous chaque champ
- En cas de succès : redirect vers `/reclamation` avec flash `success` affichant le message exact : *"Votre réclamation a bien été envoyée. Une réponse vous sera adressée par e-mail ou éventuellement par téléphone dans les plus brefs délais."*
- Accessible depuis la homepage via le bouton "Envoyer une réclamation" dans le CTA Strip

---

## 13. Panel Admin — Fonctionnalités

### Dashboard (`/admin/dashboard`)
- 4 stats cards : total candidatures · en attente · validées · documents PDF
- Tableau des 6 dernières candidatures avec statut color-coded
- Actions rapides + aperçu de l'annonce active

### Candidatures (`/admin/candidatures`)
- **Navigation par onglets :** 3 onglets — En attente · Acceptés · Refusés — avec compteurs
- **Filtres :** recherche (nom/email) + type de formation (dans chaque onglet)
- **Boutons d'action rapide :** selon l'onglet courant — [Accepter] [Refuser] ou [En attente] (PATCH direct)
- **Bouton "Convertir en liste (PDF)" :** visible uniquement dans l'onglet Acceptés → génère le PDF officiel
- **URL param :** `?tab=en_attente|accepte|refuse` pour switcher l'onglet
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
- **Création** (`/admin/articles/create`) : formulaire — titre, textarea contenu (pas de WYSIWYG), fichier image ou PDF optionnel (max 10 Mo)
- **Édition** (`/admin/articles/{id}/edit`) : même formulaire + aperçu de la pièce jointe actuelle + action supprimer intégrée
- **Validation** : `strip_tags()` appliqué sur `content` avant sauvegarde — aucun HTML accepté
- **Stockage fichiers** : `storage/app/public/articles/`
- **Suppression** : efface le fichier physique et l'enregistrement DB

### Réclamations (`/admin/complaints`)

Deux vues séparées avec navigation par onglets :

**Vue Active** (`index.blade.php`) — réclamations `is_archived = false` :
- Tableau : Date, Nom, Contact (email + tél), Objet, Actions
- Bouton **"Ouvrir"** → page détail
- Bouton **"Archiver — Traitée"** (vert) → PATCH `/archive` · déplace vers les archives avec confirmation

**Vue Archivée** (`archived.blade.php`) — réclamations `is_archived = true` :
- Même tableau avec fond header amber, badge "Traitée" sur chaque ligne
- Bouton **"Désarchiver"** (amber) → PATCH `/unarchive` · restaure dans les actives avec confirmation

**Page détail** (`show.blade.php`) :
- Informations expéditeur (nom, email cliquable, téléphone cliquable)
- Message complet en `whitespace-pre-wrap`
- Bouton **"Répondre par e-mail"** → `mailto:` pré-rempli avec le sujet
- Bouton **"Archiver"** ou **"Désarchiver"** selon l'état courant (`is_archived`)
- Le lien "Retour" s'adapte automatiquement (liste active ou archives)

### Filières de Formation (`/admin/filieres`)

CRUD complet via `Route::resource` — `FiliereController` dans `Admin/` :

- **Index** : tableau avec aperçu icône (44×44 px), titre, badge, durée, extrait description, actions Modifier/Supprimer
- **Création** (`create.blade.php`) : champs title, badge, duration, description + upload icône (JPG/PNG/SVG, max 2 Mo) — si pas d'icône : SVG maritime placeholder affiché
- **Édition** (`edit.blade.php`) : même formulaire + aperçu de l'icône actuelle · upload optionnel pour la remplacer
  - **Architecture forms** : le formulaire d'édition et le bouton de suppression sont **deux `<form>` frères** (jamais imbriqués). Le bouton "Enregistrer" utilise l'attribut HTML5 `form="filiere-update-form"` pour rester associé au bon formulaire même hors de ses balises.
- **Stockage icônes** : `storage/app/public/filieres/` · l'ancienne icône est supprimée du disque lors du remplacement
- **Suppression** : efface l'icône physique + l'enregistrement DB

### Paramètres (`/admin/parametres`)
- Toggle activer/désactiver le bandeau d'annonce
- Éditer le titre et le texte de l'annonce
- Aperçu live dans le sidebar

### Sidebar admin
Liens dans l'ordre : Tableau de bord · Candidatures (badge count) · Documents PDF · Actualités (badge count) · **Réclamations** (badge count) · **Filières** (badge count) · Paramètres · Voir le site public (nouvelle fenêtre)

---

## 14. Sécurité articles (XSS)

Le champ `content` des articles est protégé à deux niveaux :
1. **À la saisie** : `strip_tags($request->input('content'))` dans `ArticleController::store()` et `update()` — supprime toute balise HTML avant écriture en base
2. **À l'affichage** : `{!! nl2br(e($article->content)) !!}` — `e()` échappe les caractères spéciaux, `nl2br()` convertit les retours à la ligne en `<br>` (seule transformation HTML autorisée)

---

## 15. Config PHP importante

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

## 16. Commandes utiles

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

# Seeders
php artisan db:seed --class=FiliereSeeder   # Insère les 6 filières maritimes par défaut

# Vider les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Lien storage (à exécuter une seule fois)
php artisan storage:link
```

---

## 17. Ce qui reste à faire (pistes Phase suivante)

- [ ] **Export CSV** des candidatures depuis l'admin
- [ ] **Email de confirmation** automatique au candidat après soumission (config SMTP)
- [ ] **Notification email** à l'admin lors d'une nouvelle réclamation
- [ ] **Ordre d'affichage des filières** : ajouter un champ `sort_order` pour permettre le glisser-déposer ou le réordonnement manuel depuis l'admin
- [ ] **Icônes filières** : uploader les logos officiels de chaque filière via l'admin (`/admin/filieres/{id}/edit`)
- [ ] **Pagination des filtres** candidatures : vérifier que `withQueryString()` fonctionne correctement
- [ ] **Logos officiels** : remplacer les SVG placeholders dans `public/img/` (`logo-royaume.png`, `logo-ministere.png`)
- [ ] **Photo du Directeur** : remplacer le placeholder dans la section `#mot-directeur` par une vraie `<img>` et mettre à jour le nom/titre
- [ ] **Galerie photos** ou slider pour le hero (actuellement CSS-only)
- [ ] **Multi-admin** : passer à la table `users` standard avec `bcrypt` + Laravel Auth
- [ ] **Déploiement production** : configurer `.env` de production, `APP_DEBUG=false`, storage S3 ou filesystem

---

## 18. Dépendances

### PHP (composer.json)
- `laravel/framework` ^12.0
- `laravel/tinker` ^2.10
- `barryvdh/laravel-dompdf` ^3.1 — Génération PDF (liste officielle admis)

### Node (package.json)
- `tailwindcss` ^4.0 (via `@tailwindcss/vite`)
- `laravel-vite-plugin` ^2.0
- `vite` ^7.0
- `axios` ^1.11
