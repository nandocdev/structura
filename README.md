# Laravel Modular Monolith

Aplicación Laravel estructurada bajo una arquitectura **Monolito Modular**, orientada a mantener un código organizado por dominios, con límites claros entre módulos y sin introducir complejidad innecesaria.

## Estado del proyecto

Base modular operativa (P0/P1/P2):

```text
app/Modules/
├── CoreModule/            # Infra compartida
├── UserModule/            # Auth + FindUser::run() como contrato inter-módulo
└── TaskModule/            # Plantilla CRUD copiable (Actions/Data/Models/Policies/Livewire/Tests)
```

- `php artisan make:module {Name}` → scaffolding + registro en `bootstrap/providers.php`
- API versionada `GET /api/v1/tasks` (Sanctum + throttle, Resources, FormRequests)
- Eventos `TaskCreated/Updated/Deleted` → `LogTaskActivity` + `QueueTaskMetrics` (queue `metrics`)
- Horizon `supervisor-1`/`supervisor-metrics` + `horizon:snapshot` cada 5m, `pulse:check` cada 1m
- Guardrails: `tests/Feature/ArchitectureGuardTest.php` + `PerformanceGuardTest.php` (N+1 ≤4 queries)

## Stack

- PHP 8.3+ (CI 8.4) / Laravel 13 / Livewire 4 / Flux UI 2 / Tailwind 4 / Vite + vite-plus
- SQLite dev (`database/database.sqlite`, `sqlite :memory:` en tests) / PostgreSQL opcional `docker-compose.yml` + Redis (predis)
- Pest 5 / Pint / Larastan lvl7 / Horizon / Pulse

## Arquitectura

El proyecto utiliza un **Monolito Modular**:

```text
┌──────────────────────────────────────────────┐
│                 Laravel App                  │
│                                              │
│  ┌────────────┐ ┌────────────┐ ┌──────────┐ │
│  │  Module A  │ │  Module B  │ │ Module C │ │
│  │            │ │            │ │          │ │
│  │ Domain     │ │ Domain     │ │ Domain   │ │
│  │ Actions    │ │ Actions    │ │ Actions  │ │
│  │ Models     │ │ Models     │ │ Models   │ │
│  │ UI         │ │ UI         │ │ UI       │ │
│  └────────────┘ └────────────┘ └──────────┘ │
│                                              │
│              Shared Infrastructure           │
└──────────────────────────────────────────────┘
```

Los módulos se ejecutan dentro de la misma aplicación y proceso, pero mantienen una separación lógica y física del código.

### Principios

1. **Modularidad antes que microservicios.**
2. **Cada módulo representa una capacidad de negocio.**
3. **Alta cohesión dentro del módulo.**
4. **Bajo acoplamiento entre módulos.**
5. **No colocar lógica de negocio en Controllers.**
6. **Las operaciones de negocio se implementan mediante Actions/Services según su complejidad.**
7. **Los modelos pertenecen al módulo que posee su responsabilidad.**
8. **La infraestructura compartida no debe contener lógica específica de negocio.**
9. **Evitar abstracciones hasta que exista una necesidad real.**
10. **Los módulos deben poder evolucionar independientemente dentro del monolito.**

---

## Estructura

```text
app/
├── Modules/
│   ├── CoreModule/
│   │   ├── Actions/
│   │   ├── Data/
│   │   ├── Enums/
│   │   ├── Exceptions/
│   │   ├── Models/
│   │   ├── Policies/
│   │   ├── Providers/
│   │   ├── Resources/
│   │   ├── Rules/
│   │   ├── Services/
│   │   ├── Support/
│   │   └── Tests/
│   │
│   ├── ExampleModule/
│   │   ├── Actions/
│   │   ├── Data/
│   │   ├── Enums/
│   │   ├── Exceptions/
│   │   ├── Models/
│   │   ├── Policies/
│   │   ├── Providers/
│   │   ├── Rules/
│   │   ├── Services/
│   │   ├── Support/
│   │   ├── Resources/
│   │   ├── Livewire/
│   │   └── Tests/
│   │
│   └── ...
│
├── Console/
├── Exceptions/
├── Http/
├── Providers/
└── Support/

bootstrap/
config/
database/
├── factories/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/

routes/
├── web.php
├── api.php
└── console.php

tests/
├── Feature/
└── Unit/
```

> La estructura exacta puede variar según el proyecto. No se crean carpetas únicamente para satisfacer un patrón arquitectónico.

---

## Módulos

Un módulo encapsula una **capacidad funcional del sistema**.

Ejemplo:

```text
app/Modules/
├── EmployeesModule/
├── SchedulingModule/
├── OperationsModule/
├── OrganizationModule/
└── SupportModule/
```

Cada módulo debe contener su propio código relacionado con el dominio.

Ejemplo:

```text
SchedulingModule/
├── Actions/
│   ├── CreateSchedule.php
│   ├── PublishSchedule.php
│   └── AssignEmployee.php
├── Models/
│   ├── Schedule.php
│   └── ScheduleAssignment.php
├── Enums/
├── Policies/
├── Services/
├── Livewire/
├── Providers/
├── Resources/
└── Tests/
```

### Regla principal

Si una funcionalidad pertenece claramente a un módulo, **su código debe vivir dentro de ese módulo**.

Evitar:

```text
app/
├── Models/
│   ├── Employee.php
│   ├── Schedule.php
│   └── Order.php
│
├── Services/
│   ├── ScheduleService.php
│   ├── OrderService.php
│   └── EmployeeService.php
```

Preferir:

```text
app/Modules/
├── EmployeesModule/
│   ├── Models/
│   └── Actions/
│
├── SchedulingModule/
│   ├── Models/
│   └── Actions/
│
└── OrdersModule/
    ├── Models/
    └── Actions/
```

---

## Dependencias entre módulos

Las dependencias deben ser **explícitas y controladas**.

Ejemplo:

```text
SchedulingModule
       │
       ▼
EmployeesModule
```

El módulo de Scheduling puede necesitar información de Employees, pero no debe acceder arbitrariamente a cualquier implementación interna.

Preferir:

```php
$employee = FindEmployee::run($employeeId);
```

sobre:

```php
DB::table('employees')
    ->where('id', $employeeId)
    ->first();
```

La primera opción mantiene la responsabilidad dentro del módulo propietario.

### Evitar

Dependencias circulares:

```text
Module A → Module B
Module B → Module A
```

Si esto ocurre frecuentemente, probablemente los límites de los módulos están mal definidos.

---

## Actions

Las operaciones de negocio importantes se encapsulan en Actions.

Ejemplo:

```php
final class PublishSchedule
{
    public function execute(Schedule $schedule): void
    {
        // Validaciones
        // Persistencia
        // Eventos
        // Efectos secundarios
    }
}
```

El Controller debe limitarse principalmente a coordinar la entrada y salida:

```php
public function publish(Schedule $schedule)
{
    $this->publishSchedule->execute($schedule);

    return redirect()
        ->back()
        ->with('success', 'Horario publicado.');
}
```

No convertir las Actions en clases genéricas tipo:

```text
BaseAction
AbstractAction
GenericAction
ActionManager
ActionFactory
ActionResolver
```

si no existe una necesidad concreta.

---

## Models

Los modelos Eloquent pertenecen al módulo que posee la responsabilidad sobre la entidad.

```text
SchedulingModule/
└── Models/
    └── Schedule.php
```

El modelo debe contener:

- Relaciones.
- Casts.
- Scopes simples.
- Configuración Eloquent.
- Reglas directamente relacionadas con la entidad.

La lógica de procesos complejos debe permanecer fuera del modelo.

---

## UI

Las interfaces Livewire pertenecen al módulo que las utiliza.

```text
SchedulingModule/
└── Livewire/
    ├── ScheduleList.php
    ├── ScheduleForm.php
    └── ScheduleTimeline.php
```

Las vistas:

```text
resources/views/
└── modules/
    └── scheduling/
        ├── schedules/
        └── components/
```

o una estructura equivalente definida por el proyecto.

La UI no debe convertirse en una segunda capa de dominio.

---

## Base de datos

El proyecto utiliza una única base de datos.

Los módulos pueden tener sus propias tablas:

```text
employees
schedules
schedule_assignments
organizations
operations
```

Las migraciones permanecen en:

```text
database/migrations/
```

La propiedad lógica de una tabla pertenece al módulo correspondiente.

Ejemplo:

```text
SchedulingModule
    └── owns → schedules

EmployeesModule
    └── owns → employees
```

No crear bases de datos separadas por módulo salvo que exista una razón operacional real.

---

## Testing

Los tests deben acompañar al módulo cuando sea posible:

```text
app/Modules/SchedulingModule/Tests/
├── Feature/
└── Unit/
```

Además pueden existir tests globales:

```text
tests/
├── Feature/
└── Unit/
```

Prioridad:

1. Reglas de negocio.
2. Casos de uso.
3. Integraciones críticas.
4. UI cuando aporte valor real.

No escribir tests simplemente para aumentar cobertura numérica.

---

## Convenciones

### Naming

```text
CreateSchedule
PublishSchedule
AssignEmployee
CancelSchedule
```

Preferir nombres que representen una intención concreta.

Evitar:

```text
ScheduleManager
ScheduleHelper
ScheduleUtil
ScheduleProcessor
```

cuando no describen claramente una responsabilidad.

### Controllers

Los Controllers deben ser delgados.

```text
Request
   ↓
Controller
   ↓
Action
   ↓
Domain / Model
   ↓
Database
```

### Queries

Evitar:

- N+1 queries.
- Consultas innecesarias.
- `SELECT *` cuando una consulta masiva requiere pocas columnas.
- Consultas repetidas dentro de loops.
- Eager loading indiscriminado.

Medir antes de optimizar.

---

## Reglas arquitectónicas

### DO

- Mantener las funcionalidades dentro de su módulo.
- Definir límites claros.
- Usar Laravel de forma idiomática.
- Aprovechar Eloquent, Policies, Events, Jobs, Notifications, etc.
- Mantener Actions pequeñas y enfocadas.
- Escribir código fácil de eliminar.
- Preferir composición sobre jerarquías innecesarias.
- Revisar consultas SQL generadas en operaciones críticas.

### DON'T

- Crear microservicios prematuramente.
- Crear interfaces para cada clase.
- Crear repositories para ocultar Eloquent sin una razón real.
- Crear DTOs para simples arrays sin necesidad.
- Crear múltiples capas que solamente delegan llamadas.
- Compartir modelos entre módulos indiscriminadamente.
- Acceder directamente a tablas pertenecientes a otros módulos.
- Crear un `Helpers.php` gigante.
- Convertir `app/Services` en un cajón de sastre.

---

## Instalación

```bash
git clone <repository>

cd <project>

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

npm install

npm run build

php artisan serve
```

Para desarrollo:

```bash
php artisan serve
npm run dev
```

---

## Variables de entorno

Configurar como mínimo:

```env
APP_NAME="Laravel Modular Monolith"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=database
```

Los valores reales deben mantenerse fuera del repositorio.

---

## Desarrollo

Antes de implementar una funcionalidad:

1. Identificar el módulo propietario.
2. Definir el caso de uso.
3. Identificar las entidades involucradas.
4. Implementar la lógica de negocio.
5. Integrar la UI/API.
6. Agregar tests relevantes.
7. Revisar dependencias entre módulos.
8. Revisar rendimiento y consultas.

---

## Filosofía

Este proyecto utiliza **Monolito Modular porque es suficiente**.

La arquitectura debe facilitar:

- Desarrollo.
- Mantenimiento.
- Testing.
- Evolución.
- Deploy.
- Debugging.

La complejidad arquitectónica debe justificarse por un problema real.

> **Simple cuando puede ser simple. Modular cuando necesita ser modular. Abstraído cuando existe una razón.**
