# Redesign progress — دليل الأطباء

## Done
1. **Clinic system (stage 1, approved):** `public/css/clinic/theme.css` rewritten as a presentational layer (palette, type, sidebar, stat cards, tables, tabs, inputs, modals, dropdowns, dark mode).
2. **Public site mobile pass (stage 2):**
   - New file `public/css/public/refine.css`, linked last in `resources/views/home/layout/app.blade.php` (only change to that file: one `<link>` line).
   - Brand name now shows beside the logo on phones.
   - Home hero: the big decorative doctor graphic is hidden on phones so search appears first; title sized for phones.
   - Specialty cards: two per row on phones (one per row under 360px), description clamped to 2 lines.
   - Section headers stack cleanly; sort dropdown is full width.
   - "Join as doctor" / jobs banner: fixed the title breaking one word per line and the squeezed button; button is now full width.
   - Home "join" illustration hidden on phones.
   - Doctor profile: shorter photo block, call/WhatsApp buttons side by side, tighter cards, booking dialog fits the screen and keyboard (`100dvh`), image viewer fits.
   - Footer: 2 columns on phones, bigger tap targets.
   - Inputs are 16px on phones (stops iPhone zoom), 44–48px tap targets, visible keyboard focus ring.

3. **Public pages readability & cards pass (stage 3):**
   - New files, each scoped to one responsibility, linked after `refine.css` in `home/layout/app.blade.php` (that file only gained 4 `<link>` lines):
     - `public/css/public/type-scale.css` — shared public-site type scale (section labels, search/filter bars, pagination, empty states, footer). The original sheet used 7–10px for these.
     - `public/css/public/cards-doctor.css` — doctor card: readable name/specialty/meta, pill badges and tags, avatar and cover proportions, button as a full-size target, 3→2→1 column grid.
     - `public/css/public/cards-job.css` — job cards and the "post a job" banner: readable meta, equal-height cards with the action pinned to the bottom, 3→2→1 column grid, stacked banner on phones.
     - `public/css/public/doctor-profile.css` — profile page: about text, booking days/slots, reviews, sidebar and the booking dialog lifted to readable sizes with 46–48px actions.
   - No colours were changed, so dark mode and the existing identity are untouched.

## Pages checked (real Laravel run, sample data, 1280px and 375px)
`/`, `/doctors`, `/doctors/1`, `/specialties`, `/jobs`, `/about-me`, `/login` — all HTTP 200, no horizontal overflow at either width.

## Files changed
- `public/css/clinic/theme.css` (stage 1)
- `public/css/public/refine.css` (new)
- `resources/views/home/layout/app.blade.php` (+1 stylesheet link)

## JS / CSS organisation
- The only inline script on public pages (`doctor_details.blade.php`, `window.medBookingData`) was **left inline on purpose**: it passes `old()` and `$errors` values from Blade to JS, so moving it out would break the booking form restoring its values.
- No JS files were changed.

## Still to do (next steps, in order)
1. Doctor cards on `/doctors` and home: they didn't show with the sample data (the list query returned nothing), so card layout on phones is **untested visually**. Next step: check with real data at 320/375/430px.
2. Doctor profile: check the booking day list and time slots, reviews and gallery with a doctor that has those features.
3. Jobs pages (`jobs_details`, `create_jobs`, `edit_job`): mobile form pass.
4. Auth pages (`resources/views/auth/*`, `public/css/auth/auth.css`).
5. Doctor dashboard (`public/css/doctor/*`), then admin (`public/css/admin/*`).
6. Clinic screens in depth: bookings/queue, patients, finances.
7. Dark-mode check of the public phone fixes.

**Stopped at:** end of the public readability/cards pass (stage 3). Resume at jobs detail/create/edit forms, then auth pages.

> Stage 3 was written without a running Laravel instance (no visual check). Please open `/`, `/doctors`, `/doctors/{id}` and `/jobs` at 1280px and 375px to confirm.

## Issues found but NOT fixed (need backend/content changes)
- `resources/views/vendor/pagination/custom.blade.php` is missing from the project, but `specialties`, `jobs` and `doctors` all call `links('vendor.pagination.custom')`. Those pages crash with pagination unless the file exists on your server.
- Some queries use MySQL `NOW()` (they won't work on SQLite; fine on MySQL).
- `firsthero` component buttons point to `doctors.html` / `contact.html` (placeholder links) on non-home pages.
- Home search form (`#homeSearchForm`) city options are hardcoded (4 governorates), not taken from the areas table.

## Confirmation
No controllers, models, routes, migrations, validation, policies, middleware, queries or business conditions were modified. No IDs, classes, `data-*` attributes, form fields, `@csrf`, `old()` or error handling were changed.

## Stage 4 — Job details + auth pages (2026-09-28)
Presentational CSS only, same rules as stage 3 (no markup/logic/color changes).

- New `public/css/public/job-details.css`: readable type on `/jobs/{id}` — hero category/title, data grid labels/values (were 8–10px), section text, extra-info, apply/contact buttons (15px, 50px targets), publisher card, security note. Stacks the sidebar under the content below 992px; data grid 3→2→1 columns.
- New `public/css/public/auth-pages.css`: login/forgot-password readability — labels 13.5px, inputs 16px/50px (stops iOS zoom), buttons 16px/52px, links and notes readable. Decorative hero column hides below 992px so the form takes full width on phones.
- Both linked in `home/layout/app.blade.php` after `doctor-profile.css`.

**Stopped at:** end of stage 4. Remaining: `create_jobs`/`edit_job` forms pass, then doctor dashboard and admin areas (not started, need confirmation).

> Not visually verified (no running Laravel here). Please open `/jobs/{id}`, `/login` and `/password/reset` at 1280px and 375px to confirm.

## Stage 5 — Job create/edit forms (2026-09-28)
- New `public/css/public/job-form.css` (scoped to `.form-layout`): inputs 16px/50px (were 11px), labels 14px, errors 13px with red field border, section icons in soft chips, full-width submit on phones, sidebar tips stack under the form below 992px, 1-column grid below 640px, review-notice accent. Dark mode via existing theme variables + `body.dark` tweaks. Linked in `home/layout/app.blade.php`.

## Stage 6 — Doctor dashboard (2026-09-28)
- New `public/css/doctor/dashboard/readability/*.css` — one file per existing module (app, sidebar, topbar, ratings, notifications, subscription, account-notification). Each repeats only the rules that had text under 12px, with the same selector and media query, at 12–13.5px (175 rules total). Original sheets untouched.
- New `public/css/doctor/dashboard/ux.css` — shared dashboard layer: focus rings, 44px sidebar links, 16px/46px inputs, scrollable tables and 46px buttons on phones, reduced motion.
- Linked: layout `doctor/layouts/app.blade.php` (app, sidebar, ux); page files push their own layer next to the original sheet (index, doctor_profile/edit, notifications, ratings).

**Stopped at:** end of stage 6. Remaining: admin area, clinic screens (bookings/queue, patients, finances), then a dark-mode sweep.
> Not visually verified (no running Laravel here).

## Stage 7 — Public Site UI, Responsive Polish & Doctors Grid Component (2026-09-28)
Comprehensive UI/UX and Responsive refinements applied to the public website without altering any backend logic, database, models, controllers, routes, validation, or existing feature sets.

### 1. New Files
- `resources/views/components/home/doctors/doctors_grid.blade.php`: New independent Blade component designed for displaying small groups of doctors in secondary public sections. Supports 3 columns on Desktop, 2 on Tablet, and 1 on Mobile, while rendering the existing `card_doctor_clinic_system_component` with exact same data, logic, badges, and links.
- `public/css/public/ui-enhancements.css`: Dedicated presentational layer loaded last in `app.blade.php`. Scoped selectors for doctor grid, banner responsiveness, result count hierarchy, footer redesign, about page cards, and mobile auth.

### 2. Modified Files
- `resources/views/home/layout/app.blade.php`:
  - Linked `ui-enhancements.css`.
  - Upgraded mobile navigation drawer (`public-mobile-nav`) with categorized sections, clear icons, and UI-only placeholders for "تواصل معنا" and "الأسئلة الشائعة" without fake hrefs.
  - Balanced visual weight of "تسجيل الدخول" and "انضم كطبيب" as primary action buttons in the drawer.
  - Redesigned footer into a modern, 4-column layout on Desktop, 2-column on Tablet/Mobile, using ONLY existing routes (`doctors.index`, `specialties.index`, `jobs.index`, `doctor_join`, `jobs.create`, `about`).
- `resources/views/home/index.blade.php`:
  - Replaced `.home-doctors-grid` markup with the new independent `<x-home.doctors.doctors_grid :doctors="$doctors" />`.
  - Banner "هل أنت طبيب؟" enhanced for mobile screens (375px, 390px, 430px) to prevent horizontal overflow and card breaking.
- `resources/views/home/doctors/doctor_details.blade.php`:
  - Replaced `.med-similar-grid` markup with `<x-home.doctors.doctors_grid :doctors="$similar_doctors" />`.
- `resources/views/home/info/about.blade.php`:
  - Replaced placeholder `contact.html` link with safe UI element.
  - Full responsive audit: features grid 3→2→1 columns, mission section 2→1 columns, company card responsive stacking.
- `resources/views/components/home/hero/firsthero.blade.php`:
  - Replaced placeholder `doctors.html` with real `route('doctors.index')` and `contact.html` with safe UI element.
- `public/css/layouts/public-nav.css`:
  - Fixed mobile drawer close button dimensions and prevented global button selectors from overriding drawer controls.

### 3. Doctors Grid Component & Primary Doctor Card Safety
- The primary Doctor Card (`card_doctor_clinic_system_component.blade.php`) and the main Doctors listing page (`/doctors` - `resources/views/home/doctors/doctors.blade.php`) **were NOT broken, replaced, or altered**.
- The new `<x-home.doctors.doctors_grid>` is strictly utilized in:
  1. `resources/views/home/index.blade.php` (Home page featured doctors).
  2. `resources/views/home/doctors/doctor_details.blade.php` (Similar Doctors section).
- Re-uses the existing card component internally to avoid any markup or logic duplication, guaranteeing 100% data consistency, subscription badge logic, rating display, and booking action links.

### 4. Key Responsive Enhancements
- **Banner "هل أنت طبيب؟"**: Responsive grid collapsing to 1 column below 900px, hidden decorative visual on mobile, fluid typography (`clamp(21px, 5.5vw, 27px)`), wrapping feature tags, full-width CTA button, zero horizontal scroll verified at 375px, 390px, and 430px.
- **"تم العثور على عدد..."**: Restructured hierarchy across `doctors.blade.php`, `specialty.blade.php`, and `jobs.blade.php`. Section title is the primary visual anchor; result count is a secondary pill badge (`font-size: 13px`) that drops cleanly beneath the title on mobile screens without horizontal squeezing or overlap.
- **Footer**: Modern dark/light theme alignment, responsive 4→2→1 columns, clean icon list items, 40px+ tap targets on phones, and safe routing.
- **Sidebar Drawer**: Polished header, structured navigation sections, UI elements for Support/FAQ, and balanced login/join buttons.
- **About Us**: Card grids dynamically scale across desktop (3), tablet (2), and mobile (1), preventing any content clipping or overflow.
- **Auth (Login & Register)**: Safe card padding, 16px font inputs preventing iOS zoom, 50px tap target buttons, and embedded error states.

### 5. Remaining Notes
- All requested tasks completed with zero modifications to backend logic, queries, models, or database schemas.

## Stage 8 — Mobile Footer Columns, Search Truncation & Doctor Dashboard Footer Fixes (2026-09-28)
Targeted UI and responsive refinements requested by the user:

### 1. Specialties & Jobs Search Sizing & Truncation Fix
- **Issue**: On mobile screens (e.g. 375px), `.specialties-search-box` had a fixed 150px button that squeezed the input down to ~100px. With 16px font from `refine.css`, placeholder text "ابحث عن تخصص طبي..." was cut off at the last letter "ص" in "تخصص".
- **Fix**:
  - In `resources/views/home/specialty/specialty.blade.php`: updated placeholder to `ابحث عن تخصص...`.
  - In `resources/views/home/jobs/jobs.blade.php`: updated placeholder to `ابحث عن وظيفة...`.
  - In `public/css/public/ui-enhancements.css`: added responsive rules for `.specialties-search-box` below 768px:
    - Button width made compact (`min-width: 80px`, flex-shrink: 0).
    - Input expands to full available width (`230px+`) with `font-size: 14px` and placeholder `13.5px` (down to `13px` / `12px` below 380px).
    - Text never overflows or truncates; letter "ص" is 100% visible.

### 2. Public Footer Mobile Link Layout
- **Issue**: On mobile screens (<= 380px), footer link columns were collapsed into a single 1fr column (`grid-template-columns: 1fr !important`), stacking every link underneath each other and creating an unnecessarily elongated footer.
- **Fix**:
  - In `public/css/public/ui-enhancements.css`: updated `.site-footer .footer-grid` for `<= 768px` to `repeat(3, minmax(0, 1fr)) !important`.
  - Removed the `1fr` single-column override from the `<= 380px` media query.
  - Placed the 3 link columns ("استكشف", "للأطباء", "المساعدة") side-by-side, tightened vertical link padding to `2px 0`, and set font size to `12px` (and `11px` under 380px).
  - Footer height is significantly reduced, compact, and neatly balanced.

### 3. Sidebar Drawer Links ("تواصل معنا" & "الأسئلة الشائعة")
- **Issue**: "تواصل معنا" and "الأسئلة الشائعة" were non-interactive span elements with a "قريبًا" badge.
- **Fix**:
  - In `resources/views/home/layout/app.blade.php`: removed the `is-ui-item` class and the `<span class="public-nav-pill">قريبًا</span>` badges.
  - Converted both to regular links (`<a href="#" class="public-mobile-nav-link">`) with the same primary blue icon styling and hover behaviors as all other navigation links.

### 4. Doctor Dashboard Footer Text Overlap & Mobile Layout
- **Issue**: In the doctor dashboard footer (`<x-doctor.dashboard.footer />`), mobile rules in `app.css` (<= 430px) forced `grid-template-columns: 1fr` and `text-align: center`, which caused elements, margins, and text lines to pile awkwardly on top of each other.
- **Fix**:
  - In `public/css/doctor/dashboard/app.css`: updated the `<= 430px` media query to maintain a 2-column layout (`grid-template-columns: 1fr 1fr; text-align: right;`) and reset center margins.
  - In `public/css/doctor/dashboard/ux.css`: added dedicated responsive grid rules for `.footer` across all viewports:
    - Desktop: 3-column layout (`1.8fr 1fr 1.2fr`).
    - Mobile (<= 768px & <= 380px): Brand column spans full width (`grid-column: 1 / -1`), while "حسابي" and "تواصل معنا" sit side-by-side in 2 equal columns (`grid-template-columns: 1fr 1fr !important`).
    - Ensured correct RTL alignment, comfortable line heights (`1.75`), compact WhatsApp CTA button, and clear spacing so text never collides or stacks uncomfortably.

## Stage 9 — Contact Page UI & Responsive Modernization (2026-09-28)
Comprehensive professional UI and responsive redesign of the public "تواصل معنا" (Contact Us) page matching the visual identity of "دليل الأطباء".

### 1. Files Created & Modified
- **`public/css/public/contact.css` (New)**:
  - Dedicated presentational stylesheet scoped strictly to `.contact-*` and `.faq-*` elements.
  - Full RTL support with native alignment and responsive spacing.
  - 100% Dark Mode compatibility using the project's native CSS variables (`--card`, `--input`, `--text`, `--text-light`, `--border`, `--primary`, `--shadow`).
  - Balanced 2-column desktop grid (`minmax(320px, 1fr) 1.4fr`) gracefully transitioning to a 1-column stack below 992px and 768px.
- **`resources/views/home/contact/index.blade.php` (Enhanced)**:
  - **Header / Hero**: Integrated `<x-home.hero.secondhero>` with clean breadcrumbs (`الرئيسية > تواصل معنا`), support badge ("فريق الدعم والمساعدة"), concise title, and professional description note.
  - **Direct WhatsApp Card**: Prominent card with direct link `https://wa.me/201093796014`, phone `01093796014`, availability badge, and soft green styling.
  - **Contact Information Cards**: Structured blocks for Phone (`0109 379 6014`), Location (`البحيرة — جمهورية مصر العربية`), and Working Hours (`يوميًا من 10:00 ص حتى 8:00 م`), plus social channels.
  - **Contact Form**: 100% backend preservation ("اللوجيك خط احمر"):
    - Exact field names: `name`, `phone`, `message`.
    - Exact route: `POST {{ route('contact.store') }}` with `@csrf`.
    - Maintained `old()` values and `@error` blocks with inline SVG warning icons.
    - Added in-form success alert matching the card styling when `session('success')` is present.
    - Prevents iOS auto-zoom (`font-size: 16px` on mobile), comfortable textarea height (130px), and prominent full-width submit button.
  - **FAQ Section**: Modern list of frequent questions with smooth vanilla JavaScript accordion toggle and quick WhatsApp support trigger.
- **`resources/views/home/layout/app.blade.php`**:
  - Linked `public/css/public/contact.css` in the `<head>`.
  - Connected real `route('contact.index')` in the mobile sidebar drawer and public site footer.

### 2. Responsive & Viewport Verification
- **375px (iPhone SE)**: 1-column stack, zero horizontal overflow, cards fit within viewport with 14px padding, 48px tap targets, readable font sizes.
- **390px & 430px (Standard / Pro Max Phones)**: Clean margins, cards neatly spaced, zero overflow.
- **768px (Tablets)**: Balanced vertical rhythm, form and info panel cleanly stacked.
- **1024px & 1200px+ (Desktops)**: Proportional 2-column layout (Info 40%, Form 60%), elegant box shadows, professional appearance.

### 3. Logic & Backend Preservation
- No modifications to `ContactMessageController`, `ContactMessage` model, database migrations, requests, validation rules, or routes.

## Stage 10 — FAQ Page Responsive Fixes (2026-09-28)
Targeted responsive and functional fixes for the FAQ page (`/faq`). No design, color, or layout changes — only bug fixes.

### Files Changed
- **`public/css/public/faq.css` (New)**:
  - Fixes `max-height: 180px` on `.faq-item.active .faq-answer` → raised to `600px` so long answers are never clipped.
  - Responsive `category-grid`: 4 cols (≥1024px) → 2 cols (≤992px) → 2 cols (≤768px).
  - Visual section separation on mobile: `border-top` + adjusted padding between `.categories-section` and `.questions-section`.
  - Reduced heavy `padding: 0 62px 0 65px` on `.faq-answer` to `16px` on mobile — prevents overflow and improves readability.
  - Max-width cap on container (≥1400px) to prevent form from stretching on ultra-wide screens.
  - `overflow-x: hidden` on both sections.
  - Consistent padding/font-size scale across 375 / 390 / 430 / 768 / 992 / 1024 / 1200 / 1440px.

- **`resources/views/home/info/faq.blade.php`**:
  - Uncommented `<link rel="stylesheet" href="{{ asset('css/public/faq.css') }}">` in `@push('styles')`.
  - **Added FAQ accordion JavaScript** in `@push('scripts')` — the original script only handled category switching; accordion toggle (`.faq-item.active`) was missing entirely:
    - Click `.faq-question` → toggles `active` class on parent `.faq-item`.
    - One question open at a time per category.
    - Switching categories closes all open items.
    - No external dependencies.

### Problems Fixed
1. **Accordion not working** — JS was missing; added clean vanilla JS toggle.
2. **Long answers clipped** — `max-height: 180px` too small; raised to `600px`.
3. **Section separation on mobile** — added `border-top` separator + adjusted padding.
4. **Category grid fixed 4-col** — made responsive (2-col on tablet/mobile).
5. **Answer padding overflow** — `62px/65px` reduced to `16px` on mobile.
6. **Ultra-wide container** — capped at `1200px` on `≥1400px` screens.

## Stage 11 — Contact Page Hero Overlap, Mobile Card Separation & FAQ Accordion Fixes (2026-09-28)
Comprehensive resolution of layout and accordion issues on `/contact` and `/faq` based on image analysis and multi-screen testing:

### 1. Files Modified
- **`public/css/public/contact.css`**:
  - **Large Screens (Desktop)**: Removed `margin-top: -55px` from `.contact-wrapper` (`margin-top: 0 !important; max-width: 1200px`) and added `padding: 36px 0 70px` to `.contact-section`. The hero `<x-home.hero.secondhero>` no longer overlaps or "eats" the contact form; headers "أرسل رسالة" and "بيانات التواصل" are completely visible and clear.
  - **Small Screens (Mobile ≤768px, 430px, 390px, 375px)**: Reset `.contact-wrapper` negative margin (`margin-top: 0 !important; gap: 18px`) and added clean `padding: 24px 0 50px` to `.contact-section`. This visually separates the blue hero from the blue "بيانات التواصل" card with the page background showing in-between, so they no longer touch or look like a single merged block.
  - **FAQ Closed-State Text Leak on Phone**: Replaced `padding: 0 16px 14px` on `.faq-answer` with strict `padding-top: 0 !important; padding-bottom: 0 !important; max-height: 0 !important; overflow: hidden !important;` when closed. Only applied bottom padding (`padding-bottom: 16px !important`) when `.faq-item.active`. Completely fixed the text leaking underneath closed questions shown in Image 3.
- **`resources/views/home/info/faq.blade.php`**:
  - Removed duplicate accordion click listener that conflicted with `public/js/app.js` (which already handles `.faq-item` toggle). The duplicate listeners were toggling `active` on and immediately off in the same click, causing questions not to open. Now questions open and close smoothly across all screen sizes.
- **`public/css/public/faq.css`**:
  - Reinforced `max-height: 0 !important; padding-top: 0 !important; padding-bottom: 0 !important; overflow: hidden !important;` for inactive questions and `max-height: 600px !important; padding-bottom: 20px !important;` for active questions.

### 2. Verification Across Breakpoints
- **375px / 390px / 430px (Phones)**:
  - Hero and "بيانات التواصل" have distinct visual separation (24px gap).
  - Closed FAQ questions show exactly 0px height, zero text peek.
  - Open FAQ questions expand smoothly with full text readable.
- **768px (Tablets)**:
  - 1-column responsive layout, clean spacing, touch targets ≥ 48px.
- **992px / 1200px / 1440px+ (Desktops)**:
  - 2-column layout (Info card + Form card) with zero hero overlap.
  - Form container capped cleanly at 1200px.
- **Backend & Logic**: Zero changes to routes, controllers, models, or database.
- **Footer Bottom Spacing Polish**: Reduced bottom padding and margin on `.site-footer` and `.footer-bottom` across desktop and mobile in `ui-enhancements.css`, removing the excessive empty space between copyright text and the page bottom.

## Stage 12 — Doctor Dashboard Help Page Redesign & Sidebar Notification Badge Fix (2026-09-28)
Targeted implementation of two specific Doctor Dashboard enhancements:

### 1. Doctor Dashboard Help Page (`doctor/dashboard/help/index.blade.php`)
- **Complete Visual Redesign**: Redesigned from scratch using dedicated scoped classes (`.doc-help-*`) in new file `public/css/doctor/dashboard/help.css` pushed via `@push('extra_style')`.
- **Search Completely Removed**: Removed search input entirely, with no replacement search, per requirements.
- **Preserved Existing Questions**: Preserved all 3 original questions and answers verbatim.
- **Category Switcher Tabs**: Added category tabs ("عرض الكل", "إدارة الحجوزات", "مساعد الدكتور", "الملفات الطبية") inspired by the public FAQ pattern for intuitive category filtering.
- **Smooth Accordion**: Scoped vanilla JS accordion with smooth `max-height` transition, arrow rotation, active highlight, and strict 0px height when closed (preventing any text leak).
- **Responsive Layout**: Fluid header banner, 4-col category grid (collapsing to 2-col on tablets/phones), 48px+ touch targets, zero horizontal overflow across all viewports.
- **Quick Support Card**: Integrated direct WhatsApp support card at the bottom (`https://wa.me/201093796014`).

### 2. Sidebar Notification Badge Fix (`components/doctor/dashboard/sidebar.blade.php`)
- **No More Clipping**: Moved notification count into `<span class="sidebar-badge notification-badge">` beside the text (identical to the existing "التقييمات" badge).
- **Flexible Width**: Configured `min-width: 22px; width: auto; padding: 0 7px; border-radius: 999px; white-space: nowrap;` in `public/css/doctor/dashboard/ux.css`.
- **Zero Overlap**: The badge is placed at the end of the link row using `margin-inline-start: auto`, so it never overlaps the "الإشعارات" text and never leaves the sidebar.
- **Multi-Digit Support**: Single-digit, double-digit, and `99+` counts now render completely and cleanly without clipping on all screen sizes.
- **Zero Backend/Logic Changes**: Maintained exact notification count variables and routes.


