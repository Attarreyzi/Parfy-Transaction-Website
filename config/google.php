<?php
/**
 * Konfigurasi Google OAuth Client ID
 * Dapatkan Client ID dari Google Cloud Console: https://console.cloud.google.com
 */
define('GOOGLE_CLIENT_ID', getenv('GOOGLE_CLIENT_ID') ?: 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com');
