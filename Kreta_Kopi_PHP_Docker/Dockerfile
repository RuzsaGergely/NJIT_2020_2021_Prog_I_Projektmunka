FROM ubuntu:20.04
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install software-properties-common -y && \
    add-apt-repository ppa:ondrej/php -y && \
    apt-get update && \
    apt-get install apache2 php7.3 php7.3-fpm libapache2-mod-php7.3 php7.3-cli php7.3-readline php7.3-mbstring php7.3-zip php7.3-intl php7.3-xml php7.3-json php7.3-curl php7.3-gd php7.3-pgsql php7.3-mysql php-pear -y
    
RUN service apache2 stop
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]

EXPOSE 80
