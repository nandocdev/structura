# 🎨 Sprint 2 - Componentes Importantes Flux UI

**Estado:** ✅ Implementados y Testeados (21/21 tests)  
**Ubicación:** `app/Modules/UserModule/Livewire/Components/`  
**Vistas:** `resources/views/livewire/user-module/components/`

---

## 📋 Componentes Implementados

### 1️⃣ Card Component

**Propósito:** Contenedor flexible para agrupar y presentar contenido

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/Card.php](app/Modules/UserModule/Livewire/Components/Card.php)
- Vista: `resources/views/livewire/user-module/components/card.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.card
    title="Dashboard Statistics"
    description="Key metrics for this month"
>
    <div class="grid grid-cols-3 gap-4">
        <div>
            <span class="text-2xl font-bold">42</span>
            <p class="text-sm text-zinc-600">New Users</p>
        </div>
        <div>
            <span class="text-2xl font-bold">$1,234</span>
            <p class="text-sm text-zinc-600">Revenue</p>
        </div>
        <div>
            <span class="text-2xl font-bold">156</span>
            <p class="text-sm text-zinc-600">Orders</p>
        </div>
    </div>
</livewire:user-module.components.card>
```

### Propiedades

| Propiedad     | Tipo   | Descripción                     |
| ------------- | ------ | ------------------------------- |
| `title`       | string | Título del card                 |
| `description` | string | Descripción opcional            |
| `padded`      | bool   | Agregar padding (defecto: true) |
| `padding`     | string | Tamaño de padding: sm, md, lg   |
| `class`       | string | Clases CSS adicionales          |

### Ejemplo: Grid de Cards

```blade
<div class="grid md:grid-cols-3 gap-6">
    @foreach ($departments as $dept)
        <livewire:user-module.components.card
            :title="$dept->name"
            :description="$dept->description"
            :key="'card-'.$dept->id"
        >
            <div class="space-y-2">
                <p>{{ $dept->employee_count }} employees</p>
                <flux:button size="sm">View Details</flux:button>
            </div>
        </livewire:user-module.components.card>
    @endforeach
</div>
```

---

### 2️⃣ Callout Component

**Propósito:** Alertas y mensajes contextuales con variantes de estilo

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/Callout.php](app/Modules/UserModule/Livewire/Components/Callout.php)
- Vista: `resources/views/livewire/user-module/components/callout.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.callout
    message="Your account has been updated successfully"
    variant="success"
    icon="check-circle"
    title="Success"
/>
```

### Variantes

```php
'info'    => 'Información (icono: information-circle)'
'success' => 'Éxito (icono: check-circle)'
'warning' => 'Advertencia (icono: exclamation-triangle)'
'danger'  => 'Error (icono: x-circle)'
```

### Propiedades

| Propiedad     | Tipo   | Descripción                          |
| ------------- | ------ | ------------------------------------ |
| `message`     | string | Texto del mensaje                    |
| `variant`     | string | Tipo: info, success, warning, danger |
| `icon`        | string | Nombre del icono Heroicons           |
| `title`       | string | Título opcional                      |
| `dismissible` | bool   | Mostrar botón cerrar                 |
| `show`        | bool   | Mostrar/ocultar                      |

### Ejemplo: Callout Descarable

```blade
<livewire:user-module.components.callout
    message="Por favor verifica tu email para confirmar tu cuenta"
    variant="warning"
    title="Email Verification Required"
    dismissible="true"
    icon="envelope"
/>
```

### Ejemplo: Multiple Alerts

```blade
<div class="space-y-4">
    @if ($errors->any())
        <livewire:user-module.components.callout
            message="{{ $errors->first() }}"
            variant="danger"
            title="Error"
            dismissible
        />
    @endif

    @if (session('success'))
        <livewire:user-module.components.callout
            message="{{ session('success') }}"
            variant="success"
            title="Success"
        />
    @endif
</div>
```

---

### 3️⃣ SkeletonLoader Component

**Propósito:** Placeholders animados durante la carga de datos

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/SkeletonLoader.php](app/Modules/UserModule/Livewire/Components/SkeletonLoader.php)
- Vista: `resources/views/livewire/user-module/components/skeleton-loader.blade.php`

### Uso Básico

```blade
<div wire:loading.delay>
    <livewire:user-module.components.skeleton-loader
        count="5"
        height="16"
    />
</div>

<div wire:loading.remove>
    <!-- Tu contenido aquí -->
</div>
```

### Propiedades

| Propiedad  | Tipo   | Descripción                        |
| ---------- | ------ | ---------------------------------- |
| `count`    | int    | Cantidad de skeletons (defecto: 1) |
| `height`   | string | Alto en Tailwind (ej: 12, 16)      |
| `width`    | string | Ancho en Tailwind (defecto: full)  |
| `animated` | bool   | Animar (defecto: true)             |
| `class`    | string | Clases CSS adicionales             |

### Ejemplo: Loading Table

```blade
<div>
    <div wire:loading.delay.shortest>
        <livewire:user-module.components.skeleton-loader
            count="10"
            height="12"
            class="space-y-2"
        />
    </div>

    <div wire:loading.remove>
        <livewire:user-module.components.table-list
            :rows="$users"
            :columns="$columns"
        />
    </div>
</div>
```

### Ejemplo: Custom Heights

```blade
<!-- Texto -->
<livewire:user-module.components.skeleton-loader
    count="1"
    height="4"
/>

<!-- Línea de título -->
<livewire:user-module.components.skeleton-loader
    count="1"
    height="6"
/>

<!-- Bloque grande -->
<livewire:user-module.components.skeleton-loader
    count="1"
    height="32"
/>
```

---

### 4️⃣ BreadcrumbsNav Component

**Propósito:** Navegación jerárquica para mostrar rutas en la aplicación

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/BreadcrumbsNav.php](app/Modules/UserModule/Livewire/Components/BreadcrumbsNav.php)
- Vista: `resources/views/livewire/user-module/components/breadcrumbs-nav.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.breadcrumbs-nav
    :breadcrumbs="[
        ['label' => 'Home', 'href' => route('dashboard'), 'active' => false],
        ['label' => 'Users', 'href' => route('users.index'), 'active' => false],
        ['label' => 'Edit User', 'active' => true],
    ]"
/>
```

### Propiedades

| Propiedad     | Tipo   | Descripción                            |
| ------------- | ------ | -------------------------------------- |
| `breadcrumbs` | array  | Array de migas con label, href, active |
| `separator`   | string | Separador (defecto: /)                 |

### Estructura de Breadcrumbs Array

```php
[
    [
        'label' => 'Dashboard',           // Texto visible
        'href' => route('dashboard'),     // URL (opcional si active=true)
        'active' => false,                // Es la página actual
    ],
    [
        'label' => 'Projects',
        'href' => route('projects.index'),
        'active' => false,
    ],
    [
        'label' => 'Edit Project',
        'active' => true,                 // Última miga (sin enlace)
    ],
]
```

### Ejemplo: En Layout

```blade
<div>
    <livewire:user-module.components.breadcrumbs-nav
        :breadcrumbs="[
            ['label' => 'Dashboard', 'href' => route('dashboard')],
            ['label' => 'Settings', 'href' => route('settings.index')],
            ['label' => 'Security', 'active' => true],
        ]"
    />

    <flux:heading class="mt-4">Security Settings</flux:heading>
    <!-- Contenido aquí -->
</div>
```

### Ejemplo: Dinámico desde Livewire

```php
class ProfileEdit extends Component {
    public function mount(User $user) {
        $this->user = $user;
        $this->breadcrumbs = [
            ['label' => 'Dashboard', 'href' => route('dashboard')],
            ['label' => 'Users', 'href' => route('users.index')],
            ['label' => 'Edit ' . $user->name, 'active' => true],
        ];
    }
}
```

---

### 5️⃣ PaginationNav Component

**Propósito:** Controles de paginación para listas de datos

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/PaginationNav.php](app/Modules/UserModule/Livewire/Components/PaginationNav.php)
- Vista: `resources/views/livewire/user-module/components/pagination-nav.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.pagination-nav
    :paginator="$users"
    alignment="center"
/>
```

### Propiedades

| Propiedad     | Tipo              | Descripción                        |
| ------------- | ----------------- | ---------------------------------- |
| `paginator`   | AbstractPaginator | El paginador de Laravel            |
| `alignment`   | string            | center, start, end                 |
| `queryString` | string            | Parámetro de query (defecto: page) |

### Ejemplo: En Lista

```blade
<div>
    <livewire:user-module.components.table-list
        :rows="$users->items()"
        :columns="$columns"
    />

    <div class="mt-6">
        <livewire:user-module.components.pagination-nav
            :paginator="$users"
            alignment="center"
        />
    </div>
</div>
```

---

## 🎯 Patrones de Uso Combinado

### Página de Listado Completa

```blade
<div class="space-y-6">
    <!-- Breadcrumbs -->
    <livewire:user-module.components.breadcrumbs-nav
        :breadcrumbs="[
            ['label' => 'Dashboard', 'href' => route('dashboard')],
            ['label' => 'Users', 'active' => true],
        ]"
    />

    <!-- Alerta si hay mensaje -->
    @if (session('success'))
        <livewire:user-module.components.callout
            message="{{ session('success') }}"
            variant="success"
            dismissible
        />
    @endif

    <!-- Card contenedor -->
    <livewire:user-module.components.card
        title="Users Management"
        description="Manage system users and permissions"
    >
        <!-- Loading skeleton -->
        <div wire:loading.delay.shortest>
            <livewire:user-module.components.skeleton-loader count="5" />
        </div>

        <!-- Tabla -->
        <div wire:loading.remove>
            <livewire:user-module.components.table-list
                :rows="$users->items()"
                :columns="$columns"
            />

            <!-- Paginación -->
            <div class="mt-6">
                <livewire:user-module.components.pagination-nav
                    :paginator="$users"
                />
            </div>
        </div>
    </livewire:user-module.components.card>
</div>
```

### Dashboard con Multiple Cards

```blade
<div class="space-y-6">
    <!-- Alertas -->
    <livewire:user-module.components.callout
        message="System maintenance scheduled for Saturday 2am"
        variant="warning"
        title="Maintenance Notice"
    />

    <!-- Grid de Cards -->
    <div class="grid md:grid-cols-3 gap-6">
        <livewire:user-module.components.card
            title="Total Users"
            padding="lg"
        >
            <div class="text-center">
                <div class="text-4xl font-bold">{{ $stats['users'] }}</div>
                <p class="text-sm text-zinc-600">Active accounts</p>
            </div>
        </livewire:user-module.components.card>

        <livewire:user-module.components.card
            title="Revenue"
            padding="lg"
        >
            <div class="text-center">
                <div class="text-4xl font-bold">${{ $stats['revenue'] }}</div>
                <p class="text-sm text-zinc-600">This month</p>
            </div>
        </livewire:user-module.components.card>

        <livewire:user-module.components.card
            title="Conversion"
            padding="lg"
        >
            <div class="text-center">
                <div class="text-4xl font-bold">{{ $stats['conversion'] }}%</div>
                <p class="text-sm text-zinc-600">Conversion rate</p>
            </div>
        </livewire:user-module.components.card>
    </div>
</div>
```

---

## 🧪 Tests

Todos los componentes de Sprint 2 tienen tests:

```bash
php artisan test tests/Feature/UserModule/Livewire/Components/FluxComponentsTest.php
```

### Cobertura de Sprint 2 (6 tests nuevos)
- ✅ `test_card_renders` - Renderizado de card
- ✅ `test_card_custom_padding` - Padding personalizado
- ✅ `test_callout_renders` - Renderizado de callout
- ✅ `test_callout_variants` - Todas las variantes
- ✅ `test_callout_dismissible` - Callout descartable
- ✅ `test_skeleton_loader_renders` - Skeleton animado
- ✅ `test_skeleton_loader_no_animation` - Skeleton sin animación
- ✅ `test_breadcrumbs_nav_renders` - Breadcrumbs con enlaces
- ✅ `test_breadcrumbs_nav_empty` - Breadcrumbs vacío
- ✅ `test_pagination_nav_renders` - Paginación

---

## 📊 Estado del Proyecto

### Sprint 1 ✅ (Críticos - 5 componentes)
- SelectField
- CheckboxField
- SwitchField
- BadgeStatus
- TableList

### Sprint 2 ✅ (Importantes - 5 componentes)
- Card
- Callout
- SkeletonLoader
- BreadcrumbsNav
- PaginationNav

### Total: 10/10 componentes implementados
### Total Tests: 21/21 pasando ✅

---

## 🚀 Próximas Acciones

1. Integrar componentes en módulos reales
2. Crear ejemplos de uso en vistas
3. Documentar patrones avanzados
4. Optimizar performance de paginación
5. Agregar pruebas de integración

