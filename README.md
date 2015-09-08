# ICBigBand
A simple PHP link shortener for IC Big Band.

# Vagrant
- [Download Vagrant](https://www.vagrantup.com/)
- Install
- Clone repository
- `cd` into directory
- Run `vagrant up` in the directory
- (Optional) Install [vagrant hostmanager](https://github.com/smdahlen/vagrant-hostmanager) with `vagrant plugin install vagrant-hostmanager`
- Access the site at `192.168.33.10` ( or if hostmanager is installed at `http://bigband` )

# Usage
`index.php` is the link shortener itself. 

Add a new entry to the database of shortened links by navigating to `/admin/`

# Credit
- [Scotchbox](https://box.scotch.io/) - The base of the vagrant environment
