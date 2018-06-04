<?php include('template/head.php'); ?>
<form action="action/newstaff.php" method="POST">
            <div class="main">
                <div class="heading">Add Staff</div>

                <div class="titles"> Name</div>
                    <div class="inputs"><input type="text" name="name" required=""/></div>
                
                <div class="titles"> Username</div>
                    <div class="inputs"><input type="text" name="user_name" required=""/></div>
                
                <div class="titles"> Password</div>
                    <div class="inputs"><input type="password" name="password" required=""/></div>
                    
                
                <div class="btn"><input type="submit" name="add_staff" value="Add Staff" class="botn" /></div>
                
            </div>
        </form>
   <?php include('template/foot.php'); ?>