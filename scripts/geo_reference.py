import re

# Reference of 38 Indonesian Provinces with official BPS codes, island groups, and map centroids
PROVINCES_INDONESIA = {
    "Aceh": {"kode_bps": "11", "pulau": "Sumatera", "lat": 4.695135, "lng": 96.749399},
    "Sumatera Utara": {"kode_bps": "12", "pulau": "Sumatera", "lat": 2.1153547, "lng": 99.5450974},
    "Sumatera Barat": {"kode_bps": "13", "pulau": "Sumatera", "lat": -0.7399397, "lng": 100.8000051},
    "Riau": {"kode_bps": "14", "pulau": "Sumatera", "lat": 0.293347, "lng": 101.706829},
    "Jambi": {"kode_bps": "15", "pulau": "Sumatera", "lat": -1.4851831, "lng": 102.4380581},
    "Sumatera Selatan": {"kode_bps": "16", "pulau": "Sumatera", "lat": -3.3194374, "lng": 104.914704},
    "Bengkulu": {"kode_bps": "17", "pulau": "Sumatera", "lat": -3.5778471, "lng": 102.3463875},
    "Lampung": {"kode_bps": "18", "pulau": "Sumatera", "lat": -4.5585849, "lng": 105.4068079},
    "Kepulauan Bangka Belitung": {"kode_bps": "19", "pulau": "Sumatera", "lat": -2.7410513, "lng": 106.4405872},
    "Kepulauan Riau": {"kode_bps": "21", "pulau": "Sumatera", "lat": 3.9456514, "lng": 108.1428669},
    "DKI Jakarta": {"kode_bps": "31", "pulau": "Jawa", "lat": -6.2087634, "lng": 106.845599},
    "Jawa Barat": {"kode_bps": "32", "pulau": "Jawa", "lat": -6.917464, "lng": 107.619123},
    "Jawa Tengah": {"kode_bps": "33", "pulau": "Jawa", "lat": -7.150975, "lng": 110.1402594},
    "DI Yogyakarta": {"kode_bps": "34", "pulau": "Jawa", "lat": -7.7955798, "lng": 110.3694896},
    "Jawa Timur": {"kode_bps": "35", "pulau": "Jawa", "lat": -7.5360639, "lng": 112.2384017},
    "Banten": {"kode_bps": "36", "pulau": "Jawa", "lat": -6.4058172, "lng": 106.0640179},
    "Bali": {"kode_bps": "51", "pulau": "Bali & Nusa Tenggara", "lat": -8.4095178, "lng": 115.188916},
    "Nusa Tenggara Barat": {"kode_bps": "52", "pulau": "Bali & Nusa Tenggara", "lat": -8.6529334, "lng": 117.3616476},
    "Nusa Tenggara Timur": {"kode_bps": "53", "pulau": "Bali & Nusa Tenggara", "lat": -8.6573819, "lng": 121.0793705},
    "Kalimantan Barat": {"kode_bps": "61", "pulau": "Kalimantan", "lat": -0.2787808, "lng": 111.4752851},
    "Kalimantan Tengah": {"kode_bps": "62", "pulau": "Kalimantan", "lat": -1.6814878, "lng": 113.3823545},
    "Kalimantan Selatan": {"kode_bps": "63", "pulau": "Kalimantan", "lat": -3.0926415, "lng": 115.2837585},
    "Kalimantan Timur": {"kode_bps": "64", "pulau": "Kalimantan", "lat": 0.5386586, "lng": 116.419389},
    "Kalimantan Utara": {"kode_bps": "65", "pulau": "Kalimantan", "lat": 3.0730929, "lng": 116.04139},
    "Sulawesi Utara": {"kode_bps": "71", "pulau": "Sulawesi", "lat": 0.6246932, "lng": 123.9750018},
    "Sulawesi Tengah": {"kode_bps": "72", "pulau": "Sulawesi", "lat": -1.4300254, "lng": 121.4456179},
    "Sulawesi Selatan": {"kode_bps": "73", "pulau": "Sulawesi", "lat": -3.6687994, "lng": 119.9740534},
    "Sulawesi Tenggara": {"kode_bps": "74", "pulau": "Sulawesi", "lat": -4.14491, "lng": 122.174605},
    "Gorontalo": {"kode_bps": "75", "pulau": "Sulawesi", "lat": 0.6999372, "lng": 122.4467238},
    "Sulawesi Barat": {"kode_bps": "76", "pulau": "Sulawesi", "lat": -2.8441371, "lng": 119.2320784},
    "Maluku": {"kode_bps": "81", "pulau": "Maluku & Papua", "lat": -3.2384616, "lng": 130.1452734},
    "Maluku Utara": {"kode_bps": "82", "pulau": "Maluku & Papua", "lat": 1.5709993, "lng": 127.8087693},
    "Papua Barat": {"kode_bps": "91", "pulau": "Maluku & Papua", "lat": -1.3361154, "lng": 133.1747162},
    "Papua Barat Daya": {"kode_bps": "92", "pulau": "Maluku & Papua", "lat": -0.87897, "lng": 131.2544},
    "Papua": {"kode_bps": "94", "pulau": "Maluku & Papua", "lat": -4.269928, "lng": 138.0803529},
    "Papua Selatan": {"kode_bps": "93", "pulau": "Maluku & Papua", "lat": -7.4854, "lng": 139.8872},
    "Papua Tengah": {"kode_bps": "95", "pulau": "Maluku & Papua", "lat": -3.5516, "lng": 136.2366},
    "Papua Pegunungan": {"kode_bps": "96", "pulau": "Maluku & Papua", "lat": -4.0954, "lng": 139.0833}
}

def clean_province_name(raw_name):
    if not isinstance(raw_name, str):
        return None
    name = raw_name.strip()
    name = re.sub(r'\s*\d+\)', '', name)
    name = re.sub(r'[\"\']', '', name)
    name = name.strip()
    
    alias = {
        "Kep. Bangka Belitung": "Kepulauan Bangka Belitung",
        "Bangka Belitung": "Kepulauan Bangka Belitung",
        "Kep. Riau": "Kepulauan Riau",
        "D.I. Yogyakarta": "DI Yogyakarta",
        "DIY": "DI Yogyakarta",
        "Daerah Istimewa Yogyakarta": "DI Yogyakarta",
        "DKI": "DKI Jakarta"
    }
    return alias.get(name, name)
