# Description

Homework task for Kiona to process energy consumption data from CSV file and generate daily, weekly and monthly reports

# Requirements

* Git: https://www.git-scm.com/downloads
* Docker: https://www.docker.com/
 
# Quickstart

1. Clone repository: `git clone https://github.com/MJKiona/energy-csv.git`
2. Change to folder: `cd energy-csv`
2. Build docker container: `docker build -t kiona-csv .`
3. Run the application: `docker run -it kiona-csv`

## Usage notes:

1. Files are loaded from `./data` folder;
2. By default, if not specified `./data/data Kiona.csv` (attached to a task) is processed;
3. To process custom file:
   - Place file into `./data` folder
   - Run application: `docker run -it -v "$(PWD)\data:/usr/app/kiona-csv/data" kiona-csv php -f index.php app:csv-report "custom_file.csv"`

## Solution notes:

1. Empty rows are ignored (skipped)
2. Data timestamp field timezone is assumed UTC
3. Value format is assumed decimal with two decimal numers
4. Data validation is loose and would require additional work:
   - It is unknown if records can be provided our of order
   - It is unknown if records can be duplicate values
5. Value column is stored as INT internally
6. Output is not ordered

## Potential improvements

1. It is possible to improve intermediate data storage by ditching weekly and monthly collections. Those can be dynamically calculated from Daily values collection.
2. Output table rendering is naive and has a potential to break on very large data collections.
