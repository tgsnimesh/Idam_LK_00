<?php $where_from = "membership"; ?>

<?php require_once("../account/account-db-handler.php"); ?>
<?php require_once("../library/verified-seller-handler.php"); ?>

<?php

    $now = new DateTime(date("Y:m:d H:i:s"));

    $user = get_login_user(check_is_login_user())->fetch_assoc();
    $verified_seller = get_verified_seller(check_is_login_user())->fetch_assoc();

    $membership_requiest_month = 1;

?>

<div class="membership">
    <div class="login-name border-bottom">
        <p class="">My Membership</p>
    </div><!-- member ship owner title bar -->

    <?php if ($user['is_verified_member']) { ?>
    <!-- ----------Verified seller card---------- -->
    <div class="verified-seller-card py-3">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <div class="toast align-items-center text-white bg-primary border-0 show w-100" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Idam.lk Membership
                        </div>
                        <div class="me-2 m-auto d-flex align-items-center">
                            <p class="mb-0 me-1 text-warning">Member</p>
                            <i class="fa fa-star text-warning" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Idam.lk Member Ship</h5>
                <a href="" class="btn btn-primary btn-sm">About Membership</a>
            </div>
            <div class="card-footer text-muted">
                <?php
                    $today = new DateTime();
                    $created = new DateTime($user['created_dt']);
                    $registerd = $created->modify('+30 day');
                    $interval = $today->diff($registerd);
                                    
                    if ($y = $interval->format("%y"))
                        echo $y . " years ago";
                    else if ($m = $interval->format("%m"))
                        echo $m . " months ago";
                    else if ($d = $interval->format("%d"))
                        echo $d . " days ago";
                    else if ($h = $interval->format("%h"))
                        echo $h . " hours ago";
                    else if ($i = $interval->format("%i"))
                        echo $i . " minutes ago";
                    else
                        echo "just now";
                ?>
            </div>
        </div>
    </div>
    <!-- ----------Verified seller card end---------- -->

    <?php if (!$user['is_verified_seller']) { ?>
    <!-- ----------Request Verified seller card---------- -->
    <div class="verified-seller-card py-3">
        <div class="title">
            <i class="fa fa-truck" aria-hidden="true"></i>
            <p>Request idam.lk verified seller</p>
        </div>
        <p>Memberships give your business a voice and presence on ikman,<br> 
        to reach more customers, increase your sales and expand your business!<br> 
        Memberships unlock powerful tools like sales analytics,<br>
        a dedicated business page and discounted ad promotions.</p>
        <form action="../request-seller/" method="POST">
            <input type="hidden" name="u_id" value="<?php echo $user['u_id']; ?>">
            <button type="submit" name="requert_seller" class="btn btn-success btn-sm p-2 px-4 shadow">Request Seller</button>
        </form>
    </div>
    <!-- ----------Request Verified seller card end---------- -->

    <?php } } else {
        // is can request member ship
        $creted_dt = new DateTime($user['created_dt']);
        $intervel = $creted_dt->diff($now);

        $is_month = $intervel->format("%m");

        if ($is_month >= $membership_requiest_month) { ?>
    <!-- ----------reqest verified member card---------- -->
    <div class="request-membership-card py-3">
        <div class="title">
            <i class="fa fa-truck" aria-hidden="true"></i>
            <p>Request idam.lk member</p>
        </div>
        <p>Memberships give your business a voice and presence on ikman,<br> 
        to reach more customers, increase your sales and expand your business!<br> 
        Memberships unlock powerful tools like sales analytics,<br>
        a dedicated business page and discounted ad promotions.</p>
        <button type="button" data-bs-toggle="modal" data-bs-target="#requestMembership" class="btn btn-success btn-sm p-2 px-4 shadow">Request member</button>
    </div>
    <!-- ----------reqest verified member card end---------- -->

    <?php } else { ?>
    <!-- ----------Become a Member Ship Card.---------- -->
    <div class="become-member-ship-card py-3">
        <div class="title">
            <i class="fa fa-truck" aria-hidden="true"></i>
            <p>Become a idam.lk member</p>
        </div>
        <p>Memberships give your business a voice and presence on ikman,<br> 
        to reach more customers, increase your sales and expand your business!<br> 
        Memberships unlock powerful tools like sales analytics,<br>
        a dedicated business page and discounted ad promotions.</p>
        <button class="btn btn-success btn-sm p-2 px-4 shadow">Learn more</button>
    </div> 
    <!-- ----------Become a Member Ship Card end---------- -->
    
    <?php } } if ($user['is_verified_seller']) { ?>
    <!-- ----------Verified seller card---------- -->
    <div class="verified-seller-card">
        <div class="card text-center shadow-sm">
            <div class="card-header">
                <div class="toast align-items-center text-white bg-primary border-0 show w-100" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body"> Idam.lk Verified Seller</div>
                        <div class="me-2 m-auto d-flex align-items-center">
                            <p class="mb-0 me-2 text-warning">Verified Seller</p>
                            <i class="fa fa-shirtsinbulk text-warning fa-lg" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5 class="card-title">Verified Seller</h5>
                <p class="card-text">Memberships give your business a voice and presence on ikman,<br> 
                to reach more customers, increase your sales and expand your business!<br> 
                Memberships unlock powerful tools like sales analytics,<br>
                a dedicated business page and discounted ad promotions.</p>
                <a href="../seller-shop/?id=<?php echo $user['u_id']; ?>" class="btn btn-primary btn-sm">Go to Shop</a>
                <a href="../edit-shop/?id=<?php echo $user['u_id']; ?>" class="btn btn-success btn-sm">Edit Shop</a>
            </div>
            <div class="card-footer text-muted">
                <?php
                    $today = new DateTime();
                    $created = new DateTime($verified_seller['created_dt']);
                    $interval = $today->diff($created);
                                    
                    if ($y = $interval->format("%y"))
                        echo $y . " years ago";
                    else if ($m = $interval->format("%m"))
                        echo $m . " months ago";
                    else if ($d = $interval->format("%d"))
                        echo $d . " days ago";
                    else if ($h = $interval->format("%h"))
                        echo $h . " hours ago";
                    else if ($i = $interval->format("%i"))
                        echo $i . " minutes ago";
                    else
                        echo "just now";
                ?>
            </div>
        </div>
    </div>
    <!-- ----------Verified seller card end---------- -->
    <?php } ?>
</div>

<!-- request membership model -->  
<div class="modal fade" id="requestMembership" tabindex="-1" aria-labelledby="requestMembershipLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="requestMembershipLabel">Get Membership</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="title">
                <i class="fa fa-truck" aria-hidden="true"></i>
                <p>Get idam.lk membership</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Not now</button>
            <form action="../account/" method="POST">
                <input type="hidden" name="u_id" value="<?php echo $user['u_id']; ?>">
                <button type="submit" class="btn btn-success btn-sm" name="requert_membership">Get membership</button>
            </form>
        </div>
        </div>
    </div>
</div>
<!-- request membership model end-->
