rm(list=ls())

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='localhost',port=3306)
res <- dbGetQuery(myconn, "SELECT t.c as tweet_count ,users.twitter_name, users.twitter_followers_count, t.c/TIMESTAMPDIFF(DAY,t.min,t.max) as tweets_per_day, t.twitter_user_id FROM (SELECT twitter_user_id,MAX(twitter_created_at) as max, MIN(twitter_created_at) as min, COUNT(*) as c FROM tweets GROUP BY twitter_user_id) t JOIN users ON users.twitter_user_id = t.twitter_user_id WHERE t.c >= 30 ORDER BY tweets_per_day DESC")
dbDisconnect(myconn)

model <- lm(log(res$twitter_followers_count) ~res$tweets_per_day)
print(summary(model))
plot <- plot(res$tweets_per_day, log(res$twitter_followers_count),pch = 19,cex=0.5, xlab="Tweets/Day", ylab="Follower Count (log)")
abline(model,col = 'red')

