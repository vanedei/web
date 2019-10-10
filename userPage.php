<!DOCTYPE html>
<html lang="en">

<?php
require_once 'head.php';
require_once 'user.php';
require_once 'navbar.php';
require_once './controllers/userPageController.php';
?>

<body>
    <div class="container d-flex justify-content-center">
        <div class="container col-3">
            <img src="<?php echo $user->getPhoto();?>">
        </div>
        <div class="container d-flex justify-content-center col-9">
            <form class="w-50" method="POST" action="./controllers/updateController.php">
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" value="<?php echo $user->getEmail();?>" type="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input name="password" type="password" class="form-control" pattern="\w+" title="Letters, numbers and '_' are allowed" placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" value="<?php echo $user->getFirstname();?>" type="text" class="form-control" pattern="[^\W\d]+" title="Only letters" placeholder="Name">
                </div>
                <div class="form-group">
                    <label>Surname</label>
                    <input name="surname" value="<?php echo $user->getLastname();?>" type="text" class="form-control" pattern="[^\W\d]+" title="Only letters" placeholder="Surname">
                    <input type="hidden" name="user" value="<?php echo $_GET['user']?>">
                </div>
                <button type="submit" class="btn btn-primary ml-3">Save</button>
            </form>
        </div>
    </div>
</body>
<?php
require_once 'scripts.php';
?>
</html>