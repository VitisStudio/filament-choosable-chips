# Design package — Choosable Chips

Everything needed to design a **thumbnail** and **hero** for this Filament plugin. Point a
design tool (e.g. Claude Design) at this folder.

**Start with [`BRIEF.md`](BRIEF.md)** — it's the full brief. The rest are inputs it references:

| File | What it is |
|------|------------|
| [`BRIEF.md`](BRIEF.md) | The brief: product, deliverables, specs, brand, do/don't |
| [`specs.json`](specs.json) | Machine-readable dimensions + export targets |
| [`palette.json`](palette.json) | Exact Filament color tokens (OKLCH + hex) |
| [`copy.md`](copy.md) | The only approved text strings |
| [`reference/`](reference/) | Real screenshots to match + a labeled chip-anatomy diagram |

## TL;DR for the designer

Design two images of **pill-shaped, colorful, dismissable "chips"** (Filament badges) — the
plugin turns form options into them. Make the chips the hero. Keep it clean and
Filament-native (Inter/Instrument Sans, gray-50 or gray-950 canvas, soft rings). Two
deliverables: a **1200×675 thumbnail** (must read at 400px wide) and a **2400×1260 hero**.
Colors and copy are fixed — use only what's in `palette.json` and `copy.md`. Match the look of
`reference/choosable-chips.png`.

## Where the finished art goes

- Thumbnail → used on the Filament plugins page + as the GitHub social preview.
- Hero → replaces / sits above `../art/choosable-chips.png` at the top of the main README.
