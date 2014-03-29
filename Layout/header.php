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
                <div class="pull-right member-detail">
                    <a href="/products"><span class="pull-left member-type"><?php echo $registeredProductName; ?></span></a>
                    <a href="/account/settings" id="profile-link">
                        <figure class="pull-left"><img src="/img/avatar.png" /></figure>
                        <span class="pull-left identification"><?php echo $entityDetail->nickName; ?></span>
                    </a>
            <div class="pull-right settings">
                <a href="javascript:void(0)" id="btn-settings"><i class="fa fa-cog"></i></a>
                <ul class="dropdown-menu" role="menu" id="settings-dropdown">
                    <li><a href="/account/settings">Settings</a></li>
                    <li><a id="bt-logout" href="javascript:void(0)">Log Out</a></li>
                </ul>
            </div>
        </div>
    </header>
<?php        
    }else {
?>
    <header class="site-header">
    </header>
<?php        
    }
?>
