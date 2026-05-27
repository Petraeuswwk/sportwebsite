#!/usr/bin/env python3
"""
Process product Excel file and extract data + images for WordPress import.
"""

import json
import os
import sys
from pathlib import Path

import openpyxl
import pandas as pd
from openpyxl.drawing.spreadsheet_drawing import TwoCellAnchor


EXCEL_PATH = "/Users/wuwenkai/Downloads/产品报价表.xlsx"
OUTPUT_DIR = "/Users/wuwenkai/Desktop/sports_website/import_data"


# Category name mapping (Chinese -> English slug for WordPress taxonomy)
CATEGORY_SLUG_MAP = {
    "乒乓球": "table-tennis",
    "乒乓球拍": "table-tennis-racket",
    "羽毛球": "badminton",
    "羽毛球拍": "badminton-racket",
    "跳绳": "jump-rope",
    "握力器": "grip-strengthener",
    "网球": "tennis",
}

CATEGORY_NAME_MAP = {
    "乒乓球": "乒乓球",
    "乒乓球拍": "乒乓球拍",
    "羽毛球": "羽毛球",
    "羽毛球拍": "羽毛球拍",
    "跳绳": "跳绳",
    "握力器": "握力器",
    "网球": "网球",
}


def extract_images_from_sheet(wb, sheet_name):
    """Extract images from a sheet and map them to row numbers."""
    ws = wb[sheet_name]
    image_map = {}  # row_index -> image_bytes

    for img in ws._images:
        try:
            anchor = img.anchor
            if isinstance(anchor, TwoCellAnchor):
                row_idx = anchor._from.row  # 0-indexed
            else:
                row_idx = anchor._from.row

            # Get image data
            img_data = img._data()
            if img_data:
                image_map[row_idx] = img_data
        except Exception as e:
            print(f"  Warning: Could not extract image: {e}")

    return image_map


def get_column_mapping(header_row):
    """Map column names to their indices."""
    col_map = {}
    for i, val in enumerate(header_row):
        if pd.isna(val):
            continue
        val = str(val).strip()
        col_map[val] = i
    return col_map


def process_sheet(wb, sheet_name, skip_rows=3):
    """Process a single sheet and return product data."""
    ws = wb[sheet_name]

    # Read with pandas for data
    df = pd.read_excel(EXCEL_PATH, sheet_name=sheet_name, header=None)

    # Get header row (should be at index 2)
    header_row = df.iloc[2].tolist()
    col_map = get_column_mapping(header_row)

    print(f"\nProcessing: {sheet_name}")
    print(f"  Columns: {col_map}")

    # Extract images
    image_map = extract_images_from_sheet(wb, sheet_name)
    print(f"  Images found: {len(image_map)}")

    products = []
    category_slug = CATEGORY_SLUG_MAP.get(sheet_name, sheet_name)
    category_name = CATEGORY_NAME_MAP.get(sheet_name, sheet_name)

    # Process data rows (starting from row index 3)
    for idx in range(3, len(df)):
        row = df.iloc[idx]

        # Get product code (title)
        code_idx = col_map.get("货号")
        if code_idx is None:
            continue

        title = row.iloc[code_idx]
        if pd.isna(title):
            continue
        title = str(title).strip()
        if not title:
            continue

        # Get other fields
        def get_val(col_name):
            idx = col_map.get(col_name)
            if idx is not None and idx < len(row):
                val = row.iloc[idx]
                if pd.notna(val):
                    return str(val).strip()
            return ""

        product = {
            "title": title,
            "category_slug": category_slug,
            "category_name": category_name,
            "quantity_per_box": get_val("每箱数量"),
            "unit_price": get_val("单价"),
            "total_price": get_val("金额"),
            "material": get_val("材质"),
            "box_spec": get_val("箱规"),
            "weight": get_val("重量"),
            "dimensions": get_val("产品尺寸"),
            "moq": get_val("起订量（件）"),
            "has_image": idx in image_map,
        }

        # Check for image (openpyxl row is 0-indexed, pandas is 0-indexed too)
        # Excel row = pandas index (since header is at row 2, data starts at row 3)
        # openpyxl image anchor row is 0-indexed from row 0
        # So pandas row 3 = openpyxl row 3
        if idx in image_map:
            product["image_data"] = image_map[idx]

        products.append(product)

    return products


def main():
    print(f"Loading Excel: {EXCEL_PATH}")
    wb = openpyxl.load_workbook(EXCEL_PATH)

    # Create output directory
    os.makedirs(OUTPUT_DIR, exist_ok=True)
    images_dir = os.path.join(OUTPUT_DIR, "images")
    os.makedirs(images_dir, exist_ok=True)

    all_products = []
    sheets_to_process = [s for s in wb.sheetnames if s != "Sheet1"]

    for sheet_name in sheets_to_process:
        products = process_sheet(wb, sheet_name)

        # Save images
        for i, product in enumerate(products):
            if "image_data" in product:
                img_data = product["image_data"]
                # Determine extension from data
                ext = "png"
                if img_data[:3] == b'\xff\xd8\xff':
                    ext = "jpg"
                elif img_data[:4] == b'\x89PNG':
                    ext = "png"

                safe_title = product["title"].replace("/", "_").replace("\\", "_").replace(" ", "_")
                img_filename = f"{product['category_slug']}_{safe_title}.{ext}"
                img_path = os.path.join(images_dir, img_filename)

                with open(img_path, "wb") as f:
                    f.write(img_data)

                product["image_file"] = img_filename
                del product["image_data"]

        all_products.extend(products)
        print(f"  Products found: {len(products)}")

    # Save product data as JSON
    json_path = os.path.join(OUTPUT_DIR, "products.json")
    with open(json_path, "w", encoding="utf-8") as f:
        json.dump(all_products, f, ensure_ascii=False, indent=2)

    print(f"\n{'='*50}")
    print(f"Total products: {len(all_products)}")
    print(f"Data saved to: {json_path}")
    print(f"Images saved to: {images_dir}")

    # Summary per category
    from collections import Counter
    cat_counts = Counter(p["category_name"] for p in all_products)
    for cat, count in cat_counts.items():
        print(f"  {cat}: {count} products")


if __name__ == "__main__":
    main()
