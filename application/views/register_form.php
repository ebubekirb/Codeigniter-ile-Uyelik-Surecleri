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
              <form action="<?php echo base_url("member/registration") ?>" method="post">
                <div class="input-field">
                  <input type="text" name="full_name">
                  <label>Ad Soyad</label>
                </div>

                <div class="input-field">
                  <input type="email" name="email">
                  <label>E-posta Adresi</label>
                </div>

                <div class="input-field">
                  <input type="text" name="phone">
                  <label>Telefon</label>
                </div>

                <div class="input-field">
                   <select name="gender">
                    <option value="" disabled selected>Cinsiyet Seçiniz</option>
                    <option value="e">Erkek</option>
                    <option value="k">Kadın</option>
                  </select>
                  <label>Cinsiyet</label>
                </div>

                <div class="input-field">
                  <input type="password" name="password">
                  <label>Şifre</label>
                </div>

                <div class="input-field">
                  <input type="password" name="re_password">
                  <label>Tekrar Şifre</label>
                </div>

                <button class="btn waves-effect waves-light" type="submit">Üye Ol
                  <i class="material-icons right">send</i>
                </button>

                <a href="#" class="btn red waves-effect waves-light"> Vazgeç
                  <i class="material-icons left">close</i>
                </a>
              </form>
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


