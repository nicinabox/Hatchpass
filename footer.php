<?php if ($desktop): ?>
  <div id="about">
    <div class="container">
      <!-- <h2>The Hatchpass Project</h2> -->
      <p><strong>Create strong, unique passwords for your online accounts. Don't remember any of them.</strong></p>
      <p>This app combines your master password with the domain (and some other data) to create a really kick ass password. Every time you type that combination, you'll get the same password.</p>
      
      <p>This password is unique to you. See that ID in the address bar? That's yours. It influences the creation of your passwords. No one else can have the same one, even if they use the same master + domain combo.</p>
      
      <p>You may want to remember or write down the ID in your url. You and you won't be able to get the same passwords without it.</p>
      
    </div>
  </div>
  <div id="footer">
    <ul>
      <li>Version <?= VERSION ?></li>
      <li><a id="aboutproject" href="#about">About Hatchpass</a></li>
      <li>Designed <span class="amp">&amp;</span> developed by <a target="_blank" href="http://nicinabox.com">Nic Haynes</a></li>
    </ul>
  </div>
<?php endif ?>

</body>
</html>