<?php
$title = "Home";
include "header.php";
include "navbar.php";
?>
<div class="cc_content">
<span style="font-size: 14px; font-weight: bold;">EOH: Original Undergraduate Research</span><br />
Our project placed <b>2nd</b> in the Original Undergraduate Research category at EOH, second only to our good friends
in SIGMusic with their awesome Tacchi multi-touch music table. We'll be getting all the code ready some time around
May 20th. We're sorry for the delays, the system on which our implementation runs is old, buggy, and being replaced.
<br /><br />
<span style="font-size: 14px; font-weight: bold;">Overview</span><br />
The goal of this project is to implement a proxy tunnel that passes data through DNS queries and responses.
Captive portal networks, as used at airports and by many wireless access point providers, have one fatal
flaw, and it is one that can not easily be solved. This hole exists in the DNS system:
the network must accept DNS requests and handle them appropriately or it could have devastating effects
on users. Because the DNS network is recursive - servers calling other servers until they get an answer -
we can gain access to our own hardware in the outside world and send it a payload using DNS requests.<br />
<br />
<span style="font-size: 14px; font-weight: bold;">Implementation</span><br />
Our implementation is based on the one used by <a href="http://en.wikipedia.org/wiki/Dan%20Kaminsky">Dan Kaminsky</a>.
We use two types of queries in our client:
<ul>
    <li><b>A</b> requests - The standard DNS query used to get IPs associated with domain names.</li>
    <li><b>TXT</b> requests - An atypical query made for retrieving raw data from a DNS server.</li>
</ul>
The A requests are used to send data to the server, while another thread sends TXT requests to retrieve data.
Outgoing data is encoded to a format that can be fit into a string of subdomains, concatanated with an identifier
and then attached to a tunnel domain (ie "t.example.com"). On a real DNS server, this domain is assigned an NS
entry that points to our server (ie, ns.example.com, ns. being a standard subdomain for nameservers). When we make
our query to the local network's DNS server, it continues to pass the request along, first to find who manages
example.com and then to find who manages t.example.com, at which point we have achieved a connection to our own
system. Our fake server will read the subdomain, decode its data, and push it to a another server (specifically, an
SSH server). The second request type is used to query data back from the server. Our client periodically sends
a TXT request with an identifier (containing a random value and an incrementing counter). This reaches the server
in the same way as an A request, but the server handles it differently, finding that it is a "down" request (noted
by a ".d." in the identifier, as well its "TXT" query type), pulls data from its connection to the proxy server,
encodes it, and then puts that data in a series of TXT chunks (raw text data) and sends back its response. If the
server has no data to respond with, it will do nothing, so no answer is cached and we can continue to ask for the
same identifier (therefore not wasting identifiers on unused requests).<br />
<br />
<span style="font-size: 14px; font-weight: bold;">Resources Used</span><br />
To develop our implementation, we spent significant time reverse engineering the original proof-of-concept
code by Dan Kaminsky (as noted in the "Implementation" section). We then found ways to get more data into our requests
and responses to improve performance. 
Our server is written in C using the <a href="http://freshmeat.net/projects/poslib/">Poslib</a> library. Our
client is written in Python and uses a third-party DNS module combined with a TCP socket server.
<br />
<br />
</div>
<?php
include "footer.php";
?>
