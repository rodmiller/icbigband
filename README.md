# ICBigBand
A simple PHP link shortener for IC Big Band.

# Vagrant
- [Download Vagrant](https://www.vagrantup.com/)
- [Install](https://docs.vagrantup.com/v2/installation/index.html)
- Clone repository
- `cd` into directory
- Run `vagrant up` in the directory
- (Optional) Install [vagrant hostmanager](https://github.com/smdahlen/vagrant-hostmanager) with `vagrant plugin install vagrant-hostmanager`
- Access the site at `192.168.33.10` ( or if hostmanager is installed at `http://bigband` )

# Usage
`index.php` is the link shortener itself. 

Add a new entry to the database of shortened links by navigating to `/admin/`.

Note, a row with the slug of `default` is required as a url to return when a slug doesn't match

# Credit
- [Scotchbox](https://box.scotch.io/) - The base of the vagrant environment
