<html>
  <head>
    <title>Page Not Found.</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Podkova'>
  </head>
  <style>

    html {
        height: 100%;
    }

    body{
        background-color: #262626;
        font-family: 'podkova', sans-serif;
        color: #888;
        margin: 0;
    }

    #main{
        display: table;
        width: 100%;
        height: 100vh;
        text-align: center;
    }

    .fof{
        display: table-cell;
        vertical-align: middle;
    }

    .fof h1{
        font-size: 174px;
        display: inline-block;
        padding-right: 12px;
        animation: type .5s alternate infinite;
        margin: 10px;
    }
    .fof .link{
      color: #0077cc; /* Link color */
      text-decoration: none; /* Remove default underline */
      transition: color 0.3s ease;
      margin: 0px;
    }
    .fof .link:hover{
      color: #004466;
    }
    .textize{
      background: none;
      border: none;
      padding:0px;
      cursor: pointer;
      font-size: 17px;
      font-family: 'podkova', sans-serif;
    }
    .plex{
      color: #d17f00;
    }

  </style>
  <body>
    <div id="main">
          <div class="fof">
                <h1>404</h1><br>
            
            <?php 
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $domain = $_SERVER['HTTP_HOST'];
            $uri = $_SERVER['REQUEST_URI'];

            $fullUrl = $protocol . "://" . $domain . $uri;

            echo "<p>The page <l class='plex'>$fullUrl</l> does not exist!</p>";
            ?>
            <p>You can go<a href='/' class='link'>&nbsp;Home</a>, or go 
            <button onclick='history.back()' class='textize link'>&nbsp;Back</button>&nbsp;to previous page...<br></p>
          </div>
      
    </div>
  </body>
</html>
