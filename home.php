<div id="home" class="current">
  <div class="toolbar">
      <h1>HatchPass</h1>
      <a class="button slideup leftButton" id="myUrlBtn" href="#myUrl">My Url</a>
      <a class="button flip" id="settingsBtn" href="#settings">Settings</a>
  </div>
  <form method="post" accept-charset="utf-8" class="" id="hatchForm">
    <ul class="rounded">
      <input type="hidden" name="id" value="<?php echo ID; ?>" id="url" >
      <li><label>Master</label><input type="password" name="master" placeholder="" id="master" />
        <a class="clearinput">&times;</a>
      </li>
      <li><label>Domain</label><input type="url" name="host" placeholder="" id="host" />
        <a class="clearinput">&times;</a>
      </li>
      <li><label>Secure</label><input type="text" name="secure" placeholder="" id="secure"/></li>
    </ul>
	</form>
	<small id="tagline">The best kept secret is one nobody knows.</small>
</div>
