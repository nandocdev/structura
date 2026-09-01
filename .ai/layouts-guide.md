# 📐 Guía de Layouts

**Versión:** 1.0  
**Estado:** Completo con 4 layouts disponibles

---

## 📋 Layouts Disponibles

### 1️⃣ `layouts.app` (App with Sidebar)

**Propósito:** Layout principal con sidebar colapsible y full-featured  
**Archivo:** `resources/views/layouts/app.blade.php`  
**Vista Real:** `resources/views/layouts/app/sidebar.blade.php`

**Características:**
- Sidebar fijo con navegación principal
- Collapsible en mobile
- Header móvil con toggle
- User menu desktop + mobile
- Ideal para dashboards complejos

**Uso:**
```blade
<x-layouts::app.sidebar>
    <flux:heading>Dashboard</flux:heading>
    <!-- Contenido -->
</x-layouts::app.sidebar>
```

**Props:**
- `title` - Título de la página (optional)

---

### 2️⃣ `layouts.app.simple` (App without Sidebar) ✨ NUEVO

**Propósito:** Layout limpio sin sidebar con navbar superior configurable  
**Archivo:** `resources/views/layouts/app/simple.blade.php`

**Características:**
- Sin sidebar (más ancho para contenido)
- Header superior con navbar
- Navbar configurable (on/off)
- User menu desktop + mobile
- Ideal para páginas de contenido o galerías

**Uso Básico:**
```blade
<x-layouts::app.simple>
    <div class="p-6">
        <flux:heading>Contenido sin Sidebar</flux:heading>
    </div>
</x-layouts::app.simple>
```

**Desabilitar Navbar:**
```blade
<x-layouts::app.simple :showHeader="false">
    <!-- Full page sin header -->
</x-layouts::app.simple>
```

**Props:**
- `showHeader` - Mostrar/ocultar navbar (default: true)
- `title` - Título de la página (optional)

---

### 3️⃣ `layouts.app.centered` (App with Centered Container) ✨ NUEVO

**Propósito:** Layout centrado para formularios o dashboards estrechos  
**Archivo:** `resources/views/layouts/app/centered.blade.php`

**Características:**
- Contenido centrado y ancho máximo (max-w-4xl)
- Header superior configurable
- Perfecto para formularios, perfiles, cards
- Padding responsive
- Mantiene user menu

**Uso Básico:**
```blade
<x-layouts::app.centered>
    <livewire:user-module.components.card
        title="User Profile"
        description="Edit your information"
    >
        <!-- Form content -->
    </livewire:user-module.components.card>
</x-layouts::app.centered>
```

**Desabilitar Navbar:**
```blade
<x-layouts::app.centered :showHeader="false">
    <!-- Contenido centrado, sin header -->
</x-layouts::app.centered>
```

**Props:**
- `showHeader` - Mostrar/ocultar navbar (default: true)
- `title` - Título de la página (optional)

---

### 4️⃣ `layouts.auth` (Auth Simple)

**Propósito:** Layout simple para páginas de autenticación  
**Archivo:** `resources/views/layouts/auth.blade.php`  
**Vista Real:** `resources/views/layouts/auth/simple.blade.php`

**Características:**
- Centrado y minimalista
- Sin navbar ni usuario logueado
- Ideal para login, registro, password reset
- Diseño limpio y enfocado

**Uso:**
```blade
<x-layouts::auth.simple>
    <x-auth-header
        title="Sign In"
        description="Welcome back"
    />
    <!-- Form content -->
</x-layouts::auth.simple>
```

**Props:**
- `title` - Título de la página (optional)

---

## 🎯 Matriz de Selección

| Caso de Uso              | Layout Recomendado | Props               |
| ------------------------ | ------------------ | ------------------- |
| Dashboard con navegación | `app.sidebar`      | -                   |
| Blog/Content pages       | `app.simple`       | `showHeader: true`  |
| Fullscreen page          | `app.simple`       | `showHeader: false` |
| Formularios              | `app.centered`     | `showHeader: true`  |
| Perfil usuario           | `app.centered`     | `showHeader: true`  |
| Login/Register           | `auth.simple`      | -                   |
| Modal content            | `app.centered`     | `showHeader: false` |

---

## 📝 Ejemplos de Uso

### Página de Perfil

```blade
<x-layouts::app.centered :showHeader="true">
    <livewire:user-module.components.breadcrumbs-nav
        :breadcrumbs="[
            ['label' => 'Dashboard', 'href' => route('dashboard')],
            ['label' => 'Profile', 'active' => true],
        ]"
    />

    <livewire:user-module.components.card
        title="My Profile"
        description="Edit your personal information"
    >
        <!-- Form fields -->
    </livewire:user-module.components.card>
</x-layouts::app.centered>
```

### Galería de Contenido

```blade
<x-layouts::app.simple :showHeader="true">
    <div class="p-6">
        <flux:heading level="1">Content Gallery</flux:heading>

        <div class="grid md:grid-cols-3 gap-6 mt-6">
            @foreach ($items as $item)
                <livewire:user-module.components.card
                    :title="$item->title"
                    :key="'card-'.$item->id"
                >
                    <!-- Item content -->
                </livewire:user-module.components.card>
            @endforeach
        </div>
    </div>
</x-layouts::app.simple>
```

### Fullscreen Sin Header

```blade
<x-layouts::app.simple :showHeader="false">
    <div class="w-full h-screen flex items-center justify-center">
        <div class="text-center">
            <flux:heading>Wellcome to the App</flux:heading>
            <flux:text>Full screen mode, no header</flux:text>
        </div>
    </div>
</x-layouts::app.simple>
```

### Formulario Centrado

```blade
<x-layouts::app.centered :showHeader="true">
    <livewire:user-module.components.card
        title="Create New Project"
        description="Start a new project"
    >
        <form wire:submit="save" class="space-y-6">
            <livewire:user-module.components.select-field
                model="category_id"
                label="Category"
                :options="$categories"
                required
            />

            <flux:input
                wire:model="name"
                label="Project Name"
                type="text"
                required
            />

            <flux:button type="submit">Create Project</flux:button>
        </form>
    </livewire:user-module.components.card>
</x-layouts::app.centered>
```

---

## 🔧 Configuración

### Componentes Comunes

Todos los layouts app incluyen:
- Logo y nombre de app en header (si showHeader=true)
- User menu dropdown (desktop)
- User menu mobile (mobile)
- Toast notifications
- Flux scripts

### Navbar Height

- Desktop: 65px (h-16)
- Mobile: 65px (h-16)
- Contenido main: `min-h-[calc(100vh-65px)]`

### Responsive Behavior

- **Mobile (<768px):** Oculta desktop menu, muestra mobile dropdown
- **Desktop (≥768px):** Oculta toggle, muestra desktop menu

---

## 📚 Componentes Compatibles

Todos los layouts funcionan con:
- ✅ Componentes Flux UI (buttons, inputs, cards, etc.)
- ✅ Componentes Sprint 1 (SelectField, Checkbox, Switch, Badge, Table)
- ✅ Componentes Sprint 2 (Card, Callout, Skeleton, Breadcrumbs, Pagination)
- ✅ Livewire components
- ✅ Forms y validaciones

---

## 🚀 Próximas Mejoras

- [ ] Layout con sidebar derecho
- [ ] Layout con drawer modal
- [ ] Layout con breadcrumbs automáticos
- [ ] Temas personalizables (light/dark)
- [ ] Layout con tabs horizontales
