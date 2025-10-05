#!/bin/bash

SSL_DIR="/etc/ssl/certificate"
SSL_KEY="${SSL_DIR}/ssl.key"
SSL_CERT="${SSL_DIR}/ssl.crt"

generate_ssl_certificate() {
    mkdir -p "${SSL_DIR}"
    openssl req -new -newkey rsa:4096 -days 3650 -nodes -x509 -subj "/C=CZ/ST=Czechia/L=Prague/O=${APP_NAME}/CN=${APP_NAME}" -keyout "${SSL_KEY}" -out "${SSL_CERT}"
    chmod -R 775 "${SSL_DIR}"
    chown -R nginx:nginx "${SSL_DIR}"
}

# Generate a new certificate if missing, or if the existing one is expired.
if [[ ! -e "${SSL_CERT}" || ! -e "${SSL_KEY}" ]]; then
    generate_ssl_certificate
elif ! openssl x509 -in "${SSL_CERT}" -noout -checkend 0 >/dev/null 2>&1; then
    generate_ssl_certificate
fi

TEMPLATES_DIR="/etc/nginx/sites-templates"
AVAILABLE_DIR="/etc/nginx/sites-available"

if [ ! -d "$AVAILABLE_DIR" ]; then
  mkdir -p "$AVAILABLE_DIR"
fi

envsubst '${APP_NAME}' < "$TEMPLATES_DIR/default.conf" > "$AVAILABLE_DIR/default.conf"
envsubst '${APP_NAME} ${ADMINER_PORT}' < "$TEMPLATES_DIR/adminer.conf" > "$AVAILABLE_DIR/adminer.conf"

rm -Rf /var/cache/nginx/*

nginx
