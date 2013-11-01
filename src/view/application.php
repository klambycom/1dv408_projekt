<?php

namespace view;

class Application {
  public function getPage() {
    return isset($_GET['page']) ? $_GET['page'] : '';
  }

  public function getController() {
    return isset($_GET['controller']) ? $_GET['controller'] : '';
  }

  public function html($content, $title = "") {
    return "<!doctype html>
            <html lang='sv'>
            <head>
              <meta charset='utf-8'>
              <title>$title - ?</title>
              <link rel='stylesheet' href='/stylesheets/styles.css' />
            </head>
            <body>
              <div class='container'>
                <div class='page-header'>
                  <h1>Namnet</h1>
                  <p class='lead'>Mer text sen</p>
                </div>

                $content
              </div>
            </body>
            </html>";
  }

  public function notFound(){
    return $this->html('404', 'Sidan hittades inte');
  }
}
/*
<link href='/stylesheets/screen.css' media='screen, projection' rel='stylesheet' type='text/css' />
<link href='/stylesheets/print.css' media='print' rel='stylesheet' type='text/css' />
<!--[if IE]>
<link href='/stylesheets/ie.css' media='screen, projection' rel='stylesheet' type='text/css' />
<![endif]-->
 */
