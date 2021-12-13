### What is this?
This program extracts data from gliding ops' SQL server to create monthly dashboards in Google Sheet.
The dashboard is created as a copy of a template Google Sheet spreadsheet. 
The SQL data is then copied into a specific sheet of that template copy: this "hydrates" the sheets and the dashboard is ready.

### Intended use cases

1. A user manually (or a task scheduler automatically) runs this task
2. The task connects to the gliding ops database via TCP/IP, running the predefined queries intended to extract the data. The queries are coupled, to some extent, with the Google sheet template (see further down)
3. The task creates a copy of the predefined google sheet template and then populates it with the intended data in a predefined format. This action makes the charts available for the users in Google Sheet.

Further development: print to PDF, email.
```
                 ┌──────────┐      ┌──────────┐
                 │PRE       │      │MONTHLY   │
                 │  DEFINED │      │  REPORT  │
                 │ GOOGLE   │      │          │
                 │   SHEET  ├─────►│ GOOGLE   │
                 │TEMPLATE  │      │  SHEET   │
                 │  WITH    │      │          │
                 │   CHARTS │      │          │
                 └─────▲────┘      └─────▲────┘
                       │                 │
                       │                 │
                  Copy to            Writes data
                    new sheet          into predefined
                       │             sheet, to hydrate
                       │                the reports
                       │                 ┼
                   HTTPS/OAuth2      HTTPS/OAuth2
                       │                 │
                       │(3)              │
                    ┌──┴─────────────┐   │(4)
                 (2)│                │   │
        ┌───────────┤ GOPS REPORTING ├───┘
        │           │     TASK       │
        │           └────────────▲───┘
        │                        │
     TCP-IP                      │
      MySql                      │
        ┼                     Runs GOPS
 Read  data from DB           REPORTING
        │                     providing
 ┌──────▼──────┐              MONTH & YEAR         ┌───────────────────────┐
 │             │                 │            (1)  │                       │
 │ GOPS        │                 └───CMD┼LINE──────┤ USER / TASK SCHEDULER │
 │   SQL       │                                   │                       │
 │     GLIDING │                                   └───────────────────────┘
 │       DB    │
 │             │
 └─────────────┘
```

### Example of cronjob setup
Run at the beginning of every month, for the previous month:
```
0 0 1 * * cd /var/local/gopsreporting && sudo php main.php $(date --date="yesterday" "+%m %Y")
```

### Local development

To make mysql work, edit /etc/mysql/my.cnf.

use sudo for everything

To add lines in vim:
1. Enter insert mode (i)
2. Write the text
3. To save: Esc => :wq => enter


Lines to write:

```
[client]
default-character-set=utf8mb4

[mysql]
default-character-set=utf8mb4

[mysqld]
init-connect='SET NAMES utf8mb4'
character-set-server = utf8mb4
```
