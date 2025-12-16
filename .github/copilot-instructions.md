# Copilot Instructions for Irina Sarmiento Codebase

## Project Overview

This is a **Laravel 12 + Vue 3 + Inertia.js** full-stack application with a focus on modern frontend architecture and server-side rendering (SSR).

- **Backend**: Laravel 12 with Fortify (authentication), Wayfinder (API-driven navigation)
- **Frontend**: Vue 3 + TypeScript, Inertia.js for seamless server-client integration
- **Build System**: Vite with Tailwind CSS and TypeScript compilation
- **Testing**: Pest (PHP), with Inertia testing support
- **Auth**: Laravel Fortify with two-factor authentication support

## Architecture Patterns

### Inertia.js Data Flow

Pages are rendered via `Inertia::render()` from Laravel controllers:

```php
// routes/web.php
Route::get('dashboard', function () {
    return Inertia::render('Dashboard', ['prop' => 'value']);
})->middleware(['auth', 'verified'])->name('dashboard');
```

Vue components receive props and render automatically. **No separate API layer is needed** for basic operations—use `@inertiajs/vue3` helpers like `router.post()` or `router.put()` for form submissions.

### Layout System

- **AuthLayout**: Minimal layout for login/register pages (resources/js/layouts/auth/)
- **AppLayout**: Authenticated sidebar layout with breadcrumbs (resources/js/layouts/app/)
- **GuestLayout**: Public pages like home/welcome

Layouts wrap page content via component composition, not route-level middleware.

### State Management (Pinia)

Stores use Pinia for global state. Key stores:

- `useAppStore`: Application-wide state
- `useAdminNavigationStore`: Admin sidebar navigation with links and drawer state
- `usePublicNavigationStore`: Public site navigation
- `useServicesStore`: Services data
- `useBlogStore`, `useProjectsStore`: Content stores

**Pattern**: Stores use `defineStore` with `state`, `getters`, and `actions`. Access via `const store = useAppStore()`.

### Component Structure

Components organized by type:

- **UI Components** (`components/ui/`): Reusable reka-ui/shadcn-style components (buttons, inputs, etc.)
- **Page-Specific** (`pages/`): Full page components that render via Inertia
- **Section Components** (`components/Sections/`): Reusable page sections
- **Layouts** (`layouts/`): Page wrappers with headers/sidebars

### Styling

- **Tailwind CSS 4** with custom plugins (`@tailwindcss/vite`)
- **Asset aliases**: `@` → `resources/js`, `@images` → `resources/images`
- Component-scoped styles use Tailwind classes; avoid scoped CSS unless necessary

### Icon System

FontAwesome is pre-configured:

- Solid icons imported in `resources/js/app.ts`
- Register icons in the library: `library.add(faIcon)`
- Use: `<FontAwesomeIcon icon="icon-name" />`

Also available: Material Design Icons (`@mdi/font`), Lucide Vue Next

## Development Workflows

### Setup

```bash
composer install
npm install
php artisan key:generate
php artisan migrate
npm run build
```

### Running Locally

**With SSR** (server-side rendering):

```bash
npm run dev:ssr
```

This starts: Laravel serve, queue listener, SSR server, and logs in parallel.

**Without SSR**:

```bash
npm run dev
```

Runs: Laravel serve, queue listener, Vite dev server.

### Build & Deploy

```bash
npm run build        # Production Vite build
npm run build:ssr    # Build with SSR manifest
```

The built assets go to `public/build/` and are auto-versioned by Vite.

### Testing

**Pest** (PHP):

```bash
php artisan test                # Run all tests
php artisan test tests/Feature  # Run feature tests
```

Tests use `Illuminate\Foundation\Testing\RefreshDatabase` trait for test isolation. Inertia assertions: `assertInertia()` checks props passed to pages.

### Code Style

- **PHP**: Laravel Pint (auto-fixer included)
- **JavaScript/TypeScript**: ESLint with TypeScript config + Prettier (formats imports, Tailwind order)
- **Format command**: `npm run format` (or `--check` to validate)

## Critical Conventions

### Routes & Naming

- Routes defined in `routes/web.php` with named routes: `->name('dashboard')`
- Settings routes in `routes/settings.php` (included in web.php)
- Named routes enable type-safe Inertia navigation: `router.visit(route('dashboard'))`

### Authentication Middleware

Fortify provides built-in guards:

- Use `auth` middleware for authenticated-only routes
- Use `verified` for email-verified users
- Two-factor auth is transparent (Fortify handles the flow)

**Fortify Configuration**: `config/fortify.php` (e.g., username field, features like 2FA)

### Migrations

Located in `database/migrations/`. Naming: timestamp + descriptor (e.g., `2025_08_14_170933_add_two_factor_columns_to_users_table.php`).

Run: `php artisan migrate` (uses `.env` DB config)

### Controllers

Minimal—just return Inertia renders. Business logic goes in Laravel models or form requests (`app/Http/Requests/`).

### Composables

Custom composables in `resources/js/composables/`:

- `useAppearance`: Theme initialization (dark/light mode)
- `useTwoFactorAuth`: 2FA setup/recovery
- `useGlobalMessage`: Toast/alert notifications
- `useInitials`: Helper for avatar initials

### Form Requests

Located in `app/Http/Requests/`. Use for validation—Laravel validates automatically and Inertia returns errors as props.

## Key Dependencies

- **@inertiajs/vue3**: Server-client bridge
- **pinia**: State management
- **@fortawesome/vue-fontawesome**: Icons
- **reka-ui**: Headless component library
- **lucide-vue-next**: Icon library alternative
- **sweetalert2**: Modal dialogs
- **laravel/wayfinder**: API-driven navigation (used in navigation stores)

## Quick Debugging

- **Inertia Inspector**: Browser devtools shows props/components
- **Pail** (Laravel logs): `php artisan pail` streams logs in real-time
- **SSR Issues**: Check `http://127.0.0.1:13714` (SSR server URL in `config/inertia.php`)
- **TypeScript Errors**: Run `vue-tsc --noEmit` to check without compilation

## Common Tasks

**Add a new page**:

1. Create component in `resources/js/pages/Example.vue`
2. Add route in `routes/web.php`: `Route::get('/example', fn() => Inertia::render('Example'))`

**Add state to Pinia**:

1. Create store: `resources/js/stores/useExampleStore.ts`
2. Use in component: `const store = useExampleStore()`

**Add a form**:

1. Create form request: `app/Http/Requests/ExampleRequest.php`
2. Submit via Inertia: `router.post('/example', formData)`
3. Handle validation errors in template

**Modify navigation**:

- Update `resources/js/stores/useAdminNavigationStore.ts` or `usePublicNavigationStore.ts`
- Data flows to navigation components via store getters
