<div id="settings">
<?php if ($mobile): ?>
    <div class="toolbar">
        <h1>Settings</h1>
        <a class="button blueButton" id="saveSettings">Done</a>
        <a class="button cancel" id="cancelSettings" href="#">Cancel</a>
    </div>
<?php endif ?>  

  <form method="POST">
    <?php if ($desktop): ?>
      <a class="button blueButton" href="#" id="saveSettings">Done</a>
    <?php endif ?>
    
  	<h2>Variation</h2>
  	<ul>
  	  <li><label>Symbols</label> <span class="toggle"><input id="symbols" type="checkbox" <?php echo parseSetting($s->symbols); ?>/></span></li>
  	  <li><label>Uppercase Letters</label> <span class="toggle"><input id="caps" type="checkbox" <?php echo parseSetting($s->caps); ?>/></span></li>
  	  <li><label>Length</label> <input type="text" name="length" placeholder="Length" value="<?php echo $s->strlen; ?>" id="length" ></li>
  	</ul>
  	
  	<h2>Algorithm</h2>
  	<ul class="rounded">
  	  <li><label>Default</label><input type="radio" name="alt" value="" id="default" <?php echo (($s->h_algorithm == "default") ? "checked" : ""); ?>></li>
  	  <li><label>Legacy</label><input type="radio" name="alt" value="" id="legacy" <?php echo (($s->h_algorithm == "legacy") ? "checked" : ""); ?>></li>
  	</ul>
  	
  	<h2>Remember</h2>
  	<ul class="rounded">
  	  <li><label>Remember master</label> <span class="toggle"><input id="r_master" type="checkbox" checked/></span></li>
  	  <li><label>Remember settings</label> <span class="toggle"><input id="r_settings" type="checkbox" <?php echo parseSetting($s->r_settings); ?>/></span></li>
  	  <li><label>Remember URL</label> <span class="toggle"><input id="r_url" type="checkbox" checked/></span></li>
  	</ul>
  	
  	<div class="info">
      <p>
        Designed by <a href="http://nicinabox.com">Nic Haynes</a>
      </p>
      <p>Version 2.1b</p>
    </div>
  	
  	<?php if (DEBUG): ?>
  	<h2>Debug</h2>
  	<ul>
      <li>
      <pre>
        <?php print_r($s); ?>
      </pre>
    </li>
  	 </ul>
  	<?php endif ?>
  </form>
</div>