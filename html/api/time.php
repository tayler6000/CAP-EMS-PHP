<?php
date_default_timezone_set(empty(getenv("TIMEZONE")) ? "Zulu" : getenv("TIMEZONE"));
?>
The current time is <?= date("d M y Hi e") ?>
