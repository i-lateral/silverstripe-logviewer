# Silverstripe Log Viewer module

Log viewer is a module that should allow you to easily access recent server logs
through your Silverstripe CMS (rather than by squirreling away in your servers
log folder).

## Install Instructions

1.  Upload the Silverstripe Log Viewer module to the "logviewer" folder in your
    SilverStripe root
2.  Run `/dev/build/?flush=1`
3.  Login to your administration panel (/admin): There should be a 'Logs' link
    available

## Usage

Once you have installed this module, you can add logs by adding the following to
your `_config.php`:

    LogAdmin::addLog($log_file_path,$path_type);

`$log_file_path` is the path to your log file (eg: /var/logs/apache2/error.log)  
`$path_type` allows you to specify if the path is absolute ('a') or relative ('r')
if no type is specified, absolute is assumed.

## Example

Using `_ss_enviroment.php` to manage logs in multiple locations with one install

In your `_ss_enviroment.php` file, add something like:

```php
define('APACHE_ERROR_LOG','/var/log/apache2/error.log');
```

Then in your `_config.php`, you can perform a check like this:

```php
if(defined('APACHE_ERROR_LOG'))
    LogAdmin::addLog(APACHE_ERROR_LOG);
```

This will then allow you to alter the constant `APACHE_ERROR_LOG` on your
different environments, but not have to change your `_config.php`

