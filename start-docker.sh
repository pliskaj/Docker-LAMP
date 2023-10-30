#!/bin/bash

# Define the path to your docker-compose.yaml file
compose_file="docker-compose.yaml"

# Check if the MYSQL_ROOT_PASSWORD already exists in the MariaDB service section
if grep -q "MYSQL_ROOT_PASSWORD:" "$compose_file"; then
    existing_password=$(grep "MYSQL_ROOT_PASSWORD:" "$compose_file" | awk '{print $2}')
    if [ -n "$existing_password" ]; then
        echo "MYSQL_ROOT_PASSWORD is already set and not empty: $existing_password"
        read -p "Do you want to change the MYSQL_ROOT_PASSWORD? (y/n): " change_password
        if [ "$change_password" != "y" ]; then
            echo "No changes were made."
            exit 1
        fi
    fi
fi

# Ask the user for the new MYSQL_ROOT_PASSWORD
read -p "Enter the new MYSQL_ROOT_PASSWORD: " new_password

# Check if the new password is not empty, and if it is, do not proceed
if [ -z "$new_password" ]; then
    echo "New MYSQL_ROOT_PASSWORD is empty. No changes were made."
    exit 1
fi

# Replace the existing MYSQL_ROOT_PASSWORD line or add a new one
if grep -q "MYSQL_ROOT_PASSWORD:" "$compose_file"; then
    # Replace the existing MYSQL_ROOT_PASSWORD line
    sed -i "/MYSQL_ROOT_PASSWORD:/c\      MYSQL_ROOT_PASSWORD: $new_password" "$compose_file"
else
    # Add the new MYSQL_ROOT_PASSWORD to the MariaDB service section
    sed -i "/mariadb:/a\    environment:" "$compose_file"
    sed -i "/    environment:/a\      MYSQL_ROOT_PASSWORD: $new_password" "$compose_file"
fi

# Print a success message
echo "Updated $compose_file with the new MYSQL_ROOT_PASSWORD for the MariaDB service."
