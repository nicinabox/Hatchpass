<div id="home" class="current">
  <div class="toolbar">
      <?php if ($mobile): ?>
        <h1>HatchPass</h1>
      <?php else: ?>
        <h1><a id="logo" href="/" title=""><img src="/img/logo.png" alt="HatchPass"/></a></h1>
      <?php endif ?>
      
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
	<small id="tagline"><strong>Esc</strong> + <strong>h</strong> to see shortcuts</small>
</div>
