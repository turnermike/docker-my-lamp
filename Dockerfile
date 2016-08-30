FROM centos:6
MAINTAINER Mike Turner <mturner@realinteractive.ca>

# public directory
ENV public_html /public_html
# local httpd.conf file for
ENV httpd_conf ${public_html}/httpd.conf
# required by nano editor
ENV TERM xterm


# install software (extra packages for enterprise linux (EPEL), apache, php)
RUN rpm -ivh http://dl.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm
RUN rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-6.rpm
RUN yum install -y nano
RUN yum install -y httpd
RUN yum install --enablerepo=epel,remi-php56,remi -y \
                              php \
                              php-cli \
                              php-gd \
                              php-mbstring \
                              php-mcrypt \
                              php-mysqlnd \
                              php-pdo \
                              php-xml \
                              php-xdebug

# update php.ini with date.timezone
RUN sed -i -e "s|^;date.timezone =.*$|date.timezone = America/Toronto|" /etc/php.ini

# add the files from deploy to public_html
ADD ./deploy $public_html

# add an include to the bottom of apache config to include our own override file
RUN test -e $httpd_conf && echo "Include $httpd_conf" >> /etc/httpd/conf/httpd.conf

# open ports
EXPOSE 80

# start apache
CMD ["/usr/sbin/apachectl", "-D", "FOREGROUND"]