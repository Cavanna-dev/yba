<div class="row">
    <div class="row">
        <div class="col-lg-2">
            <div class="btn-panel btn-panel-msg">
                <a href="/home/logout" class="btn  col-lg-3  send-message-btn pull-left" role="button"><i class="fa fa-gears"></i> Se Deconnecter</a>
            </div>
        </div>
    </div>
    <div class="conversation-wrap col-lg-3" id="connected">
        <?php foreach ($users as $user) { ?>
            <div class="media conversation">
                <div class="media-body">
                    <h5 class="media-heading"><?= $user->login ?></h5>
                    <small><?php
                        if ($user->online === 'true') {
                            echo 'En ligne';
                        } else {
                            echo 'Hors ligne';
                        }
                        ?></small>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="message-wrap col-lg-9" id="chat">
        <div class="msg-wrap" id="contentMessages" style="padding-bottom: 15px;height:400px;">
            <?php foreach ($messages as $message) { ?>
                <div class="media msg">
                    <div class="media-body">
                        <small class="pull-right time"><i class="fa fa-clock-o"></i> <?= $message->date ?></small>

                        <h5 class="media-heading"><?= $message->login ?></h5>
                        <small class="col-lg-10"><?= htmlentities($message->message) ?></small>
                    </div>
                </div>
            <?php } ?>
        </div>
        <form method="POST" action="#">
            <div class="send-wrap ">
                <textarea name="message" id="message" class="form-control send-message" rows="3" placeholder="You better answer !"></textarea>
            </div>
            <div class="btn-panel">
                <button type="submit" class=" col-lg-4 text-right btn   send-message-btn pull-right" ><i class="fa fa-plus"></i> Send Message</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    var lastId = <?= $lastId ?>;
</script>
