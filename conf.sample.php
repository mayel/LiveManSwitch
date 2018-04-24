<?php
# Live Man's Switch v0.1
# Settings

$PW['live'] = 'yes'; // your password to check in
$PW['test'] = 'test'; // special password to manually trigger the switch (for testing)
$PW['check'] = 'friend'; // password for your friend

$config_days_switch = 30; // days to wait before giving access to your friend

$switch_file = '../switch.status';

$PAYLOAD = "PAYLOAD (TEXT) GOES HERE";

$PAYLOAD_FILE = "../payload.txt.gpg"; // make sure you don't put the file in the public directory!
