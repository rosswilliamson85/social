

<nav>
    <ul>
   
        <li>
            <a href="/"> home </a>
        </li>
        <?php if(!$session->has('username')): ?>
        <li>
            <a href="/login"> login </a>
        </li>

        <li>
            <a href="/register"> Register </a>
        </li>
       <?php endif; ?>
        <?php if($session->has('username')):  ?>
        <li>
            <a href="/profile/<?php echo $session->get('username')  ?>"> profile </a>
        </li>

        
        <li>
            <a href="/logout"> sign out </a>
        </li>

        <?php endif; ?>
    </ul>
</nav>

