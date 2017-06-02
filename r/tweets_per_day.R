# RODBC Example
# import 2 tables (Crime and Punishment) from a DBMS
# into R data frames (and call them crimedat and pundat)
rm(list=ls())

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='localhost',port=3306)
res <- dbGetQuery(myconn, "SELECT t.c as tweet_count ,users.twitter_name, users.twitter_followers_count, t.c/TIMESTAMPDIFF(DAY,t.min,t.max) as tweets_per_day, t.twitter_user_id FROM (SELECT twitter_user_id,MAX(twitter_created_at) as max, MIN(twitter_created_at) as min, COUNT(*) as c FROM tweets GROUP BY twitter_user_id) t JOIN users ON users.twitter_user_id = t.twitter_user_id WHERE t.c >= 30 ORDER BY tweets_per_day DESC")
dbDisconnect(myconn)

hist <- hist(res$tweets_per_day, breaks=20,col="red",xlab="Tweets per Day", main="Histogram of Tweets / Day")
# Filled Density Plot
d <- density(res$tweets_per_day)
plot(d, main="Distribution of")
polygon(d, col="red", border="blue")
abline(v=mean(res$tweets_per_day))

boxplot <- boxplot(res$tweets_per_day, horizontal=TRUE, main="Tweets per Day")
abline(v=median(res$tweets_per_day),col = 'red')
text(x = boxplot.stats(res$tweets_per_day)$stats[3], labels = boxplot.stats(res$tweets_per_day)$stats[3], y = 0.6)
print(boxplot.stats(res$tweets_per_day)$stats)
