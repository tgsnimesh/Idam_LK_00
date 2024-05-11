
<?php date_default_timezone_set("Asia/Colombo"); ?>

<nav class="navbar navbar-expand-md navbar-light p-1">
    <div class="container">

        <a class="navbar-brand" href="../">
            <img src="../img/logo/logo.png" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link all-ads" aria-current="page" href="../">All Ads</a>
                </li>
                <div class="left-option d-flex">
                    <li class="nav-item">
                        <i class="fa fa-commenting fa-lg" aria-hidden="true"></i>
                        <a class="nav-link active" aria-current="page" href="../">Chat</a>
                    </li>
                    <li class="nav-item">
                        <i class="fa fa-user fa-lg" aria-hidden="true"></i>
                        <?php 
                            /*
                                check is login user

                                if login user then -> show my account nav bar link
                            */
                            if (check_is_login_user()) { 
                        ?>
                        <a class="nav-link active" href="../account/?acc=dashboard">My Account</a>
                        <?php
                            /*
                                else -> show login user nav bar link
                            */
                            } else {
                        ?>
                        <a class="nav-link active" aria-current="page" data-bs-toggle="modal" data-bs-target="#login-model">Login</a>
                        <?php
                            }
                        ?>
                    </li>
                    <?php  if ($where_from != "post-add" && $where_from != "post") { ?>
                    <button class="btn btn-sm btn-warning btn-post-your-add py-2" <?php echo check_is_login_user() ? "id=\"btn-post-your-add\"" : "aria-current=\"page\" data-bs-toggle=\"modal\" data-bs-target=\"#login-model\""; ?>>POST YOUR ADD</button>
                    <?php } ?>
                </div>
            </ul>
        </div>

    </div>
</nav>
