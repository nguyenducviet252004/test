<?php
/**
 * Script to check and auto-create storage link if missing
 * Add this to your Laravel application or run periodically
 */

function checkAndCreateStorageLink() {
    $publicPath = __DIR__ . '/public';
    $storageLinkPath = $publicPath . '/storage';
    $storageTargetPath = __DIR__ . '/storage/app/public';

    // Check if storage link exists and is working
    if (!is_dir($storageLinkPath) || !is_readable($storageLinkPath)) {
        echo "Storage link missing or broken. Creating new link...\n";

        // Remove existing if it's a broken link
        if (file_exists($storageLinkPath)) {
            if (is_dir($storageLinkPath)) {
                rmdir($storageLinkPath);
            } else {
                unlink($storageLinkPath);
            }
        }

        // Create junction on Windows
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $command = 'mklink /J "' . $storageLinkPath . '" "' . $storageTargetPath . '"';
            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                echo "SUCCESS: Storage link created successfully!\n";
                return true;
            } else {
                echo "ERROR: Failed to create storage link. Try running as Administrator.\n";
                return false;
            }
        } else {
            // For Linux/Mac
            if (symlink($storageTargetPath, $storageLinkPath)) {
                echo "SUCCESS: Storage link created successfully!\n";
                return true;
            } else {
                echo "ERROR: Failed to create storage link.\n";
                return false;
            }
        }
    } else {
        echo "Storage link is working properly.\n";
        return true;
    }
}

// Run the check
checkAndCreateStorageLink();
?>
