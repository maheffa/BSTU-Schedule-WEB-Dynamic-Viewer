# BSTU-Schedule-WEB-ynamic-Viewer
This is a Web (PHP/Javascript/HTML/CSS) project from my university

ScheduleParser - is a java program that I wrote to parse all group'schedule from bstu.ru/about/useful/schedule. It categorizes each group into faculty (therefore assigning each group to its faculty), then open each link pointing to each group's schedule. Each schedule contain some classes, which I extracted by analyzing the HTML structure of the page and parsed using Java Library JSOUP. Then smartly insert these data into the database.

mysqldump.sql - is the data gathered by ScheduleParser, which are analyzed and showed by ScheduleAnalizer (should have named it ScheduleViewer). It contains: the all the university's faculty, groups, classes, professor names, subject and schedule, since it was the result of extraction of all the classes information.

ScheduleAnalizer - is the web client itself.

Screenshots - the visula output of ScheduleAnalizer 
