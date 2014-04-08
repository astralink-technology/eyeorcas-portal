<div class="device-nav">
<!--    <div class="logo"><a href="/"><img src="/img/logo.png" /></a></div>-->
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li class="active"><a href="/devices/overview?id=<?php if(isset($deviceId)){echo $deviceId;}; ?>">Overview</a></li>
            <li><a href="/logs?id=<?php if(isset($deviceId)){echo $deviceId;}; ?>">Activities</a></li>
            <li><a href="/media?id=<?php if(isset($deviceId)){echo $deviceId;}; ?>">Gallery</a></li>
            <li><a href="/devices/settings?id=<?php if(isset($deviceId)){echo $deviceId;}; ?>">Device Settings</a></li>
            <li><a href="/devices">Device List</a></li>
        </ul>
    </div>
<!---->
<!--    <div class="device-control-panel">-->
<!--        <div class="device-card">-->
<!--            --><?php
//                if($type == "M"){
//                    echo '<img src="/img/clipcam-md.png" />';
//                }else if ($type == "H"){
//                    echo '<img src="/img/hxs-md.png" />';
//                }
//            ?>
<!--            <span>--><?php //if(isset($deviceName)){echo $deviceName;}; ?><!--</span>-->
<!--        </div>-->
<!--        <div class="device-controls">-->
<!--            <ul class="list-unstyled">-->
<!--                <li><a href="/devices/overview?id=--><?php //if(isset($deviceId)){echo $deviceId;}; ?><!--">Overview</a></li>-->
<!--                <li><a href="/logs?id=--><?php //if(isset($deviceId)){echo $deviceId;}; ?><!--">Activities</a></li>-->
<!--                <li><a href="/media?id=--><?php //if(isset($deviceId)){echo $deviceId;}; ?><!--">Gallery</a></li>-->
<!--                <li><a href="/devices/settings?id=--><?php //if(isset($deviceId)){echo $deviceId;}; ?><!--">Device Settings</a></li>-->
<!--                <li><a href="/devices">Device List</a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--    </div>-->
</div>
