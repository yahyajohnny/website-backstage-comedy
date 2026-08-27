# Backstage Comedy Night – Website

Offizielles Repository der Website **[backstage-comedy.de](https://www.backstage-comedy.de)** – Münchens monatliche Stand-up Comedy Show im Backstage München.

Dieses Projekt enthält den vollständigen statischen Quellcode der Website: HTML, CSS, JavaScript und alle lokal gehosteten Medien (Bilder, Logos). Die Seite ist bewusst ohne Build-Tool oder Framework gehalten und kann direkt auf jedem Webserver ausgeliefert werden.

---

## Inhaltsverzeichnis

- [Über das Projekt](#über-das-projekt)
- [Live-Website](#live-website)
- [Technologie-Stack](#technologie-stack)
- [Projektstruktur](#projektstruktur)
- [Seitenübersicht](#seitenübersicht)
- [JavaScript (`main.js`)](#javascript-mainjs)
- [Lokale Entwicklung](#lokale-entwicklung)
- [Deployment](#deployment)
- [Inhalte pflegen](#inhalte-pflegen)
- [SEO & Barrierefreiheit](#seo--barrierefreiheit)
- [Design Guide](#design-guide)
- [Bekannte Einschränkungen](#bekannte-einschränkungen)
- [Repository & Kontakt](#repository--kontakt)

---

## Über das Projekt

**Backstage Comedy Night** ist eine monatliche Stand-up Comedy Show im Backstage München (Reitknechtstr. 6, 80639 München). Die Website dient als zentrale Anlaufstelle für:

- **Ticketverkauf** – Anzeige kommender Shows mit direkten Ticket-Links
- **Show-Detailseiten** – Eigene Landingpages pro Termin (SEO-optimiert)
- **Comedian-Profile** – Vorstellung der Show-Organisatoren und Künstler
- **Location** – Anfahrt, Karte und Infos zum Veranstaltungsort
- **Blog** – SEO-Artikel zu Comedy in München
- **Galerie** – Impressionen aus vergangenen Shows
- **Rechtliches** – Impressum und Datenschutzerklärung

Gegründet von **Yahya Pervaiz** und **Bilal Mohammed**.

---

## Live-Website

| | |
|---|---|
| **URL** | [https://www.backstage-comedy.de](https://www.backstage-comedy.de) |
| **E-Mail** | [haha@backstage-comedy.de](mailto:haha@backstage-comedy.de) |
| **Instagram** | [@backstage.comedy.night](https://www.instagram.com/backstage.comedy.night/) |
| **Location** | Backstage München, Reitknechtstr. 6, 80639 München |
| **Ticketpreis** | ab 20 € |

---

## Technologie-Stack

| Bereich | Technologie |
|---------|-------------|
| Markup | Semantisches HTML5 |
| Styling | Vanilla CSS (CSS Custom Properties, kein Framework) |
| Logik | Vanilla JavaScript (ES6+, `'use strict'`) |
| Schriftart | [Google Fonts](https://fonts.google.com/) – **Outfit** (300–800) |
| Bilder | WebP (mit PNG-Fallback für Logo) |
| Build | Keiner – Dateien werden direkt ausgeliefert |
| Hosting | Statischer Webserver (Apache mit `.htaccess`, Nginx, All-inkl) |

Es gibt **kein** `package.json`, **kein** Bundler und **keine** Abhängigkeiten, die vor dem Deployment installiert werden müssen.

---

## Projektstruktur

```
website-backstage-comedy/
├── index.html                          # Startseite (Hero, Shows, Team, FAQ, Kontakt)
├── galerie.html                        # Galerie mit Lightbox
├── impressum.html                      # Impressum
├── datenschutz.html                    # Datenschutzerklärung
├── 404.html                            # Fehlerseite
├── styles.css                          # Globales Stylesheet (Design System)
├── main.js                             # Navigation, FAQ, Lightbox, Cookie-Banner
├── robots.txt                          # Crawler-Anweisungen
├── sitemap.xml                         # XML-Sitemap für Suchmaschinen
├── .htaccess                           # Apache: HTTPS, www, Caching, Security-Header
├── SEO-ANLEITUNG.md                    # SEO- & Upload-Anleitung für All-inkl
│
├── assets/
│   ├── logo.webp / logo.png            # Logo (WebP + PNG-Fallback)
│   ├── favicon.svg                     # Favicon
│   ├── hero.webp / hero-mobile.webp    # Hero-Bilder (Desktop & Mobile)
│   ├── yahya.webp / bilal.webp         # Team-Fotos
│   └── galerie/
│       ├── index.json                  # Liste aller Galerie-Bilder
│       └── show-backstage-comedy-night-muenchen-*.webp
│
├── shows/
│   ├── index.html                      # Show-Übersicht
│   └── backstage-comedy-night-*/       # Eigene Landingpage pro Termin
│       └── index.html
│
├── comedians/
│   ├── index.html                      # Comedian-Übersicht
│   ├── yahya-pervaiz/index.html
│   └── bilal-mohammed/index.html
│
├── location/
│   └── index.html                      # Location-Seite mit Karte
│
└── blog/
    ├── index.html                      # Blog-Übersicht
    ├── beste-comedy-shows-muenchen/
    ├── comedy-muenchen-guide/
    └── was-ist-stand-up-comedy/
```

---

## Seitenübersicht

| Seite | Datei | Beschreibung |
|-------|-------|--------------|
| **Startseite** | `index.html` | Hero, kommende Shows, Features, Team, Galerie-Vorschau, FAQ, CTA |
| **Shows** | `shows/index.html` | Alle kommenden Termine |
| **Show-Detail** | `shows/backstage-comedy-night-*/index.html` | Termin-spezifische Landingpage mit Schema.org `ComedyEvent` |
| **Comedians** | `comedians/index.html` | Übersicht aller Comedians |
| **Comedian-Profil** | `comedians/*/index.html` | Einzelprofile mit Bio und Social Links |
| **Location** | `location/index.html` | Backstage München – Adresse, Karte, Anfahrt |
| **Galerie** | `galerie.html` | Fotogalerie mit Lightbox |
| **Blog** | `blog/index.html` | SEO-Artikel zu Comedy in München |
| **Impressum** | `impressum.html` | Rechtliche Angaben gemäß TMG |
| **Datenschutz** | `datenschutz.html` | Datenschutzerklärung (DSGVO) |
| **404** | `404.html` | Benutzerdefinierte Fehlerseite |

Alle Seiten teilen sich eine einheitliche Navigation (fixiert, scroll-effekt), Mobile-Hamburger-Menü und Footer.

---

## JavaScript (`main.js`)

Verantwortlich für:

- **Navigation** – Scroll-Effekt (`.nav.scrolled`), Mobile-Menü-Toggle
- **FAQ-Akkordeon** – Aufklappbare FAQ-Einträge (nur ein Item gleichzeitig offen)
- **Scroll Reveal** – Einblend-Animationen per `IntersectionObserver` (`.reveal` → `.visible`)
- **Lightbox** – Galerie-Vollbildansicht mit Escape-Taste und Klick-außerhalb
- **Cookie-Banner** – Einwilligung via `localStorage` (`cookieConsent`)
- **Active Nav Link** – Markiert aktuellen Pfad in der Navigation

Es gibt **keine** externen API-Abhängigkeiten – Show-Termine werden statisch in HTML gepflegt.

---

## Lokale Entwicklung

Da kein Build-Schritt nötig ist, reicht ein lokaler Webserver. Die Seite **nicht** per `file://` öffnen – relative Pfade und `fetch()` für Galerie-JSON funktionieren nur über HTTP.

### Option 1: MAMP (empfohlen für dieses Setup)

Das Projekt liegt unter `/Applications/MAMP/htdocs/website-backstage-comedy/`.

1. MAMP starten
2. Browser öffnen: [http://localhost:8888/website-backstage-comedy/](http://localhost:8888/website-backstage-comedy/)

### Option 2: Python (eingebaut auf macOS)

```bash
cd website-backstage-comedy
python3 -m http.server 8080
```

Dann: [http://localhost:8080](http://localhost:8080)

### Option 3: Node.js (npx)

```bash
cd website-backstage-comedy
npx serve .
```

### Option 4: PHP

```bash
cd website-backstage-comedy
php -S localhost:8080
```

---

## Deployment

Die Website ist für **All-inkl.com** (KAS) vorbereitet. Details siehe auch `SEO-ANLEITUNG.md`.

### All-inkl (Produktion)

1. Per FTP/SFTP mit dem KAS verbinden
2. In das Verzeichnis `html/` navigieren (Web-Root)
3. Alle Dateien aus diesem Repository hochladen
4. `https://www.backstage-comedy.de` im Browser prüfen

### Apache (generisch)

Dateien in das Document Root kopieren. Die mitgelieferte `.htaccess` erzwingt:

- HTTPS-Weiterleitung
- `www`-Subdomain
- Trailing Slashes für Verzeichnisse
- Browser-Caching & Gzip
- Security-Header (X-Frame-Options, CSP-adjacent)
- Custom 404 → `/404.html`

### Nginx

```nginx
server {
    listen 443 ssl;
    server_name www.backstage-comedy.de backstage-comedy.de;
    root /var/www/website-backstage-comedy;
    index index.html;

    # www erzwingen + HTTPS (backstage-comedy.de → www)
    if ($host != 'www.backstage-comedy.de') {
        return 301 https://www.backstage-comedy.de$request_uri;
    }

    location / {
        try_files $uri $uri/ $uri.html =404;
    }

    error_page 404 /404.html;
}
```

### Checkliste vor dem Go-Live

- [ ] Canonical-URLs und OG-Tags auf `https://www.backstage-comedy.de` zeigen
- [ ] `sitemap.xml` und `robots.txt` aktuell
- [ ] HTTPS aktiv
- [ ] Google Search Console: Sitemap einreichen
- [ ] Google Unternehmensprofil anlegen (siehe `SEO-ANLEITUNG.md`)

---

## Inhalte pflegen

### Neue Show-Termine hinzufügen

1. Ordner `shows/backstage-comedy-night-04-mai-2026/` kopieren
2. Umbenennen: `shows/backstage-comedy-night-DD-monat-JJJJ/`
3. In `index.html` alle Datums-Angaben, Meta-Tags und Schema.org-JSON ersetzen
4. Termin in `shows/index.html` eintragen
5. Termin in `index.html` (Startseite) eintragen
6. Neue URL in `sitemap.xml` ergänzen
7. Geänderte Dateien deployen

### Neue Galerie-Fotos

1. WebP-Bild in `assets/galerie/` ablegen (Naming: `show-backstage-comedy-night-muenchen-XX.webp`)
2. Dateiname in `assets/galerie/index.json` eintragen
3. Optional: Bild auch in `galerie.html` und Startseite einbinden

### Blog-Artikel

1. Neuen Ordner unter `blog/` anlegen (z. B. `blog/mein-neuer-artikel/`)
2. `index.html` nach Vorlage der bestehenden Artikel erstellen
3. In `blog/index.html` verlinken
4. URL in `sitemap.xml` eintragen

### Texte ändern

Inhalte liegen direkt in den jeweiligen `.html`-Dateien. Es gibt kein CMS – Änderungen werden per Editor vorgenommen und committed.

---

## SEO & Barrierefreiheit

Die Website ist für Suchmaschinen und Social Media optimiert:

- **Structured Data (JSON-LD):** `Organization`, `EntertainmentBusiness`, `ComedyEvent`, `BreadcrumbList`
- **Open Graph & Twitter Cards** auf allen Hauptseiten
- **Canonical URLs** und `meta robots`
- **XML-Sitemap** (`sitemap.xml`) mit 15 URLs
- **Semantisches HTML** mit ARIA-Attributen (Navigation, FAQ, Lightbox)
- **Alt-Texte** auf Bildern
- **Tastaturnavigation** in Lightbox (Escape) und Navigation
- **Lazy Loading** für Galerie-Bilder (`loading="lazy"`)
- **Responsive Hero** via `<picture>` mit `hero-mobile.webp`

Ausführliche SEO-Maßnahmen nach dem Launch: siehe `SEO-ANLEITUNG.md`.

---

## Design Guide

Dieser Abschnitt dokumentiert das visuelle Design-System der Website. Alle Werte sind in `styles.css` als CSS Custom Properties definiert und sollten bei Erweiterungen konsistent beibehalten werden.

### Markenidentität

| Aspekt | Wert |
|--------|------|
| **Markenname** | Backstage Comedy Night |
| **Positionierung** | Premium Stand-up Comedy in München – monatlich, 5 Comedians, 1 Bühne |
| **Tonality** | Energetisch, direkt, einladend – Comedy-Club-Atmosphäre |
| **Sprache** | Deutsch (Du-Ansprache in CTAs) |

### Farbpalette

Das Design basiert auf einem **Dark-Mode-first**-Ansatz mit leuchtendem Gelb als Akzentfarbe – angelehnt an Bühnenlicht und Comedy-Club-Ästhetik.

| Token | Hex | Verwendung |
|-------|-----|------------|
| `--yellow` | `#FFE600` | Primäre Akzentfarbe: CTAs, Labels, Hover, Highlights, Datum-Boxen |
| `--black` | `#0A0A0A` | Seitenhintergrund |
| `--dark` | `#111111` | Footer-Hintergrund |
| `--card` | `#1A1A1A` | Karten, FAQ-Icons, Cookie-Banner |
| `--border` | `#2A2A2A` | Rahmen, Trennlinien |
| `--text` | `#E8E8E8` | Fließtext, Navigation |
| `--muted` | `#888888` | Sekundärtext, Meta-Infos, Footer-Links |
| `--white` | `#FFFFFF` | Überschriften auf dunklem Hintergrund |

**Regeln:**

- Gelb **nur** für Akzente und CTAs – nie als großflächiger Hintergrund
- Text auf Gelb immer in `--black` (Kontrast!)
- Hover-Effekte auf Karten: Border wechselt zu `--yellow` oder `rgba(255,230,0,0.3–0.4)`
- Hero-Overlay: `linear-gradient(135deg, rgba(0,0,0,0.85), rgba(0,0,0,0.5))`

### Typografie

| Element | Schrift | Größe | Gewicht |
|---------|---------|-------|---------|
| **Schriftfamilie** | [Outfit](https://fonts.google.com/specimen/Outfit) | – | 300, 400, 600, 700, 800 |
| **H1** | Outfit | `clamp(2rem, 5vw, 3.5rem)` | 800 |
| **H2** | Outfit | `clamp(1.5rem, 3vw, 2.2rem)` | 700 |
| **H3** | Outfit | `clamp(1.1rem, 2vw, 1.4rem)` | 600 |
| **H4** | Outfit | `1rem` | 600 |
| **Fließtext** | Outfit | `1rem` | 400 |
| **Section Label** | Outfit | `0.75rem`, uppercase, `letter-spacing: 0.2em` | 600, `--yellow` |

**Regeln:**

- Überschriften in Hero und Page-Hero: `--white`, Akzent-Wörter in `--yellow` (`<span>`)
- Section Labels immer uppercase mit Letter-Spacing – signalisieren Abschnittswechsel
- Sekundärtext in `--muted`, nie reines Grau unter `#666` (Lesbarkeit!)
- Zeilenhöhe Fließtext: `1.7`, Überschriften: `1.1–1.2`

### Layout & Spacing

| Token | Wert | Verwendung |
|-------|------|------------|
| `--max` | `1200px` | Maximale Content-Breite |
| `--radius` | `12px` | Karten, Cookie-Banner, Map |
| Section Padding | `5rem 0` (Mobile: `3.5rem 0`) | Vertikaler Abstand zwischen Sektionen |
| Container Padding | `0 1.5rem` | Horizontaler Innenabstand |
| Grid Gap | `1.5–2rem` | Karten-Grids |

**Breakpoints:**

| Breakpoint | Anpassungen |
|------------|-------------|
| `≤ 900px` | About/Location: 1 Spalte; Footer: 2 Spalten; Galerie: 2 Spalten |
| `≤ 768px` | Mobile-Navigation (Fullscreen-Overlay); Show-Cards: gestapelt; Footer: 1 Spalte |
| `≤ 480px` | Galerie: 1 Spalte; Hero-Buttons: gestapelt |

### Komponenten

#### Navigation (`.nav`)

- Fixiert oben, transparent → bei Scroll: `rgba(10,10,10,0.97)` mit `backdrop-filter: blur(10px)`
- Logo-Höhe: `40px`
- Links: `0.9rem`, Hover/Active: `--yellow`
- CTA-Button (`.nav-cta`): Gelber Pill-Button, `--black` Text

#### Buttons (`.btn`)

| Variante | Stil |
|----------|------|
| `.btn-primary` | Gelber Hintergrund, schwarzer Text, Pill-Form (`border-radius: 50px`) |
| `.btn-outline` | Transparent, weißer Border `rgba(255,255,255,0.4)` |
| `.btn-sm` | Kompakte Variante für Karten |

Hover: `translateY(-2px)` + Box-Shadow mit Gelb-Glow `rgba(255,230,0,0.4)`

#### Show Cards (`.show-card`)

- Hintergrund `--card`, Border `--border`, Radius `--radius`
- Datum-Box (`.show-date-box`): Gelber Block mit Tag (groß, 800) + Monat (uppercase, klein)
- Preis in `--yellow`, rechts ausgerichtet
- Hover: Border `--yellow`, leichtes Anheben

#### Feature Cards (`.feature-card`)

- Icon-Box: `48×48px`, Hintergrund `rgba(255,230,0,0.12)`, Emoji/Symbol zentriert
- Titel + kurzer Beschreibungstext in `--muted`

#### Team Cards (`.team-card`)

- Bild: `320px` Höhe, `object-fit: cover`, `object-position: top`
- Rolle (`.team-role`): uppercase, `--yellow`, `0.72rem`
- Hover: `translateY(-4px)`, Border-Glow

#### Blog Cards (`.blog-card`)

- Bild oben: `200px` Höhe, Zoom on Hover (`scale(1.05)`)
- Kategorie-Label: uppercase, `--yellow`
- Footer mit Datum und „Weiterlesen"-Link

#### FAQ (`.faq-item`)

- Akkordeon: Frage-Button mit rundem Icon (`+` rotiert bei Open)
- Offenes Icon: gelber Hintergrund, schwarzes `+`
- Antwort: `max-height`-Transition, Text in `--muted`

#### CTA Section (`.cta-section`)

- Subtiler Gelb-Gradient-Hintergrund
- Gelbe Border oben/unten (`rgba(255,230,0,0.15)`)
- Zentrierter Text + Primary Button

#### Footer (`.footer`)

- 4-Spalten-Grid (Brand breiter: `2fr 1fr 1fr 1fr`)
- Social Icons: runde Buttons `36×36px`, Hover: gelber Glow
- Bottom Bar: Copyright + Impressum/Datenschutz-Links

#### Cookie Banner (`.cookie-banner`)

- Fixiert unten, zentriert, max. `520px` breit
- Zwei Buttons: Accept (Primary) + Decline (Outline)

### Bilder & Medien

| Asset | Format | Verwendung |
|-------|--------|------------|
| `hero.webp` | WebP, 1920×714 | Hero Desktop, OG-Image |
| `hero-mobile.webp` | WebP | Hero Mobile (`<picture>`) |
| `logo.webp` / `logo.png` | WebP + PNG | Navigation, Footer (Fallback) |
| Galerie | WebP, 4:3 | Show-Fotos, benannt nach Schema |
| Team-Fotos | WebP | Comedian-Profile |

**Regeln:**

- Bilder immer mit `alt`-Text und sinnvollen Dateinamen (SEO)
- Galerie: `aspect-ratio: 4/3`, `object-fit: cover`
- Hero: `<picture>` mit `source` für Mobile
- Preload für Hero und Logo im `<head>`

### Animationen & Interaktion

| Effekt | Implementierung |
|--------|-----------------|
| Scroll Reveal | `.reveal` → `.visible` via IntersectionObserver, `translateY(24px)` → `0` |
| Delays | `.reveal-delay-1/2/3` (0.1s, 0.2s, 0.3s) |
| Hover Lift | Karten: `translateY(-2px bis -4px)` |
| Lightbox | Fade-in Overlay `rgba(0,0,0,0.95)` |
| FAQ | Icon-Rotation 45°, max-height Transition |
| Smooth Scroll | `html { scroll-behavior: smooth }` |

**Regeln:**

- Animationen dezent halten – Comedy-Club-Feeling, nicht verspielt
- Keine Autoplay-Videos oder blinkende Elemente
- Transitions: `0.2–0.4s ease`

### Do's & Don'ts

| ✅ Do | ❌ Don't |
|-------|---------|
| Dark Background + Gelb-Akzente | Helle Hintergründe oder bunte Farbpaletten |
| Outfit als einzige Schriftart | Weitere Schriftfamilien mischen |
| Pill-Buttons (`border-radius: 50px`) | Eckige oder rechteckige Buttons |
| WebP für Fotos | Unkomprimierte PNG/JPG ohne Fallback |
| Semantisches HTML + ARIA | Div-Soup ohne Rollen |
| Konsistente `--radius: 12px` | Unterschiedliche Border-Radien pro Komponente |
| Mobile-first Responsive | Desktop-only Layouts |

---

## Bekannte Einschränkungen

| Thema | Details |
|-------|---------|
| **Kein CMS** | Alle Inhalte werden manuell in HTML/JSON gepflegt |
| **Statische Shows** | Termine müssen manuell in HTML aktualisiert werden (keine Ticket-API) |
| **Google Fonts** | Outfit wird von Google CDN geladen – Internet erforderlich |
| **Kein Build-Prozess** | Kein CSS/JS-Minifying – Performance über `.htaccess`-Caching |

---

## Repository & Kontakt

| | |
|---|---|
| **Repository** | [github.com/yahyajohnny/website-backstage-comedy](https://github.com/yahyajohnny/website-backstage-comedy) |
| **Live-Website** | [www.backstage-comedy.de](https://www.backstage-comedy.de) |
| **E-Mail** | [haha@backstage-comedy.de](mailto:haha@backstage-comedy.de) |
| **Instagram** | [@backstage.comedy.night](https://www.instagram.com/backstage.comedy.night/) |

---

*Stand-up Comedy in München – jeden Monat im Backstage. 5 Comedians, 1 Bühne, 100 % Lachgarantie.*
