Customized MRBS for _Quartierwerkstatt Viktoria_
============================================

This is a rather hacky customization of _Meeting Room Booking System_ for
the needs of [Quartierwerkstatt Viktoria](https://www.quartierwerkstatt-viktoria.ch/) in Bern.

Key modifications:

- [x] Simpler booking form by removing many fields for non-admin users
  (no description, confirmation status or privacy status)
- [x] Remembers the user's name used for the previous booking using a cookie
- [x] Added endpoint providing a filterable `.ical` calendar containing all bookings
- [x] Login using dropdown since we only need one "User" and one "Admin"
- [x] Hack to use a room's "additional HTML" as a link to an external website
  (we use this to provide deep links to our Wiki)
- [x] iCal export: Merge multi-room-bookings to one single event
- [x] Highlight today
- [x] Full-page sized tables for week / day overviews with fixed headers

***

Meeting Room Booking System
===
http://mrbs.sourceforge.net
-------------------------------

The Meeting Room Booking System (MRBS) is a PHP-based application for
booking meeting rooms (surprisingly!). I got annoyed with the piles of books
which were being used to book meetings. They were slow, hard to edit and only
at the reception desk. I thought that a nice web-based system would be much
nicer.

Some parts of this are based on WebCalender 0.9.4 by Craig Knudsen
(http://www.radix.net/~cknudsen/webcalendar/) but there is now very little
which is similar. There are fundamental design goal differences between
WebCalendar and MRBS - WC is for individuals, MRBS is for meeting rooms.

------
To Use
------
See the INSTALL file for installation instructions.

Once it's installed try going to http://yourhost/mrbs/

If you're using the default authentication type ('db') the first thing you'll
be prompted to do is to create an admin user.  Once you've done that you'll
need to login using the credentials you've just specified.

Once you have logged in as an administrator you can click on "Rooms" and
create first an "Area", and then a "Room" within that area.

There are other ways to configure authentication in MRBS, see the
file AUTHENTICATION for a more complete description.

It should be pretty easy to adjust it to your corporate colours - you can
modify the themes under "Themes" or (preferably) copy an existing theme
to a new directory and modify the new theme.

See LICENSE for licensing info.

See NEWS for a history of changes.

See AUTHENTICATION for information about user authentication/passwords.

-------------
Requirements:
-------------
- PHP 7.2 or above with MySQL and/or PostgreSQL support
- MySQL (5.5.3 and above) or PostgreSQL 8.2 or above.
- Any web server that is supported by PHP

Recommended:
- JavaScript-enabled browser
- PHP module connection to the server (also called SAPI) if you want to use any
  of the basic http authentication schemes provided.

(If you are considering porting MRBS to another database, see README.sqlapi)

