# RODBC Example
# import 2 tables (Crime and Punishment) from a DBMS
# into R data frames (and call them crimedat and pundat)

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='127.0.0.0',port=3306)
dbListTables(myconn)
crimedat <- dbFetch(myconn, "users")
pundat <- dbSendQuery(myconn, "select * from users")
pundat
close(myconn)
