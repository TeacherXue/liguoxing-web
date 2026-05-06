# Development Spec Extracted From docs/example (Structure and Standards Only)

> Purpose: use `docs/example` only as a reference for project structure, tech stack, and coding standards.
> Restriction: do not reuse any copy, image, video, brand element, contact detail, or case content from `docs/example`.

## 1. Directory Structure

Recommended static site structure:

- `/*.html`: page-based split (home, about, product/equipment, news, contact, download)
- `/css/`: style resources (main stylesheet + responsive additions)
- `/js/`: interaction scripts
- `/images/`: site assets (only original or licensed project assets)
- `/docs/`: company materials and downloadable files
- `robots.txt`, `sitemap.xml`: baseline SEO files

## 2. HTML Standards

- Each page should have its own `title`, `meta description`, and `canonical`
- Home page should include Open Graph, Twitter Card, and Organization JSON-LD
- Product/equipment pages should include Product JSON-LD
- Use semantic tags: `header`, `nav`, `main`, `section`, `article`, `footer`
- Keep navigation naming consistent across all pages
- All images require `alt`; non-first-screen images should use `loading="lazy"`

## 3. CSS Standards

- Use CSS variables for color, spacing, and container width tokens
- Organize styles by sections/components (for example `hero`, `section`, `card`, `footer`)
- Desktop-first with responsive breakpoints for tablet and mobile
- Keep class names readable and low-coupling; avoid deeply nested selectors

## 4. JS Standards

- Keep only necessary interactions; avoid redundant plugins
- Separate interaction logic from layout styles
- Validate plugin dependencies and versions before use
- Minimize render-blocking script behavior for production pages

## 5. Information Architecture

Recommended global navigation:

1. Home
2. About Us
3. Equipment
4. News
5. Application
6. Contact Us
7. Download

Recommended homepage modules:

1. Hero value proposition + CTA
2. Core equipment/capability showcase
3. Company profile and strengths
4. Application scenarios
5. Latest news
6. Footer contact and quick links

## 6. SEO and Maintainability Checklist

- Check dead links, missing images, and typo issues before launch
- Keep URLs simple and stable (English, lowercase, short paths)
- Maintain `sitemap.xml` and `robots.txt`
- External copy, contact info, and address must follow the latest company data

## 7. Content Usage Redlines

Only layout form can be referenced. Direct reuse is prohibited for:

- Any text in `docs/example`
- Any image/video in `docs/example/images`
- Any company names, emails, phone numbers, addresses, cases, or news in `docs/example`

Execution strategy:

- Layout logic can be referenced, but all assets must be project-owned
- Copy must be rewritten based on LIGUOXING materials in `docs`
- Use placeholder logo until the final official logo is provided
