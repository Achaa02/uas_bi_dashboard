import json
import urllib.request
import os

url = 'https://raw.githubusercontent.com/denyherianto/indonesia-geojson-topojson-maps-with-38-provinces/main/GeoJSON/indonesia-38-provinces.geojson'
print("Downloading GeoJSON from:", url)

req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
response = urllib.request.urlopen(req, timeout=15)
data = json.loads(response.read().decode('utf-8'))

print("Features count:", len(data['features']))
for i, f in enumerate(data['features']):
    print(f"{i+1}: {f['properties']}")

# Save raw copy in scratch/
os.makedirs('scratch', exist_ok=True)
with open('scratch/raw_38_provinces.geojson', 'w', encoding='utf-8') as out:
    json.dump(data, out)
print("Saved to scratch/raw_38_provinces.geojson")
