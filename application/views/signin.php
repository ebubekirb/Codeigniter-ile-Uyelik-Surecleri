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


  <?php 
  // Beni Hatirla icin gerekli olan cookie islemleri

  $this->load->helper("cookie");

  $remember_me = get_cookie("remember_me");

  if ($remember_me) {
    
    $member = json_decode($remember_me);

  } 
  
  ?>


  <div class="container">
    <div class="row">
     <div class="col s6 offset-s3">
      <div class="card-panel light">
        <form action="<?php echo base_url('member/signin') ?>" method="post">

          <div class="row">
            <div class="input-field col s12">
              <input type="email" name="email" value="<?php echo (isset($member)) ? $member->email : ""; ?>">
              <label>E-posta Adresi</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <input type="password" name="password" value="<?php echo (isset($member)) ? $member->password : ""; ?>">
              <label>Şifre</label>
            </div>
          </div>


          <div class="row">
            <label>
              <input type="checkbox" id="remember_me" name="remember_me" <?php echo (isset($member)) ? "checked" : ""; ?> />
              <span>Beni Hatırla</span>  
            </label>             
          </div>

          <div class="row center-align">                
            <button class="btn waves-effect waves-light" type="submit">Giriş Yap
              <i class="material-icons right">send</i>
            </button>

            <a href="#forgot_pass_modal" class="btn-flat modal-trigger waves-effect waves-light"> Şifremi Unuttum
              <i class="material-icons left">help</i>
            </a>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Structure -->
<div id="forgot_pass_modal" class="modal">
  <div class="modal-content">
    <h4>Şifremi Unuttum</h4>
    <p>Şifrenizi hatırlatmak için size yeni bir şifre oluşturup göndereceğiz. Bunun için sistemde kayıtlı olan <br> e-posta adresinizi giriniz.</p>

    <form action="<?php echo base_url('member/forgot_password') ?>" method="post">
      <div class="row">
        <div class="input-field col s12">
          <input type="email" id="email" name="email" placeholder="Sistemde kayıtlı e-posta adresiniz...">
          <label for="email">E-posta Adresi</label>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="modal-close waves-effect waves-green btn-flat"><i class="material-icons left">send</i>Gönder</button>
      </div>
    </form>
  </div>
</div>

<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-3.3.1.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/materialize.min.js") ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/custom.js") ?>"></script>
</body>
</html>
