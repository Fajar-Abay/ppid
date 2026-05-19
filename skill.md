# SKILL RULES: PPID CMS (Laravel + Filament + Livewire)

> **Version:** 1.0.0
> **Scope:** All code generation, architectural decisions, UI/UX design, and database modeling for the PPID (Pejabat Pengelola Informasi dan Dokumentasi) Full CMS Web Application.
> **Authority:** This document is the single source of truth. Any deviation requires explicit user approval.

---

## 1. Project Overview & Architecture

### 1.1 Application Definition
**PPID CMS** is a comprehensive institutional information disclosure portal and content management system designed for Indonesian government bodies or public institutions. It serves as the official channel for managing, publishing, and tracking public information requests, complaints, and official documents under the framework of Keterbukaan Informasi Publik (KIP).

### 1.2 Architectural Principles
- **Monolithic Laravel Application** with modular service layers.
- **Admin-First Design:** The CMS (Filament) is the primary control plane. All content, layout, and configuration originate from the admin panel.
- **Public Portal:** A separate, read-optimized frontend consuming managed content via Eloquent models or cached repositories.
- **Security-First:** All uploads, downloads, and complaint data are treated as sensitive institutional data.
- **Accessibility-First:** WCAG 2.1 AA compliance is mandatory for all public-facing interfaces.

### 1.3 High-Level Architecture Diagram (Conceptual)
```
+-------------------------------------------------------------+
|                      PUBLIC PORTAL                           |
|  +----------+  +------------+  +------------+  +----------+  |
|  | Landing  |  | Document  |  | Complaint |  |  News   |  |
|  |  Page    |  |  Search   |  |   Form    |  |  Feed   |  |
|  +----------+  +------------+  +------------+  +----------+  |
+----------------------+--------------------------------------+
                       |
+----------------------v--------------------------------------+
|                   LARAVEL APPLICATION                          |
|  +------------------------------------------------------+  |
|  |              FILAMENT ADMIN PANEL (CMS)                 |  |
|  |  +----------+ +----------+ +----------+ +----------+  |  |
|  |  | Content  | | Document | |Complaint | |  User    |  |  |
|  |  | Manager  | |  Manager | | Manager  | |  Admin   |  |  |
|  |  +----------+ +----------+ +----------+ +----------+  |  |
|  |  +----------+ +----------+ +----------+             |  |
|  |  |  Letter  | |Signature | | Settings |             |  |
|  |  | Template | | Manager  | | & Config |             |  |
|  |  +----------+ +----------+ +----------+             |  |
|  +------------------------------------------------------+  |
|  +------------------------------------------------------+  |
|  |              SERVICE & REPOSITORY LAYER                 |  |
|  |  +----------+ +----------+ +----------+ +----------+  |  |
|  |  | Document | |Complaint | |  PDF     | |Signature |  |  |
|  |  | Service  | | Service  | | Service  | | Service  |  |  |
|  |  +----------+ +----------+ +----------+ +----------+  |  |
|  +------------------------------------------------------+  |
|  +------------------------------------------------------+  |
|  |              LIVEWIRE COMPONENTS (Public)             |  |
|  |  +----------+ +----------+ +----------+             |  |
|  |  |Complaint | | Document | |  Search  |             |  |
|  |  |   Form   | |  Filter  | | Widget   |             |  |
|  |  +----------+ +----------+ +----------+             |  |
|  +------------------------------------------------------+  |
+-------------------------------------------------------------+
```

---

## 2. Technical Stack & Packages

### 2.1 Core Framework
| Layer | Technology | Version/Notes |
|-------|-----------|---------------|
| Backend Framework | Laravel | Latest stable (12.x or current) |
| PHP | PHP | 8.3+ |
| Admin Panel | Filament PHP | Latest stable (3.x) |
| Reactive Components | Livewire | 3.x |
| Styling | Tailwind CSS | 3.4+ with custom config |
| Database | MySQL / PostgreSQL | 8.0+ / 15+ |
| Queue | Redis | For PDF generation & notifications |
| Cache | Redis / File | Redis preferred for production |

### 2.2 Required Packages
Install and configure the following packages. No alternatives without justification.

```bash
# Admin Panel & Shield
composer require filament/filament
composer require bezhansalleh/filament-shield

# Permissions (Filament Shield uses Spatie underneath)
composer require spatie/laravel-permission

# Media Handling
composer require spatie/laravel-medialibrary

# PDF Generation (Primary: Browsershot for fidelity; Fallback: DOMPDF for simple docs)
composer require spatie/browsershot
npm install puppeteer
composer require barryvdh/laravel-dompdf # Fallback only

# Translatable (if multi-language is scoped)
composer require spatie/laravel-translatable

# Excel/CSV Export for reports
composer require maatwebsite/excel

# Slug generation
composer require spatie/laravel-sluggable

# Activity Logging (for audit trails)
composer require spatie/laravel-activitylog

# QR Code generation (for complaint tracking)
composer require simplesoftwareio/simple-qrcode

# Image optimization
composer require spatie/laravel-image-optimizer
```

### 2.3 Frontend Stack (Public Portal)
- **CSS Framework:** Tailwind CSS (custom institutional config)
- **JavaScript:** Vanilla JS or Alpine.js (bundled with Filament/Livewire)
- **Fonts:** Inter (body), Plus Jakarta Sans (UI elements), optional sharp serif for headings (e.g., "Merriweather" or "Playfair Display" for editorial headings)
- **Icons:** Heroicons (outline style only for public portal)
- **No Bootstrap, No jQuery, No generic UI kits.**

---

## 3. Database Schema & Modeling Standards

### 3.1 Core Entities
The following entities MUST exist. Use Laravel migrations with strict foreign keys and indexes.

#### `users` (Extended)
- Standard Laravel users + `nip` (string, nullable), `jabatan` (string), `phone`, `signature_path` (string, nullable for digital signature image)
- Soft deletes enabled

#### `categories` (Document & News Categories)
- `id`, `name`, `slug`, `type` (enum: 'informasi_berkala', 'informasi_serta_merta', 'informasi_setiap_saat', 'berita'), `description`, `sort_order`, `is_active`
- Tree structure (nested set or adjacency list) if sub-categories are needed

#### `documents` (Informasi Publik)
- `id`, `category_id` (FK), `title`, `slug`, `description` (long text), `file_path` (string), `file_size`, `file_type`, `mime_type`, `download_count` (unsigned big int, default 0), `published_at`, `expired_at`, `status` (enum: 'draft', 'published', 'archived'), `meta_keywords`, `created_by` (FK users)
- MUST use Spatie Media Library for file attachments. Do NOT store raw file paths in the model.
- Index on `category_id`, `status`, `published_at`

#### `complaints` (Pengaduan / Permohonan Informasi)
- `id`, `tracking_code` (unique, 12 chars alphanumeric), `complainant_name`, `complainant_email`, `complainant_phone`, `complainant_address` (text), `subject`, `description` (long text), `category` (enum: 'permohonan_informasi', 'pengaduan', 'saran'), `status` (enum: 'pending', 'processing', 'approved', 'rejected', 'completed'), `ktp_media_id` (nullable, FK to media), `attachment_media_ids` (JSON array of media IDs), `submitted_at`, `processed_at`, `processed_by` (FK users), `response_letter_id` (nullable, FK letters)
- `tracking_code` must be auto-generated using a cryptographically secure random generator, formatted as `PPID-XXXX-XXXX` where X is alphanumeric.
- Index on `tracking_code`, `status`, `submitted_at`

#### `letters` (Surat Balasan / Official Replies)
- `id`, `complaint_id` (FK), `template_id` (nullable, FK), `letter_number` (unique, formatted string), `subject`, `body` (long text, HTML allowed), `signature_id` (nullable, FK users who signed), `signed_at`, `pdf_path` (string, generated path), `status` (enum: 'draft', 'signed', 'sent'), `created_by` (FK)
- `letter_number` format: `SRT/{department}/{sequence}/{month}/{year}` auto-generated via service class

#### `letter_templates` (Template Surat)
- `id`, `name`, `slug`, `subject_template`, `body_template` (long text, contains Blade-like placeholders: `{{ $complaint->subject }}`, `{{ $official_name }}`, etc.), `header_html` (text), `footer_html` (text), `css_styles` (text), `is_active`

#### `pages` (CMS Pages for Landing)
- `id`, `title`, `slug`, `content` (JSON blocks or HTML), `meta_title`, `meta_description`, `is_published`, `sort_order`, `template` (enum: 'default', 'fullwidth', 'sidebar')
- Content MUST be stored in a structured format (JSON blocks) to allow Filament Builder or Repeater fields to manage sections dynamically.

#### `banners` / `sliders`
- `id`, `title`, `subtitle`, `image_media_id`, `link_url`, `button_text`, `sort_order`, `is_active`, `display_location` (enum: 'homepage', 'sidebar', 'footer')

#### `settings` (Site Configuration)
- `id`, `key` (unique), `value` (text), `type` (enum: 'string', 'text', 'image', 'boolean', 'json'), `group` (enum: 'general', 'contact', 'social', 'appearance', 'legal')
- Store ALL site-wide configurable values here. No hardcoded strings in views.

#### `menus` (Navigation Management)
- `id`, `name`, `url`, `parent_id` (nullable, self-referencing FK), `sort_order`, `location` (enum: 'header', 'footer', 'sidebar'), `is_external`, `is_active`

#### `activities` (Audit Trail - via Spatie ActivityLog)
- Auto-managed by package. Ensure `subject_type` and `causer_type` are properly logged for all complaint and document mutations.

### 3.2 Migration Rules
- ALL tables MUST use `$table->ulid('id')` or `$table->id()` consistently. Prefer ULID for public-facing entities (complaints, documents) to prevent ID enumeration.
- ALL tables MUST have `created_at` and `updated_at`.
- ALL tables MUST have `$table->softDeletes()` where data integrity is critical (users, documents, complaints, letters).
- ALL foreign keys MUST have `onDelete` constraints explicitly defined (usually `restrict` or `set null`, never `cascade` on critical data).
- ALL string columns that are searchable MUST have appropriate indexes or full-text indexes.

---

## 4. Core Feature Specifications

### 4.1 Full CMS Control (Zero Hardcoded Content)
**RULE:** There is NO hardcoded text, image, or link in any Blade view. Everything is configurable via Filament resources.

#### Implementation Pattern:
1. **Settings Resource (Filament):** Create a `SettingResource` with tabs for General, Contact, Social Media, Appearance, and Legal. Use appropriate form fields based on `type`.
2. **Page Builder Resource:** Create a `PageResource` using Filament's `Builder` form component. Define custom blocks:
   - `heading_block`: title, subtitle, alignment
   - `text_block`: rich text content
   - `image_block`: image (via Spatie Media), caption, alt text
   - `document_list_block`: category selector, limit, layout (grid/list)
   - `complaint_form_block`: embed code or direct component reference
   - `banner_block`: reference to active banners
   - `news_feed_block`: category, limit, layout
   - `custom_html_block`: for advanced users (sanitized)
3. **Menu Manager Resource:** Create a `MenuResource` with a tree/repeater structure. Support nested menus up to 3 levels deep.
4. **Banner/Slider Resource:** Full CRUD with image upload, scheduling (publish/unpublish dates), and position management.

#### Blade View Pattern:
```blade
{{-- CORRECT --}}
<h1>{{ $page->title }}</h1>
<p>{{ settings('site_tagline') }}</p>
<img src="{{ settings('logo_url') }}" alt="{{ settings('site_name') }}">

{{-- INCORRECT --}}
<h1>Portal PPID</h1>
<p>Informasi Terbuka Untuk Semua</p>
<img src="/images/logo.png" alt="Logo">
```

#### Helper Functions:
Create a `settings()` helper function that caches settings for 24 hours:
```php
function settings(string $key, mixed $default = null): mixed {
    return cache()->remember('setting.'.$key, 86400, fn() => 
        \App\Models\Setting::where('key', $key)->first()?->value ?? $default
    );
}
```

### 4.2 Document Management (Informasi Publik)

#### Categories (Strict):
Documents MUST be classified into exactly these categories:
1. **Informasi Berkala** - Information published periodically (annual reports, budgets, etc.)
2. **Informasi Serta Merta** - Urgent information that must be disclosed immediately
3. **Informasi Setiap Saat** - Information available at any time upon request
4. **Berita / Artikel** - News and articles (separate from formal documents)

#### Document Resource (Filament):
- Form fields: Title, Category (select), Description (RichText), File Upload (Spatie Media, max 50MB, restrict to PDF, DOC, DOCX, XLS, XLSX, ZIP), Publish Date, Expiry Date, Status
- Table columns: Title, Category badge, File type icon, Download count, Status toggle, Published date
- Actions: Download (increment counter), Preview (if PDF), Delete (soft)
- Filters: Category, Status, Date range, File type

#### Download Counter:
Implement via middleware or controller action. NEVER increment in a view.
```php
// DocumentDownloadController
public function download(Document $document) {
    $document->increment('download_count');
    $media = $document->getFirstMedia('documents');
    return response()->download($media->getPath(), $media->file_name);
}
```

#### Public Document Portal:
- Category-based browsing with breadcrumb navigation
- Search with full-text search on title and description
- Sort by: newest, most downloaded, alphabetical
- Document cards: Title, category badge, file size, file type icon, download count, publish date
- Pagination: 12 items per page

### 4.3 Complaint System (Form Pengaduan)

#### Public Livewire Component: `ComplaintForm`
**Fields (Step-by-step wizard or single form):**
1. **Personal Data:**
   - Name (required, string, max 100)
   - Email (required, email, unique per active complaint optional)
   - Phone (required, regex Indonesian phone format)
   - Address (required, text area, max 500)
   - KTP Upload (required, image or PDF, max 2MB, stored securely via Spatie Media)
2. **Complaint Details:**
   - Category (required, select: Permohonan Informasi / Pengaduan / Saran)
   - Subject (required, string, max 200)
   - Description (required, text area, min 50 chars, max 5000)
   - Attachments (optional, multiple files, max 5 files, 5MB each)
3. **Verification:**
   - CAPTCHA (Google reCAPTCHA v2 or hCaptcha)
   - Terms checkbox (required)

#### Security Rules:
- KTP and attachments MUST be stored in a non-public disk (`private_uploads`) or in a hashed directory structure.
- Access to complaint attachments MUST be via signed URLs with expiration (e.g., 5 minutes).
- File names MUST be randomized (UUID) on storage. Original names are stored in metadata only.
- All uploads MUST be scanned for MIME type validation (never trust extension alone).

#### Tracking System:
- On submission, generate `tracking_code` and display it prominently.
- Send confirmation email with tracking code and QR code image.
- Public tracking page: Input tracking code -> display status timeline.

#### Status Timeline (Livewire Component: `ComplaintTracker`):
```
[Submitted] -> [Under Review] -> [Being Processed] -> [Response Ready / Rejected]
```
Display as vertical timeline with timestamps and status descriptions.

### 4.4 Official Reply & Letter Templates (Balas Pengaduan)

#### Letter Template Resource (Filament):
- CRUD for HTML/Blade templates
- Preview functionality (render template with dummy data)
- Placeholder system: `{{ $complaint->subject }}`, `{{ $complaint->complainant_name }}`, `{{ $letter_number }}`, `{{ $date }}`, `{{ $official_name }}`, `{{ $official_jabatan }}`
- Header/Footer editor with custom CSS for print media

#### Letter Composition Workflow:
1. Admin opens complaint detail in Filament.
2. Clicks "Generate Reply" action.
3. Selects template (optional) or starts blank.
4. Rich Text Editor (Tiptap or Filament RichEditor) opens with complaint data pre-filled as placeholders.
5. Admin composes/edits the letter body.
6. Admin clicks "Preview PDF" -> system generates PDF via Browsershot using the template CSS.
7. Admin clicks "Add Signature" -> selects official from dropdown (users with signature image).
8. Signature is stamped onto PDF at designated coordinates.
9. Final PDF is saved to `letters/{year}/{month}/{letter_number}.pdf`.
10. Letter status updated to `signed`. Complaint status updated to `completed`.
11. System sends email to complainant with PDF attachment and download link (signed URL).

#### PDF Generation Service (Repository Pattern):
```php
namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class LetterPdfService {
    public function generate(Letter $letter): string {
        $html = view('pdf.letter', [
            'letter' => $letter,
            'header' => $letter->template?->header_html,
            'footer' => $letter->template?->footer_html,
            'css' => $letter->template?->css_styles,
        ])->render();

        $path = "letters/{$letter->created_at->format('Y/m')}/{$letter->letter_number}.pdf";

        Browsershot::html($html)
            ->format('A4')
            ->margins(20, 20, 20, 20)
            ->showBackground()
            ->save(Storage::disk('public')->path($path));

        return $path;
    }

    public function stampSignature(string $pdfPath, User $signer): string {
        // Use PDF manipulation library (e.g., setasign/fpdi or smalot/pdfparser)
        // Stamp signature image at coordinates defined in settings
        // Return new path
    }
}
```

#### Digital Signature (TTE - Tanda Tangan Elektronik):
- **Simple Implementation:** Upload signature image (PNG with transparency) per user. Stamp onto PDF at configured coordinates.
- **Advanced Implementation (if requested):** Integrate with official TTE providers (e.g., BSrE) using their API. Store certificate data securely in environment variables.
- Signature coordinates (x, y, page) MUST be configurable per template in the admin panel.
- Each signature action MUST be logged in the activity log with IP address and timestamp.

---

## 5. Role & Permission System (Filament Shield)

### 5.1 Defined Roles
| Role | Description | Permissions |
|------|-------------|-------------|
| **Super Admin** | Full system access | `*` (all) |
| **Administrator** | Content and user management | Manage content, documents, news, pages, menus, banners, settings. Cannot manage roles/permissions. |
| **Verifikator** | Complaint reviewer | View complaints, update status to processing/approved/rejected, view KTP, cannot delete. |
| **Atasan / Pimpinan** | Approver and signer | View complaints, generate and sign letters, view reports. Cannot modify content. |
| **Editor** | Content creator | Create/edit documents, news, pages. Cannot publish (needs approval) or manage users. |
| **Public** | Anonymous/Registered public | Submit complaints, track status, download public documents. |

### 5.2 Permission Granularity
Use resource-level permissions generated by Filament Shield:
- `view_complaint`, `view_any_complaint`, `create_complaint`, `update_complaint_status`, `delete_complaint`
- `view_document`, `view_any_document`, `create_document`, `update_document`, `delete_document`, `publish_document`
- `view_letter`, `create_letter`, `update_letter`, `sign_letter`, `delete_letter`
- `view_user`, `create_user`, `update_user`, `delete_user`, `assign_role`
- `view_setting`, `update_setting`
- `view_report`, `export_report`

### 5.3 Policy Enforcement
- ALL Filament resources MUST have corresponding Policies registered.
- ALL custom pages and actions MUST check permissions via `$user->can('permission_name')`.
- Complaint KTP uploads MUST be restricted: only Verifikator, Atasan, and Super Admin can view. Use custom Filament table action with `can()` authorization.

---

## 6. Anti-AI Slop UI/UX Guidelines (CRITICAL - ZERO TOLERANCE)

### 6.1 Design Philosophy
This is an **institutional government portal**, not a SaaS dashboard or a startup landing page. The design must convey **authority, trustworthiness, clarity, and professionalism**. Every pixel must serve the content. Decorative elements are permitted ONLY if they reinforce institutional identity.

### 6.2 Color Palette (Strict)
**Base Colors:**
```css
/* Tailwind Config Extension */
colors: {
    /* Neutrals - Sophisticated, not cold */
    'institutional': {
        50: '#f8f9fa',   /* Off-white background */
        100: '#f1f3f5',  /* Subtle section bg */
        200: '#e9ecef',  /* Borders, dividers */
        300: '#dee2e6',  /* Disabled states */
        400: '#adb5bd',  /* Muted text */
        500: '#868e96',  /* Secondary text */
        600: '#495057',  /* Body text */
        700: '#343a40',  /* Headings */
        800: '#212529',  /* Deep text */
        900: '#121214',  /* Near black */
    },
    /* Primary Accent - Navy Blue (Institutional Authority) */
    'primary': {
        50: '#e7ecf3',
        100: '#c5d0e3',
        200: '#9eb0d0',
        300: '#7790bd',
        400: '#5a78af',
        500: '#3d60a1',  /* Main primary */
        600: '#355895',
        700: '#2d4e87',
        800: '#264479',
        900: '#1a3261',
    },
    /* Secondary Accent - Deep Maroon or Forest Green (choose ONE per deployment) */
    'accent': {
        /* Option A: Deep Maroon */
        DEFAULT: '#7b1f3f',
        light: '#a84565',
        dark: '#52152a',
        /* Option B: Forest Green (alternative) */
        // DEFAULT: '#2d6a4f',
        // light: '#52b788',
        // dark: '#1b4332',
    },
    /* Semantic Colors - Muted, not neon */
    'success': '#2f855a',
    'warning': '#c05621',
    'danger': '#9b2c2c',
    'info': '#2b6cb0',
}
```

**Rules:**
- Backgrounds: Use `institutional-50` or white. NO gradients on main backgrounds.
- Cards: White background with `institutional-200` 1px border. NO drop shadows on cards (or at most a very subtle `shadow-sm`).
- Primary actions: `primary-600` or `primary-700`. Hover state: `primary-800`.
- Accent color: Use SPARINGLY. Only for active navigation states, important badges, or section dividers. Maximum 5% of visible area.
- NEVER use: Purple, Indigo, Pink, Teal, Cyan, or Orange as primary colors. NEVER use rainbow gradients. NEVER use neon colors.

### 6.3 Typography (Strict)
```css
/* tailwind.config.js */
fontFamily: {
    'sans': ['Inter', 'system-ui', 'sans-serif'],
    'display': ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
    'serif': ['Merriweather', 'Georgia', 'serif'], /* Optional for editorial headings */
}
```

**Hierarchy Rules:**
- **H1 (Page Title):** `font-display`, `text-3xl` to `text-4xl`, `font-bold`, `text-institutional-800`, `tracking-tight`, `leading-tight`
- **H2 (Section Title):** `font-display`, `text-2xl`, `font-semibold`, `text-institutional-700`, `tracking-tight`
- **H3 (Card/Block Title):** `font-sans`, `text-lg`, `font-semibold`, `text-institutional-700`
- **Body:** `font-sans`, `text-base` (16px), `text-institutional-600`, `leading-relaxed` (1.625)
- **Small/Caption:** `text-sm`, `text-institutional-400`
- **Navigation:** `font-display`, `text-sm`, `font-medium`, `tracking-wide`, uppercase allowed for main nav items with `text-xs` and `tracking-wider`

**Rules:**
- NEVER use `font-black` or `font-extrabold`. Maximum `font-bold`.
- NEVER use all-caps for body text or long headings.
- Line height for body MUST be `leading-relaxed` or `leading-loose`. NEVER `leading-snug` for body paragraphs.
- Contrast ratio MUST be minimum 4.5:1 for body text, 3:1 for large text.

### 6.4 Spacing & Layout (Strict)
```css
/* Tailwind spacing scale - use generous spacing */
spacing: {
    '18': '4.5rem',
    '22': '5.5rem',
}
```

**Rules:**
- Section padding: `py-16` to `py-24` (64px to 96px). NEVER `py-4` for major sections.
- Container: `max-w-7xl` or `max-w-6xl` centered with `mx-auto px-4 sm:px-6 lg:px-8`.
- Grid gaps: `gap-8` minimum. `gap-4` only for dense data lists.
- Card padding: `p-6` or `p-8`. NEVER `p-2` or `p-3` for content cards.
- Border radius: `rounded-sm` (2px) or `rounded` (4px) maximum for cards and buttons. `rounded-md` (6px) ONLY for small UI elements like badges. NEVER `rounded-xl`, `rounded-2xl`, or `rounded-full` for main containers or cards.
- Buttons: `rounded-sm` or sharp corners (`rounded-none`) for primary actions. `px-6 py-3` minimum sizing.

### 6.5 Component Design Rules

#### Navigation (Header)
- Sticky top, white background, `border-b border-institutional-200`
- Logo left, horizontal menu center/right
- Menu items: `text-sm font-medium text-institutional-600 hover:text-primary-700`
- Active item: `text-primary-700` with a `border-b-2 border-primary-600` indicator
- Dropdown menus: White bg, `border border-institutional-200`, `shadow-sm`, NO rounded corners on dropdown container (`rounded-none` or `rounded-sm`)
- Mobile: Hamburger icon (Heroicons), full-screen overlay or slide-down panel with `bg-institutional-50`

#### Hero / Banner Section
- If using image: Dark overlay (`bg-institutional-900/70`) with white text
- Text alignment: Left-aligned or centered. If centered, max-width `max-w-3xl`.
- NO animated gradients. NO particle effects. NO floating geometric shapes.
- Subtle pattern overlay (e.g., very low opacity institutional seal/watermark) is acceptable.

#### Document Cards / News Cards
- White background, `border border-institutional-200`, `rounded-sm`
- NO box shadows. Use border to define separation.
- Image (if any): `aspect-video` or `aspect-[4/3]`, `object-cover`
- Title: `font-display text-lg font-semibold text-institutional-800`
- Meta: `text-xs text-institutional-400 flex items-center gap-2` with Heroicons
- Hover state: `border-primary-300` transition, NO lift/shadow increase

#### Forms (Public)
- Labels: `block text-sm font-medium text-institutional-700 mb-1`
- Inputs: `w-full border-institutional-300 rounded-sm px-4 py-3 text-institutional-700 focus:border-primary-500 focus:ring-1 focus:ring-primary-500`
- NO floating labels. NO animated placeholders.
- Error states: `border-danger` with `text-sm text-danger mt-1` error message below field
- Submit buttons: `bg-primary-600 text-white px-8 py-3 rounded-sm font-medium hover:bg-primary-700 transition-colors`

#### Tables (Admin & Public)
- Header: `bg-institutional-100 text-institutional-700 font-semibold text-sm uppercase tracking-wider`
- Rows: `border-b border-institutional-200`, hover `bg-institutional-50`
- Striping: Optional, use `even:bg-institutional-50/50`
- NO rounded corners on table container. Sharp edges.

#### Footer
- Background: `bg-institutional-800` or `bg-institutional-900`
- Text: `text-institutional-300` and `text-institutional-400`
- Links: `text-institutional-300 hover:text-white`
- Layout: Multi-column grid, organized by information category
- Bottom bar: `border-t border-institutional-700` with copyright and legal links

### 6.6 Filament Admin Customization
**DO NOT use default Filament purple/indigo theme.**

```php
// app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel {
    return $panel
        ->default()
        ->id('admin')
        ->path('admin')
        ->login()
        ->colors([
            'primary' => Color::hex('#3d60a1'),    // Navy Blue
            'danger' => Color::hex('#9b2c2c'),
            'warning' => Color::hex('#c05621'),
            'success' => Color::hex('#2f855a'),
            'info' => Color::hex('#2b6cb0'),
            'gray' => Color::hex('#868e96'),
        ])
        ->font('Inter')
        ->brandName(fn () => settings('site_name', 'PPID Portal'))
        ->brandLogo(fn () => settings('logo_url'))
        ->brandLogoHeight('2rem')
        ->favicon(fn () => settings('favicon_url'))
        ->sidebarCollapsibleOnDesktop()
        ->navigationGroups([
            'Content Management',
            'Document & Information',
            'Complaint & Response',
            'System & Users',
            'Reports & Analytics',
        ])
        ->middleware([
            // Custom middleware for audit logging
        ]);
}
```

**Filament Table Customization:**
- Striped rows: `->striped()`
- No rounded corners on table: Custom CSS override
- Compact density for data-heavy resources: `->defaultPaginationPageOption(25)`
- Actions: Icon buttons with tooltip text, NO text buttons in row actions (save space)

---

## 7. Coding Standards & Conventions

### 7.1 PHP / Laravel Standards
- Follow **PSR-12** coding standards.
- Use **PHP 8.3+ features:** named arguments, match expressions, readonly properties, enums.
- **Strict typing:** Declare `declare(strict_types=1);` at the top of every PHP file.
- **Class ordering:** Constants, traits, properties, constructor, public methods, protected methods, private methods.
- **Method naming:** `camelCase` for methods, `PascalCase` for classes, `SCREAMING_SNAKE_CASE` for constants.
- **Variable naming:** Descriptive. `$complaintTrackingCode` not `$code`. `$officialLetterPdfPath` not `$path`.

### 7.2 Repository Pattern (Mandatory for Complex Logic)
For Document, Complaint, Letter, and Report domains, use Repository pattern:

```php
// app/Repositories/Contracts/ComplaintRepositoryInterface.php
interface ComplaintRepositoryInterface {
    public function findByTrackingCode(string $code): ?Complaint;
    public function createWithMedia(array $data, array $files): Complaint;
    public function updateStatus(Complaint $complaint, string $status, ?User $processor = null): Complaint;
    public function getPendingCount(): int;
    public function getStatsByPeriod(DateTime $start, DateTime $end): Collection;
}

// app/Repositories/Eloquent/ComplaintRepository.php
class ComplaintRepository implements ComplaintRepositoryInterface {
    public function __construct(private Complaint $model) {}
    // Implementation...
}

// app/Providers/RepositoryServiceProvider.php
public function register(): void {
    $this->app->bind(ComplaintRepositoryInterface::class, ComplaintRepository::class);
}
```

### 7.3 Service Classes
Encapsulate business logic in service classes:
- `App\Services\ComplaintService` - Complaint submission, status workflow, notification triggers
- `App\Services\DocumentService` - Document CRUD, category management, download tracking
- `App\Services\LetterPdfService` - PDF generation, template rendering, signature stamping
- `App\Services\SignatureService` - Digital signature logic, coordinate mapping, verification
- `App\Services\NotificationService` - Email notifications, SMS (if applicable), in-app alerts
- `App\Services\TrackingCodeService` - Secure tracking code generation

### 7.4 Livewire Component Standards
- **Atomic Components:** Each component handles ONE concern. Break large forms into steps or sub-components.
- **Reactive Updates:** Use `$this->dispatch()` and `wire:model.live` judiciously. Debounce text inputs (`wire:model.debounce.300ms`).
- **Validation:** Define `$rules` property. Use `validate()` in methods. NEVER validate in render().
- **File Uploads:** Use `WithFileUploads` trait. Temporary uploads MUST be cleaned up. Use `delete()` on temporary files.
- **Security:** Authorize in `mount()` or via middleware. Complaint detail components MUST verify ownership or role.
- **Performance:** Use pagination. Cache expensive queries. Use `shouldRender()` sparingly.

```php
// Example Livewire Component Structure
namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ComplaintService;

class ComplaintForm extends Component {
    use WithFileUploads;

    public string $complainantName = '';
    public string $complainantEmail = '';
    public $ktpFile;

    protected array $rules = [
        'complainantName' => ['required', 'string', 'max:100'],
        'complainantEmail' => ['required', 'email'],
        'ktpFile' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
    ];

    public function submit(ComplaintService $service): void {
        $validated = $this->validate();
        $complaint = $service->create($validated, $this->ktpFile);
        $this->dispatch('complaint-submitted', trackingCode: $complaint->tracking_code);
    }
}
```

### 7.5 Filament Resource Standards
- **Form Schema:** Use `Section` and `Grid` to organize fields logically. Group related fields.
- **Table Columns:** Use `TextColumn`, `BadgeColumn`, `IconColumn` appropriately. Add `searchable()` and `sortable()` where relevant.
- **Filters:** Always add `TrashedFilter` if soft deletes enabled. Add custom filters for status, date ranges, categories.
- **Actions:** Use `Action::make()` for custom row actions. Group bulk actions logically.
- **Widgets:** Create dashboard widgets for: Pending Complaints Count, Documents by Category Chart, Recent Complaints Table, Monthly Submission Chart.

### 7.6 Route & Controller Standards
- **Public Routes:** Use route model binding with explicit slugs. Cache routes in production.
- **Document Downloads:** Use signed URLs for sensitive documents.
```php
Route::get('/documents/{document:slug}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/{document:slug}/download', [DocumentController::class, 'download'])
    ->middleware('throttle:10,1')
    ->name('documents.download');
Route::get('/complaints/track', [ComplaintController::class, 'track'])->name('complaints.track');
```
- **Protected Routes:** All admin routes under `/admin` are protected by Filament auth middleware.
- **Signed URLs:** For complaint detail access by complainant (email links):
```php
URL::signedRoute('complaints.show', ['complaint' => $complaint], now()->addMinutes(30));
```

### 7.7 Security Standards
- **SQL Injection:** Use Eloquent or Query Builder. NEVER raw SQL with user input.
- **XSS Prevention:** Use `{{ }}` (escaped) in Blade by default. Use `{!! !!}` ONLY for trusted HTML (letter templates, CMS content with Purifier).
- **CSRF:** Livewire and Filament handle this automatically. For custom forms, include `@csrf`.
- **File Uploads:**
  - Store outside web root OR use `.htaccess` / nginx deny rules for `storage/app/private`.
  - Validate MIME type server-side using `mimeType` rule or `getMimeType()`.
  - Randomize filenames: `Str::uuid()->toString() . '.' . $extension`.
  - Scan with ClamAV if available (optional but recommended).
- **Rate Limiting:** Apply to complaint submission (5 per hour per IP), login attempts, and document downloads.
- **Encryption:** Encrypt sensitive database fields if required by regulation (e.g., complainant phone/address can be encrypted at application level using Laravel's encryption).

### 7.8 Blade View Standards
- **Component-Based:** Create Blade components for reusable UI: `<x-document-card>`, `<x-complaint-timeline>`, `<x-section-heading>`.
- **Layout:** Use a single `layouts/public.blade.php` with sections (`@yield('content')`, `@section('meta')`).
- **No Logic:** Minimal PHP logic in views. Use View Composers for shared data (settings, menus).
- **SEO:** Every page MUST have dynamic `<title>`, `<meta name="description">`, Open Graph tags populated from CMS settings or model data.

---

## 8. File Structure & Naming Conventions

```
app/
+-- Console/Commands/           # Custom artisan commands (e.g., cleanup temp uploads)
+-- Enums/                      # PHP 8.1+ Enums
|   +-- ComplaintStatus.php
|   +-- DocumentCategoryType.php
|   +-- LetterStatus.php
|   +-- UserRole.php
+-- Helpers/                    # Helper functions (settings(), format_date(), etc.)
+-- Http/
|   +-- Controllers/
|   |   +-- Public/             # Public portal controllers
|   |   |   +-- HomeController.php
|   |   |   +-- DocumentController.php
|   |   |   +-- ComplaintController.php
|   |   |   +-- PageController.php
|   |   +-- Auth/               # Custom auth if extending beyond Filament
|   +-- Middleware/
|   |   +-- TrackDocumentDownload.php
|   |   +-- ObfuscateFilePath.php
|   +-- Requests/               # Form Request classes for public forms
+-- Livewire/
|   +-- Public/                 # Public Livewire components
|   |   +-- ComplaintForm.php
|   |   +-- ComplaintTracker.php
|   |   +-- DocumentSearch.php
|   |   +-- NewsList.php
|   +-- Admin/                  # Admin-specific Livewire (if needed beyond Filament)
+-- Models/
|   +-- Concerns/               # Traits (HasTrackingCode, HasMediaCollection, etc.)
|   +-- Category.php
|   +-- Complaint.php
|   +-- Document.php
|   +-- Letter.php
|   +-- LetterTemplate.php
|   +-- Menu.php
|   +-- Page.php
|   +-- Setting.php
|   +-- User.php
+-- Providers/
|   +-- AppServiceProvider.php
|   +-- AuthServiceProvider.php
|   +-- EventServiceProvider.php
|   +-- Filament/               # Filament panel providers
|   |   +-- AdminPanelProvider.php
|   +-- RepositoryServiceProvider.php
+-- Repositories/
|   +-- Contracts/              # Interfaces
|   +-- Eloquent/               # Implementations
+-- Services/
|   +-- ComplaintService.php
|   +-- DocumentService.php
|   +-- LetterPdfService.php
|   +-- NotificationService.php
|   +-- SignatureService.php
|   +-- TrackingCodeService.php
+-- View/
    +-- Components/               # Blade components

bootstrap/
config/
database/
+-- factories/
+-- migrations/                   # Organized by date, descriptive names
+-- seeders/
    +-- RolePermissionSeeder.php
    +-- DefaultSettingSeeder.php
    +-- DemoDataSeeder.php

resources/
+-- css/
|   +-- filament/                 # Filament custom theme overrides
|   |   +-- theme.css
|   +-- public/                   # Public portal Tailwind entry
|       +-- app.css
+-- js/
|   +-- public/
|       +-- app.js                # Minimal JS, Alpine.js if needed
+-- views/
|   +-- components/               # Blade components
|   |   +-- document-card.blade.php
|   |   +-- complaint-timeline.blade.php
|   |   +-- section-heading.blade.php
|   |   +-- ui/
|   |       +-- button.blade.php
|   |       +-- input.blade.php
|   +-- layouts/
|   |   +-- public.blade.php      # Main public layout
|   +-- livewire/
|   |   +-- public/
|   |   |   +-- complaint-form.blade.php
|   |   |   +-- complaint-tracker.blade.php
|   |   |   +-- document-search.blade.php
|   |   +-- admin/                # If custom admin Livewire views needed
|   +-- pdf/
|   |   +-- letter.blade.php      # PDF template base
|   +-- pages/                    # Static-ish pages (if not CMS-driven)

routes/
+-- web.php                       # Public routes
+-- admin.php                     # Filament handles its own, but custom admin routes here

storage/
+-- app/
|   +-- public/                   # Public documents (symlinked)
|   +-- private/                  # Complaint attachments, KTP, signed letters
+-- logs/

tests/
+-- Feature/
|   +-- PublicPortalTest.php
|   +-- ComplaintWorkflowTest.php
|   +-- DocumentManagementTest.php
|   +-- LetterGenerationTest.php
+-- Unit/
    +-- Services/
    +-- Repositories/
```

---

## 9. Asset & Build Configuration

### 9.1 Tailwind Config (Public Portal)
```javascript
// tailwind.config.js
module.exports = {
    content: [
        './resources/views/**/*.blade.php',
        './resources/views/**/*.html',
        './app/Livewire/**/*.php',
        './app/View/Components/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                institutional: {
                    50: '#f8f9fa',
                    100: '#f1f3f5',
                    200: '#e9ecef',
                    300: '#dee2e6',
                    400: '#adb5bd',
                    500: '#868e96',
                    600: '#495057',
                    700: '#343a40',
                    800: '#212529',
                    900: '#121214',
                },
                primary: {
                    DEFAULT: '#3d60a1',
                    50: '#e7ecf3',
                    100: '#c5d0e3',
                    200: '#9eb0d0',
                    300: '#7790bd',
                    400: '#5a78af',
                    500: '#3d60a1',
                    600: '#355895',
                    700: '#2d4e87',
                    800: '#264479',
                    900: '#1a3261',
                },
                accent: {
                    DEFAULT: '#7b1f3f',
                    light: '#a84565',
                    dark: '#52152a',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                display: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
            },
            spacing: {
                '18': '4.5rem',
                '22': '5.5rem',
            },
            borderRadius: {
                'sm': '2px',
                'DEFAULT': '4px',
                'md': '6px',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
```

### 9.2 Vite Configuration
```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/public/app.css',
                'resources/js/public/app.js',
                'resources/css/filament/theme.css',
            ],
            refresh: true,
        }),
    ],
});
```

---

## 10. Testing & Quality Assurance

### 10.1 Testing Requirements
- **Feature Tests:** Every user-facing workflow MUST have feature tests:
  - Complaint submission (valid, invalid, file upload, rate limiting)
  - Document download (public, signed URL, counter increment)
  - Letter generation (template rendering, PDF creation, signature stamping)
  - Admin CRUD for all Filament resources
  - Role-based access control (each role can/cannot access specific actions)
- **Unit Tests:** Service classes, repository classes, helper functions.
- **Browser Tests:** Optional, but recommended for complaint form and PDF preview workflows using Laravel Dusk.

### 10.2 Code Quality Tools
```bash
# Static Analysis
composer require --dev larastan/larastan
./vendor/bin/phpstan analyse --memory-limit=1G

# Linting
composer require --dev laravel/pint
./vendor/bin/pint

# Security
composer require --dev enlightn/security-checker
```

### 10.3 Performance Benchmarks
- Page load (public): < 2 seconds (TTFB < 500ms)
- Filament admin table (1000 rows): < 1 second
- PDF generation (single page): < 5 seconds (queue if > 3 seconds)
- Complaint form submission: < 3 seconds including file upload

---

## 11. Compliance & Legal Considerations

### 11.1 Data Privacy
- KTP uploads and personal data MUST be handled per UU Perlindungan Data Pribadi (PDP Law).
- Implement data retention policies: Auto-archive or anonymize complaints after 5 years.
- Provide data export (PDF/Excel) for complainants upon request.
- Display privacy policy and terms of use on complaint form.

### 11.2 Accessibility (WCAG 2.1 AA)
- All images MUST have descriptive `alt` text (managed via CMS).
- Form fields MUST have associated `<label>` elements.
- Color contrast MUST meet 4.5:1 for normal text, 3:1 for large text.
- Keyboard navigation MUST work for all interactive elements.
- Focus indicators MUST be visible (use `ring-2 ring-primary-500 ring-offset-2`).
- Screen reader announcements for Livewire dynamic updates (`aria-live` regions).

### 11.3 Audit Trail
- Log ALL actions on complaints and letters: who viewed, who changed status, who signed, when.
- Log ALL document uploads and deletions.
- Use Spatie ActivityLog with `causer` and `subject` relationships.
- Provide read-only audit log view in Filament for Super Admin.

---

## 12. AI Code Generation Checklist

Before generating ANY code for this project, verify against this checklist:

- [ ] **No hardcoded text** in views. All strings from CMS settings or models.
- [ ] **No default purple/indigo** colors. Use institutional navy/maroon palette.
- [ ] **No rounded-xl cards or buttons.** Maximum `rounded-sm` (2px) or sharp corners.
- [ ] **No drop shadows** on cards. Use borders for separation.
- [ ] **No gradient backgrounds** (except very subtle hero overlays). Solid colors only.
- [ ] **Repository pattern** used for Document, Complaint, Letter services.
- [ ] **Spatie Media Library** used for ALL file attachments. No raw `Storage::put()`.
- [ ] **Signed URLs** for ALL confidential file access (KTP, letters, attachments).
- [ ] **Role-based authorization** enforced on every Filament resource action.
- [ ] **Validation rules** defined explicitly. Never trust user input.
- [ ] **Activity logging** added for status changes, signatures, and deletions.
- [ ] **Filament Shield** permissions configured for each new resource.
- [ ] **Tailwind config** extended with institutional colors, not inline arbitrary values.
- [ ] **Accessibility** considered: labels, alt text, contrast, keyboard nav, ARIA.
- [ ] **Rate limiting** applied to public forms and downloads.
- [ ] **Soft deletes** enabled on critical models with `TrashedFilter` in Filament.
- [ ] **PHP 8.3+ features** used: enums, readonly properties, match expressions.
- [ ] **Strict types** declared in every PHP file.

---

## 13. Example Code Patterns

### 13.1 Filament Resource: DocumentResource (Minimal Example)
```php
namespace App\Filament\Resources;

use App\Models\Document;
use App\Filament\Resources\DocumentResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DocumentResource extends Resource {
    protected static ?string $model = Document::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Document & Information';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form {
        return $form->schema([
            Forms\Components\Section::make('Document Information')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name', fn (Builder $query) => $query->where('type', 'informasi_publik'))
                        ->required(),
                    Forms\Components\RichEditor::make('description')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\SpatieMediaLibraryFileUpload::make('document_file')
                        ->collection('documents')
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(51200)
                        ->required(),
                    Forms\Components\DatePicker::make('published_at')
                        ->required()
                        ->default(now()),
                    Forms\Components\DatePicker::make('expired_at'),
                    Forms\Components\Toggle::make('is_active')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Informasi Berkala' => 'primary',
                        'Informasi Serta Merta' => 'warning',
                        'Informasi Setiap Saat' => 'success',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('download_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc')
            ->striped();
    }

    public static function getPages(): array {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder {
        return parent::getEloquentQuery()->withoutGlobalScopes();
    }
}
```

### 13.2 Livewire Component: ComplaintForm (Minimal Example)
```php
namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\ComplaintService;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;

class ComplaintForm extends Component {
    use WithFileUploads;

    public int $currentStep = 1;
    public string $complainantName = '';
    public string $complainantEmail = '';
    public string $complainantPhone = '';
    public string $complainantAddress = '';
    public $ktpFile;
    public string $category = 'permohonan_informasi';
    public string $subject = '';
    public string $description = '';
    public $attachments = [];
    public string $captchaResponse = '';
    public bool $agreedToTerms = false;

    public ?string $trackingCode = null;
    public bool $submitted = false;

    protected function rules(): array {
        return [
            'complainantName' => ['required', 'string', 'max:100'],
            'complainantEmail' => ['required', 'email'],
            'complainantPhone' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'complainantAddress' => ['required', 'string', 'max:500'],
            'ktpFile' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,png'],
            'category' => ['required', 'in:permohonan_informasi,pengaduan,saran'],
            'subject' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'min:50', 'max:5000'],
            'attachments.*' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,doc,docx'],
            'agreedToTerms' => ['accepted'],
        ];
    }

    public function submit(ComplaintService $service): void {
        $executed = RateLimiter::attempt(
            'submit-complaint:' . request()->ip(),
            5,
            function () use ($service) {
                $validated = $this->validate();
                $complaint = $service->create($validated, $this->ktpFile, $this->attachments);
                $this->trackingCode = $complaint->tracking_code;
                $this->submitted = true;
                $this->dispatch('complaint-submitted');
            },
            3600
        );

        if (! $executed) {
            $this->addError('rate_limit', 'Terlalu banyak pengiriman. Silakan coba lagi dalam 1 jam.');
        }
    }

    public function render() {
        return view('livewire.public.complaint-form');
    }
}
```

### 13.3 Service: ComplaintService (Minimal Example)
```php
namespace App\Services;

use App\Models\Complaint;
use App\Repositories\Contracts\ComplaintRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ComplaintService {
    public function __construct(
        private ComplaintRepositoryInterface $repository,
        private NotificationService $notificationService,
        private TrackingCodeService $trackingCodeService,
    ) {}

    public function create(array $data, $ktpFile, array $attachments = []): Complaint {
        return DB::transaction(function () use ($data, $ktpFile, $attachments) {
            $trackingCode = $this->trackingCodeService->generate();

            $complaint = $this->repository->create([
                'tracking_code' => $trackingCode,
                'complainant_name' => $data['complainantName'],
                'complainant_email' => $data['complainantEmail'],
                'complainant_phone' => $data['complainantPhone'],
                'complainant_address' => $data['complainantAddress'],
                'category' => $data['category'],
                'subject' => $data['subject'],
                'description' => $data['description'],
                'status' => 'pending',
                'submitted_at' => now(),
            ]);

            // Store KTP securely
            $complaint->addMedia($ktpFile->getRealPath())
                ->usingFileName(Str::uuid() . '.' . $ktpFile->getClientOriginalExtension())
                ->toMediaCollection('ktp', 'private_uploads');

            // Store attachments
            foreach ($attachments as $attachment) {
                $complaint->addMedia($attachment->getRealPath())
                    ->usingFileName(Str::uuid() . '.' . $attachment->getClientOriginalExtension())
                    ->toMediaCollection('attachments', 'private_uploads');
            }

            // Send confirmation
            $this->notificationService->sendComplaintConfirmation($complaint);

            return $complaint;
        });
    }
}
```

---

## 14. Deployment & Environment Configuration

### 14.1 Environment Variables
```env
APP_NAME="PPID Portal"
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=ppid_portal
DB_USERNAME=ppid_user
DB_PASSWORD=secure_random_password

FILAMENT_PATH=admin
FILAMENT_BRAND_NAME="PPID Admin"

MEDIA_DISK=private_uploads
DOCUMENT_DISK=public_documents

# PDF Generation
PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser
DOMPDF_ENABLE_REMOTE=true

# Email
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_ENCRYPTION=tls

# Queue (REQUIRED for PDF generation and notifications)
QUEUE_CONNECTION=redis

# Cache
CACHE_DRIVER=redis

# Security
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=strict
SANCTUM_STATEFUL_DOMAINS=ppid.yourdomain.go.id

# reCAPTCHA
RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key
```

### 14.2 Server Requirements
- PHP 8.3+ with extensions: `gd`, `imagick`, `exif`, `zip`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `curl`, `fileinfo`
- Node.js 20+ and NPM for asset building
- Redis for queue and cache
- Chromium/Puppeteer for Browsershot PDF generation
- MySQL 8.0+ or PostgreSQL 15+
- Web server: Nginx (preferred) or Apache
- SSL certificate (mandatory for signed URLs and file security)

### 14.3 Post-Deployment Checklist
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan db:seed --class=RolePermissionSeeder`
- [ ] Run `php artisan db:seed --class=DefaultSettingSeeder`
- [ ] Run `php artisan storage:link` (for public disk)
- [ ] Configure cron for `php artisan schedule:run` (every minute)
- [ ] Start queue workers: `php artisan queue:work --sleep=3 --tries=3`
- [ ] Set proper file permissions (`chmod -R 775 storage bootstrap/cache`)
- [ ] Configure Nginx to deny access to `storage/app/private/`
- [ ] Enable and test rate limiters
- [ ] Verify email sending (SMTP or local mail driver)
- [ ] Run `php artisan optimize` (route cache, config cache, view cache)

---

## 15. Maintenance & Future Extensibility

### 15.1 Versioning Strategy
- Use semantic versioning for the application (e.g., `v1.2.3`).
- Tag releases in Git.
- Maintain a `CHANGELOG.md` documenting features, fixes, and breaking changes.

### 15.2 Extensibility Points
- **Multi-language:** Spatie Translatable is pre-configured. Add `HasTranslations` trait to models and configure Filament translatable forms.
- **API Mobile App:** Laravel Sanctum is recommended for future mobile app integration. Structure controllers under `Api/V1/` namespace.
- **Advanced Analytics:** Integrate Filament chart widgets or external analytics (Matomo) for public portal tracking.
- **TTE Integration:** The `SignatureService` interface allows swapping canvas/image signatures with official BSrE or similar certificate-based signatures.
- **Workflow Engine:** If complaint approval workflows become complex, consider integrating `spatie/laravel-model-states` or a simple state machine pattern.

### 15.3 Backup Strategy
- Database: Daily automated backups (mysqldump/pg_dump) to secure off-site storage.
- Files: Weekly backup of `storage/app/private` and `storage/app/public`.
- Code: Git repository with remote backup (GitHub/GitLab).
- Test restore procedures quarterly.

---

## 16. Final Authority Statement

> **This document is the authoritative specification for all code generation, architectural decisions, UI/UX design, and database modeling for the PPID CMS project.**
>
> Any AI assistant or developer working on this project MUST adhere to these rules without exception. Deviations require explicit written approval from the project owner.
>
> **Key Non-Negotiables:**
> 1. Zero hardcoded content in views.
> 2. Institutional color palette only (no purple/indigo/neon gradients).
> 3. Sharp corners and borders, not heavy rounded cards and shadows.
> 4. Repository pattern for complex domains.
> 5. Spatie Media Library for all file handling.
> 6. Signed URLs for all confidential access.
> 7. Role-based access control on every admin action.
> 8. WCAG 2.1 AA accessibility compliance.
> 9. Audit logging for all critical mutations.
> 10. PHP 8.3+ strict typing in all files.

---

*Document generated for PPID CMS Project. Effective immediately. Version 1.0.0*
