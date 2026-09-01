# 📊 Inventario de Componentes Flux UI

**Fecha:** 2026-09-01  
**Edición:** Free (Gratuita)  
**Stack:** Flux UI + Livewire 3 + Tailwind CSS

---

## 1. COMPONENTES DISPONIBLES EN FLUX UI (FREE)

### ✅ Componentes ACTUALMENTE EN USO

| Componente           | Ubicaciones Principales           | Estado      | Notas                                                   |
| -------------------- | --------------------------------- | ----------- | ------------------------------------------------------- |
| **button**           | Autenticación, Settings, Passkeys | ✅ Activo    | Variantes: primary, default. Bien utilizado.            |
| **input**            | Formularios Auth, Settings, Login | ✅ Activo    | Text, email, password. Integrado con wire:model.        |
| **textarea**         | Potencial en formularios          | ✅ Soportado | No usado, listo para formas multilineales.              |
| **field**            | Formularios                       | ✅ Activo    | Contiene label + input + error. Estructura estándar.    |
| **heading**          | Layouts, Settings, Auth           | ✅ Activo    | h1-h6 levels. Bien utilizado.                           |
| **text**             | Vistas de contenido, Auth         | ✅ Activo    | Texto semántico. Usado ampliamente.                     |
| **subheading**       | Settings, Auth                    | ✅ Activo    | Subtítulos descriptivos.                                |
| **error**            | Validación en formularios         | ✅ Activo    | Mostrar errores de validación Blade.                    |
| **modal**            | Settings (Delete account, 2FA)    | ✅ Activo    | Diálogos focales. Funciona con wire:model.              |
| **avatar**           | Menú de usuario, Perfiles         | ✅ Activo    | Muestra iniciales o imágenes.                           |
| **dropdown**         | Menú de usuario desktop           | ✅ Activo    | Dropdown de acciones.                                   |
| **menu**             | Menú usuario, Submenu items       | ✅ Activo    | Menu.item, Menu.separator, Menu.radio.group.            |
| **sidebar**          | Layout principal                  | ✅ Activo    | Sidebar principal de navegación. Collapsible en mobile. |
| **sidebar.brand**    | Header del Sidebar                | ✅ Activo    | Logo de aplicación.                                     |
| **sidebar.nav**      | Navegación principal              | ✅ Activo    | Grupos de navegación.                                   |
| **sidebar.item**     | Elementos de navegación           | ✅ Activo    | Links con icono y estado current.                       |
| **sidebar.group**    | Agrupación de items               | ✅ Activo    | Grupo de items con heading.                             |
| **sidebar.profile**  | Menú usuario en sidebar           | ✅ Activo    | Perfil con avatar, iniciales e icono.                   |
| **sidebar.toggle**   | Toggle mobile/desktop             | ✅ Activo    | Botón collapse sidebar.                                 |
| **sidebar.collapse** | Collapsar sidebar mobile          | ✅ Activo    | Visual de cierre sidebar.                               |
| **navbar**           | Header desktop                    | ✅ Activo    | Barra de navegación horizontal.                         |
| **navbar.item**      | Items navbar                      | ✅ Activo    | Links con icono en navbar.                              |
| **header**           | Layout app                        | ✅ Activo    | Header con sidebar.toggle + navbar.                     |
| **spacer**           | Layout                            | ✅ Activo    | Espaciador flexible (flex-1).                           |
| **separator**        | Divisor visual                    | ✅ Activo    | Línea divisoria (hr).                                   |
| **tooltip**          | Navbar buttons                    | ✅ Activo    | Tooltips al hover.                                      |
| **toast**            | Notificaciones                    | ✅ Activo    | Mensajes toast con Flux::toast().                       |
| **toast.group**      | Contenedor toasts                 | ✅ Activo    | Grupo de notificaciones.                                |
| **otp**              | 2FA, Passkeys                     | ✅ Activo    | OTP input para códigos de autenticación.                |
| **icon**             | Iconos Heroicons                  | ✅ Activo    | Integración con Heroicons.                              |

### 🟡 Componentes DISPONIBLES pero NO USADOS (Alto Valor Potencial)

| Componente       | Caso de Uso Ideal                                                      | Valor | Prioridad    |
| ---------------- | ---------------------------------------------------------------------- | ----- | ------------ |
| **radio**        | Selecciones mutuamente excluyentes (Appearance settings usa segmented) | ⭐⭐⭐⭐  | 🔴 Alta       |
| **checkbox**     | Selecciones múltiples, Terms of Service, Permisos                      | ⭐⭐⭐⭐  | 🔴 Alta       |
| **select**       | Dropdowns con búsqueda (roles, categorías, departamentos)              | ⭐⭐⭐⭐⭐ | 🔴 Alta       |
| **switch**       | Toggle de opciones booleanas (notificaciones, privacidad)              | ⭐⭐⭐⭐  | 🔴 Alta       |
| **badge**        | Tags, estados, categorías, labels                                      | ⭐⭐⭐⭐⭐ | 🟡 Media-Alta |
| **table**        | Listados de datos (usuarios, transacciones, reportes)                  | ⭐⭐⭐⭐⭐ | 🔴 Alta       |
| **pagination**   | Paginación de tablas y listados                                        | ⭐⭐⭐⭐  | 🔴 Alta       |
| **progress**     | Barras de progreso, completitud de perfiles, carga                     | ⭐⭐⭐   | 🟡 Media      |
| **card**         | Containers de contenido, dashboards                                    | ⭐⭐⭐⭐  | 🟡 Media      |
| **callout**      | Alertas informativas, warnings, tips                                   | ⭐⭐⭐⭐  | 🟡 Media      |
| **navlist**      | Navegación secundaria (Settings ya lo usa)                             | ⭐⭐⭐   | 🟡 Media      |
| **navlist.item** | Items de navlist                                                       | ⭐⭐⭐   | 🟡 Media      |
| **breadcrumbs**  | Navegación jerárquica, rutas en app                                    | ⭐⭐⭐   | 🟡 Media      |
| **link**         | Links estilizados Flux (algunas vistas lo usan)                        | ⭐⭐    | 🟢 Baja       |
| **profile**      | Perfil de usuario en diferentes contextos                              | ⭐⭐⭐   | 🟡 Media      |
| **brand**        | Branding, logos de empresas                                            | ⭐⭐    | 🟢 Baja       |
| **skeleton**     | Loaders de contenido, fallback durante carga                           | ⭐⭐⭐⭐  | 🟡 Media      |

---

## 2. USO ACTUAL POR MÓDULO/ÁREA

### 📁 Layouts
- `resources/views/layouts/app.blade.php` → flux:main, flux:sidebar, flux:header
- `resources/views/layouts/app/sidebar.blade.php` → Toda la jerarquía sidebar
- `resources/views/layouts/app/header.blade.php` → navbar, tooltip, dropdown

### 🔐 Autenticación (Fortify)
- `resources/views/pages/auth/` → input, button, heading, text, otp
- Login, Register, Password Reset, 2FA, Passkeys

### ⚙️ Settings/Profile
- `resources/views/pages/settings/` → input, modal, button, heading, subheading, radio, navlist
- Profile, Security, Appearance, Delete account
- 2FA setup con modal + otp

### 🎨 Componentes Compartidos
- `resources/views/components/desktop-user-menu.blade.php` → dropdown, menu, avatar
- `resources/views/components/auth-header.blade.php` → heading

---

## 3. COMPONENTES ESTRATÉGICOS PARA IMPLEMENTAR PRÓXIMAMENTE

### 🔴 CRÍTICOS (Implementar INMEDIATAMENTE)

#### **1. Select Component**
```blade
<flux:select wire:model="role" :options="['admin' => 'Administrator', 'user' => 'User']" label="Role" />
```
**Ubicaciones potenciales:**
- Gestión de usuarios (asignar roles)
- Formularios de creación/edición
- Filtros de búsqueda

**Beneficio:** Dropdowns accesibles con búsqueda integrada. Mejor UX que inputs de texto.

#### **2. Table Component**
```blade
<flux:table :rows="$users" wire:sortable="reorder" wire:sortable-item="user">
    <flux:columns>
        <flux:column key="name" sortable>Name</flux:column>
        <flux:column key="email">Email</flux:column>
        <flux:column key="role">Role</flux:column>
    </flux:columns>
</flux:table>
```
**Ubicaciones potenciales:**
- Listados de usuarios, datos, reportes
- Dashboards de datos
- Gestión de recursos

**Beneficio:** Table nativa Flux con sorting, responsive, accesible. Esencial para dashboards.

#### **3. Checkbox Component**
```blade
<flux:checkbox wire:model="agree_terms" label="I agree to the terms" />
```
**Ubicaciones potenciales:**
- Formularios con múltiples selecciones
- Permisos y términos de servicio
- Filtros avanzados

**Beneficio:** Checkboxes accesibles con validación Livewire integrada.

#### **4. Switch Component**
```blade
<flux:switch wire:model="notifications_enabled" label="Enable notifications" />
```
**Ubicaciones potenciales:**
- Settings de usuario (notificaciones, privacidad)
- Toggle de features
- Preferencias de cuenta

**Beneficio:** Toggle elegante, mejor que radio buttons para opciones booleanas.

#### **5. Badge Component**
```blade
<flux:badge>Active</flux:badge>
<flux:badge color="warning">Pending</flux:badge>
```
**Ubicaciones potenciales:**
- Estados de usuarios/órdenes (Active, Pending, Inactive)
- Tags de categorías
- Labels de estado en tablas

**Beneficio:** Indicadores visuales consistentes para estados.

### 🟡 IMPORTANTES (Próximas 2 sprints)

#### **6. Pagination Component**
```blade
<flux:pagination :links="$items->links()" />
```
**Ubicaciones:** Listados de datos en tablas, búsquedas.

#### **7. Card Component**
```blade
<flux:card class="p-6">
    <flux:heading>Dashboard Card</flux:heading>
    {{ $content }}
</flux:card>
```
**Ubicaciones:** Dashboards, widgets, agrupación de contenido.

#### **8. Callout Component**
```blade
<flux:callout icon="information-circle" variant="info">
    Important message here
</flux:callout>
```
**Ubicaciones:** Alertas, consejos, información importante.

#### **9. Skeleton Component**
```blade
<flux:skeleton class="h-12 w-full" />
```
**Ubicaciones:** Loading states, wire:loading en tablas y formularios.

#### **10. Breadcrumbs Component**
```blade
<flux:breadcrumbs :items="[
    ['label' => 'Home', 'href' => route('dashboard')],
    ['label' => 'Users'],
]" />
```
**Ubicaciones:** Navegación jerárquica, rutas complejas.

---

## 4. ARQUITECTURA DE COMPONENTES POR MÓDULO

### Estructura Recomendada Modular

```
app/Modules/
├── UserModule/
│   └── Livewire/
│       ├── UserTable.php          ← flux:table
│       ├── UserFormModal.php       ← flux:modal + flux:field + flux:select
│       └── UserActionMenu.php      ← flux:dropdown + flux:menu
├── BillingModule/
│   └── Livewire/
│       ├── InvoiceTable.php        ← flux:table + flux:badge (status)
│       └── PaymentForm.php         ← flux:input + flux:select
├── SettingsModule/
│   └── Livewire/
│       ├── NotificationPreferences ← flux:switch + flux:checkbox
│       └── SecuritySettings.php    ← flux:input + flux:modal
```

---

## 5. RECOMENDACIONES INMEDIATAS

### Sprint 0: Fundamentos
1. **Integrar Select** en todos los formularios que requieran dropdowns
2. **Implementar Table** para el módulo de usuarios/datos
3. **Agregar Checkbox & Switch** en settings
4. **Implementar Badge** para estados visuales

### Sprint 1: UX Enhancement
5. **Pagination** para listados
6. **Callout** para alertas contextuales
7. **Card** para widgets de dashboard
8. **Skeleton** para loading states

### Sprint 2: Navegación
9. **Breadcrumbs** para rutas complejas
10. **Mejorar Profile component** en diferentes contextos

---

## 6. CHECKLIST DE COMPONENTES NO APROVECHADOS

```markdown
- [ ] Implementar `flux:select` en UserModule
- [ ] Crear `UserTable` con `flux:table`
- [ ] Agregar `flux:checkbox` en términos de servicio
- [ ] Reemplazar radio segmented con `flux:switch` en Appearance
- [ ] Agregar `flux:badge` para estados de usuario
- [ ] Implementar `flux:pagination` en listados
- [ ] Crear cards de dashboard con `flux:card`
- [ ] Agregar `flux:callout` en alertas de seguridad
- [ ] Implementar `flux:skeleton` en wire:loading
- [ ] Agregar `flux:breadcrumbs` en navegación
```

---

## 7. REFERENCIAS & COMANDOS ÚTILES

### Agregar Iconos Lucide (si necesitas más allá de Heroicons)
```bash
php artisan flux:icon crown grip-vertical github
```

### Buscar Documentación Flux
Usar `search-docs` en Copilot con queries como:
- "Flux UI table component sorting"
- "Flux UI select with search"
- "Flux UI validation patterns"

### Componentes Pro (NO DISPONIBLES en Free)
- Kanban
- Date-picker
- Time-picker
- Color-picker
- File-upload
- Rich-text-editor

---

## 8. CONCLUSIÓN

**Status:** ✅ Proyecto usa ~25 componentes Flux activamente  
**Oportunidad:** 🚀 15+ componentes subutilizados con alto valor  
**Recomendación:** Implementar Select, Table, Checkbox/Switch, Badge como **PRIORIDAD INMEDIATA**

