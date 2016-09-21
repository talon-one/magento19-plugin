FROM alexcheng/magento

ADD app /var/www/htdocs/app/
COPY entrypoint.sh /
CMD ["/entrypoint.sh"]
