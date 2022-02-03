FROM httpd:2.4.33-alpine
RUN apk update;
RUN apk upgrade;
COPY shoppinglist.conf /usr/local/apache2/conf/shoppinglist.conf

RUN echo "Include /usr/local/apache2/conf/shoppinglist.conf" >> /usr/local/apache2/conf/httpd.conf