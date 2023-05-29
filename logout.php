<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();

return print_r($_SESSION);

?>