# RODBC Example
# import 2 tables (Crime and Punishment) from a DBMS
# into R data frames (and call them crimedat and pundat)

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='localhost',port=3306)
res <- dbGetQuery(myconn, "SELECT * FROM users JOIN (SELECT twitter_user_id,AVG(score * magnitude) as i FROM tweets_analyzed WHERE twitter_lang = 'en' GROUP BY twitter_user_id) t ON users.twitter_user_id = t.twitter_user_id ORDER BY i DESC")
close(myconn)

hist(res$i,breaks=12, col="red",xlab="Sentiment Index (score * magnitude)", main="Histogram of Sentiment Index")
