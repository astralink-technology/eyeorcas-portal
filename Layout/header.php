<?php
    $entityType = $userHelper->getCurrentEntityType();
    $registeredProductName = $productRegistrationHelper->getUserRegisteredProductName();
    if ($entityType == 1){
        $entityDetail = $userHelper->getCurrentEntityDetails();
            ?>
        <?php if ($webConfig->production == false){ ?>
            <div class="production-status">Development Mode</div>
        <?php } ?>
<header class="site-header">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/"><img src="/img/logo-inverted-sm.png" /></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li id="nav-my-devices"><a href="/">My Devices</a></li>
                        <li id="nav-activities"><a href="/logs">Activities</a></li>
                        <li id="nav-gallery"><a href="/media">Gallery</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><?php echo $entityDetail->nickName; ?></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/account/settings">Account</a></li>
                                <li class="divider"></li>
                                <li><a href="/account/logout">Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
</header>
    <?php
    }else {
?>
    <header class="site-header">
    </header>
<?php        
    }
?>
