<div class="span10">
<form class="form-horizontal" action="/book/process/{$route_id}" method="post">
    <div class="control-group">
    	<!--<label class="control-label" for="vid">VID</label>-->
        <div class="controls">
        	<input type="text" maxlength="6" id="vid" name="vid"  placeholder="VID" />
        </div>
    </div>
    <div class="control-group">
    	<!--<label class="control-label" for="email">E-mail</label>-->
        <div class="controls">
        	<input type="text" id="email" name="email" placeholder="Email" />
        </div>
    </div>
    
    <div class="control-group">
    	<label class="control-label" for="kcaptcha"><img src="/captcha" alt="Captcha" /></label>
        <div class="controls">
        	<input type="text" id="kcaptcha" name="kcaptcha" placeholder="Captcha" />
        </div>
    </div>
    
    <div class="control-group">
        <div class="controls">
        	<button type="submit" class="btn">Book!</button>
        </div>
    </div>
</form>
</div>