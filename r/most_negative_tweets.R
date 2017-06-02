rm(list=ls())

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='localhost',port=3306)
res <- dbGetQuery(myconn, "SELECT users.twitter_user_id, users.twitter_screen_name, users.twitter_name,users.twitter_location, (t2.negative / t1.total) as neg_percent, t2.negative, t1.total FROM users JOIN 
(SELECT twitter_user_id , COUNT(*) as total FROM tweets_analyzed WHERE twitter_lang = 'en' GROUP BY twitter_user_id) t1 ON users.twitter_user_id = t1.twitter_user_id JOIN 
                  (SELECT twitter_user_id , COUNT(*) as negative FROM tweets_analyzed WHERE twitter_lang = 'en' AND (score * magnitude_normalized) < 0 GROUP BY twitter_user_id) t2 ON t1.twitter_user_id = t2.twitter_user_id WHERE t1.total >= 30 ORDER BY neg_percent DESC")
#close(myconn)
par(mar=c(8,4,4,2))
barplot <- barplot(res$neg_percent,names.arg = res$twitter_name,las=2,cex.names=0.5)


