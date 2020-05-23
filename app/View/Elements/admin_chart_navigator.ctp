<nav id="navigator" class="navbar navbar-default stat-navbar">
    <div class="col-xs-12" id="myNavbar">
        <ul class="nav navbar-nav">
        <li><?= $this->Html->link('<p style="color:green;"><i class="glyphicon glyphicon-tree-conifer"></i>Tree structure</p>',
                    array('controller' => 'pages', 'action' => 'notification', 'admin' => true),
                    array('escape' => false, 'role' => 'button', 'title' => __('Tree structure'))); ?>
            </li>
            <li><?= $this->Html->link('<p style="color:green;"><i class="glyphicon glyphicon-signal"></i>Statistics</p>',
                    array('controller' => 'Profilers', 'action' => 'statistics', 'admin' => true),
                    array('escape' => false, 'role' => 'button', 'title' => __('Statistics'))); ?>
            </li>
             
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><?= $this->Html->link('<i class="glyphicon glyphicon-log-out"></i>',
                    array('controller' => 'users', 'action' => 'logout', 'admin' => true),
                    array('escape' => false, 'title' => __('Logout'))); ?></li>
        </ul>
    </div>
</nav>