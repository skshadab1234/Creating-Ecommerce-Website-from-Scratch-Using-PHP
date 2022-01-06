<?php
    require 'includes/header.php';
    ?>


<div class="content" style="background:#FEE3EC">
    <div id="mainContent" style="margin: 28px auto 0;max-width: 400px;padding:50px 0;">
            width="100%">
        <div class="bg-white p-1">
            <div style="margin: 0 0 2px;color: #282c3f;font-size: 14px;font-weight: 500;">
                Invite Friends
            </div>
            <div class="share-description" style="padding-right: 18px;line-height: 1.7;">
                <span class="text-muted">Invite friends to <?= SITE_NAME ?> &amp; SAVE UP TO ₹500 EXTRA </span>
                <a href="<?= FRONT_SITE_PATH ?>" style="font-weight: 500;color: #ff3f6c;">Terms &amp; Conditions</a>
            </div>
            
            <hr>
            <div style="margin: 0 0 2px;color: #282c3f;font-size: 20px;font-weight: 500;">
                Share to  <i class="fa fa-share-alt"></i>
            </div>

            <?php
            $social_message = "Hi, I am ".$user['firstname']." ".$user['lastname']."

I am Shopping on ".SITE_NAME." Since ".date("M", strtotime($user['userAdded_On']))." and i am earning by shopping.

You can also earn just sign up and get ₹".SIGNUP_BONUS." as sign up bonus and ₹".GETSIGNEDUPBONUS." on completing your first order.

So Don't waste time go to my referral link now: ".FRONT_SITE_PATH."register?referCode=".$user['MyReferralCode']."&UserId=".$user['id']."
or enter my Referral code on signup: ".$user['MyReferralCode']."

Hurry up, limited offer left. Register now!";

            $social_url = FRONT_SITE_PATH."register?referCode=".$user['MyReferralCode'];
            ?>
            <div class="referrals-share-widget row mb-2">
                <div class="share-icon col-xs-4">
                    <a href="https://wa.me/?text=<?= urlencode($social_message) ?>" target="_blank">
                        <button class="btn btn-light" >
                            <img  width="60px" height="60px" class="img-fluid" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/2042px-WhatsApp.svg.png" alt="Others">
                            <div class="text-black">WhatsApp</div>
                        </button>
                    </a>
                </div>

                <div class="share-icon col-xs-4">
                    <a href="https://telegram.me/share/url?text=<?php echo urlencode($social_message) ?>&amp;url=<?php echo urlencode($social_url) ?>" target="_blank">
                        <button class="btn btn-light" >
                            <img  width="60px" height="60px" class="img-fluid" src="https://www.freepnglogos.com/uploads/telegram-logo-png-0.png" alt="Others">
                            <div class="text-black">Telegram</div>
                        </button>
                    </a>
                </div>

                <div class="share-icon col-xs-4">
                    <a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode($social_url) ?>" target="_blank">
                        <button class="btn btn-light" >
                            <img  width="60px" height="60px" class="img-fluid" src="https://pngimg.com/uploads/facebook_logos/facebook_logos_PNG19759.png" alt="Others">
                            <div class="text-black">Facebook</div>
                        </button>
                    </a>
                </div>

                <div class="share-icon col-xs-4">
                    <a href="https://twitter.com/intent/tweet/?text=<?php echo urlencode($social_message) ?>&amp;url=<?php echo urlencode($social_url) ?>" target="_blank">
                        <button class="btn btn-light" >
                            <img  width="60px" height="60px" class="img-fluid" src="https://freepngimg.com/save/62860-logo-twitter-computer-icons-free-photo-png/512x512" alt="Others">
                            <div class="text-black">Twitter</div>
                        </button>
                    </a>
                </div>

                <div class="share-icon col-xs-4">
                    <a href="mailto:?subject=Share and Earn by <?= SITE_NAME ?>&amp;body=<?php echo urlencode($social_message) ?>" target="_blank">
                        <button class="btn btn-light" >
                            <img  width="60px" height="60px" class="img-fluid" src="https://www.freepnglogos.com/uploads/gmail-email-logo-png-16.png" alt="Others">
                            <div class="text-black">E-mail</div>
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<?php
    require 'includes/footer.php';
?>
