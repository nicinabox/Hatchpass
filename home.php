<div id="home" class="current">
  <div class="toolbar">
      <h1>HatchPass</h1>
      <a class="button slideup leftButton" id="myUrlBtn" href="#myUrl">My Url</a>
      <a class="button flip" id="settingsBtn" href="#settings">Settings</a>
  </div>
  <form method="post" accept-charset="utf-8" class="panel" id="hatchForm">
    <ul class="rounded">
      <input type="hidden" name="id" value="<?php echo ID; ?>" id="id" >
      <li><label>Master</label><input type="password" name="master" placeholder="" id="master" /></li>
      <li><label>Domain</label><input type="url" name="host" placeholder="" id="host" /></li>
      <li><label>Secure</label><input type="text" name="secure" placeholder="" id="secure" /></li>
    </ul>
	</form>
	
</div>