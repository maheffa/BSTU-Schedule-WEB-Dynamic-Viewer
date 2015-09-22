# BSTU-Schedule-WEB-ynamic-Viewer
This is a Web (PHP/Javascript/HTML/CSS) project I wrote at my university, that really surprised my professor since it was a little bit more advanced than what was asked as school project.

Schedule for my university are given on static web pages. They can be accessed here [http://www.bstu.ru/about/useful/schedule](http://www.bstu.ru/about/useful/schedule). A typical schedule has a current static form [http://www.bstu.ru/static/themes/bstu/schedule/index.php?gid=4170&](http://www.bstu.ru/static/themes/bstu/schedule/index.php?gid=4170&) (as of september 2015). My idea was to explore all the schedule in static webpages, download, parse and store them in a database. Then I wrote a web client that access them and present the schedule in a single webpage dynamically based on the client's choice (in dropdown menus). I also created another webpage that compares how much hours on average students in one group, faculty or institute study in each day of the week. These options are also available for professors since each groups' schedule contains the name of the professors. Cross-referencing these data allow to output professors' schedule.

About the codes:
ScheduleParser - is a java program that I wrote to parse all groups'schedule from bstu.ru/about/useful/schedule. It categorizes each group into faculty (assigning each group to its faculty), then open each link pointing to each group's schedule. Each schedule page contains information about the classes (professor name, room number, time, subject), which I extracted by analyzing the HTML structure of the page and parsed it using Java Library JSOUP. Then smartly inserted these data into the database.

mysqldump.sql - is the data gathered by ScheduleParser, which are analyzed and showed by ScheduleAnalizer (should have named it ScheduleViewer). It contains all the university's faculties name, groups, classes, professor names, subjects and schedules, since it was the result of extraction of all the classes information from the University's official website.

ScheduleAnalizer - is the web client itself, the scripts and php and csses. Charts are showed using HighChart's library.

Screenshots - the visual output of ScheduleAnalizer 
