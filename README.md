# eSponsor — Plataforma de Apoyo a Creadores de Contenido

Clon funcional de una plataforma tipo "Buy Me a Coffee" desarrollado como desafío técnico para eSponsor.  
Permite a creadores gestionar su perfil, enlaces y recibir apoyos (donaciones simuladas) de su audiencia.

---

## 🛠 Stack Tecnológico

| Capa | Tecnología |
|---|---|
| Backend | **Laravel 12** (PHP 8.3) |
| Frontend | **Vue 3** + **Inertia.js** |
| Estilos | **Tailwind CSS 4** |
| Autenticación | **Laravel Breeze** |
| Base de Datos | **SQLite** (dev) |
| Build Tool | **Vite 6** |

---

## ⚙️ Instalación y Ejecución Local

### Requisitos
- PHP 8.2+
- Composer
- Node.js 20+

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/esponsor.git
cd esponsor

# 2. Instalar dependencias de PHP
composer install

# 3. Instalar dependencias de Node
npm install

# 4. Configurar el entorno
cp .env.example .env
php artisan key:generate

# 5. Crear la base de datos y ejecutar migraciones + seeders
touch database/database.sqlite
php artisan migrate

# 6. Iniciar ambos servidores (en dos terminales separadas)
php artisan serve        # Terminal 1 → http://127.0.0.1:8000
npm run dev              # Terminal 2 → Vite con Hot Reload
```

---

## 📐 Arquitectura y Decisiones Técnicas

### Modelos de Datos

```
User (Breeze)
  └── Creator (1:1) — Creado automáticamente al registrarse
        ├── links (1:N) — SoftDeletes habilitado
        └── supports (1:N) — Registradas por visitantes
```

- **Creator** se crea automáticamente al registrar un `User` (interceptando `RegisteredUserController`).
- **slug** único generado desde el nombre de usuario, validado con `pattern` regex en frontend.
- **Links** implementan `SoftDeletes` para preservación histórica de datos.
- **Supports** almacenan nombre, monto y mensaje opcional del donante.

### Backend (Laravel MVC)

- **Rutas:** Protegidas por middleware `auth` para el dashboard.
- **Métricas:** Calculadas en el servidor con `sum()`, `count()` y `avg()` de Eloquent — no en el frontend.
- **Paginación:** `->paginate(5)` para la tabla de apoyos (escalable para miles de registros).

### Frontend (Vue 3 + Inertia)

- **Componentización:** Uso de componentes atómicos (`TextInput`, `PrimaryButton`, `InputLabel`).
- **Estado reactivo:** `useForm` de Inertia para manejar formularios con estado de error y éxito.
- **Toast nativo:** Sistema de notificaciones implementado con `ref()` y `watch()` de Vue 3, sin librerías externas.

---

## 🔒 Seguridad Implementada

- **CSRF Protection:** Inertia gestiona el token CSRF automáticamente.
- **Autorización:** Middleware `auth` protege todas las rutas del dashboard.
- **Validación HTML5:** `maxlength`, `pattern` (regex) y `required` en todos los formularios.
- **File Upload:** Validación de tipo MIME y tamaño en el backend para el avatar.
- **Soft Deletes:** Los datos eliminados son auditables y recuperables.

---

## 📱 Páginas Implementadas

| Página | Ruta | Acceso |
|---|---|---|
| Landing Page | `/` | Público |
| Registro | `/register` | Público |
| Login | `/login` | Público |
| Dashboard | `/dashboard` | Autenticado |
| Perfil Público | `/@{slug}` | Público |

---

## 🎬 Demostración en Video

> 🔗 **[Ver video demostrativo en YouTube/Loom](URL_DEL_VIDEO_AQUÍ)**

