<div class="row">
    <div class="col-md-offset-5 col-md-3">
        <div class="form-login">
            <form method="POST" action="/home/login">
                <h4>Welcome</h4>
                <input type="text" id="userLogin" name="userLogin" class="form-control input-sm chat-input" placeholder="Login" />
                </br>
                <input type="password" id="userPassword" name="userPassword" class="form-control input-sm chat-input" placeholder="Password" />
                </br>
                <?php if (isset($errorMsg)) { ?><p><?= $errorMsg ?></p><?php } ?>
                <div class="wrapper">
                    <span class="group-btn">     
                        <button href="#" class="btn btn-primary btn-md">login <i class="fa fa-sign-in"></i></button>
                    </span>
                </div>
            </form>
        </div>

    </div>
</div>