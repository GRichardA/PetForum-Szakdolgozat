# Design System

Date: 2026-04-25
UI stack: Blade templates + Tailwind CSS 4 style tokens

## Component approach

- Core UI layer: Tailwind utility classes in Blade views.
- Form patterns: shared field, error, and submit patterns across auth/profile/event screens.
- Feedback patterns: inline validation errors, success flashes, guarded actions for auth-only routes.

## Color palette

The current implementation relies on Tailwind semantic colors and neutral surfaces.
The table below defines the target palette used in UX documentation.

- Primary: #2563EB
- Secondary: #475569
- Accent: #0EA5E9
- Success: #16A34A
- Warning: #D97706
- Error: #DC2626
- Surface: #FFFFFF
- Surface alt: #F8FAFC
- Text primary: #0F172A
- Text secondary: #334155

## Typography

- Primary font family: Instrument Sans
- Fallback stack: ui-sans-serif, system-ui, sans-serif
- Scale guideline:
  - H1: 32px / 700
  - H2: 24px / 600
  - H3: 20px / 600
  - Body: 16px / 400
  - Caption: 14px / 400

## Spacing and layout

- Base spacing unit: 8px
- Preferred content max width: 1200px
- Form width target: 480-640px depending on page intent
- Card gap guideline: 16-24px

## Iconography

- Current: inline SVG and minimal icon usage in views.
- Recommendation: standardize with Heroicons or Lucide in next iteration.

## Dark mode

- Current support: not implemented.
- Recommendation: add tokenized color variables before enabling dark mode.

## Responsive breakpoints

- Mobile: 0-639px
- Tablet: 640-1023px
- Desktop: 1024px+
- Wide desktop: 1280px+

## Accessibility baseline

- Keyboard reachable interactive controls.
- Form labels and inline error messaging in key forms.
- Further work needed: explicit ARIA audit and contrast test evidence.

## Source references

- [resources/css/app.css](resources/css/app.css)
- [resources/views/layouts/app.blade.php](resources/views/layouts/app.blade.php)
- [docs/03_design/ux_flows.md](docs/03_design/ux_flows.md)
