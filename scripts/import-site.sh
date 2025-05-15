#!/bin/bash

echo "📥 Pulling latest changes..."
cd ..
git pull

cd wp-content/../ # Navigate back to site root

echo "📦 Importing database..."
wp db import ../db-export.sql --allow-root

echo "🔄 Flushing permalinks..."
wp rewrite flush --allow-root

echo "✅ Site updated and in sync."
