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

<body style="background-color: darkcyan" class="blue-grey lighten-4">
  <br>
  <?php if (isset($error)) { ?>
    <div class="container">
      <div class="row">
        <div class="col s6 offset-s3">
          <div class="card-panel red white-text center-align pulse">
            <?php echo $error; ?>
          </div>
        </div>
      </div>  
    </div>  
  <?php } ?>



  <div class="container">
    <div class="row">
     <div class="col s6 offset-s3">
      <div class="card-panel light">
        <form action="<?php echo base_url("member/password_change/$code"); ?>" method="post">

         

          <div class="row">
            <div class="input-field col s12">
              <input type="password" name="password">
              <label>Yeni Şifre</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input type="password" name="re_password">
              <label>Yeni Şifre Tekrar</label>
            </div>
          </div>


          <div class="row center-align">                
            <button class="btn waves-effect waves-light" type="submit">Değiştir
              <i class="material-icons right">send</i>
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.3.1.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/materialize.min.js") ?>"></script>
</body>
</html>
