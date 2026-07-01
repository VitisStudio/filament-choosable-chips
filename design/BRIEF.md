# Design brief — Choosable Chips for Filament

Point Claude Design (or any design tool) at this folder. It contains everything needed to
produce a **thumbnail** and a **hero image** for the plugin. Reference screenshots of the
real component live in [`reference/`](reference/).

---

## 1. What the product is

`vitisstudio/filament-choosable-chips` is a **FilamentPHP v5 form field**. It renders
checkbox/radio options as **dismissable, colorable, icon-bearing "chips"** (pill-shaped
badges). One field does single-select (radio) or multi-select (checkbox). Developers
configure per-option colors, icons, and labels through a fluent PHP API.

Audience: **Laravel / Filament developers** browsing the Filament plugins directory. The
imagery must read instantly as "a polished Filament form component."

One-liner (use verbatim if copy is needed):
> Turn checkbox and radio options into colorful, dismissable chips.

Longer description:
> A Filament v5 form field that renders options as pill-shaped badge chips with per-option
> colors, icons, and a selected check — single or multi select from one fluent API.

---

## 2. Deliverables & exact specs

Produce **two** images. Export PNG (and SVG source if the tool supports it).

### A. Thumbnail (plugins-grid card)
- **1200 × 675 px** (16:9). This is the card image in the Filament plugins grid and the
  GitHub social-preview card, so it must look good scaled down to ~400 px wide.
- Safe zone: keep all text within the centre 90%. Assume corners may be cropped/rounded.
- Must be legible as a small tile: **one clear focal cluster of chips + the product name**.

### B. Hero (README top / landing)
- **2400 × 1260 px** (roughly 40:21, a wide banner). Displayed full-width at the top of the
  README, so it can carry more detail than the thumbnail.
- Can include a tagline and a small code snippet motif (optional), but chips remain the star.

Also export a **1:1 crop (800 × 800)** of the thumbnail's chip cluster in case a square
avatar is needed.

---

## 3. The star of the image: the chips

The single most important thing is that the viewer sees **a row (or scatter) of pill-shaped
chips in Filament's colors**, each with a short label, some with a leading icon, some with a
small × (dismiss) or a ✓ (selected check). This is the product's whole identity.

Chip anatomy (match [`reference/chip-anatomy.png`](reference/chip-anatomy.png) and the real
screenshots):
- **Fully rounded pill** (border-radius = height/2), soft 1px ring/border in the chip's color.
- Light tinted fill (~color-50) with a saturated label (~color-600) in light mode.
- Optional **leading icon** (Heroicon outline style), a **✓ check** on selected chips, or a
  small **× delete** button on the trailing edge.
- Comfortable horizontal padding (roomy, not cramped).

Use these labels + colors (they're the real demo values — see `palette.json` for hexes):

| Label | Filament token | Note |
|-------|----------------|------|
| Blue | `info` | leading swatch icon, × delete |
| Red | `danger` | leading fire icon |
| Green | `success` | |
| Amber | `warning` | |
| Indigo | `indigo` | |
| Purple | `purple` | ✓ check |
| Teal | `teal` | |
| Cyan | `cyan` | |
| Pro | `success` | ✓ check |
| Enterprise | `warning` | dimmed / disabled look |

---

## 4. Brand & visual system

- **This must look like Filament.** Filament's aesthetic: clean, rounded, generous
  whitespace, Inter/Instrument Sans typeface, subtle rings and soft shadows, a neutral
  gray-50 canvas in light mode (or gray-950 in dark). No harsh gradients, no skeuomorphism.
- **Primary accent**: Filament's amber/orange (`primary` in the default theme, ~`#f59e0b`),
  used sparingly for the product name or a highlight — the chips themselves carry the color.
- Full palette (OKLCH + hex) is in [`palette.json`](palette.json).
- Type: a modern geometric/grotesque sans (Inter, Instrument Sans, or similar). Product name
  in semibold; body/taglines in regular.

### Two acceptable directions (pick one, or offer both)
1. **Light + product-true** — a white/gray-50 card, real-looking Filament form with a cluster
   of colorful chips, product name top-left. Feels like a screenshot-plus. Safest, most
   "official." (See `reference/choosable-chips.png` for the exact real look.)
2. **Dark + bold** — gray-950 canvas, the chips glowing as the hero cluster, big product
   wordmark. More striking on a plugins grid. (Filament's dark mode; see `reference/` — the
   component supports dark natively.)

---

## 5. Copy to place

- **Product name**: `Choosable Chips` (and optionally the smaller kicker `for Filament`).
- **Tagline (hero only, optional)**: "Options as colorful, dismissable chips."
- Do **not** put the full composer name or long paragraphs in the image.

---

## 6. Do / Don't

**Do**
- Make the chips the obvious focal point.
- Show variety: several colors, at least one icon, one ✓, one ×.
- Keep it flat, clean, Filament-native.
- Ensure the thumbnail reads at 400 px wide.

**Don't**
- Don't invent UI that the component doesn't have (no dropdowns, sliders, avatars).
- Don't use colors outside the Filament palette in `palette.json`.
- Don't clutter with device mockups, hands, or stock photography.
- Don't use a different font family than a clean sans.

---

## 7. Files in this folder

- `BRIEF.md` — this file.
- `palette.json` — exact color tokens (OKLCH + hex) for every chip color + the Filament accent.
- `specs.json` — machine-readable dimensions and export targets.
- `copy.md` — all approved text strings.
- `reference/` — real screenshots of the component to match style, plus a labeled
  chip-anatomy diagram.
