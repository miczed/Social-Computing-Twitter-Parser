rm(list=ls())

options(scipen=999)

library(DBI)
myconn <-dbConnect(RMySQL::MySQL(),dbname='social-computing', username='root', password="root",host='localhost',port=3306)
res <- dbGetQuery(myconn, "SELECT users.twitter_followers_count, countries.population, twitter_screen_name, users_countries.country FROM users LEFT JOIN users_countries ON users.`twitter_screen_name` = users_countries.`twitter_handle` JOIN countries ON users_countries.country = countries.country WHERE users.twitter_followers_count > 0")
dbDisconnect(myconn)

model <- lm(log(res$population) ~ log(res$twitter_followers))
print(summary(model))
plot <- plot(log(res$twitter_followers), log(res$population),pch = 19,cex=0.5, xlab="Twitter Followers (log)",ylab="Population of country (log)")
abline(model,col = 'red')
