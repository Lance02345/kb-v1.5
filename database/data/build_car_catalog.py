"""
Build a catalogue of car makes and models from two free public sources:

  * NHTSA vPIC API  (US government; passenger cars, SUVs/MPVs and pickups)
  * Wikidata        (global, incl. Japanese-market models common in Kenya)

Outputs (next to this script):
  car_makes_models_all.csv          every cleaned make/model pair found
  car_makes_models_recommended.csv  filtered for a marketplace dropdown
                                    (mainstream makes, models current since 1990 or undated)

Usage:  python -I database/data/build_car_catalog.py
"""

import csv
import hashlib
import json
import re
import sys
import time
import urllib.error
import urllib.parse
import urllib.request
from collections import defaultdict
from concurrent.futures import ThreadPoolExecutor
from pathlib import Path

OUT_DIR = Path(__file__).resolve().parent
UA = "car-catalog-builder/1.0 (python urllib)"
VPIC = "https://vpic.nhtsa.dot.gov/api/vehicles"
WDQS = "https://query.wikidata.org/sparql"
MODERN_YEAR = 1990


CACHE_DIR = OUT_DIR / ".cache"  # raw API responses; delete to force a fresh download


def http_json(url, params=None, headers=None, retries=5):
    if params:
        url = f"{url}?{urllib.parse.urlencode(params)}"
    cache_file = CACHE_DIR / (hashlib.sha256(url.encode()).hexdigest()[:32] + ".json")
    if cache_file.exists():
        return json.loads(cache_file.read_text(encoding="utf-8"))

    req = urllib.request.Request(url, headers={"User-Agent": UA, **(headers or {})})
    for attempt in range(retries):
        try:
            with urllib.request.urlopen(req, timeout=180) as resp:
                data = json.load(resp)
            CACHE_DIR.mkdir(exist_ok=True)
            cache_file.write_text(json.dumps(data), encoding="utf-8")
            return data
        except Exception as exc:  # noqa: BLE001 - retry any network/parse error
            if attempt == retries - 1:
                raise
            wait = 3 * (attempt + 1)
            if isinstance(exc, urllib.error.HTTPError) and exc.code == 429:
                wait = int(exc.headers.get("Retry-After") or 0) or 70
            print(f"  retry {attempt + 1} in {wait}s for {url[:90]}: {exc}", file=sys.stderr)
            time.sleep(wait)


# ---------------------------------------------------------------- name cleaning

MAKE_SUFFIXES = re.compile(
    r"\s+(motor company|motor corporation|motor co\.?|motors? corporation|motors?|automobiles?|auto|"
    r"automotive|cars?|corporation|company|group|gmbh|ag|s\.?p\.?a\.?|s\.?a\.?|ltd\.?|limited|inc\.?|"
    r"co\.?,? ?ltd\.?|plc|nv|n\.v\.|kk|k\.k\.)$",
    re.I,
)

# Common spelling/branding differences between the sources -> one canonical make name.
MAKE_ALIASES = {
    "mercedes-benz": "Mercedes-Benz", "mercedes benz": "Mercedes-Benz", "mercedes": "Mercedes-Benz",
    "volkswagen": "Volkswagen", "vw": "Volkswagen",
    "bmw": "BMW", "gmc": "GMC", "mg": "MG", "mini": "MINI", "byd": "BYD", "ds": "DS",
    "alfa romeo": "Alfa Romeo", "land rover": "Land Rover", "range rover": "Land Rover",
    "rolls-royce": "Rolls-Royce", "rolls royce": "Rolls-Royce", "aston martin": "Aston Martin",
    "great wall": "Great Wall", "isuzu": "Isuzu", "daihatsu": "Daihatsu", "ssangyong": "SsangYong",
    "kia": "Kia", "hyundai": "Hyundai", "chevrolet": "Chevrolet", "citroën": "Citroën", "citroen": "Citroën",
    "škoda": "Škoda", "skoda": "Škoda", "seat": "SEAT", "ram": "Ram", "tesla": "Tesla",
    "mazda": "Mazda", "nissan": "Nissan", "toyota": "Toyota", "honda": "Honda", "subaru": "Subaru",
    "mitsubishi": "Mitsubishi", "suzuki": "Suzuki", "lexus": "Lexus", "infiniti": "Infiniti",
    "peugeot": "Peugeot", "renault": "Renault", "volvo": "Volvo", "jeep": "Jeep", "ford": "Ford",
    "audi": "Audi", "porsche": "Porsche", "jaguar": "Jaguar", "fiat": "Fiat", "opel": "Opel",
    "chery": "Chery", "geely": "Geely", "haval": "Haval", "foton": "Foton", "tata": "Tata",
    "mahindra": "Mahindra", "proton": "Proton", "perodua": "Perodua", "dacia": "Dacia",
    "acura": "Acura", "cadillac": "Cadillac", "lincoln": "Lincoln", "buick": "Buick",
    "dodge": "Dodge", "chrysler": "Chrysler", "hino": "Hino", "jac": "JAC", "faw": "FAW",
    "changan": "Changan", "dongfeng": "Dongfeng", "gwm": "Great Wall", "baic": "BAIC", "saic": "SAIC",
}

# Wikidata sometimes records a parent company as the manufacturer; prefer the consumer brand.
NOT_A_BRAND = {
    "general motors", "stellantis", "fca", "fiat chrysler automobiles", "volkswagen group",
    "toyota motor", "hyundai motor group", "groupe psa", "psa group", "renault–nissan–mitsubishi alliance",
    "british leyland", "rootes group", "daimler", "daimler-benz", "tata motors",
    "general",  # "General Motors" after suffix stripping
}

DROP_MODEL = re.compile(r"concept|prototype|#|race car|racing|rally car|safety car|show car|\bgt\d|lmp|nascar|formula", re.I)
# Any trailing bracketed note: generation codes "(XV40, Asia)", "(E170/E180)", years, "(PHEV)".
GEN_PAREN = re.compile(r"\s*\([^()]*\)\s*$")
GEN_TOKEN = re.compile(r"\s+(?:[A-Z]{1,3}\d{2,3}[A-Z]?|mk\s?[ivx\d]+|series \d+|\d(?:st|nd|rd|th) generation)$", re.I)


def clean_make(name):
    name = (name or "").strip()
    if not name:
        return ""
    base = name
    for _ in range(3):
        stripped = MAKE_SUFFIXES.sub("", base).strip()
        if stripped == base or not stripped:
            break
        base = stripped
    key = base.lower()
    if key in MAKE_ALIASES:
        return MAKE_ALIASES[key]
    # vPIC returns upper case; title-case it but keep short acronyms (e.g. "JAC").
    if base.isupper() and len(base) > 3:
        base = base.title()
    return base


def clean_model(model, make):
    m = (model or "").strip()
    if not m or DROP_MODEL.search(m):
        return ""
    # Strip the make prefix ("Toyota Corolla" -> "Corolla").
    for prefix in {make, make.replace("-", " "), make.split()[0]}:
        if prefix and m.lower().startswith(prefix.lower() + " "):
            m = m[len(prefix) + 1:].strip()
            break
    # Collapse generation labels ("Corolla E90", "Camry (XV40)", "Supra (A80)") into the nameplate.
    for _ in range(2):
        m = GEN_PAREN.sub("", m).strip()
        m = GEN_TOKEN.sub("", m).strip()
    if not m or m.lower() == make.lower() or len(m) > 40:
        return ""
    return m


# ---------------------------------------------------------------- NHTSA vPIC

VPIC_TYPES = ["car", "multipurpose passenger vehicle (mpv)"]


def fetch_vpic():
    makes = {}
    for vtype in VPIC_TYPES:
        data = http_json(f"{VPIC}/GetMakesForVehicleType/{urllib.parse.quote(vtype)}", {"format": "json"})
        for row in data["Results"]:
            makes.setdefault(row["MakeId"], row["MakeName"])
    print(f"vPIC: {len(makes)} car/MPV makes", file=sys.stderr)

    # Pickups (Hilux, Navara, D-Max...) are "truck" in vPIC; only fetch them for car/MPV makes.
    jobs = [(mid, name, t) for mid, name in makes.items() for t in VPIC_TYPES + ["truck"]]

    def models_for(job):
        mid, name, vtype = job
        url = f"{VPIC}/GetModelsForMakeIdYear/makeId/{mid}/vehicletype/{urllib.parse.quote(vtype)}"
        try:
            data = http_json(url, {"format": "json"})
        except Exception as exc:  # noqa: BLE001
            print(f"  vPIC skip {name}/{vtype}: {exc}", file=sys.stderr)
            return []
        return [(name, r["Model_Name"]) for r in data["Results"]]

    rows = []
    with ThreadPoolExecutor(max_workers=6) as pool:
        for result in pool.map(models_for, jobs):
            rows.extend(result)
    print(f"vPIC: {len(rows)} raw make/model rows", file=sys.stderr)
    return rows


# ---------------------------------------------------------------- Wikidata

WIKIDATA_QUERY = """
SELECT ?model ?modelLabel ?brandLabel ?manuLabel
       (MIN(YEAR(?start)) AS ?startYear) (MAX(YEAR(?end)) AS ?endYear)
WHERE {
  VALUES ?class { wd:Q3231690 wd:Q59773381 }   # car model, car model series (e.g. Hilux, Navara)
  ?model wdt:P31 ?class .
  OPTIONAL { ?model wdt:P1716 ?brand . }
  OPTIONAL { ?model wdt:P176 ?manu . }
  FILTER(BOUND(?brand) || BOUND(?manu))
  OPTIONAL { ?model wdt:P571 ?start . }
  OPTIONAL { ?model wdt:P2669 ?end . }
  SERVICE wikibase:label { bd:serviceParam wikibase:language "en". }
}
GROUP BY ?model ?modelLabel ?brandLabel ?manuLabel
"""


def fetch_wikidata():
    data = http_json(WDQS, {"query": WIKIDATA_QUERY, "format": "json"},
                     headers={"Accept": "application/sparql-results+json"})
    rows = []
    for b in data["results"]["bindings"]:
        label = b.get("modelLabel", {}).get("value", "")
        if re.fullmatch(r"Q\d+", label):  # no English label
            continue
        brand = b.get("brandLabel", {}).get("value", "")
        manu = b.get("manuLabel", {}).get("value", "")
        make = brand
        if not make or re.fullmatch(r"Q\d+", make) or clean_make(make).lower() in NOT_A_BRAND:
            make = manu
        if not make or re.fullmatch(r"Q\d+", make) or clean_make(make).lower() in NOT_A_BRAND:
            # Fall back to the first word of the model label when it names a known brand.
            first = label.split()[0] if label else ""
            make = first if first.lower() in MAKE_ALIASES else ""
        if not make:
            continue
        start = b.get("startYear", {}).get("value")
        end = b.get("endYear", {}).get("value")
        rows.append((make, label, int(start) if start else None, int(end) if end else None))
    print(f"Wikidata: {len(rows)} raw make/model rows", file=sys.stderr)
    return rows


# ---------------------------------------------------------------- merge

# Always kept in the recommended list, whatever the year data says: global mainstream brands plus
# the Chinese / Indian / Malaysian brands sold in Kenya (Wikidata often lacks dates for these).
MAINSTREAM_MAKES = {
    "Acura", "Alfa Romeo", "Aston Martin", "Audi", "BAIC", "Bentley", "BMW", "Buick", "BYD", "Cadillac",
    "Changan", "Chery", "Chevrolet", "Chrysler", "Citroën", "Cupra", "Dacia", "Daewoo", "Daihatsu", "Datsun",
    "Dodge", "Dongfeng", "DS", "FAW", "Ferrari", "Fiat", "Ford", "Foton", "GAC", "Geely", "Genesis", "GMC",
    "Great Wall", "Haval", "Hino", "Holden", "Honda", "Hongqi", "Hummer", "Hyundai", "Infiniti", "Isuzu", "JAC",
    "Jaguar", "Jeep", "Jetour", "Kia", "Lada", "Lamborghini", "Land Rover", "Lexus", "Lincoln", "Lotus",
    "Mahindra", "Maserati", "Maybach", "Mazda", "McLaren", "Mercedes-Benz", "MG", "MINI", "Mitsubishi", "Nissan",
    "Opel", "Perodua", "Peugeot", "Polestar", "Pontiac", "Porsche", "Proton", "Ram", "Renault", "Rivian",
    "Rolls-Royce", "Rover", "Saab", "SEAT", "Škoda", "Smart", "SsangYong", "Subaru", "Suzuki", "Tata", "Tesla",
    "Toyota", "Vauxhall", "Volkswagen", "Volvo", "Wuling",
}


def build_recommended(rows):
    """Filter the full catalogue down to what belongs in a marketplace dropdown.

    Keeps a make if it is in MAINSTREAM_MAKES, or is sold in the US (NHTSA) with at least 3 models,
    or has at least 5 dated models from 1975+ still built in 1990+ (drops brass-era and one-off
    kit-car makers). Then keeps that make's models unless known to have ended before 1990.
    """
    def year(value):
        return int(value) if value not in (None, "") else None

    modern_models = defaultdict(int)
    nhtsa_models = defaultdict(int)
    for r in rows:
        if "nhtsa" in r["sources"]:
            nhtsa_models[r["make"]] += 1
        start, end = year(r["year_start"]), year(r["year_end"])
        if start and start >= MODERN_YEAR - 15 and (not end or end >= MODERN_YEAR):
            modern_models[r["make"]] += 1

    keep_makes = (
        MAINSTREAM_MAKES
        | {m for m, n in nhtsa_models.items() if n >= 3}
        | {m for m, n in modern_models.items() if n >= 5}
    )
    return [
        r for r in rows
        if r["make"] in keep_makes
        and (not year(r["year_end"]) or year(r["year_end"]) >= MODERN_YEAR)
        and (not year(r["year_start"]) or year(r["year_start"]) >= 1960)
    ]


def write_csvs(rows, recommended):
    fields = ["make", "model", "year_start", "year_end", "sources"]
    for name, data in [("car_makes_models_all.csv", rows), ("car_makes_models_recommended.csv", recommended)]:
        with open(OUT_DIR / name, "w", newline="", encoding="utf-8") as fh:
            writer = csv.DictWriter(fh, fieldnames=fields)
            writer.writeheader()
            writer.writerows(data)
        makes = len({r["make"] for r in data})
        print(f"wrote {name}: {makes} makes, {len(data)} models", file=sys.stderr)


def main():
    if "--recommend-only" in sys.argv:
        # Re-filter the existing full list without hitting the network.
        with open(OUT_DIR / "car_makes_models_all.csv", encoding="utf-8") as fh:
            rows = list(csv.DictReader(fh))
        write_csvs(rows, build_recommended(rows))
        return

    catalogue = defaultdict(lambda: {"sources": set(), "start": None, "end": None, "display": None})

    def add(make_raw, model_raw, source, start=None, end=None):
        make = clean_make(make_raw)
        if not make or make.lower() in NOT_A_BRAND:
            return
        model = clean_model(model_raw, make)
        if not model:
            return
        key = (make.lower(), re.sub(r"[\s\-]+", " ", model.lower()))
        entry = catalogue[key]
        entry["sources"].add(source)
        entry["make"] = make
        # Prefer the Wikidata spelling (mixed case) over vPIC where both exist.
        if entry["display"] is None or source == "wikidata":
            entry["display"] = model
        if start and 1885 < start < 2100:
            entry["start"] = min(filter(None, [entry["start"], start]))
        if end and 1885 < end < 2100:
            entry["end"] = max(filter(None, [entry["end"], end]))

    for make, model in fetch_vpic():
        add(make, model, "nhtsa")
    for make, model, start, end in fetch_wikidata():
        add(make, model, "wikidata", start, end)

    rows = sorted(
        ({"make": v["make"], "model": v["display"], "year_start": v["start"] or "", "year_end": v["end"] or "",
          "sources": "+".join(sorted(v["sources"]))} for v in catalogue.values()),
        key=lambda r: (r["make"].lower(), r["model"].lower()),
    )

    write_csvs(rows, build_recommended(rows))


if __name__ == "__main__":
    main()
