#!/usr/bin/env python3
"""Fast-pass compress remaining rasters in /images to WebP (method=4)."""

from __future__ import annotations

import io
import sys
from pathlib import Path

from PIL import Image, ImageFile

ImageFile.LOAD_TRUNCATED_IMAGES = True

ROOT = Path(__file__).resolve().parents[1]
IMG = ROOT / "images"
MAX_BYTES = 300 * 1024
SKIP = frozenset({"logo-liguoxing-header.png"})


def fit_long_edge(im: Image.Image, max_side: int) -> Image.Image:
    w, h = im.size
    m = max(w, h)
    if m <= max_side:
        return im
    scale = max_side / m
    nw = max(1, int(round(w * scale)))
    nh = max(1, int(round(h * scale)))
    return im.resize((nw, nh), Image.Resampling.LANCZOS)


def prep(im: Image.Image) -> Image.Image:
    if im.mode in ("RGBA", "RGB"):
        return im
    if im.mode == "P":
        return im.convert("RGBA")
    if im.mode == "LA":
        return im.convert("RGBA")
    return im.convert("RGB")


def go(src: Path) -> tuple[str, int] | None:
    if src.name in SKIP:
        return None
    if src.suffix.lower() not in {".png", ".jpg", ".jpeg"}:
        return None
    if src.stat().st_size < 80 * 1024:
        return None
    im = prep(Image.open(src))
    base = im.copy()
    best: bytes | None = None
    best_sz = 10**12
    for max_side in (2000, 1600, 1280, 1000, 840, 720):
        work = fit_long_edge(base, max_side)
        for q in range(82, 44, -4):
            buf = io.BytesIO()
            work.save(buf, format="WEBP", quality=q, method=4)
            raw = buf.getvalue()
            sz = len(raw)
            if sz < best_sz:
                best_sz = sz
                best = raw
            if sz <= MAX_BYTES:
                out = src.with_suffix(".webp")
                out.write_bytes(raw)
                src.unlink(missing_ok=True)
                return out.name, sz
    if best is None:
        return None
    out = src.with_suffix(".webp")
    out.write_bytes(best)
    src.unlink(missing_ok=True)
    return out.name, len(best)


def main() -> int:
    for p in sorted(IMG.iterdir()):
        if not p.is_file():
            continue
        r = go(p)
        if r:
            print(r[0], r[1] // 1024, "KB")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
