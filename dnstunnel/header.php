<?php
// header
if (isset($title)) {
    $real_title = $title . " :: ";
} else {
    $real_title = "";
}
print <<<END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en">
<head>
<title>{$real_title}DNS Packet Tunneling - LUG</title>
<link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<div width="100%" class="cc_header">
    <span class="cc_header_title">DNS Packet Tunneling</span>
    <span class="cc_header_subtitle">{$title}</span>
</div>
<hr class="cc_header_break" />
END;
?>
