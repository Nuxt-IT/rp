"""
Extract issue-category rows from FRONTEND MANAGEMENT (1).xlsx.

Usage (PowerShell):
  python buildscripts/extract_frontend_management_issues.py
  python buildscripts/extract_frontend_management_issues.py --sheet \"ISSUE CATEGORY\"
"""

from __future__ import annotations

import argparse
import json
import re
import sys
from pathlib import Path

import pandas as pd


WORKBOOK = Path(__file__).resolve().parents[1] / "FRONTEND MANAGEMENT (1).xlsx"


def norm_col(name: object) -> str:
    return str(name).strip().lower().replace("\n", " ").replace("\r", " ")


DEV_REVIEW_COL_CANDIDATES = [
    "developer review ( in loom ) and fixes made",
    "developer review (in loom) and fixes made",
    "developer review (in loom ) and fixes made",
    "developer review ( in loom) and fixes made",
    "developer review ( in loom ) and fixes made.",
]


def compact(text: object) -> str:
    s = "" if text is None else str(text)
    return re.sub(r"\s+", " ", s).strip()


def extract_sheet_rows(xls: pd.ExcelFile, sheet: str) -> dict:
    df = xls.parse(sheet)
    cols = list(df.columns)
    ncols = {norm_col(c): c for c in cols}

    issue_col = ncols.get("issue category")
    dev_review_col = None
    for cand in DEV_REVIEW_COL_CANDIDATES:
        if cand in ncols:
            dev_review_col = ncols[cand]
            break

    result: dict = {"sheet": sheet, "has_issue_category": issue_col is not None, "rows": []}
    if issue_col is None:
        return result

    if dev_review_col is None:
        # Still return the issue categories so we can see what’s present.
        cats = (
            df[issue_col]
            .dropna()
            .astype(str)
            .map(compact)
            .loc[lambda s: s != ""]
            .unique()
            .tolist()
        )
        result["categories"] = sorted(set(cats))
        return result

    sub = df[[issue_col, dev_review_col]].copy().dropna(how="all")
    sub = sub[(sub[issue_col].notna()) & (sub[issue_col].astype(str).map(compact) != "")]

    for _, row in sub.iterrows():
        issue = compact(row[issue_col])
        review = compact(row[dev_review_col])
        if issue == "":
            continue
        result["rows"].append(
            {
                "issue_category": issue,
                "developer_review": review,
            }
        )

    return result


def main() -> int:
    # Ensure we can print arrows/special chars on Windows consoles.
    try:
        sys.stdout.reconfigure(encoding="utf-8")
    except Exception:
        pass

    ap = argparse.ArgumentParser()
    ap.add_argument("--sheet", default=None, help="Extract only one sheet")
    ap.add_argument("--json", action="store_true", help="Output JSON (default prints summary)")
    args = ap.parse_args()

    if not WORKBOOK.exists():
        raise SystemExit(f"Workbook not found: {WORKBOOK}")

    xls = pd.ExcelFile(WORKBOOK)
    sheets = [args.sheet] if args.sheet else list(xls.sheet_names)

    extracted = [extract_sheet_rows(xls, sh) for sh in sheets]

    if args.json:
        print(json.dumps({"workbook": str(WORKBOOK), "sheets": extracted}, ensure_ascii=False, indent=2))
        return 0

    print("Workbook:", WORKBOOK)
    print("Sheets:", xls.sheet_names)
    for sh in extracted:
        if not sh.get("has_issue_category"):
            continue
        rows = sh.get("rows", [])
        cats = sorted({r["issue_category"] for r in rows}) if rows else sh.get("categories", [])
        print("\n===", sh["sheet"], "===")
        print("categories:", cats)
        if rows:
            with_review = [r for r in rows if r.get("developer_review")]
            print("rows with issue category:", len(rows))
            print("rows with dev review text:", len(with_review))
            for r in with_review[:15]:
                print("-", r["issue_category"] + ":", r["developer_review"][:220])

    return 0


if __name__ == "__main__":
    raise SystemExit(main())

