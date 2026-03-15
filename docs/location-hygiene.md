# Location Hygiene Enhancements

1. **Structure**
   - `cities` now stores `latitude`/`longitude` so we can map textual locations to precise points (`database/migrations/2026_03_17_000000_add_latlong_to_cities.php`). Seed these fields with your trusted coordinates (OpenStreetMap, etc.).
   - `garages` and `spare_parts` each received a nullable `location_normalized` column to capture the cleaned-up version of what sellers typed (`database/migrations/2026_03_17_010000_add_location_normalized_fields.php`).

2. **Models updated**
   - The models now expose the new columns via `$fillable` so form submissions or the normalizer command can populate them (`app/Models/City.php`, `app/Models/Garage.php`, `app/Models/SparePart.php`).

3. **Backfill command**
   - Run `php artisan listings:normalize-locations` to normalize the location text and, when a `City` matches the string, backfill any missing coordinates. Use `--dry-run` to preview proposed updates without saving.
   - The command tries to match a roughly title-cased city name (e.g., `Nairobi`, `Mombasa`) anywhere inside the `location` text, so you can manually extend the `cities` table before re-running if the match fails.

4. **Next steps for data quality**
   - Keep enriching the `cities` table with additional lat/long pairs so heuristic matches cover more of your inventory.
   - After running the command, re-run `php artisan listings:normalize-locations` regularly for new listings or integrate it into a scheduled job if you want automated upkeep.
