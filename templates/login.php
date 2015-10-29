<?php require('header.php') ?>

<form class="jumbotron" action="?act=do-login" method="post" style="width: 25%; margin: auto;">

    <label class="sr-only">Login</label>
    <input type="text" name="login" class="form-control" placeholder="Login" required autofocus>
    <label class="sr-only">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <div style="margin-top: 10px;">    
      <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>    
    </div>
    <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
</form>

<?php require('footer.php') ?>