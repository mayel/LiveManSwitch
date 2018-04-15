# Live Man's Switch

Live Man's Switch is a simple implementation of the [dead man's switch](https://en.wikipedia.org/wiki/Dead_man%27s_switch) concept to make some data accessible to a friend only if the main user does not check in for X days (by loading the site using the 'live' password).

It should run on a PHP web server. There are no email notifications or cronjobs (to reduce possible points of failure), so your friend will have to manually check the site (with the 'check' password) if they don't hear from you.

It is recommended to encrypt the payload (using GPG) with your friend's public key, and also provide them the site URL and 'check' password beforehand.
