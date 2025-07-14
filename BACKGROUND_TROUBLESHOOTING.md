# Background Image Troubleshooting Guide

## Current Status
The background image `productsimg.jpg` is not showing on the products and services page despite multiple implementation attempts.

## What I've Implemented

### 1. **Direct Inline Styles** (Most Reliable)
```php
<main style="background: url('<?php echo get_template_directory_uri(); ?>/assets/images/productsimg.jpg') no-repeat center center fixed !important;">
```

### 2. **Test Image Box** (Top Right Corner)
Added a small test box in the top-right corner that should show the image if it's loading correctly.

### 3. **Debug Console Script**
Added JavaScript that will log to browser console:
- ✅ Image loaded successfully (if working)
- ❌ Image failed to load (if broken)
- The actual URL being tested

### 4. **Force Background CSS**
Created `force-background.css` with multiple override attempts.

## How to Troubleshoot

### Step 1: Check Browser Console
1. Open the products page
2. Press F12 to open Developer Tools
3. Go to Console tab
4. Look for messages like:
   - "Testing image URL: [URL]"
   - "✅ Image loaded successfully!" or "❌ Image failed to load"

### Step 2: Check Test Image Box
1. Look for a small red-bordered box in the top-right corner
2. If you see the image in this box = Image file is working
3. If box is empty/broken = Image file issue

### Step 3: Check Network Tab
1. In Developer Tools, go to Network tab
2. Refresh the page
3. Look for `productsimg.jpg` in the requests
4. Check if it loads successfully (status 200) or fails (404, 500, etc.)

### Step 4: Manual URL Test
1. Copy this URL and paste in browser address bar:
   ```
   http://your-site-url/wp-content/themes/daystar-theme4 - Copy (3) - Copynewer/assets/images/productsimg.jpg
   ```
2. Replace "your-site-url" with your actual site URL
3. If image shows = File exists and is accessible
4. If 404 error = File path issue

## Possible Issues & Solutions

### Issue 1: File Path Problem
**Symptoms**: 404 error in Network tab, test box empty
**Solution**: 
- Check if file exists at correct location
- Verify folder permissions
- Try renaming theme folder to remove spaces

### Issue 2: File Permissions
**Symptoms**: 403 error in Network tab
**Solution**: 
- Set file permissions to 644
- Set folder permissions to 755

### Issue 3: CSS Override
**Symptoms**: Image loads in test box but not as background
**Solution**: 
- Check for conflicting CSS
- Use browser inspector to see computed styles

### Issue 4: WordPress Theme Path
**Symptoms**: Wrong URL in console log
**Solution**: 
- Verify `get_template_directory_uri()` returns correct path
- Check WordPress site URL settings

## Quick Fixes to Try

### Fix 1: Rename Theme Folder
The spaces in "daystar-theme4 - Copy (3) - Copynewer" might cause issues.
Try renaming to: `daystar-theme4-copy3`

### Fix 2: Move Image to Root
Copy `productsimg.jpg` to WordPress root directory and use:
```php
background: url('/productsimg.jpg')
```

### Fix 3: Use Different Image
Try with a different image file to test if it's file-specific.

### Fix 4: Check .htaccess
Ensure `.htaccess` isn't blocking image access.

## What to Report Back

Please check the browser console and let me know:

1. **Console Messages**: What does the debug script show?
2. **Test Box**: Do you see the image in the red-bordered test box?
3. **Network Tab**: Does `productsimg.jpg` load successfully?
4. **Manual URL**: Does the direct image URL work?

With this information, I can provide a targeted fix for the specific issue.

## Current File Locations

- **Image File**: `assets/images/productsimg.jpg` ✅ (confirmed exists)
- **Main Template**: `page-products-services.php` (with inline styles)
- **CSS File**: `assets/css/pages/page-products-enhanced.css` (overlay disabled)
- **Force CSS**: `assets/css/pages/force-background.css` (override attempts)
- **Debug Script**: Added to page template

The image file definitely exists (1.5MB, created July 6, 2025), so the issue is likely with the path or CSS conflicts.