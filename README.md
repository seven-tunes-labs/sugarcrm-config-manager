# Config Manager

Hello from [Seven Tunes Labs](seventunes.com)!

This is a simple package that adds a "Config Manager" extension in your Administration page.

You can search/update configuration directly from the Admin page, but you have to be careful!

To ensure not everyone goes and updates the password, we are setting a default password which is hardcoded in the `ConfigManager.php` file. You will need this password to update a config, but searches doesn't need a password.

By default, the code skips `pass` or `key` variables from display. You can configure this in the `ConfigManager.php` file!

---

### Installation

1. Create your own package by zipping up this folder, or use our Release - Change the default password in `files/ConfigManager.php` if needed.
2. In your SugarCRM Instance, go to Module Loader -> Load package -> and then Install.
3. Careful: Installation triggers Repair & Rebuild and might logout users.
4. Once installed, refresh the page and navigate to Admin -> Config Manager!

---

### Usage

Searches are simple - search for simple configs, and you can also search arrays!
Use the syntax `array_key.array_subkey`. Eg: `dbconfig.db_host_name`

---

### About Us

We, Seven Tunes Labs is a small startup of friendly engineers! We have tons of experience in SugarCRM and has worked with leading Media/Publishing companies in the US. Reach out to us at [seventunes.com](seventunes.com) for any questions! We are happy to help!  

---

### License

We offer this free package under MIT License

---

### WARNING: Use it at your own risk! Use this with Caution and change your password before installing this package in your system!

Use it at your own risk!
Any worng updates could potentially harm your system, so be careful in using this. We recommend installing this only in your TEST environments.
