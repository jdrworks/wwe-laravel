require 'yaml'
require 'fileutils'

# set domains for host file
# you'll need to add an Apache2 vHost in sites-available for each domain
# you'll also have to tell Apache2 to enable each at the bottom of bootstrap.sh
domains = {
  vagrant: 'vagrant.test',
}

# read config
options = YAML.load_file 'vagrant/config.yml'

Vagrant.configure("2") do |config|

    # select box (Ubuntu 16.04.2 LTS)
    config.vm.box = "ubuntu/bionic64"

    # should we ask about box updates?
    config.vm.box_check_update = options['box_check_update']


    config.vm.provider 'virtualbox' do |vb|
        # machine cpus count
        vb.cpus = options['cpus']
        # machine memory size
        vb.memory = options['memory']
        # machine name (for VirtualBox UI)
        vb.name = options['machine_name']
        # Remove Log File
        vb.customize [ "modifyvm", :id, "--uartmode1", "disconnected" ]
    end

    # machine name (for vagrant console)
    config.vm.define options['machine_name']

    # machine name (for guest machine console)
    config.vm.hostname = options['machine_name']

    # configure network
    config.vm.network "private_network", ip: options['ip']
    config.vm.network "forwarded_port", guest: 80, host: options['apache_forward']
    config.vm.network "forwarded_port", guest: 3306, host: options['mysql_forward']

    # sync app folder
   config.vm.synced_folder './', '/app', id: "vagrant", :nfs => false, :mount_options => ["dmode=777","fmode=666"]
    
    # disable folder '/vagrant' on guest machine
    config.vm.synced_folder '.', '/vagrant', disabled: true

    # hosts settings (host machine)
    config.vm.provision :hostmanager
    config.hostmanager.enabled            = true
    config.hostmanager.manage_host        = true
    config.hostmanager.ignore_private_ip  = false
    config.hostmanager.include_offline    = true
    config.hostmanager.aliases            = domains.values

    # provisioners
    config.vm.provision :shell, path: "vagrant/bootstrap.sh", args: [options['mysql_dbname'], options['mysql_dbuser'], options['mysql_dbpassword']]

    # post-install message (vagrant console)
    config.vm.post_up_message = "Test URL: http://#{domains[:vagrant]}"

end