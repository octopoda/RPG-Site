        <form id="formLogin" class="login" name="formLogin" method="post" accept-charset="utf-8">
            <div class="control-group">
                <label class="control-label" for="email">Email:</label>
                <div class="controls">
                    <input class="input-large" id="email" name="email" type="text" placeholder="Email" maxlength="60" size="30" >
                    <p class="help-block"></p>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="password">Password:</label>
                <div class="controls">
                    <input type="password" class="input-large" id="password" name="password" maxlength="60" size="30">
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                     <input type="hidden" name="refer" id="refer" value="<?php echo $refer ?>" >
                     <input type="hidden" name="login" id="login" value="1" >
                     <button id="loginSubmit" class="btn btn-primary"  name ="submit" type="submit" >Log In</button>
                </div>
                <div class="erorrs"></div>
            </div>

        </form>

    <nav>
    	<ul class="inline">
            <li><a href="/users/first_time.html">First Visit to Renal?</a></li>
    		<li><a href="/forgot-password.html">Forgot Password</a></li>
    	</ul>
    </nav>
    <div class="errors">
    </div>

