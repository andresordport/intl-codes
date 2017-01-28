library(tm)
args = commandArgs(trailingOnly=TRUE)
sum<-0
cmd_args = commandArgs();
doc<-""
for (arg in cmd_args) {
	sum<-sum+1
	if(sum==1 | sum==length(cmd_args)){
	} else {
		doc<-paste(doc,arg, sep=' ')
	}
}
doc
corpus<-Corpus(VectorSource(doc))
matrix <- TermDocumentMatrix(corpus,control=list(stopwords=FALSE,wordLengths=c(1, Inf)))
inspect(matrix)