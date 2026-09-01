# 🎨 Componentes Flux UI Críticos - Guía de Uso

**Estado:** ✅ Implementados y Testeados  
**Ubicación:** `app/Modules/UserModule/Livewire/Components/`  
**Vistas:** `resources/views/livewire/user-module/components/`

---

## 1️⃣ SelectField Component

**Propósito:** Selector dropdown accesible con soporte para opciones múltiples

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/SelectField.php](app/Modules/UserModule/Livewire/Components/SelectField.php)
- Vista: `resources/views/livewire/user-module/components/select-field.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.select-field
    label="Selecciona un rol"
    model="role"
    placeholder="-- Elige una opción --"
    :options="['admin' => 'Administrador', 'user' => 'Usuario', 'guest' => 'Invitado']"
/>
```

### Propiedades

| Propiedad     | Tipo   | Descripción                          |
| ------------- | ------ | ------------------------------------ |
| `label`       | string | Etiqueta del campo                   |
| `model`       | string | Nombre de la propiedad a vincular    |
| `modelValue`  | mixed  | Valor actual                         |
| `placeholder` | string | Texto de placeholder                 |
| `options`     | array  | Array `value => label`               |
| `description` | string | Descripción debajo del select        |
| `disabled`    | bool   | Deshabilitar el campo                |
| `required`    | bool   | Campo requerido                      |
| `errorKey`    | string | Clave de error (por defecto = model) |

### Ejemplo Avanzado

```blade
<livewire:user-module.components.select-field
    label="Departamento"
    model="departmentId"
    placeholder="Selecciona un departamento"
    :options="$departments->pluck('name', 'id')"
    description="El departamento donde trabajarás"
    :errorKey="'department_id'"
/>
```

---

## 2️⃣ CheckboxField Component

**Propósito:** Checkbox accesible para selecciones booleanas o múltiples

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/CheckboxField.php](app/Modules/UserModule/Livewire/Components/CheckboxField.php)
- Vista: `resources/views/livewire/user-module/components/checkbox-field.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.checkbox-field
    label="Acepto los términos de servicio"
    model="agreeTerms"
/>
```

### Propiedades

| Propiedad     | Tipo   | Descripción               |
| ------------- | ------ | ------------------------- |
| `label`       | string | Etiqueta del checkbox     |
| `model`       | string | Propiedad a vincular      |
| `modelValue`  | bool   | Valor actual (true/false) |
| `description` | string | Descripción adicional     |
| `disabled`    | bool   | Deshabilitar              |
| `errorKey`    | string | Clave de validación       |

### Ejemplo Avanzado

```blade
<div class="space-y-4">
    <livewire:user-module.components.checkbox-field
        label="Notificaciones por email"
        model="emailNotifications"
        description="Recibe notificaciones importantes por correo"
    />
    
    <livewire:user-module.components.checkbox-field
        label="Marketing"
        model="marketingEmails"
        description="Ofertas y promociones"
    />
</div>
```

---

## 3️⃣ SwitchField Component

**Propósito:** Toggle switch para opciones booleanas (mejor que radio para 2 opciones)

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/SwitchField.php](app/Modules/UserModule/Livewire/Components/SwitchField.php)
- Vista: `resources/views/livewire/user-module/components/switch-field.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.switch-field
    label="Habilitar notificaciones"
    model="notificationsEnabled"
    description="Recibe alertas en tiempo real"
/>
```

### Propiedades

| Propiedad     | Tipo   | Descripción            |
| ------------- | ------ | ---------------------- |
| `label`       | string | Etiqueta del switch    |
| `model`       | string | Propiedad a vincular   |
| `modelValue`  | bool   | Estado actual          |
| `description` | string | Descripción contextual |
| `disabled`    | bool   | Deshabilitar           |
| `errorKey`    | string | Clave de validación    |

### Ejemplo Avanzado (Settings de Usuario)

```blade
<div class="space-y-6 divide-y">
    <livewire:user-module.components.switch-field
        label="Modo oscuro"
        model="darkModeEnabled"
        description="Utiliza tema oscuro en la interfaz"
    />
    
    <div class="pt-6">
        <livewire:user-module.components.switch-field
            label="Autenticación de dos factores"
            model="twoFactorEnabled"
            description="Mayor seguridad en tu cuenta"
        />
    </div>
</div>
```

---

## 4️⃣ BadgeStatus Component

**Propósito:** Indicadores visuales para estados (Active, Pending, Inactive, etc.)

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/BadgeStatus.php](app/Modules/UserModule/Livewire/Components/BadgeStatus.php)
- Vista: `resources/views/livewire/user-module/components/badge-status.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.badge-status
    label="Activo"
    variant="success"
/>
```

### Variantes Disponibles

```php
'success'   => 'Verde (Éxito, Activo)'
'warning'   => 'Ámbar (Advertencia, Pendiente)'
'danger'    => 'Rojo (Error, Inactivo)'
'info'      => 'Azul (Información)'
'pending'   => 'Amarillo (En proceso)'
'inactive'  => 'Gris (Inactivo)'
'default'   => 'Zinc (Defecto)'
```

### Con Icono

```blade
<livewire:user-module.components.badge-status
    label="Verificado"
    variant="success"
    icon="check-circle"
/>
```

### Ejemplo en Tabla

```blade
@foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>
            <livewire:user-module.components.badge-status
                :label="$user->status_label"
                :variant="$user->status_variant"
                :icon="$user->status_icon"
                wire:key="badge-{$user->id}"
            />
        </td>
    </tr>
@endforeach
```

---

## 5️⃣ TableList Component

**Propósito:** Tabla reactiva con sorting, paginación y loading states

### Ubicación
- Clase: [app/Modules/UserModule/Livewire/Components/TableList.php](app/Modules/UserModule/Livewire/Components/TableList.php)
- Vista: `resources/views/livewire/user-module/components/table-list.blade.php`

### Uso Básico

```blade
<livewire:user-module.components.table-list
    :rows="$users"
    :columns="[
        ['key' => 'name', 'label' => 'Nombre', 'sortable' => true],
        ['key' => 'email', 'label' => 'Email'],
        ['key' => 'role', 'label' => 'Rol'],
    ]"
/>
```

### Propiedades

| Propiedad       | Tipo   | Descripción                    |
| --------------- | ------ | ------------------------------ |
| `rows`          | array  | Filas de datos                 |
| `columns`       | array  | Configuración de columnas      |
| `sortBy`        | string | Campo de ordenamiento actual   |
| `sortDirection` | string | 'asc' o 'desc'                 |
| `perPage`       | int    | Filas por página (defecto: 15) |
| `emptyMessage`  | string | Mensaje cuando no hay datos    |

### Configuración de Columnas

```php
'columns' => [
    // Columna simple
    ['key' => 'name', 'label' => 'Nombre'],
    
    // Columna sorteable
    ['key' => 'email', 'label' => 'Email', 'sortable' => true],
    
    // Columna con rendering personalizado
    [
        'key' => 'status',
        'label' => 'Estado',
        'sortable' => true,
        'render' => fn($row) => view('components.status-badge', ['status' => $row['status']])
    ],
]
```

### Ejemplo Completo

```blade
<livewire:user-module.components.table-list
    :rows="$users->toArray()"
    :columns="[
        ['key' => 'name', 'label' => 'Nombre', 'sortable' => true],
        ['key' => 'email', 'label' => 'Email'],
        [
            'key' => 'role',
            'label' => 'Rol',
            'render' => fn($row) => ucfirst($row['role'])
        ],
        [
            'key' => 'status',
            'label' => 'Estado',
            'render' => fn($row) => view('components.badge', [
                'label' => $row['status_label'],
                'variant' => $row['status_variant']
            ])
        ],
    ]"
    emptyMessage="No se encontraron usuarios"
/>
```

---

## 🎯 Uso Combinado en un Formulario

```blade
<form wire:submit="saveUser">
    <div class="space-y-6">
        <!-- Campo select -->
        <livewire:user-module.components.select-field
            label="Departamento"
            model="departmentId"
            :options="$departments->pluck('name', 'id')"
            required
        />

        <!-- Checkboxes -->
        <div class="border-t pt-6">
            <flux:heading level="3" size="sm">Permisos</flux:heading>
            <div class="space-y-3 mt-4">
                <livewire:user-module.components.checkbox-field
                    label="Puede editar usuarios"
                    model="canEditUsers"
                />
                <livewire:user-module.components.checkbox-field
                    label="Puede eliminar usuarios"
                    model="canDeleteUsers"
                />
            </div>
        </div>

        <!-- Switches -->
        <div class="border-t pt-6">
            <flux:heading level="3" size="sm">Configuración</flux:heading>
            <div class="space-y-4 mt-4">
                <livewire:user-module.components.switch-field
                    label="Activo"
                    model="active"
                />
            </div>
        </div>

        <!-- Submit -->
        <flux:button type="submit" variant="primary">Guardar Usuario</flux:button>
    </div>
</form>
```

---

## 🔄 Componentes Listos para Módulos

Estos 5 componentes están diseñados para ser **reutilizables en cualquier módulo**. Puedes copiar y adaptar:

```bash
# Copiar componentes a otro módulo
cp -r app/Modules/UserModule/Livewire/Components/* \
      app/Modules/BillingModule/Livewire/Components/

# Actualizar namespaces según sea necesario
```

---

## 📊 Tests

Todos los componentes tienen tests completos:

```bash
php artisan test tests/Feature/UserModule/Livewire/Components/FluxComponentsTest.php
```

### Cobertura de Tests
- ✅ Renderizado de componentes
- ✅ Actualización de valores
- ✅ Estados de carga
- ✅ Mensajes vacíos
- ✅ Variantes de badages
- ✅ Sorting en tablas

---

## 🚀 Próximos Pasos

### Componentes Importantes (Sprint 1)
- [ ] **Pagination** - Para listas paginadas
- [ ] **Card** - Containers de dashboard
- [ ] **Callout** - Alertas informativas
- [ ] **Skeleton** - Loading placeholders

### Optimizaciones
- [ ] Agregar validación en tiempo real
- [ ] Mejorar tipos de datos (TypeScript)
- [ ] Documentar casos de uso avanzados
- [ ] Crear ejemplos de integración con Actions

---

## 💡 Notas de Implementación

1. **Modularidad Estricta**: Los componentes residen en `UserModule` pero pueden extrapolarse a otros módulos
2. **Convención de Nombres**: Usa `ComponentName` en PHP y `component-name` en vistas Blade
3. **Events**: Los componentes emiten `field-updated` para comunicarse con componentes padres
4. **Validación**: Integrados con Blade validation (`$errors`)
5. **Accesibilidad**: Todos usan elementos HTML semánticos y Flux UI accesible

