<?php

namespace view;

class Application {
  /**
   * @return string
   */
  public function getPage() {
    return isset($_GET['page']) ? $_GET['page'] : '';
  }

  /**
   * @return string
   */
  public function getController() {
    return isset($_GET['controller']) ? $_GET['controller'] : '';
  }

  /**
   * @param string $content
   * @param string $title
   * @return string
   */
  public function html($content, $title = "") {
    return "<!doctype html>
            <html lang='sv'>
            <head>
              <meta charset='utf-8'>
              <title>$title - Kodkvalitet</title>
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

  /**
   * @return string
   */
  public function notFound(){
    return $this->html('404', 'Sidan hittades inte');
  }
}
