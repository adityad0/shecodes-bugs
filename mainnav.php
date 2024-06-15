<style>
    .nav-link {
        border-bottom: 2px solid transparent;
        /* text-transform: uppercase; */
        display: flex;
        align-items: center;
    }
    .nav-login-button {
        background-color: transparent;
        color: var(--white-color);
        padding: 6px 12px 6px 12px;
        border: 1px solid;
        /* text-transform: uppercase; */
    }
    .nav-login-button:hover {
        background-color: var(--white-color);
        color: var(--gray-900);
        transition: all 0.1s;
    }
</style>
<nav class="navbar bg-dark navbar-dark navbar-expand-lg" data-bs-theme="dark" style="background-color: rgba(0, 0, 0, 0.85) !important;">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $back_by; ?>">
            Printing
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo $back_by; ?>">
                        <span class="material-symbols-rounded color-blue">home</span>&nbsp;Home
                    </a>
                </li>
                <li class="nav-item dropdown" data-bs-theme="dark">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-rounded color-cyan">print</span>&nbsp;Printing
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Test</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav d-flex flex-row me-1">
                <?php
                    if(isset($_SESSION["user_details"])) {
                        ?>
                        <li class="nav-item me-3 me-lg-0">
                                <a class="nav-link" href="<?php echo $back_by; ?>account/dashboard/">
                                <button class="nav-login-button">
                                    Dashboard
                                </button>
                            </a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="nav-item me-3 me-lg-0">
                            <a class="nav-link" href="<?php echo $back_by; ?>account/login/">
                                <button class="nav-login-button">
                                    Log in
                                </button>
                            </a>
                        </li>
                            <li class="nav-item me-3 me-lg-0">
                                    <a class="nav-link" href="<?php echo $back_by; ?>account/register/">
                                    <button class="nav-login-button">
                                        Sign up
                                    </button>
                                </a>
                            </li>
                        <?php
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>