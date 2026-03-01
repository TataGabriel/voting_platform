# Voting Platform

Simple PHP-based voting platform for a Christian youth talent show.

## Features
- List participants with profile cards.
- View full details and select vote quantity.
- Payment page with MTN MOMO / Orange Money placeholder.
- MySQL database connectivity via PDO (configuration in `config.php`, include port if non‑standard).

## Setup
1. Place files in your PHP-capable web server root (e.g., XAMPP `htdocs`).
2. Update `config.php` with your MySQL credentials, database name and host/port (e.g. `localhost:3360` if MySQL listens on port 3360).
3. Use phpMyAdmin to create a `participants` table matching the expected columns:

   > The import script (`import.php`) reads the first row of the published sheet and
   > matches each header against the `$map` array inside that file. The keys of
   > `$map` should exactly equal the column labels in your sheet (e.g. "Name",
   > "Talent", "Age"). If your form uses different wording, either change the
   > sheet headers or update the map values accordingly before running the
   > importer.


```sql
CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    talent VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    age INT,
    address VARCHAR(255),
    email VARCHAR(255),
    church VARCHAR(255),
    phone VARCHAR(50),
    country VARCHAR(100)
);
```

4. Insert some sample rows or import from existing database.

   For automatic imports, make sure the sheet headers correspond to the keys in
   `$map` inside `import.php`. You can open that script and edit the array if
   necessary; the left-hand side of each element is what the importer looks for in
   the CSV export header row.

5. Place participant images in the `images/` directory and set the `image_path` field accordingly (e.g. `images/john.jpg`). You can use a default placeholder if desired.

6. To preview the site locally, run a PHP server from the project root (if PHP is installed):

```powershell
php -S localhost:8000 -t .
```

and then open http://localhost:8000/index.php in your browser.


## Usage
- Open `index.php` in browser.
- Click "Vote" to see details and choose number of votes.
- Proceed to payment and follow prompts.

## Notes
- The `momo_api.php` file contains a stub for integration with the actual payment API.
- Adjust styling in `css/style.css` and scripts in `js/scripts.js` as needed.

### Importing participants from Google Forms
1. Create a Google Form for audition registration; responses will be stored in a
   Google Sheet.
2. In the sheet, choose **File → Publish to the web** and publish the response
   tab. Copy the sheet ID from the URL (between `/d/` and `/edit`).
3. Edit `import.php` in the project, setting `$sheetId` and optionally the `$gid`
   if you use a different tab.
4. Ensure the column headers in the sheet match the labels in the `$map`
   array (e.g. "Name", "Talent", "Age", etc.) or adjust the map accordingly.
5. Run the script by visiting `http://localhost/yourfolder/import.php` or via
   CLI (`php import.php`) to pull the latest entries into your MySQL table.

   You can schedule the script with a cron job/Task Scheduler or configure a
   Google Apps Script to POST to this endpoint whenever a new form response
   arrives.

