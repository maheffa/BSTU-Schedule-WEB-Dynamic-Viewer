# BSTU-Schedule-WEB-ynamic-Viewer
This is a Web (PHP/Javascript/HTML/CSS) project I wrote at my university, that really surprised my professor since it was a little bit more advanced than what was asked as school project.

ScheduleParser - is a java program that I wrote to parse all groups'schedule from bstu.ru/about/useful/schedule. It categorizes each group into faculty (assigning each group to its faculty), then open each link pointing to each group's schedule. Each schedule page contains information about the classes (professor name, room number, time, subject), which I extracted by analyzing the HTML structure of the page and parsed it using Java Library JSOUP. Then smartly inserted these data into the database.

mysqldump.sql - is the data gathered by ScheduleParser, which are analyzed and showed by ScheduleAnalizer (should have named it ScheduleViewer). It contains all the university's faculties name, groups, classes, professor names, subjects and schedules, since it was the result of extraction of all the classes information from the University's official website.

ScheduleAnalizer - is the web client itself, the scripts and php and csses. Charts are showed using HighChart's library.

Screenshots - the visual output of ScheduleAnalizer 
