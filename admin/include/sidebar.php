

<nav class="navbar sticky-top p-0" style="width: 16.7%;background-color: #f44336;">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" style="color:white;" href="dashboard.php">
        <!-- <img src="images/admin.png" alt="" style="width: 200px;"> -->
        WPMS Admin Panel
    </a>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item mt-3">
                        <div class="text-center">
                            <a href="users_profile.php" class="user-button">
                                <img src="<?= $users_profile->profile_picture_picture(); ?>" class="img-fluid rounded-circle" width="52" height="52" alt="">
                                <div class="user-profile"><?= $users_profile->firstname . ' ' . $users_profile->lastname; ?></div>
                            </a>
                                <div class="text-center mt-0" style="font-size: 11px;color:#72777a;">
                                    <?= ($users_profile->designation == 0) ? 'Administrator' : 'Moderator'; ?>
                                </div>
                        </div>
                    </li>
                    <li class="nav-item"><div class="dropdown-divider"></div></li>

                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="mdi mdi-home mr-3" style="color:#242424;"></i>
                            Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item"><div class="dropdown-divider"></div></li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog_events.php">
                            <i class="mdi mdi-comment-text mr-3" style="color:#795548;"></i>
                            Blogs &amp; Events
                        </a>
                    </li>
                    <li class="nav-item"><div class="dropdown-divider"></div></li>
                    <li class="nav-item">
                        <a class="nav-link" href="client.php" >
                            <i class="mdi mdi-account-multiple mr-3" style="color: #ba372a"></i>
                            Clients
                        </a>
                    </li>
                    <li class="nav-item"><div class="dropdown-divider"></div></li>

                    <li class="nav-item">
                        <a class="nav-link" href="service_list.php">
                            <i class="mdi mdi-verified mr-3" style="color: #4caf50;"></i>
                            Services
                        </a>
                    </li>
                    <li class="nav-item"><div class="dropdown-divider"></div></li>

                    <li class="nav-item">
                        <a class="nav-link" href="photos_view.php">
                            <i class="mdi mdi-image-multiple mr-3" style="color:#673ab7!important"></i>
                            Gallery
                        </a>
                    </li>

                    <li class="nav-item"><div class="dropdown-divider"></div></li>
                    <li class="nav-item">
                        <a class="nav-link" href="photos_add.php">
                            <i class="mdi mdi-upload-multiple mr-3" style="color: #e91e63!important"></i>
                            Upload Photos
                        </a>
                    </li>
                    <li class="nav-item"><div class="dropdown-divider"></div></li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">
                            <i class="mdi mdi-account-card-details mr-3" style=" color: #03a9f4!important;"></i>
                            User Management
                        </a>
                    </li>
                    <li class="nav-item"><div class="dropdown-divider"></div></li>
                    <li class="nav-item">
                        <a class="nav-link" href="task_all_calendar.php">
                            <i class="mdi mdi-calendar-text mr-3" style="color: #f44336!important;"></i>
                            Task Calendar
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10" style="margin-top: -40px;z-index: 999">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-left:-15px;margin-right: -15px;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                    </ul>
                </div>

                <div class="form-inline my-2 my-lg-0">
                    <a class="nav-link" href="users_profile.php"><b><?= ucfirst($users_profile->firstname) . ' ' . ucfirst($users_profile->lastname); ?></b></a>
                    <a class="nav-link" href="logout.php"><b><i class="mdi mdi-logout" style="color: #f44336!important;"></i> Logout</b></a>
                </div>
            </nav>