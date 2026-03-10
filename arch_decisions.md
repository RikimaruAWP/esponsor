# Registro de Decisiones y Arquitectura (eSponsor Pro)

Este documento detalla las decisiones técnicas y de arquitectura tomadas durante el desarrollo para cumplir con los criterios de evaluación de nivel "Senior".

## 1. Estructura de Datos (BBDD)
- **Soft Deletes:** Se implementó `deleted_at` en la tabla `links`. Esto garantiza la integridad referencial y permite auditorías de datos sin pérdida de información, una práctica estándar en aplicaciones SaaS.
- **Aggregations:** En lugar de procesar datos en la capa de vista (Vue), los cálculos de métricas se realizan mediante agregaciones de Eloquent (`sum`, `count`, `avg`) en el servidor para optimizar el rendimiento y la escalabilidad.

## 2. Arquitectura Backend (MVC & Laravel)
- **Modelos:** Se utilizaron Traits nativos (`SoftDeletes`) para extender funcionalidades sin sobrecargar los modelos.
- **Routing & Controladores:** La lógica de negocio para el Dashboard se centralizó en rutas seguras asociadas al usuario autenticado, respetando el principio de "Menor Privilegio".
- **Paginación:** Implementación de `LengthAwarePaginator` de Laravel para la tabla de apoyos, reduciendo la carga de memoria en el navegador cliente.

## 3. Arquitectura Frontend (Componentización & Vue 3)
- **Estructura Atómica:** Se utilizaron componentes reutilizables (`TextInput`, `InputLabel`, `PrimaryButton`) para mantener la consistencia visual y facilitar el mantenimiento.
- **Inertia.js Integration:** Uso de prop injection para mantener el estado sincronizado entre PHP y Vue sin necesidad de una API REST separada, simplificando la complejidad del proyecto.
- **Tailwind CSS Professional:** Uso estricto de utilidades de Tailwind (Grid, Flexbox, Transitions) para garantizar una responsividad 100% Mobile-First.

## 4. Buenas Prácticas & Seguridad
- **Validación HTML5:** Todos los formularios incluyen `maxlength`, `required` y `pattern` (Regex) para evitar ingresos de datos basura.
- **CSRF & Spoofing:** Uso de directivas de Inertia para manejo seguro de formularios (spoofing de `PUT` en multipart/form-data).
- **Toast System:** Implementación de un sistema de notificaciones nativo en Vue para mejorar la experiencia de usuario (UX) sin dependencias de terceros.
