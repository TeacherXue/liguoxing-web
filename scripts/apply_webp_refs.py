#!/usr/bin/env python3
"""Replace /images/*.png|jpg references with .webp when matching file exists and raster is gone."""

from __future__ import annotations

import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
IMG = ROOT / "images"
SKIP_DIRS = frozenset(
    {"public", "template", "weapp", "install_uruajHoxbGizu83ojB8d", "data", "node_modules"}
)


def main() -> int:
    webps = {p.stem: p.name for p in IMG.glob("*.webp")}
    if not webps:
        print("no webp in images/", file=sys.stderr)
        return 1

    pairs: list[tuple[str, str]] = []
    for stem, webp_name in sorted(webps.items()):
        for ext in (".png", ".jpg", ".jpeg"):
            old_name = stem + ext
            old_path = IMG / old_name
            if old_path.exists():
                continue
            pairs.append((old_name, webp_name))

    changed = 0
    for path in ROOT.rglob("*"):
        if not path.is_file():
            continue
        if path.suffix.lower() not in {".html", ".css", ".js", ".xml"}:
            continue
        if any(p in SKIP_DIRS for p in path.parts):
            continue
        if "docs" in path.parts and "example" in path.parts:
            continue
        text = path.read_text(encoding="utf-8")
        orig = text
        for old_name, webp_name in pairs:
            text = text.replace(f"/images/{old_name}", f"/images/{webp_name}")
            if " " in old_name:
                text = text.replace(
                    f"/images/{old_name.replace(' ', '%20')}",
                    f"/images/{webp_name.replace(' ', '%20')}",
                )
        if text != orig:
            path.write_text(text, encoding="utf-8")
            changed += 1
    print("updated files:", changed, "replacements:", len(pairs))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
