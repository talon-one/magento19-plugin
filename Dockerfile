FROM alexcheng/magento

# see https://github.com/occitech/docker/issues/16
RUN rmdir /var/www/html && ln -s /var/www/htdocs /var/www/html

ADD app /var/www/htdocs/app/
COPY entrypoint.sh /
CMD ["/entrypoint.sh"]
