# ALKON HINNASTO ASSIGNMENT

## MVC FOLDER HIERARCHY
 - app
    - controllers
    - models
    - views
- config
    - Environment variable configs
- public
    - custom CSS
    - custom JavaScript
    - index.page to use APP
- temp
    - Excel file of Hinnato (Data source from website)
    - place to store .csv when created
- utils
    - PHP script to convert Excel to CSV (Run in terminal)
    - PHP script to create DB table and field with data based on CSV (Run in terminal)

## COMPOSER DEPENDENCIES
- vlucas/phpdotenv: for loading environment variables
- shuchkin/simplexlsx: for reading XLS to CSV