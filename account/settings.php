
<?php $where_from = "settings"; ?>

<?php require_once("../account/account-db-handler.php"); ?>

<?php

    $login_user_rs = get_login_user($_SESSION['login_id']);
    $login_user_r = $login_user_rs->fetch_assoc();

    $all_location_rs = get_all_locations();
    $all_sub_location_rs = get_all_sub_locations($login_user_r['d_id']);

?>

<?php

    // update details
    if (isset($_POST['btn_update_details'])) {

        if (update_user($login_user_r['u_id'], $_POST)) {
            ?>
            <script>
                window.open("../account/?acc=settings&update=true", "_self");
            </script>
            <?php
        }
    }
    if (isset($_GET['update'])) {
        if ($_GET['update'] == "true") {
            ?>
    <div class="toast align-items-center show w-100 mb-2 text-white bg-primary" id="top-toast-1" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Save and Change new Details.
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" onclick="closeToast1();"></button>
        </div>
    </div>
            <?php
        }
    }

    // update password
    $corrent_pword_error = "";

    if (isset($_POST['btn_change_pword'])) {

        if ($_POST['current_pword'] == $login_user_r['pword']) {

            if (change_pword($login_user_r['u_id'], $_POST)) {

?>
                
    <div class="toast align-items-center show w-100 mb-2 text-white bg-primary" id="top-toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                Save and Change your new Password.
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" onclick="closeToast();"></button>
        </div>
    </div>
    
    <?php
            }
        }else {
            $corrent_pword_error = "Current Password is wrong !";
        }
    }

?>

<div class="settings">
    <div class="title border-bottom">
        <p>Settings</p>
    </div>
    <div class="change-details">
        <p class="sub-title">Change Details</p>
        <p class="email">E-Mail : <span><?php echo $login_user_r['email']; ?></span></p>
        <form action="" method="POST">
            <div class="input-item">
                <label for="f_name">First Name</label>
                <input type="text" name="f_name" id="f-name" class="form-control form-control-sm" value="<?php echo $login_user_r['f_name']; ?>">
                <label for="f_name" id="f-name-error" class="error"></label>
            </div>
            <div class="input-item">
                <label for="l_name">Last Name</label>
                <input type="text" name="l_name" id="l-name" class="form-control form-control-sm" value="<?php echo $login_user_r['l_name']; ?>">
                <label for="l_name" id="l-name-error" class="error"></label>
            </div>
            <div class="input-item locations">
                <div class="sub-item">
                    <label for="location">Location</label>
                    <?php
                        // get login user in location
                        $user_location = $login_user_r['d_id'];
                        $user_sub_location = $login_user_r['c_id'];
                    ?>
                    <select name="location" id="locat" class="form-control form-control-sm text-capitalize">
                        <option value="" <?php echo $user_location ? "" : "selected"; ?>>Location</option>
                        <?php
                            while ($location = $all_location_rs->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $location['d_id']; ?>" <?php echo $user_location == $location['d_id'] ? "selected" : ""; ?>><?php echo $location['d_name']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="sub-item">
                    <label for="sub-location">Sub Location</label>
                    <select name="sub_location" id="sub-locat" class="form-control form-control-sm text-capitalize">
                        <option value="" <?php echo $user_sub_location ? "" : "selected"; ?>>Sub Location</option>
                        <?php
                            while ($sub_location = $all_sub_location_rs->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $sub_location['c_id']; ?>" <?php echo $user_sub_location == $sub_location['c_id'] ? "selected" : ""; ?>><?php echo $sub_location['c_name']; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="input-item">
                <button type="button" id="btn-confirm-update" data-bs-toggle="modal" data-bs-target="#confirmChangeDetails" class="btn btn-secondary shadow">Update Details</button>
            </div>

            <!-- change details modal -->
            <div class="modal fade" id="confirmChangeDetails" tabindex="-1" aria-labelledby="confirmDialogExampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Save and Change Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to save and change your new Details ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" name="btn_update_details" id="btn-update-details" class="btn btn-success">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="change-password">
        <p class="sub-title mb-3">Change Password</p>
        <form action="" method="POST">
            <div class="input-item">
                <label for="current-pword">Current Password</label>
                <input type="password" name="current_pword" id="current-pword" class="form-control form-control-sm" value="<?php echo strlen($corrent_pword_error) ? $_POST['current_pword'] : ""; ?>">
                <label for="current-pword" id="current-pword-error" class="error"><?php echo $corrent_pword_error; ?></label>
            </div>
            <div class="input-item">
                <label for="new-pword">New Password</label>
                <input type="password" name="new_pword" id="new-pword" class="form-control form-control-sm">
                <label for="new-pword" id="new-pword-error" class="error"></label>
            </div>
            <div class="input-item">
                <label for="confirm-new-pword">Confirm New Password</label>
                <input type="password" name="confirm_new_pword" id="confirm-new-pword" class="form-control form-control-sm">
                <label for="confirm-new-pword" id="confirm-new-pword-error" class="error"></label>
            </div>
            <div class="input-item">
                <button type="button" disabled id="btn-change-pword" data-bs-toggle="modal" data-bs-target="#confirmChangePassword" class="btn btn-secondary mb-3 shadow">Change Password</button>
            </div>
            <!-- change password modal -->
            <div class="modal fade" id="confirmChangePassword" tabindex="-1" aria-labelledby="confirmDialogExampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Save and Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to save and change your new Password ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" name="btn_change_pword" id="btn-confirm-change-pword" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="bottom-option border-top mt-4 py-3">
        <form action="../account/" method="POST">
            <button type="button" data-bs-toggle="modal" data-bs-target="#deleteAccountModel"  class="btn btn-danger me-4 shadow">Delete Account</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#logoutAccountModel"  class="btn btn-primary shadow">Log Out</button>
            <!-- logout account modal -->
            <div class="modal fade" id="logoutAccountModel" tabindex="-1" aria-labelledby="confirmDialogExampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">LogOut</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to Log Out your Account ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Not Now</button>
                        <button type="submit" name="logout" id="btn-delete-account" class="btn btn-primary">Log Out</button>
                    </div>
                    </div>
                </div>
            </div>
            <!-- delete account modal -->
            <div class="modal fade" id="deleteAccountModel" tabindex="-1" aria-labelledby="confirmDialogExampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to delete your Account ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="delete_account" id="btn-delete-account" class="btn btn-danger">delete account</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function closeToast1() {
        var t1 = document.getElementById("top-toast-1");
        t1.style.display = "none";
    }

    function closeToast() {
        var t = document.getElementById("top-toast");
        t.style.display = "none";
    }
</script>
