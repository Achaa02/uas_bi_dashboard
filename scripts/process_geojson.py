import json
import os

with open('scratch/raw_38_provinces.geojson', 'r', encoding='utf-8') as f:
    geojson = json.load(f)

# Name & ID mapping to official BPS code
# Official BPS 38 provinces
BPS_MAPPING = {
    "Aceh": "11",
    "Sumatera Utara": "12",
    "Sumatera Barat": "13",
    "Riau": "14",
    "Jambi": "15",
    "Sumatera Selatan": "16",
    "Bengkulu": "17",
    "Lampung": "18",
    "Kepulauan Bangka Belitung": "19",
    "Kepulauan Riau": "21",
    "DKI Jakarta": "31",
    "Jawa Barat": "32",
    "Jawa Tengah": "33",
    "DI Yogyakarta": "34",
    "Daerah Istimewa Yogyakarta": "34",
    "Jawa Timur": "35",
    "Banten": "36",
    "Bali": "51",
    "Nusa Tenggara Barat": "52",
    "Nusa Tenggara Timur": "53",
    "Kalimantan Barat": "61",
    "Kalimantan Tengah": "62",
    "Kalimantan Selatan": "63",
    "Kalimantan Timur": "64",
    "Kalimantan Utara": "65",
    "Sulawesi Utara": "71",
    "Sulawesi Tengah": "72",
    "Sulawesi Selatan": "73",
    "Sulawesi Tenggara": "74",
    "Gorontalo": "75",
    "Sulawesi Barat": "76",
    "Maluku": "81",
    "Maluku Utara": "82",
    "Papua Barat": "91",
    "Papua Barat Daya": "92",
    "Papua Selatan": "93",
    "Papua": "94",
    "Papua Tengah": "95",
    "Papua Pegunungan": "96"
}

# Standardized official province names
PROV_STANDARDIZED = {
    "11": "Aceh",
    "12": "Sumatera Utara",
    "13": "Sumatera Barat",
    "14": "Riau",
    "15": "Jambi",
    "16": "Sumatera Selatan",
    "17": "Bengkulu",
    "18": "Lampung",
    "19": "Kepulauan Bangka Belitung",
    "21": "Kepulauan Riau",
    "31": "DKI Jakarta",
    "32": "Jawa Barat",
    "33": "Jawa Tengah",
    "34": "DI Yogyakarta",
    "35": "Jawa Timur",
    "36": "Banten",
    "51": "Bali",
    "52": "Nusa Tenggara Barat",
    "53": "Nusa Tenggara Timur",
    "61": "Kalimantan Barat",
    "62": "Kalimantan Tengah",
    "63": "Kalimantan Selatan",
    "64": "Kalimantan Timur",
    "65": "Kalimantan Utara",
    "71": "Sulawesi Utara",
    "72": "Sulawesi Tengah",
    "73": "Sulawesi Selatan",
    "74": "Sulawesi Tenggara",
    "75": "Gorontalo",
    "76": "Sulawesi Barat",
    "81": "Maluku",
    "82": "Maluku Utara",
    "91": "Papua Barat",
    "92": "Papua Barat Daya",
    "93": "Papua Selatan",
    "94": "Papua",
    "95": "Papua Tengah",
    "96": "Papua Pegunungan"
}

# Special mapping for the specific GeoJSON IDs if needed
ID_SPECIAL_MAPPING = {
    "91-A": "94", # Papua
    "91-B": "96", # Papua Pegunungan
    "91-C": "93", # Papua Selatan
    "91-D": "95", # Papua Tengah
    "92-A": "91", # Papua Barat
    "92-B": "92", # Papua Barat Daya
}

mapped_codes = set()
for feature in geojson['features']:
    props = feature['properties']
    raw_name = props.get('PROVINSI', '').strip()
    raw_id = props.get('id', '')
    
    if raw_id in ID_SPECIAL_MAPPING:
        kode_bps = ID_SPECIAL_MAPPING[raw_id]
    elif raw_name in BPS_MAPPING:
        kode_bps = BPS_MAPPING[raw_name]
    else:
        kode_bps = str(props.get('KODE_PROV', ''))
        
    std_name = PROV_STANDARDIZED.get(kode_bps, raw_name)
    
    # Set standardized properties for easy frontend access
    feature['properties'] = {
        'kode_bps': kode_bps,
        'provinsi': std_name,
        'sumber': 'Badan Informasi Geospasial (BIG) & BPS RI 38 Provinsi (2024)',
        'id_asli': raw_id
    }
    feature['id'] = kode_bps
    mapped_codes.add(kode_bps)

print(f"Total features: {len(geojson['features'])}")
print(f"Unique BPS codes matched: {len(mapped_codes)} / 38")
missing = set(PROV_STANDARDIZED.keys()) - mapped_codes
print("Missing codes:", missing)

# Save to public/geojson/
os.makedirs('public/geojson', exist_ok=True)
target_path = 'public/geojson/indonesia-38-provinces.geojson'
with open(target_path, 'w', encoding='utf-8') as out:
    json.dump(geojson, out, ensure_ascii=False)

print(f"Successfully generated {target_path} (Size: {os.path.getsize(target_path)} bytes)")
