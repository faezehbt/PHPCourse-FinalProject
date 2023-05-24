<?php
require_once 'admin-header.php';
require_once '../system/db-connect.php';
// require_once '../system/functions/auto-load.php';
require '../system/functions/authentication.php';
require '../system/functions/photo.php';



// کاربر وارد سایت شده باشد و وجود  داشته باشد
checkLogin();


$photoName = namePhoto($account_id);


?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $page_name == 'dashboard' ? 'active' : '' ?>" aria-current="page" href="../admin/index.php">
                        داشبورد
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $page_name == 'blogs' ? 'active' : '' ?>" aria-current="page" href="../admin/blogs-list.php">
                        بلاگ ها
                    </a>
                </li>
                <? if ($account['role'] == 'Admin') : ?>
                    <li class="nav-item">
                        <a class="nav-link <?= ($page_name == 'users') ? 'active' : '' ?>" aria-current="page" href="../admin/users-list.php">
                            کاربران
                        </a>
                    </li>
                <? endif; ?>
            </ul>
        </div>

        <div class="navbar-brand d-flex">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <img src="/project/assets/uploads/profile-photos/<?= $photoName . '?' . round(1000, 100000) ?>" onerror="this.onerror=null; this.src='/project/assets/uploads/profile-photos/profile.png'" width="40" height="40" class="d-inline-block rounded-circle mx-1" alt="" />
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $account['username'] ?> خوش آمدی
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item <?= $page_name == 'profile' ? 'active' : '' ?>" href="../admin/profile.php">
                            پروفایل من
                        </a>
                        <a class="dropdown-item" href="#">
                            تغییر رمز عبور
                        </a>
                        <a class="dropdown-item" href="#">
                            <hr class="dropdown-divider">
                        </a>
                        <a class="dropdown-item link-danger" href="../admin/login.php?logout=1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                <path d="M7.5 1v7h1V1h-1z" />
                                <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z" />
                            </svg>
                            خروج
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php

require_once 'admin-footer.php';
