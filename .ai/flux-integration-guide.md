# 🎯 Guía de Integración - Componentes Flux UI

**Versión:** 1.0  
**Componentes:** 10 (Sprint 1 + Sprint 2)  
**Estado:** Completos y Testeados ✅

---

## 📦 Matriz de Componentes

### Sprint 1 - Críticos

| Componente        | Propósito         | Clase               | Tests |
| ----------------- | ----------------- | ------------------- | ----- |
| **SelectField**   | Dropdown selector | `SelectField.php`   | ✅ 2   |
| **CheckboxField** | Checkbox boolean  | `CheckboxField.php` | ✅ 2   |
| **SwitchField**   | Toggle switch     | `SwitchField.php`   | ✅ 2   |
| **BadgeStatus**   | Status badges     | `BadgeStatus.php`   | ✅ 2   |
| **TableList**     | Reactive table    | `TableList.php`     | ✅ 3   |

### Sprint 2 - Importantes

| Componente         | Propósito             | Clase                | Tests |
| ------------------ | --------------------- | -------------------- | ----- |
| **Card**           | Content container     | `Card.php`           | ✅ 2   |
| **Callout**        | Alerts/messages       | `Callout.php`        | ✅ 3   |
| **SkeletonLoader** | Loading placeholders  | `SkeletonLoader.php` | ✅ 2   |
| **BreadcrumbsNav** | Breadcrumb navigation | `BreadcrumbsNav.php` | ✅ 2   |
| **PaginationNav**  | Pagination controls   | `PaginationNav.php`  | ✅ 1   |

**Total:** 21/21 tests pasando ✅

---

## 🏗️ Arquitectura

### Estructura de Directorios

```
app/Modules/UserModule/
├── Livewire/
│   └── Components/
│       ├── SelectField.php          (Sprint 1)
│       ├── CheckboxField.php        (Sprint 1)
│       ├── SwitchField.php          (Sprint 1)
│       ├── BadgeStatus.php          (Sprint 1)
│       ├── TableList.php            (Sprint 1)
│       ├── Card.php                 (Sprint 2)
│       ├── Callout.php              (Sprint 2)
│       ├── SkeletonLoader.php       (Sprint 2)
│       ├── BreadcrumbsNav.php       (Sprint 2)
│       └── PaginationNav.php        (Sprint 2)
└── Providers/
    └── UserModuleServiceProvider.php (registra vistas)

resources/views/livewire/user-module/components/
├── select-field.blade.php
├── checkbox-field.blade.php
├── switch-field.blade.php
├── badge-status.blade.php
├── table-list.blade.php
├── card.blade.php
├── callout.blade.php
├── skeleton-loader.blade.php
├── breadcrumbs-nav.blade.php
└── pagination-nav.blade.php
```

---

## 🎨 Patrones de Integración

### 1. Formulario Completo

```blade
<livewire:user-module.components.card
    title="Create New User"
    description="Add a new user to the system"
>
    <form wire:submit="save" class="space-y-6">
        <!-- Text Input -->
        <livewire:user-module.components.select-field
            :model="'department_id'"
            label="Department"
            :options="$departments"
            required
        />

        <!-- Toggle Switch -->
        <livewire:user-module.components.switch-field
            :model="'is_active'"
            label="Active User"
            description="Enable this account"
        />

        <!-- Checkbox -->
        <livewire:user-module.components.checkbox-field
            :model="'send_welcome_email'"
            label="Send Welcome Email"
        />

        <!-- Submit -->
        <div class="flex gap-3">
            <flux:button type="submit" variant="primary">
                Create User
            </flux:button>
            <flux:button type="button" wire:click="cancel" variant="ghost">
                Cancel
            </flux:button>
        </div>
    </form>
</livewire:user-module.components.card>
```

### 2. Dashboard Principal

```blade
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900">
    <!-- Breadcrumb Navigation -->
    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-800">
        <livewire:user-module.components.breadcrumbs-nav
            :breadcrumbs="[
                ['label' => 'Dashboard', 'href' => route('dashboard'), 'active' => false],
                ['label' => 'Overview', 'active' => true],
            ]"
        />
    </div>

    <div class="p-6 space-y-6">
        <!-- Alert Callout -->
        @if ($maintenanceScheduled)
            <livewire:user-module.components.callout
                message="System maintenance scheduled for Saturday 2:00 AM EST"
                variant="warning"
                title="Scheduled Maintenance"
                icon="exclamation-triangle"
            />
        @endif

        <!-- Stats Grid -->
        <div class="grid md:grid-cols-4 gap-6">
            @foreach ($metrics as $metric)
                <livewire:user-module.components.card
                    :title="$metric['name']"
                    padding="lg"
                >
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">
                            {{ $metric['value'] }}
                        </div>
                        <p class="text-sm text-zinc-600">{{ $metric['label'] }}</p>
                    </div>
                </livewire:user-module.components.card>
            @endforeach
        </div>

        <!-- Main Content -->
        <livewire:user-module.components.card
            title="Recent Users"
            description="Latest registered accounts"
        >
            <!-- Loading State -->
            <div wire:loading.delay.shortest>
                <livewire:user-module.components.skeleton-loader
                    count="10"
                    height="12"
                    class="space-y-2"
                />
            </div>

            <!-- Table Content -->
            <div wire:loading.remove>
                <livewire:user-module.components.table-list
                    :rows="$users->items()"
                    :columns="[
                        ['key' => 'name', 'label' => 'Name', 'sortable' => true],
                        ['key' => 'email', 'label' => 'Email'],
                        ['key' => 'status', 'label' => 'Status', 'sortable' => true, 'render' => fn($row) => 'badge'],
                        ['key' => 'joined_at', 'label' => 'Joined', 'sortable' => true],
                    ]"
                    :sortBy="$sortBy"
                    :sortDirection="$sortDirection"
                />

                <!-- Pagination -->
                <div class="mt-6">
                    <livewire:user-module.components.pagination-nav
                        :paginator="$users"
                        alignment="center"
                    />
                </div>
            </div>
        </livewire:user-module.components.card>
    </div>
</div>
```

### 3. Tabla con Edición

```blade
<livewire:user-module.components.card title="Products Inventory">
    <div wire:loading.delay>
        <livewire:user-module.components.skeleton-loader count="8" />
    </div>

    <div wire:loading.remove>
        <table class="w-full">
            <thead>
                <tr class="border-b border-zinc-200 dark:border-zinc-700">
                    <th class="text-left py-3 px-4">Product</th>
                    <th class="text-left py-3 px-4">Status</th>
                    <th class="text-left py-3 px-4">In Stock</th>
                    <th class="text-center py-3 px-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-b border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="py-3 px-4">{{ $product->name }}</td>
                        <td class="py-3 px-4">
                            <livewire:user-module.components.badge-status
                                :label="$product->status"
                                :variant="$product->status_variant"
                            />
                        </td>
                        <td class="py-3 px-4">
                            <livewire:user-module.components.switch-field
                                :model="'products.'.$product->id.'.in_stock'"
                                :modelValue="$product->in_stock"
                            />
                        </td>
                        <td class="py-3 px-4 text-center">
                            <flux:button
                                size="sm"
                                variant="subtle"
                                wire:click="editProduct({{ $product->id }})"
                            >
                                Edit
                            </flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            <livewire:user-module.components.pagination-nav
                :paginator="$products"
            />
        </div>
    </div>
</livewire:user-module.components.card>
```

### 4. Perfil de Usuario

```blade
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumbs -->
    <livewire:user-module.components.breadcrumbs-nav
        :breadcrumbs="[
            ['label' => 'Dashboard', 'href' => route('dashboard')],
            ['label' => 'Users', 'href' => route('users.index')],
            ['label' => auth()->user()->name, 'active' => true],
        ]"
    />

    <!-- Alert -->
    @if (!auth()->user()->email_verified_at)
        <livewire:user-module.components.callout
            message="Please verify your email address to unlock all features"
            variant="info"
            title="Email Verification Required"
            icon="envelope"
            dismissible
        />
    @endif

    <!-- Profile Card -->
    <livewire:user-module.components.card
        title="Profile Information"
        description="Update your personal details"
    >
        <form wire:submit="updateProfile" class="space-y-6">
            <flux:input
                wire:model="name"
                label="Full Name"
                type="text"
            />

            <flux:input
                wire:model="email"
                label="Email"
                type="email"
            />

            <livewire:user-module.components.select-field
                :model="'timezone'"
                label="Timezone"
                :options="$timezones"
            />

            <livewire:user-module.components.checkbox-field
                :model="'newsletter'"
                label="Subscribe to newsletter"
                description="Receive updates about new features"
            />

            <flux:button type="submit">Save Changes</flux:button>
        </form>
    </livewire:user-module.components.card>

    <!-- Preferences Card -->
    <livewire:user-module.components.card
        title="Preferences"
        description="Customize your experience"
    >
        <div class="space-y-6">
            <livewire:user-module.components.switch-field
                :model="'dark_mode'"
                label="Dark Mode"
                description="Enable dark theme"
            />

            <livewire:user-module.components.switch-field
                :model="'notifications_enabled'"
                label="Email Notifications"
                description="Receive notification emails"
            />

            <livewire:user-module.components.select-field
                :model="'language'"
                label="Language"
                :options="$languages"
            />
        </div>
    </livewire:user-module.components.card>
</div>
```

### 5. Lista de Usuarios con Filtros

```blade
<livewire:user-module.components.card
    title="Users Management"
    description="Search and manage all users"
>
    <!-- Filters -->
    <div class="mb-6 grid md:grid-cols-3 gap-4">
        <livewire:user-module.components.select-field
            :model="'filterDepartment'"
            label="Department"
            :options="$departments"
            placeholder="All departments"
        />

        <livewire:user-module.components.select-field
            :model="'filterStatus'"
            label="Status"
            :options="['active' => 'Active', 'inactive' => 'Inactive']"
            placeholder="All statuses"
        />

        <div class="flex items-end">
            <flux:button
                wire:click="resetFilters"
                variant="ghost"
                class="w-full"
            >
                Reset Filters
            </flux:button>
        </div>
    </div>

    <!-- Results -->
    <div wire:loading.delay.shortest>
        <livewire:user-module.components.skeleton-loader count="10" />
    </div>

    <div wire:loading.remove>
        <livewire:user-module.components.table-list
            :rows="$users->items()"
            :columns="[
                ['key' => 'name', 'label' => 'Name', 'sortable' => true],
                ['key' => 'email', 'label' => 'Email'],
                ['key' => 'department', 'label' => 'Department'],
                ['key' => 'status', 'label' => 'Status', 'render' => fn($row) => $this->getStatusBadge($row)],
            ]"
            :sortBy="$sortBy"
            :sortDirection="$sortDirection"
        />

        <!-- Pagination -->
        <div class="mt-6">
            <livewire:user-module.components.pagination-nav
                :paginator="$users"
            />
        </div>
    </div>
</livewire:user-module.components.card>
```

---

## 🔌 Componente → Componente

### Card contiene Table + Pagination

```blade
<livewire:user-module.components.card title="Data List">
    <livewire:user-module.components.table-list ... />
    
    <livewire:user-module.components.pagination-nav
        :paginator="$items"
    />
</livewire:user-module.components.card>
```

### Card contiene Select + Switch + Checkbox

```blade
<livewire:user-module.components.card title="Settings">
    <livewire:user-module.components.select-field ... />
    <livewire:user-module.components.switch-field ... />
    <livewire:user-module.components.checkbox-field ... />
</livewire:user-module.components.card>
```

### Badge + Callout

```blade
<livewire:user-module.components.callout message="Status updated">
    <livewire:user-module.components.badge-status
        label="Active"
        variant="success"
    />
</livewire:user-module.components.callout>
```

### SkeletonLoader para estados de carga

```blade
<div wire:loading.delay>
    <livewire:user-module.components.skeleton-loader count="5" />
</div>
<div wire:loading.remove>
    <!-- Contenido real -->
</div>
```

---

## 📊 Matriz de Compatibilidad

|                 | Select | Checkbox | Switch | Badge | Table | Card | Callout | Skeleton | Breadcrumbs | Pagination |
| --------------- | ------ | -------- | ------ | ----- | ----- | ---- | ------- | -------- | ----------- | ---------- |
| **Select**      | -      | ✅        | ✅      | ✅     | ✅     | ✅    | ✅       | -        | -           | ✅          |
| **Checkbox**    | ✅      | -        | ✅      | ✅     | ✅     | ✅    | ✅       | -        | -           | ✅          |
| **Switch**      | ✅      | ✅        | -      | ✅     | ✅     | ✅    | ✅       | -        | -           | ✅          |
| **Badge**       | ✅      | ✅        | ✅      | -     | ✅     | ✅    | ✅       | -        | -           | ✅          |
| **Table**       | ✅      | ✅        | ✅      | ✅     | -     | ✅    | ✅       | ✅        | -           | ✅          |
| **Card**        | ✅      | ✅        | ✅      | ✅     | ✅     | ✅    | ✅       | ✅        | ✅           | ✅          |
| **Callout**     | -      | -        | -      | ✅     | -     | ✅    | -       | -        | -           | -          |
| **Skeleton**    | -      | -        | -      | -     | ✅     | ✅    | -       | -        | -           | -          |
| **Breadcrumbs** | -      | -        | -      | -     | -     | ✅    | -       | -        | -           | -          |
| **Pagination**  | ✅      | ✅        | ✅      | ✅     | ✅     | ✅    | -       | -        | -           | -          |

---

## ✅ Testing

```bash
# Ejecutar todos los tests
php artisan test tests/Feature/UserModule/Livewire/Components/FluxComponentsTest.php --compact

# Ejecutar un test específico
php artisan test --filter=test_card_renders

# Con cobertura
php artisan test --coverage
```

---

## 🚀 Optimizaciones

### 1. Lazy Loading de Componentes

```blade
@livewire('user-module.components.table-list', 
    ['rows' => $users->items(), 'columns' => $columns], 
    key: 'table-' . now()->timestamp
)
```

### 2. Debouncing en Búsquedas

```php
#[On('search')]
#[Debounce(500)]
public function search($query)
{
    $this->searchQuery = $query;
    $this->currentPage = 1;
}
```

### 3. Paginación Automática

```php
public function updatedCurrentPage($value)
{
    $this->dispatch('paginate', page: $value);
}
```

---

## 📚 Documentación

- [Sprint 1 Guide](.ai/flux-components-guide.md) - Componentes críticos
- [Sprint 2 Guide](.ai/sprint-2-components-guide.md) - Componentes importantes
- [Component Inventory](.ai/flux-inventory.md) - Matriz completa de componentes

