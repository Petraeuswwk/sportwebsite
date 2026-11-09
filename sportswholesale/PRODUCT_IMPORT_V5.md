# V5 product import fields

The existing `import_data/products.json` remains valid. Rich detail fields are optional. Put every image file in `import_data/images/` before importing; use filenames, never supplier image URLs. The importer copies files into the WordPress media library. Put extracted Yiwugo records in `import_data/yiwugo_products.json`; `process_excel.py` merges this file with the Excel catalog and preserves previously enriched records.

```json
{
  "title": "Fiberglass Pickleball Paddle Set",
  "title_en": "Fiberglass Pickleball Paddle Set — 2 Paddles, 4 Balls & Carry Bag",
  "category_name": "Pickleball",
  "category_slug": "pickleball",
  "price_tiers": [
    { "min_qty": 60, "price": "¥52.30" },
    { "min_qty": 200, "price": "¥48.10" }
  ],
  "moq": 60,
  "moq_unit": "sets",
  "lead_time_days": 7,
  "colors": [
    { "code": "201", "picture": "201.jpg" },
    { "code": "202", "picture": "202.jpg" }
  ],
  "specs": {
    "Face": "Fiberglass face, multi-layer wood core",
    "Size": "40 × 20 cm",
    "Paddle weight": "260 g",
    "Contents": "2 paddles + 4 balls + 1 carry bag",
    "Set weight": "645 g"
  },
  "packing": {
    "Carton quantity": "20 sets/carton",
    "Carton size": "54 × 43 × 42 cm",
    "Carton weight": "15 kg",
    "Set package": "40 × 20 × 3.3 cm",
    "Trade terms": "EXW / FOB — confirm when you inquire"
  },
  "gallery": ["main.jpg", "two-paddles.jpg", "bag.jpg"],
  "detail_images": ["detail-1.jpg", "detail-2.jpg"],
  "source_ids": { "1688": "942444779009", "yiwugo": "978662140" }
}
```

The values above describe the approved sample schema, not an imported product. Its source HTML and photos were not present in this checkout, so no sample catalog record or media was added.
