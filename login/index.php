
<?php

    $url = "";

    if (count($_GET)) {
        foreach ($_GET as $name => $value) {
            $url .= "{$name}={$value}&";
        }
    }

?>

<!-- Modal -->
<div class="modal fade login-model" id="login-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-7 left">
                        <h3>Welcome to idam.lk</h3>
                        <p>Log in to manage your account.</p>
                        <ul>
                            <li>Start posting your own ads.</li>
                            <li>Mark ads as favorite and view them later.</li>
                            <li>View and manage your ads at your convenience. </li>   
                        </ul>
                    </div>
                    <div class="col-5 right border-start px-4">
                        <h3>Login</h3>
                        <form action="../login/login-account-be.php" method="POST">
                            <input type="hidden" value="<?php echo $where_from."?".$url; ?>" name="where-from">
                            <div class="input-item mt-3">
                                <label for="email">E-Mail</label>
                                <input type="email" name="email" id="email" placeholder="@gmail.com" class="form-control form-control-sm mt-1" value="<?php echo isset($_SESSION['login']) ? $_SESSION['login']['login_email'] : ""; ?>">
                                <label for="" class="error-label" id="login-email-error"><?php echo isset($_SESSION['login_error'][0]) ? $_SESSION['login_error'][0] : ""; ?></label>
                            </div>
                            <div class="input-item">
                                <label for="pword">Password</label>
                                <input type="password" name="pword" id="pword" placeholder="" class="form-control form-control-sm mt-1" value="<?php echo isset($_SESSION['login']) ? $_SESSION['login']['login_pword'] : ""; ?>">
                                <label for="" class="error-label" id="login-pword-error"><?php echo isset($_SESSION['login_error'][1]) ? $_SESSION['login_error'][1] : ""; ?></label>
                            </div>
                            <div class="input-item mt-2">
                                <button type="submit" disabled class="btn btn-sm btn-success w-100" name="login" id="btn-login">Continue</button>
                            </div>
                        </form>
                        <div class="create-account">
                            <p>Don't have account<a aria-current="page" data-bs-toggle="modal" data-bs-target="#create-account-model" href="" onclick="hideLoginModel();">Create One</a></p>
                        </div>
                        <div class="login-footer">
                            <p>By signing up for an account you agree to our</p>
                            <a href="">Terms and Conditions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

    $f_name = "";
    $l_name = "";
    $email = "";
    $pword = "";
    $error;

    if (isset($_SESSION['create_account_error'])) {
        $f_name = $_SESSION['create_account']['f_name'];
        $l_name = $_SESSION['create_account']['l_name'];
        $email = $_SESSION['create_account']['email'];
        $pword = $_SESSION['create_account']['pword'];
        $error = $_SESSION["create_account_error"];
    }

?>

<!-- Cate Account Modal -->
<div class="modal fade login-model" id="create-account-model" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <i class="fa fa-arrow-left" aria-hidden="true" onclick="showLoginModel(); hideCreateAccountModel();"></i>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-7 left">
                        <h3>Welcome to idam.lk</h3>
                        <p>Log in to manage your account.</p>
                        <ul>
                            <li>Start posting your own ads.</li>
                            <li>Mark ads as favorite and view them later.</li>
                            <li>View and manage your ads at your convenience. </li>   
                        </ul>
                    </div>
                    <div class="col-5 right border-start px-4">
                        <h3>Create Account</h3>
                        <form action="../account/create-account-be.php" method="POST">
                            <input type="hidden" name="where_from" value="<?php echo $where_from."?".$url; ?>">
                            <div class="input-item mt-3">
                                <label for="first-name">First Name</label>
                                <input type="text" name="first_name" id="first-name" placeholder="" class="form-control form-control-sm mt-1" value="<?php echo $f_name; ?>">
                                <label for="" class="error-label" id="first-name-error"><?php echo isset($error['0']) ? $error['0'] : ""; ?></label>
                            </div>
                            <div class="input-item">
                                <label for="last-name">Last Name</label>
                                <input type="text" name="last_name" id="last-name" placeholder="" class="form-control form-control-sm mt-1" value="<?php echo $l_name; ?>">
                                <label for="" class="error-label" id="last-name-error"><?php echo isset($error['1']) ? $error['1'] : ""; ?></label>
                            </div>
                            <div class="input-item">
                                <label for="create-email">E-Mail</label>
                                <input type="email" name="create-email" id="create-email" placeholder="" class="form-control form-control-sm mt-1" value="<?php echo $email; ?>">
                                <label for="" class="error-label" id="create-email-error"><?php echo isset($error['2']) ? $error['2'] : ""; ?></label>
                            </div>
                            <div class="input-item">
                                <label for="last-name">Password</label>
                                <input type="password" name="pword" id="create-pword" placeholder="" class="form-control form-control-sm mt-1" value="<?php echo $pword; ?>">
                                <label for="pword" class="error-label" id="pword-error"><?php echo isset($error['3']) ? $error['3'] : ""; ?></label>
                            </div>
                            <div class="input-item mt-2">
                                <button type="submit" disabled class="btn btn-sm btn-success w-100" name="create_account" id="btn-create-account">Create Account</button>
                            </div>
                        </form>
                        <div class="login-footer">
                            <p>By signing up for an account you agree to our</p>
                            <a href="">Terms and Conditions</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
