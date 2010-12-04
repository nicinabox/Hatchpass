<div id="myUrl" class="panel">
  <?php if ($mobile): ?>
    <div class="toolbar">
      <h1>My Url</h1>
      <a class="button cancel" id="newUrl" >Done</a>
      <a class="button blueButton" target="_blank" href="/?action=newUrl" id="newUrl">New Url</a>
    </div>
  <?php endif ?>
  
  <?php if ($mobile): ?>
    <ul class="my-url">
      <li></li>
    </ul>
  <?php else: ?>
    <h1 class="my-url"></h1>
  <?php endif ?>
  
    
  <ul class="individual">
    <li><a target="_blank" href="" id="saveUrl" class="">Save current URL</a></li>
    <!-- <li><a target="_blank" href="" id="loadUrl" class="">Load saved URL</a></li> -->
  </ul>

</div>