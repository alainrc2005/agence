<?php

if (!function_exists('assets_file')) {
    function assets_file($file) {
        return asset('assets/' . $file . JC_VERSION);
    }
}
