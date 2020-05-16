<?php 
require('../../../config.php');
require('functions.php');
$notice = null;
$email = null;
$emailError = null;
$passwordError = null;
  
if(isset($_POST["login"])){
  if (isset($_POST["email"]) and !empty($_POST["email"])){
    $email = test_input($_POST["email"]);
  } else {
    $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
  }
  
  if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8){
    $passwordError = "Palun sisesta parool, vähemalt 8 märki!";
  }
  
  if(empty($emailError) and empty($passwordError)){
     $notice = signIn($email, $_POST["password"]);
  } else {
    $notice = "Ei saa sisse logida!";
  }
}
  
?>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veebirakendused ja nende loomine</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href=".">Veebirakendused</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="./2tund">2tund</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="./3tund" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        3tund
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="./3tund">Uudised</a>
          <a class="dropdown-item" href="./3tund/activity.php">Logid</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./4tund">4tund</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./5tund">5tund</a>
      </li>
    </ul>
  </div>
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="<?php if(isset($_SESSION["userid"])){echo '#modalUserInfo'; }else{?>#modalLRForm<?php };?>"><?php if(isset($_SESSION["userid"])){ echo $_SESSION["userFirstName"].' '.$_SESSION["userLastName"]; } else{?>Logi sisse<?php };?>
</button>
</nav>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Logi sisse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h2>Logi sisse</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <label>E-mail (kasutajatunnus):</label><br>
          <input type="email" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span><br>
          <label>Salasõna:</label><br>
          <input name="password" type="password"><span><?php echo $passwordError; ?></span><br>
          <input class="btn btn-primary" name="login" type="submit" value="Logi sisse!"><span><?php echo $notice; ?></span>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sulge</button>
      </div>
    </div>
  </div>
</div>

<!--Modal: Login / Register Form-->
<div class="modal fade" id="modalLRForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">
    <!--Content-->
    <div class="modal-content">

      <!--Modal cascading tabs-->
      <div class="modal-c-tabs">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs md-tabs tabs-2 light-blue darken-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel7" role="tab"><i class="fas fa-user mr-1"></i>
              Logi sisse</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#panel8" role="tab"><i class="fas fa-user-plus mr-1"></i>
              Registreeru</a>
          </li>
        </ul>

        <!-- Tab panels -->
        <div class="tab-content">
          <!--Panel 7-->
          <div class="tab-pane fade in show active" id="panel7" role="tabpanel">

            <!--Body-->
            <div class="modal-body mb-1">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="form-group">
              <label>E-mail (kasutajatunnus):</label><br>
              <input type="email" class="form-control" name="email" value="<?php echo $email; ?>"><span><?php echo $emailError; ?></span>
            </div>
            <div class="form-group">
              <label>Salasõna:</label><br>
              <input name="password" class="form-control"type="password"><span><?php echo $passwordError; ?></span>
            </div>
              <input class="btn btn-primary btn-block" name="login" type="submit" value="Logi sisse!"><span><?php echo $notice; ?></span>
            </form>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <div class="options text-center text-md-right mt-1">
               
              </div>
              <button type="button" class="btn btn-secondary waves-effect ml-auto" data-dismiss="modal">Sulge</button>
            </div>

          </div>
          <!--/.Panel 7-->

          <!--Panel 8-->
          <div class="tab-pane fade" id="panel8" role="tabpanel">

            <!--Body-->
            <div class="modal-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="text" name="firstName" id="firstName" class="form-control input-sm" placeholder="Eesnimi" value="<?php echo $name; ?>">
                                        <span class="text-danger"><?php echo $nameError; ?></span>
			    					</div>
                                </div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="text" name="surName" id="surName" class="form-control input-sm" placeholder="Perekonnanimi" value="<?php echo $surname; ?>">
                                        <span class="text-danger"><?php echo $surnameError; ?></span>
			    					</div>
			    				</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 mb-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender2" value="2" <?php if($gender == "2"){		echo " checked";} ?>>
                                        <label class="form-check-label" for="gender2">Naine</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender1" value="1" <?php if($gender == "1"){		echo " checked";} ?>>
                                        <label class="form-check-label" for="gender1">Mees</label>
                                    </div>
                                        <span class="text-danger"><?php echo $genderError; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 mb-2">
                                <?php
                                    //sünnikuupäev
                                    echo '<select class="custom-select mr-sm-2" name="birthDay">' ."\n";
                                    echo "\t \t" .'<option value="" selected disabled>päev</option>' ."\n";
                                    for($i = 1; $i < 32; $i ++){
                                        echo "\t \t" .'<option value="' .$i .'"';
                                        if($i == $birthDay){
                                            echo " selected";
                                        }
                                        echo ">" .$i ."</option> \n";
                                    }
                                    echo "\t </select> \n";
                                ?>
                                <span class="text-danger"><?php echo $birthDayError; ?></span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 mb-2">
                                <?php
                                    echo '<select class="custom-select mr-sm-2" name="birthMonth">' ."\n";
                                    echo "\t \t" .'<option value="" selected disabled>kuu</option>' ."\n";
                                    for ($i = 1; $i < 13; $i ++){
                                        echo "\t \t" .'<option value="' .$i .'"';
                                        if ($i == $birthMonth){
                                            echo " selected ";
                                        }
                                        echo ">" .$monthNamesET[$i - 1] ."</option> \n";
                                    }
                                    echo "</select> \n";
                                ?>
                                <span class="text-danger"><?php echo $birthMonthError; ?></span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 mb-2">
                                <?php
                                    echo '<select class="custom-select mr-sm-2" name="birthYear">' ."\n";
                                    echo "\t \t" .'<option value="" selected disabled>aasta</option>' ."\n";
                                    for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
                                        echo "\t \t" .'<option value="' .$i .'"';
                                        if ($i == $birthYear){
                                            echo " selected ";
                                        }
                                        echo ">" .$i ."</option> \n";
                                    }
                                    echo "</select> \n";
                                ?>
                                <span class="text-danger"><?php echo $birthYearError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email" value="<?php echo $email; ?>">
                                <span class="text-danger"><?php echo $emailError; ?></span>
			    			</div>
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Parool (min 8 tähemärki)">
                                        <span class="text-danger"><?php echo $passwordError; ?></span>
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control input-sm" placeholder="Kinnita parool">
                                        <span class="text-danger"><?php echo $confirmpasswordError; ?></span>
			    					</div>
			    				</div>
			    			</div>
			    			
			    			<input type="submit" name="submitUserData" value="Registreeri" class="btn btn-primary btn-block">
                            <span class="text-danger"><?php echo $notice; ?></span>
			    		</form>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <div class="options text-right">
                
              </div>
              <button type="button" class="btn btn-secondary waves-effect ml-auto" data-dismiss="modal">Sulge</button>
            </div>
          </div>
          <!--/.Panel 8-->
        </div>

      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<div class="modal fade" id="modalUserInfo" tabindex="-1" role="dialog" aria-labelledby="modalUserInfo" aria-hidden="true">
  <div class="modal-dialog cascading-modal" role="document">
    <!--Content-->
    <div class="modal-content">

      <!--Modal cascading tabs-->
      <div class="modal-c-tabs">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs md-tabs tabs-2 light-blue darken-3" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#panel7" role="tab"><i class="fas fa-user mr-1"></i>
              Kasutaja andmed</a>
          </li>
        </ul>
        <!-- Tab panels -->
        <div class="tab-content">
          <!--Panel 7-->
          <div class="tab-pane fade in show active" id="panel7" role="tabpanel">

            <!--Body-->
            <div class="modal-body mb-1">
            <a href="?logout=1" class="btn btn-secondary waves-effect ml-auto">Logi välja</a>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <div class="options text-center text-md-right mt-1">

              </div>
              <button type="button" class="btn btn-secondary waves-effect ml-auto" data-dismiss="modal">Sulge</button>
            </div>

          </div>
          <!--/.Panel 7-->

          <!--Panel 8-->
          <div class="tab-pane fade" id="panel8" role="tabpanel">

            <!--Body-->
            <div class="modal-body">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="text" name="firstName" id="firstName" class="form-control input-sm" placeholder="Eesnimi" value="<?php echo $name; ?>">
                                        <span class="text-danger"><?php echo $nameError; ?></span>
			    					</div>
                                </div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="text" name="surName" id="surName" class="form-control input-sm" placeholder="Perekonnanimi" value="<?php echo $surname; ?>">
                                        <span class="text-danger"><?php echo $surnameError; ?></span>
			    					</div>
			    				</div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 mb-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender2" value="2" <?php if($gender == "2"){		echo " checked";} ?>>
                                        <label class="form-check-label" for="gender2">Naine</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="gender1" value="1" <?php if($gender == "1"){		echo " checked";} ?>>
                                        <label class="form-check-label" for="gender1">Mees</label>
                                    </div>
                                        <span class="text-danger"><?php echo $genderError; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4 mb-2">
                                <?php
                                    //sünnikuupäev
                                    echo '<select class="custom-select mr-sm-2" name="birthDay">' ."\n";
                                    echo "\t \t" .'<option value="" selected disabled>päev</option>' ."\n";
                                    for($i = 1; $i < 32; $i ++){
                                        echo "\t \t" .'<option value="' .$i .'"';
                                        if($i == $birthDay){
                                            echo " selected";
                                        }
                                        echo ">" .$i ."</option> \n";
                                    }
                                    echo "\t </select> \n";
                                ?>
                                <span class="text-danger"><?php echo $birthDayError; ?></span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 mb-2">
                                <?php
                                    echo '<select class="custom-select mr-sm-2" name="birthMonth">' ."\n";
                                    echo "\t \t" .'<option value="" selected disabled>kuu</option>' ."\n";
                                    for ($i = 1; $i < 13; $i ++){
                                        echo "\t \t" .'<option value="' .$i .'"';
                                        if ($i == $birthMonth){
                                            echo " selected ";
                                        }
                                        echo ">" .$monthNamesET[$i - 1] ."</option> \n";
                                    }
                                    echo "</select> \n";
                                ?>
                                <span class="text-danger"><?php echo $birthMonthError; ?></span>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 mb-2">
                                <?php
                                    echo '<select class="custom-select mr-sm-2" name="birthYear">' ."\n";
                                    echo "\t \t" .'<option value="" selected disabled>aasta</option>' ."\n";
                                    for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
                                        echo "\t \t" .'<option value="' .$i .'"';
                                        if ($i == $birthYear){
                                            echo " selected ";
                                        }
                                        echo ">" .$i ."</option> \n";
                                    }
                                    echo "</select> \n";
                                ?>
                                <span class="text-danger"><?php echo $birthYearError; ?></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email" value="<?php echo $email; ?>">
                                <span class="text-danger"><?php echo $emailError; ?></span>
			    			</div>
			    			<div class="row">
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Parool (min 8 tähemärki)">
                                        <span class="text-danger"><?php echo $passwordError; ?></span>
			    					</div>
			    				</div>
			    				<div class="col-xs-6 col-sm-6 col-md-6">
			    					<div class="form-group">
                                        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control input-sm" placeholder="Kinnita parool">
                                        <span class="text-danger"><?php echo $confirmpasswordError; ?></span>
			    					</div>
			    				</div>
			    			</div>
			    			
			    			<input type="submit" name="submitUserData" value="Registreeri" class="btn btn-primary btn-block">
                            <span class="text-danger"><?php echo $notice; ?></span>
			    		</form>
            </div>
            <!--Footer-->
            <div class="modal-footer">
              <div class="options text-right">
                <p class="pt-1">Juba on konto? <a href="#" class="blue-text">Logi sisse</a></p>
              </div>
              <button type="button" class="btn btn-secondary waves-effect ml-auto" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!--/.Panel 8-->
        </div>

      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
