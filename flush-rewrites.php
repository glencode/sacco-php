<?php
/**
 * Flush rewrite rules to update URL structure after disabling FAQ archive
 */

// Load WordPress
require_once('../../../wp-config.php');

// Flush rewrite rules
flush_rewrite_rules();

echo "Rewrite rules flushed successfully!\n";
echo "The FAQ archive should now be disabled and the page template will be used instead.\n";
echo "You can delete this file after running it once.\n";
?>