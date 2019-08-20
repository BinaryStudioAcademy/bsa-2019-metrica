FROM nginx:1.17.2-alpine

COPY .aws/nginx/.certs/ /nginx/certs
COPY .aws/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY .aws/nginx/pki/C199461B0078D4FC6F31B9B0282DAB60.txt /pki/.well-known/pki-validation/file.txt
