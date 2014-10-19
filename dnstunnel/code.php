<?php
$title = "Code";
include "header.php";
include "navbar.php";
?>
<div class="cc_content">
<span style="font-size: 14px; font-weight: bold;">Source Code</span><br />
<i>(These are <b>not</b> complete packages, the final versions of the clients and servers will be uploaded some time around around <b>April 4th</b>)</i>
<ul>
    <li><b>Client:</b> <a href="dns_tunnel_client.tar.bz2">dns_tunnel_client.tar.bz2</a> - 05ee55b6b9bd0eb5513d5b6ed24cafd9</li>
    <li><b>Server:</b> <a href="server.tar.bz2">server.tar.bz2</a> - fde3b69443c5e14fb2c579a3d4db8524 </li>
</ul>
<span style="font-size: 14px; font-weight: bold;">Client Setup</span><br />
For the client, extract the archive to your home directory. You will then need to edit dns_client.sh and sshns/droute.py so that the server listed
reflects your own server and the username matches your username. Make sure your server is set up to use publickey authentication and that your
client has authenticated the key before running the tunnel (or it will fail to authenticate, as it runs in batch mode). Once you have set up
the files to point to the right server, you can run <span style="font-family: monospace; font-weight: bold;">./dns_client.sh</span> to start
the tunnel client. For help, and to list the current configuration, append <span style="font-family: monospace; font-weight: bold;">-h</span> to
the command.<br />
<br />
<span style="font-size: 14px; font-weight: bold;">Server Setup</span><br />
The server is a little tricker to set up. No modifications to the provided file should be necessary, but you will need to set up a DNS listing.
Replace any instance of "example.com" in the following text with the domain name of your server.
First off, make sure your NS service allows you to add NS records. Add ns.example.com to your A listings. Add an NS entry for t.example.com. This
is the domain the tunnel will query to. Note that any requests for it will be routed to your server. To confirm that this is working, you can
install your own (real) DNS server and add an entry for "t.example.com" (it need not be pointed to a real IP, just make sure it is valid) and run
a query for t.example.com to make sure your DNS server provides the authoritative response. For the tunnel server, we have provided a script
that should ensure the server keeps running (it can fail, at which point we need to restart it immediately to ensure we don't lose packets).
You can run this script with <span style="font-family: monospace; font-weight: bold;">sudo ./dnstun</span> (optionally, ensure sudo is
authenticated and run `sudo ./dnstun & disown` to run in the background). At this point, the server should be running.
<br />
<br />
</div>
<?php
include "footer.php";
?>
