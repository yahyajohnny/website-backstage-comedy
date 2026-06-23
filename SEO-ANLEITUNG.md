# SEO-Anleitung – Backstage Comedy Night München
## Neue Website hochladen & nach dem Upload

---

## 1. Upload-Anleitung (All-inkl.com)

### Schritt 1: FTP-Verbindung herstellen
- FTP-Client: FileZilla (kostenlos) oder Cyberduck
- Host: dein FTP-Host aus dem KAS (z.B. `w01234ab.kasserver.com`)
- Benutzername + Passwort: aus dem KAS unter "FTP-Accounts"
- Port: 21 (FTP) oder 22 (SFTP – empfohlen)

### Schritt 2: Dateien hochladen
- Verbinde dich mit dem FTP-Server
- Navigiere in das Verzeichnis `html/` (das ist dein Web-Root)
- **WICHTIG:** Lade alle Dateien aus diesem ZIP-Ordner in das `html/`-Verzeichnis hoch
- Überschreibe alle bestehenden Dateien

### Schritt 3: Prüfen
- Öffne https://www.backstage-comedy.de im Browser
- Prüfe ob die neue Startseite erscheint
- Teste ein paar Unterseiten (z.B. /shows/, /blog/)

---

## 2. Nach dem Upload: Diese Schritte sind wichtig!

### Google Search Console
1. Gehe zu https://search.google.com/search-console
2. Melde dich an (Google-Konto)
3. Füge die Domain `backstage-comedy.de` hinzu
4. Verifiziere die Domain (HTML-Tag oder DNS)
5. Reiche die Sitemap ein: `https://www.backstage-comedy.de/sitemap.xml`
6. Fordere eine neue Indexierung der Startseite an

### Google Unternehmensprofil (WICHTIGSTE Maßnahme!)
1. Gehe zu https://business.google.com
2. Erstelle ein neues Unternehmensprofil für "Backstage Comedy Night München"
3. Kategorie: "Comedyclub" oder "Veranstaltungsort"
4. Adresse: Reitknechtstr. 6, 80639 München (Backstage München)
5. Website: https://www.backstage-comedy.de
6. Füge Fotos hinzu (aus dem assets/galerie/ Ordner)
7. Bitte nach jeder Show aktiv um Google-Bewertungen

### Verzeichnis-Einträge (Backlinks aufbauen)
Trage die Website in diese Verzeichnisse ein:
- https://www.mucbook.de (kostenlos)
- https://www.muenchen.de/veranstaltungen (kostenlos)
- https://www.tripadvisor.de (kostenlos)
- https://www.eventim.de (für Tickets)
- https://www.yelp.de (kostenlos)

---

## 3. Neue Show-Termine hinzufügen

Wenn eine neue Show geplant ist:

1. Kopiere den Ordner `shows/backstage-comedy-night-04-mai-2026/`
2. Benenne ihn um: `shows/backstage-comedy-night-DD-monat-JJJJ/`
3. Öffne die `index.html` und ersetze alle Datums-Angaben
4. Füge den neuen Termin in `shows/index.html` ein
5. Füge den neuen Termin in `index.html` (Startseite) ein
6. Füge die neue URL in `sitemap.xml` ein
7. Lade alle geänderten Dateien hoch

---

## 4. Keyword-Strategie (Ziel-Keywords)

### Primäre Keywords (Hauptziele)
- "Comedy München"
- "Stand-up Comedy München"
- "Comedy Show München"
- "Comedy Night München"

### Sekundäre Keywords
- "Comedy München 2026"
- "Comedy Backstage München"
- "Backstage Comedy Night"
- "Comedian München"

### Long-Tail Keywords (Blog-Artikel)
- "beste Comedy Shows München"
- "was ist Stand-up Comedy"
- "Comedy Abend München"
- "Yahya Pervaiz Comedian"
- "Bilal Mohammed Comedy"

---

## 5. Monatliche SEO-Aufgaben

- [ ] Neue Show-Seite anlegen (sobald Termin feststeht)
- [ ] Google Unternehmensprofil mit neuem Beitrag aktualisieren
- [ ] Instagram-Post mit Link zur neuen Show-Seite
- [ ] 1 neuer Blog-Artikel pro Monat
- [ ] Nach jeder Show: Fotos hochladen und Galerie aktualisieren
- [ ] Google-Bewertungen einsammeln (nach jeder Show per Instagram-Story)

---

## 6. Dateistruktur der neuen Website

```
backstage-comedy.de/
├── index.html              ← Startseite (SEO-optimiert)
├── galerie.html            ← Galerie mit optimierten Bildern
├── impressum.html          ← Impressum (noindex)
├── datenschutz.html        ← Datenschutz (noindex)
├── 404.html                ← Fehlerseite
├── sitemap.xml             ← XML-Sitemap für Google
├── robots.txt              ← Crawling-Anweisungen
├── .htaccess               ← HTTPS, Caching, Sicherheit
├── styles.css              ← Globales CSS
├── main.js                 ← Globales JavaScript
├── assets/
│   ├── logo.webp           ← Logo (optimiert, 47 KB statt 1,2 MB)
│   ├── hero.webp           ← Hero-Bild (optimiert, 420 KB statt 1,7 MB)
│   ├── yahya.webp          ← Yahya-Foto (optimiert, 49 KB statt 867 KB)
│   ├── bilal.webp          ← Bilal-Foto (optimiert, 65 KB statt 144 KB)
│   └── galerie/            ← 9 Galerie-Bilder (alle WebP, SEO-Dateinamen)
├── shows/
│   ├── index.html          ← Shows-Übersicht
│   ├── backstage-comedy-night-04-mai-2026/
│   ├── backstage-comedy-night-11-juni-2026/
│   └── backstage-comedy-night-09-juli-2026/
├── comedians/
│   ├── index.html          ← Comedians-Übersicht
│   ├── yahya-pervaiz/      ← Profil Yahya Pervaiz
│   └── bilal-mohammed/     ← Profil Bilal Mohammed
├── location/
│   └── index.html          ← Location-Seite Backstage München
└── blog/
    ├── index.html          ← Blog-Übersicht
    ├── beste-comedy-shows-muenchen/
    ├── was-ist-stand-up-comedy/
    └── comedy-muenchen-guide/
```

---

## 7. Was diese Website gegenüber der alten verbessert

| Bereich | Alt | Neu |
|---|---|---|
| Seiten gesamt | 1 | 16 |
| Bilder-Größe gesamt | ~4,8 MB | ~820 KB |
| Event-Schema | Fehlt | Vollständig (ComedyEvent) |
| H1-Fehler | Vorhanden | Behoben |
| Cookie-Banner als H2 | Vorhanden | Behoben |
| Blog-Content | 0 Wörter | ~3.000 Wörter |
| Breadcrumb-Schema | Fehlt | Auf allen Seiten |
| Künstler-Profile | Fehlt | Yahya + Bilal |
| Location-Seite | Fehlt | Vollständig |
| .htaccess (Caching, HTTPS) | Nicht optimiert | Vollständig |
| Galerie-Dateinamen | UUID-Strings | SEO-optimiert |

---

*Erstellt von Manus AI – April 2026*
