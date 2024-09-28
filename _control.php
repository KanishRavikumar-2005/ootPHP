<?php
/*
 * © 2024 Kanish Ravikumar. All rights reserved.
 * Licensed under the MIT License.
 * See LICENSE file for details.
 */

Router::add('/', function() {
    document::title("Welcome");
    document::icon("/public/images/logo.ico");
    document::render('index');
}, ['GET', 'POST'], "index.page");

Router::route();

?>
  

