# 🏡 Catálogo de Quintas — CASASTEQUES

Aplicación web para la exhibición y gestión del catálogo de quintas y casas de descanso en **Tequesquitengo, Morelos**. Permite a los clientes explorar propiedades disponibles (como *Casa Luna*, *Casa Cory* y *Casa Géminis*), consultar tarifas, capacidad y amenidades, e iniciar cotizaciones directamente vía **WhatsApp**.

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=flat&logo=livewire&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)

---

## ✨ Características principales

* **Catálogo interactivo en tiempo real:** Filtrado y navegación dinámica de propiedades sin recargar la página mediante componentes de **Livewire**.
* **Fichas detalladas por propiedad:** Visualización de galería fotográfica, capacidad máxima de huéspedes, tarifas (fin de semana, entre semana y temporada alta), depósito en garantía y servicios adicionales (caldera, jacuzzi, personal de cocina).
* **Enrutamiento directo a WhatsApp:** Botones de contacto con mensajes prellenados según la quinta seleccionada para agilizar la atención comercial y el cierre de reservaciones.
* **Panel administrativo:** Gestión CRUD de propiedades, actualización de precios, disponibilidad y carga de imágenes optimizadas.
* **Diseño responsivo:** Interfaz adaptable a dispositivos móviles para tráfico proveniente de campañas en redes sociales (TikTok, Facebook e Instagram).

---

## 🛠️ Stack tecnológico

* **Backend:** PHP 8.2+, Laravel Framework
* **Frontend reactivo:** Laravel Livewire, Blade, Tailwind CSS
* **Base de datos:** MySQL / SQLite
* **Herramientas de compilación:** Composer, Node.js & Vite

---

## 📂 Estructura del proyecto

```text
catalogo-quintas/
├── app/
│   ├── Livewire/          # Componentes reactivos del catálogo y filtros
│   └── Models/            # Modelos Eloquent (Quinta, Amenidad, Tarifa, Imagen)
├── database/
│   ├── migrations/        # Esquema de tablas de propiedades y multimedia
│   └── seeders/           # Datos iniciales del catálogo
├── public/
│   └── storage/           # Imágenes y recursos multimedia públicos
├── resources/
│   └── views/
│       └── livewire/      # Vistas Blade de tarjetas y detalle de quintas
└── routes/
    └── web.php            # Rutas públicas del catálogo y panel administrativo
