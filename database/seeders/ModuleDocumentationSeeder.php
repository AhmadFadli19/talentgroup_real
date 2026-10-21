<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModuleDocumentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Category: GETTING STARTED
        $gettingStarted = ModuleCategory::updateOrCreate(
            ['slug' => 'getting-started'],
            [
                'name' => 'GETTING STARTED',
                'description' => 'Panduan awal instalasi, konfigurasi editor, dan kompatibilitas.',
                'order' => 1,
                'is_active' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'installation'],
            [
                'category_id' => $gettingStarted->id,
                'title' => 'Installation',
                'order' => 1,
                'is_published' => true,
                'enable_protection' => true,
                'excerpt' => 'Langkah-langkah cepat memasang Tailwind CSS di aplikasi Anda.',
                'content' => "# Installation\n\nGet started with Tailwind CSS in your project. Tailwind works by scanning all of your HTML files, JavaScript components, and any other templates for class names, generating the corresponding styles and then writing them to a static CSS file.\n\n## Quick Start with Vite\n\nInstall Tailwind CSS and its peer dependencies via npm:\n\n```bash:Terminal\nnpm install -D tailwindcss @tailwindcss/vite\n```\n\nAdd the `@tailwindcss/vite` plugin to your Vite configuration:\n\n```javascript:vite.config.js\nimport { defineConfig } from 'vite'\nimport tailwindcss from '@tailwindcss/vite'\n\nexport default defineConfig({\n  plugins: [\n    tailwindcss(),\n  ],\n})\n```\n\n## Import Tailwind in your CSS\n\nAdd the `@import \"tailwindcss\";` directive to your main CSS file:\n\n```css:app.css\n@import \"tailwindcss\";\n```\n\n> [!TIP]\n> Pastikan file CSS utama Anda telah diimpor di dalam template HTML utama.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'editor-setup'],
            [
                'category_id' => $gettingStarted->id,
                'title' => 'Editor setup',
                'order' => 2,
                'is_published' => true,
                'enable_protection' => true,
                'excerpt' => 'Ekstensi dan konfigurasi VS Code untuk penulisan utility class yang efisien.',
                'content' => "# Editor Setup\n\nOptimize your developer experience with syntax highlighting, autocomplete, and linting for Tailwind CSS.\n\n## Tailwind CSS IntelliSense\n\nThe official Tailwind CSS IntelliSense extension for Visual Studio Code enhances the Tailwind development experience by providing visual autocomplete, hover previews, and syntax highlighting.\n\n```json:settings.json\n{\n  \"editor.quickSuggestions\": {\n    \"strings\": true\n  },\n  \"css.validate\": false\n}\n```",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'compatibility'],
            [
                'category_id' => $gettingStarted->id,
                'title' => 'Compatibility',
                'order' => 3,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Compatibility\n\nUnderstand browser support and CSS standards compatibility across modern web engines.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'upgrade-guide'],
            [
                'category_id' => $gettingStarted->id,
                'title' => 'Upgrade guide',
                'order' => 4,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Upgrade Guide\n\nStep-by-step instructions to upgrade your existing codebase to the latest version.",
            ]
        );

        // 2. Category: CORE CONCEPTS
        $coreConcepts = ModuleCategory::updateOrCreate(
            ['slug' => 'core-concepts'],
            [
                'name' => 'CORE CONCEPTS',
                'description' => 'Konsep fundamental utility-first styling, status responsif, dan variabel tema.',
                'order' => 2,
                'is_active' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'styling-with-utility-classes'],
            [
                'category_id' => $coreConcepts->id,
                'title' => 'Styling with utility classes',
                'order' => 1,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Styling with utility classes\n\nBuilding complex components purely from single-purpose utility classes without writing custom CSS.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'hover-focus-and-other-states'],
            [
                'category_id' => $coreConcepts->id,
                'title' => 'Hover, focus, and other states',
                'order' => 2,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Hover, focus, and other states\n\nUsing pseudo-class variants to style elements on hover, focus, active, disabled, and more.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'responsive-design'],
            [
                'category_id' => $coreConcepts->id,
                'title' => 'Responsive design',
                'order' => 3,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Responsive design\n\nUsing responsive variant prefixes like `sm:`, `md:`, `lg:`, `xl:`, and `2xl:` to build adaptive layouts.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'dark-mode'],
            [
                'category_id' => $coreConcepts->id,
                'title' => 'Dark mode',
                'order' => 4,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Dark mode\n\nSeamlessly style your site in dark mode using the `dark:` variant.",
            ]
        );

        // THEME VARIABLES (Matching Screenshots 1 & 2!)
        Module::updateOrCreate(
            ['slug' => 'theme-variables'],
            [
                'category_id' => $coreConcepts->id,
                'title' => 'Theme variables',
                'order' => 5,
                'is_published' => true,
                'enable_protection' => true,
                'excerpt' => 'These low-level design decisions are often called design tokens, and in Tailwind projects you store those values in theme variables.',
                'content' => <<<MARKDOWN
These low-level design decisions are often called design tokens, and in Tailwind projects you store those values in theme variables.

## What are theme variables?

Theme variables are special CSS variables defined using the `@theme` directive that influence which utility classes exist in your project.

For example, you can add a new color to your project by defining a theme variable like `--color-mint-500`:

```css:app.css
@import "tailwindcss";

@theme {
  --color-mint-500: oklch(0.72 0.11 178);
}
```

Now you can use utility classes like `bg-mint-500`, `text-mint-500`, or `fill-mint-500` in your HTML:

```html:HTML
<div class="bg-mint-500">
  <!-- ... -->
</div>
```

Tailwind also generates regular CSS variables for your theme variables so you can reference your design tokens in arbitrary values or inline styles:

```html:HTML
<div class="nth-3:underline">
  <!-- ... -->
</div>
<div class="nth-last-5:underline">
  <!-- ... -->
</div>
<div class="nth-of-type-4:underline">
  <!-- ... -->
</div>
<div class="nth-last-of-type-6:underline">
  <!-- ... -->
</div>
```

## Relationship to utility classes

Every theme variable is automatically mapped to one or more utility classes. When you define a color token under `--color-*`, Tailwind makes it available for text colors, backgrounds, borders, rings, and gradients.

| Utility Class | CSS Property | Nilai Contoh |
| ------------- | ------------ | ------------ |
| `bg-mint-500` | `background-color` | `oklch(0.72 0.11 178)` |
| `text-mint-500` | `color` | `oklch(0.72 0.11 178)` |
| `border-mint-500` | `border-color` | `oklch(0.72 0.11 178)` |
| `ring-mint-500` | `--tw-ring-color` | `oklch(0.72 0.11 178)` |

> [!TIP]
> Anda dapat menambahkan variabel tema kustom sebanyak mungkin di dalam blok `@theme` di file CSS utama Anda. Nilai token akan otomatis diindeks oleh Tailwind compiler.

## Customizing your theme

You can customize your theme by extending the default theme or overriding it entirely.

> [!NOTE]
> Nilai variabel tema menggunakan format CSS modern seperti OKLCH untuk rentang warna yang lebih luas dan cerah di monitor modern.
MARKDOWN
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'colors'],
            [
                'category_id' => $coreConcepts->id,
                'title' => 'Colors',
                'order' => 6,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Colors\n\nCustomizing the default color palette for your project.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'adding-custom-styles'],
            [
                'category_id' => $coreConcepts->id,
                'title' => 'Adding custom styles',
                'order' => 7,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Adding custom styles\n\nBest practices for adding custom CSS to your project alongside utility classes.",
            ]
        );

        // 3. Category: BASE STYLES
        $baseStyles = ModuleCategory::updateOrCreate(
            ['slug' => 'base-styles'],
            [
                'name' => 'BASE STYLES',
                'description' => 'Gaya dasar reset CSS dan preflight default.',
                'order' => 3,
                'is_active' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'preflight'],
            [
                'category_id' => $baseStyles->id,
                'title' => 'Preflight',
                'order' => 1,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# Preflight\n\nAn opinionated set of base styles for Tailwind projects built on top of modern CSS normalize standards.",
            ]
        );

        // 4. Category: LAYOUT
        $layout = ModuleCategory::updateOrCreate(
            ['slug' => 'layout'],
            [
                'name' => 'LAYOUT',
                'description' => 'Utility classes untuk tata letak elemen.',
                'order' => 4,
                'is_active' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'aspect-ratio'],
            [
                'category_id' => $layout->id,
                'title' => 'aspect-ratio',
                'order' => 1,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# aspect-ratio\n\nUtilities for controlling the aspect ratio of an element.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'columns'],
            [
                'category_id' => $layout->id,
                'title' => 'columns',
                'order' => 2,
                'is_published' => true,
                'enable_protection' => true,
                'content' => "# columns\n\nUtilities for controlling the number of columns within an element.",
            ]
        );
    }
}
