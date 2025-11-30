FROM php:8.2-cli

# Install MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Set working directory
WORKDIR /app

# Copy all files
COPY . .

# Railway uses PORT env variable
ENV PORT=8080
EXPOSE 8080

# Start PHP built-in server using shell to expand $PORT
CMD php -S 0.0.0.0:$PORT -t public
