# hackathon Setup Instructions

1) Requirements: PHP, MySQL, Redis

2) Create a database called `hackathon` or change the file `config.ini`

3) Ensure the folder `cache` is writable

4) In the repo, run `./script_phinx_database.sh`

This will create the database tables. See http://docs.phinx.org/en/latest/migrations.html for more info.

5) In the repo, run `php scripts/scrape_packages.php` - This will populate the packages table.

6) In a separate window, run `./script_resque.sh` - Keep this Window open, as it will run the resque/redis process.

7) Back to the first window, run `php scripts/scrape_channels.php` - This will create a resque job, to scrape the channels

8) Back to the first window, run `php scripts/scrape_programs.php` - This will create a resque job, to scrape the programs for today

9) You can watch the action by tailing `cache/logfile.log`

10) Whenever adding a new class, you need to run composer install and stop/start `script_resque.sh`.




# DB Issues.

IF you having issues, comment out these lines in hackathon/vendor/tohir/database/src/db.php

Wherever it says: ` $this->db->query("SET NAMES 'UTF8';", array(), TRUE);`
