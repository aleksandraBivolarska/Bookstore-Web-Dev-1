

<?php 
include __DIR__ . '/header.php';
?>

    <section class="container-fluid py-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 login-form bg-butter py-50">
                    <h1 class="text-center">
                        Login to your account
                    </h1>

                    <!-- to do  -->
                    <form action="/login" method="post" class="pt-4 px-5">
                    <div>
                        <label for="username"><b>Username</b></label>
                        <input type="text" placeholder="Enter Username" id="username" name="username" required>
                    </div>

                    <div>
                        <label for="password"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" id="password" name="password" required>
                    </div>

                    <button type="submit" value="Submit" class="button-green">Login</button>
                    
                    </form>
                </div>
            </div>
        </div>
    </section>

<?
include __DIR__ . '/footer.php';