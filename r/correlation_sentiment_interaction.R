rm(list=ls())

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='localhost',port=3306)
res <- dbGetQuery(myconn, "SELECT twitter_user_id, twitter_retweet, twitter_favorite, twitter_retweet + twitter_favorite as twitter_interaction, ABS(magnitude_normalized * score) as sentiment_index FROM tweets_analyzed WHERE twitter_lang = 'en'")
dbDisconnect(myconn)

#res$twitter_interaction[res$twitter_interaction==0] <- c(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)
normalized = (res$twitter_interaction-min(res$twitter_interaction))/(max(res$twitter_interaction)-min(res$twitter_interaction))

model <- lm(res$sentiment_index ~ res$twitter_interaction)
print(summary(model))
plot <- plot(res$twitter_interaction, res$sentiment_index,pch = 19,cex=0.5, xlab="Interaction Count (Retweets + Favorites)", ylab="Sentiment Index")
abline(model,col = 'red')

#d <- density(res$sentiment_index)
#plot(d, main="Distribution of Sentiment Index")
#polygon(d, col="red", border="blue")
#abline(v=mean(res$sentiment_index))
