#!/usr/bin/env python3
"""Compress large raster assets in /images to WebP (~100–300KB) and update site references."""

from __future__ import annotations

import io
import sys
from pathlib import Path

from PIL import Image, ImageFile

ImageFile.LOAD_TRUNCATED_IMAGES = True

ROOT = Path(__file__).resolve().parents[1]
IMG = ROOT / "images"
MAX_BYTES = 300 * 1024
SKIP_NAMES = frozenset({"logo-liguoxing-header.png"})


def fit_long_edge(im: Image.Image, max_side: int) -> Image.Image:
    w, h = im.size
    m = max(w, h)
    if m <= max_side:
        return im
    scale = max_side / m
    nw = max(1, int(round(w * scale)))
    nh = max(1, int(round(h * scale)))
    return im.resize((nw, nh), Image.Resampling.LANCZOS)


def prepare_mode(im: Image.Image) -> Image.Image:
    if im.mode in ("RGBA", "RGB"):
        return im
    if im.mode == "P":
        return im.convert("RGBA")
    if im.mode == "LA":
        return im.convert("RGBA")
    return im.convert("RGB")


def compress_to_webp(src: Path) -> tuple[Path, int] | None:
    if src.suffix.lower() not in {".png", ".jpg", ".jpeg"}:
        return None
    if src.name in SKIP_NAMES:
        return None
    try:
        im = Image.open(src)
    except OSError:
        print("skip (open failed):", src, file=sys.stderr)
        return None
    im = prepare_mode(im)
    base = im.copy()

    best_buf: bytes | None = None
    best_size = 10**12

    for max_side in (2200, 2000, 1800, 1600, 1400, 1200, 1080, 960, 840, 720, 640):
        work = fit_long_edge(base, max_side)
        for q in range(84, 49, -3):
            buf = io.BytesIO()
            work.save(buf, format="WEBP", quality=q, method=4)
            raw = buf.getvalue()
            sz = len(raw)
            if sz < best_size:
                best_size = sz
                best_buf = raw
            if sz <= MAX_BYTES:
                out = src.with_suffix(".webp")
                out.write_bytes(raw)
                src.unlink(missing_ok=True)
                print(f"{src.name} -> {out.name} ({sz // 1024} KB)", flush=True)
                return out, sz

    if best_buf is None:
        return None
    out = src.with_suffix(".webp")
    out.write_bytes(best_buf)
    src.unlink(missing_ok=True)
    print(f"{src.name} -> {out.name} ({len(best_buf) // 1024} KB)", flush=True)
    return out, len(best_buf)


def iter_site_text_files() -> list[Path]:
    out: list[Path] = []
    skip_roots = {"public", "template", "weapp", "install_uruajHoxbGizu83ojB8d", "data", "node_modules"}
    for p in ROOT.rglob("*"):
        if not p.is_file():
            continue
        if any(part in skip_roots for part in p.parts):
            continue
        if p.suffix.lower() not in {".html", ".css", ".js", ".xml"}:
            continue
        if p.parts[0] == "docs" and "example" in p.parts:
            continue
        out.append(p)
    return out


def replace_refs(mapping: dict[str, str]) -> None:
    """mapping: basename.png -> basename.webp (same basename, new ext)."""
    if not mapping:
        return
    files = iter_site_text_files()
    for fp in files:
        text = fp.read_text(encoding="utf-8")
        orig = text
        for old_name, new_name in mapping.items():
            text = text.replace(f"/images/{old_name}", f"/images/{new_name}")
            if " " in old_name:
                text = text.replace(
                    f"/images/{old_name.replace(' ', '%20')}",
                    f"/images/{new_name.replace(' ', '%20')}",
                )
        if text != orig:
            fp.write_text(text, encoding="utf-8")


def main() -> int:
    if not IMG.is_dir():
        print("missing images dir", IMG, file=sys.stderr)
        return 1

    mapping: dict[str, str] = {}
    for path in sorted(IMG.iterdir()):
        if not path.is_file():
            continue
        if path.suffix.lower() not in {".png", ".jpg", ".jpeg"}:
            continue
        old_name = path.name
        if old_name in SKIP_NAMES:
            continue
        if path.stat().st_size <= 95 * 1024:
            continue
        r = compress_to_webp(path)
        if not r:
            print("failed:", old_name, file=sys.stderr)
            continue
        out_path, sz = r
        mapping[old_name] = out_path.name
        print(f"{old_name} -> {out_path.name} ({sz // 1024} KB)", flush=True)

    replace_refs(mapping)
    print("updated", len(mapping), "files + references")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
