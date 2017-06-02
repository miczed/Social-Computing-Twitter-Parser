# RODBC Example
# import 2 tables (Crime and Punishment) from a DBMS
# into R data frames (and call them crimedat and pundat)
rm(list=ls())

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='localhost',port=3306)
res <- dbGetQuery(myconn, "SELECT * FROM users JOIN (SELECT twitter_user_id,AVG(score * magnitude) as i FROM tweets_analyzed WHERE twitter_lang = 'en' GROUP BY twitter_user_id) t ON users.twitter_user_id = t.twitter_user_id ORDER BY i DESC")
close(myconn)

res$twitter_friends_count[res$twitter_friends_count==0] <- c(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)

hist <- hist(res$i,breaks=12, xlim = c(-1,1), col="red",xlab="Sentiment Index (score * magnitude)", main="Histogram of Sentiment Index")
model <- lm(log(res$twitter_followers_count) ~ log(res$twitter_friends_count))
print(summary(model))
plot <- plot(log(res$twitter_friends_count), log(res$twitter_followers_count))
abline(model)
