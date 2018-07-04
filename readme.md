To setup the project, you need to have [Vagrant][1] installed locally, and [VirtualBox][2], or some other VM tool. You will also need to install the hostmanager plugin for vagrant by running the `vagrant plugin install vagrant-hostmanager` command.
1. Clone the repository to your desired location, navigate there in your terminal and run `vagrant up` to create the virtual machine and start it.
2. If you have PHP installed locally, you can use `php artisan` commands from your local machine. If not, you connect to the VM with `vagrant ssh` and navigate to the `/app` directory to run them
3. Run `php artisan migrate` to run any required migrations.
4. Navigate to "http://vagrant.test:8080/" in your browser.

[1]: https://www.vagrantup.com/downloads.html
[2]: https://www.virtualbox.org/wiki/Downloads
