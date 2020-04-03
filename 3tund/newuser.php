<?php
require('header.php');
//require("users.php");
?>
    <div class="container">
    <a href='.'>Tagasi</a>
    <div class="row centered-form">
        <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
        	<div class="panel panel-default">
        		<div class="panel-heading">
			    		<h3 class="panel-title">Registreeru kasutajaks</h3>
			 			</div>
			 			<div class="panel-body">
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
			    			
			    			<input type="submit" name="submitUserData" value="Registreeri" class="btn btn-info btn-block">
                            <span class="text-danger"><?php echo $notice; ?></span>
			    		</form>
			    	</div>
	    		</div>
    		</div>
    	</div>
    </div>