library(tm)
doc<-"este es el texto de prueba para el text mining"
corpus<-Corpus(VectorSource(doc))
matrix <- TermDocumentMatrix(corpus,control=list(stopwords=FALSE,wordLengths=c(1, Inf)))
inspect(matrix)
