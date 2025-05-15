#!/bin/bash

echo "📤 Exporting database..."

# Export database to project root
wp db export ../db-export.sql --allow-root

echo "📁 Staging changes for Git..."
cd ..

git add db-export.sql
git add wp-content/themes/*/acf-json/

echo "🔃 Committing and pushing..."
git commit -m "🗃️ Auto-export: $(date '+%Y-%m-%d %H:%M:%S')"
git push

echo "✅ Export complete and pushed."
