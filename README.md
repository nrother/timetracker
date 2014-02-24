#======================#
$   Timetracker v.1.0  $
#======================#
A web-based Timetracker written in PHP.

1. Installation
2. Administration
3. Usage
4. Final Notes/License
5. Contact
6. Version History

1. Installation
---------------
This guide will tell you how to install the timetracker script
on your website. You will need:
- A webserver
- PHP, in a reasonable modern version (probably >= PHP 5)
- A MySQL Database
- Access to the webserver by FTP or similar
- Access to the Database

A typical shared hoster will satisfy this requirements.

The installation is as simple as for the most PHP-Scripts:
- Upload all files in this folder to the webserver (in a subfolder if you like)
- Create a Database (or use a existing one), import the file setup/schema.sql in your database
- Edit the db.php file to match your setup

Now you can login to your new installed timetracker by pointing your browser to the location
where you copied the files to. Login as admin/password or guest/guest. You should change these
password, see below.

NOTE: If you don't have your own server contact me, I can create you an account on my own server.

2. Administration
-----------------
There is currently no interface for user administration. To delete a user simply delete its record in
the users table.

To add a user insert a new row in the users table. You can use the script setup/hash_password.php to create
the needed hash of the password: Call it like this www.example.com/hash_password.php?pw=[yournewpassword]
This is only one option, the needed hash is a simple bcrypt/blowfish hash, you can create it how you like.

To delete entries from the timetracker delete the from the table data. There is no interface for this, too.

3. Usage
--------
The usage should be self-explaning. The table in the top shows you all entries that match the date filter on the very top
of the page. The fields below are for adding new entries.

4. Final notes/License
----------------------
This is a private project made by a single guy who needed it. This guy is German, so most of the interface is in German.
There is currently no translation support, but it might by added in the future. For now just edit the files directly.

This script makes heavy use of jQuery [http://jquery.com/], DataTables [http://datatables.net/] and jQuery UI [http://jqueryui.com/].

This program is licensed unter the GPL.

TimeTracker
Copyright (C) 2014 Niklas Rother

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.


5. Contact
----------
Mail: info@niklas-rother
Blog: niklas-rother.de (in German)


6. Version History
------------------

Version 1.0
...........
First public version.