<!DOCTYPE html>
  <html>
    <head>
      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/css/materialize.min.css"); ?>"  media="screen,projection"/>

      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body style="background-color: darkcyan" class="grey darken-4">
	<br>
  <div class="container">
    <div class="row">
        <div class="col s4 offset-s4">
          <div class="card green">
            <div class="center-align card-content white-text">
              <i class="large material-icons">mood</i>
              <span class="card-title"><strong>İşlem Başarılı!!</strong></span>
              <p><?php echo $message; ?></p>
            </div>
          </div>
        </div>
      </div>
  </div>

<!--JavaScript at end of body for optimized loading-->
      <script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.3.1.min.js") ?>"></script>
      <script type="text/javascript" src="<?php echo base_url("assets/js/materialize.min.js") ?>"></script>
      <script type="text/javascript" src="<?php echo base_url("assets/js/custom.js") ?>"></script>
    </body>
  </html>