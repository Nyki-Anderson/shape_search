# Setup Server-Side Infrastructure
At this point, we're just going to get started replicating the setup I have on the backend of Shape-Share. This includes installing and configuring the following tools and software:
- **X-Code Command Line Tools** (latest)
  - A suite of the most popular CLI tools.
- **Homebrew** 3.5.6
  - A macOS package manager.
- **OPENSSL** 3.0.5
  - A commercial-grade toolkit for cryptography and secure communication.
- **Apache** 2.4.54 (Unix)
  - A free/opensource server software.
- **PHP** 8.2.0
  - A scripting language for web development.
- **PECL** (**PEAR** 1.10.13)
  - A repository for PHP extensions.
- **MKCERT** 1.4.4
  - A simple tool for generating locally trusted development certificates.

Also, be sure that your macOS Monterey is updated. You should be running version 12.5.0.

These instruction will heavily paraphrase the resource links listed at the beginning of each section. For more in-depth tutorials and/or troublshooting help, check out the links as they do everything in order. I am merely showing you my setup that works. I did not get everything configured in one go like this...

Before we get started, here are some conventions I'm using in this document.

| TypeScript | Meaning |
|------------|---------|
| **Bold** | Applicaton Name |
| *Italics* | File in Filesystem or Path to File in Filesystem|
| `Code` | File in Repository or Path to File in Repository |
| ``` > Code Block ``` | Command Line Input |
| <details><summary>Output</summary><p>```Hidden Code```</p></details> | Command Line Output |

## Installing and Configuring Apache 2.4.54 (Unix) with Homebrew
Resources:
- [macOS 12.0 Monterey Apache Setup: Multiple PHP Versions](https://getgrav.org/blog/macos-monterey-apache-multiple-php-versions)
- [Install Apache, MySQL, PHP macOS Mojave 10.14](https://betterprogramming.pub/install-apache-mysql-php-macos-mojave-10-14-b6b5c00b7de)
- [Privileged Ports](https://www.w3.org/Daemon/User/Installation/PrivilegedPorts.html)

Open **terminal**. Install **X-Code Command Line Tools**.

```shell
> xcode-select --install
```
Install **Homebrew**. Just follow the terminal prompts and enter password where necessary.

```shell
> /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install.sh)"
```
To verify the latest version of **Homebrew** has been installed and that everything went well, run a few diagnostic commands and fix any issues.

```shell
> brew doctor
> brew update && upgrade
```

Check that you have **Homebrew** version 3.5.6.

```shell
> brew --version
```

<details><summary>output</summary>
<p>

```shell
Homebrew 3.5.6
```
</p></details>

Next, is a missing **macOS Monterey** necessity. Install **OPENSSL** 3.0.5 with **Homebrew**. Check version.

```shell
> brew install openssl
> openssl version
```

<details><summary>output</summary>
<p>

```shell
OpenSSL 3.0.5 5 Jul 2022 (Library: OpenSSL 3.0.5 5 Jul 2022)
```
</p></details>

Shutdown built-in **Apache** 2.4 (if running...). We are not using the macOS built-in **Apache** because Apple removed some required scripts.

```shell
> sudo apachectl stop
> sudo launchctl unload -w /System/Library/LaunchDaemons/org.apache.httpd.plist 2>/dev/null
```

Install new **Apache** 2.4.5 software using **Homebrew**. Check version.

```shell
> brew install httpd
> httpd -v
```

<details><summary>output</summary>
<p>

```shell
Server version: Apache/2.4.54 (Unix)
Server built:   Jun 11 2022 03:25:57
```
</p></details>

Configure our new **Apache** or **HTTPD** server to auto-start and run in background. (note: ports lower than 1024 require the use of  sudo, we will be using  port 443).

```shell
> sudo brew services start httpd
```

To verify server is running, visit your localhost in a browser  http://localhost:8080
You should see a simple header that says "It Works!"

Use these commands to stop, start, or restart the server. Every time you make a change to the server config files or PHP, restart **httpd**.

```shell
> sudo brew services stop httpd
> sudo brew services start httpd
> sudo brew services restart httpd
```

Create user level DocumentRoot (folder that our website will be delivered from). You will issue the "whoami" command to get your username. Then make the directory.

```shell
> whoami
> sudo mkdir /Users/nykianderson/Sites
```

Create a *username.conf* file and edit it as follows using your favorite text editor. I use **Sublime** Build 4126.

```shell
> cd /usr/local/etc/httpd/users/
> touch nykianderson.conf
> sublime nykianderson.conf
```

#### */usr/local/etc/httpd/users/nykianderson.conf*

```apacheconf
<IfModule mod_userdir.c>
    UserDir "public_html/public" "public_html"
    UserDir disabled root

    <Directory /Users/nykianderson/Sites/*/public_html>
            AllowOverride All
            Options MultiViews Indexes FollowSymLinks
            <Limit GET POST OPTIONS>
                    # Apache <= 2.2:
                    # Order allow,deny
                    # Allow from all

                    # Apache >= 2.4:
                    Require all granted
            </Limit>
            <LimitExcept GET POST OPTIONS>
                    # Apache <= 2.2:
                    # Order deny,allow
                    # Deny from all

                    # Apache >= 2.4:
                    Require all denied
            </LimitExcept>
    </Directory>

    <Directory /Users/nykianderson/Sites/*/public_html/public>
            AllowOverride All
            Options MultiViews Indexes FollowSymLinks
            <Limit GET POST OPTIONS>
                    # Apache <= 2.2:
                    # Order allow,deny
                    # Allow from all

                    # Apache >= 2.4:
                    Require all granted
            </Limit>
            <LimitExcept GET POST OPTIONS>
                    # Apache <= 2.2:
                    # Order deny,allow
                    # Deny from all

                    # Apache >= 2.4:
                    Require all denied
            </LimitExcept>
    </Directory>
</IfModule>
```
\* Note before configuring **HTTPD** \*

Now this is where my tutorial strays from the linked resources. I will include the entirety of my **HTTPD** configuraton file to show the final product of this server installation. I may refer back to this file in future sections to show why certain edits were made in context but beyond that you are on your own to research the specifics.

Configure **HTTPD** server by uncommenting the designated lines and adding others.

#### */usr/local/etc/httpd/httpd.conf*

```apacheconf
#
# This is the main Apache HTTP server configuration file.  It contains the
# configuration directives that give the server its instructions.
# See <URL:http://httpd.apache.org/docs/2.4/> for detailed information.
# In particular, see
# <URL:http://httpd.apache.org/docs/2.4/mod/directives.html>
# for a discussion of each configuration directive.
#
# Do NOT simply read the instructions in here without understanding
# what they do.  They're here only as hints or reminders.  If you are unsure
# consult the online docs. You have been warned.
#
# Configuration and logfile names: If the filenames you specify for many
# of the server's control files begin with "/" (or "drive:/" for Win32), the
# server will use that explicit path.  If the filenames do *not* begin
# with "/", the value of ServerRoot is prepended -- so "logs/access_log"
# with ServerRoot set to "/usr/local/apache2" will be interpreted by the
# server as "/usr/local/apache2/logs/access_log", whereas "/logs/access_log"
# will be interpreted as '/logs/access_log'.

#
# ServerRoot: The top of the directory tree under which the server's
# configuration, error, and log files are kept.
#
# Do not add a slash at the end of the directory path.  If you point
# ServerRoot at a non-local disk, be sure to specify a local disk on the
# Mutex directive, if file-based mutexes are used.  If you wish to share the
# same ServerRoot for multiple httpd daemons, you will need to change at
# least PidFile.
#
ServerRoot "/usr/local/opt/httpd"

#
# Mutex: Allows you to set the mutex mechanism and mutex file directory
# for individual mutexes, or change the global defaults
#
# Uncomment and change the directory if mutexes are file-based and the default
# mutex file directory is not on a local disk or is not appropriate for some
# other reason.
#
# Mutex default:/usr/local/var/run/httpd

#
# Listen: Allows you to bind Apache to specific IP addresses and/or
# ports, instead of the default. See also the <VirtualHost>
# directive.
#
# Change this to Listen on specific IP addresses as shown below to
# prevent Apache from glomming onto all bound IP addresses.
#
#Listen 12.34.56.78:80
#Listen 443
#
# Dynamic Shared Object (DSO) Support
#
# To be able to use the functionality of a module which was built as a DSO you
# have to place corresponding `LoadModule' lines at this location so the
# directives contained in it are actually available _before_ they are used.
# Statically compiled modules (those listed by `httpd -l') do not need
# to be loaded here.
#
# Example:
# LoadModule foo_module modules/mod_foo.so
#
#LoadModule mpm_event_module lib/httpd/modules/mod_mpm_event.so
LoadModule mpm_prefork_module lib/httpd/modules/mod_mpm_prefork.so
#LoadModule mpm_worker_module lib/httpd/modules/mod_mpm_worker.so
LoadModule authn_file_module lib/httpd/modules/mod_authn_file.so
#LoadModule authn_dbm_module lib/httpd/modules/mod_authn_dbm.so
#LoadModule authn_anon_module lib/httpd/modules/mod_authn_anon.so
#LoadModule authn_dbd_module lib/httpd/modules/mod_authn_dbd.so
LoadModule authn_socache_module lib/httpd/modules/mod_authn_socache.so
LoadModule authn_core_module lib/httpd/modules/mod_authn_core.so
LoadModule authz_host_module lib/httpd/modules/mod_authz_host.so
LoadModule authz_groupfile_module lib/httpd/modules/mod_authz_groupfile.so
LoadModule authz_user_module lib/httpd/modules/mod_authz_user.so
#LoadModule authz_dbm_module lib/httpd/modules/mod_authz_dbm.so
#LoadModule authz_owner_module lib/httpd/modules/mod_authz_owner.so
#LoadModule authz_dbd_module lib/httpd/modules/mod_authz_dbd.so
LoadModule authz_core_module lib/httpd/modules/mod_authz_core.so
#LoadModule authnz_fcgi_module lib/httpd/modules/mod_authnz_fcgi.so
LoadModule access_compat_module lib/httpd/modules/mod_access_compat.so
LoadModule auth_basic_module lib/httpd/modules/mod_auth_basic.so
#LoadModule auth_form_module lib/httpd/modules/mod_auth_form.so
#LoadModule auth_digest_module lib/httpd/modules/mod_auth_digest.so
#LoadModule allowmethods_module lib/httpd/modules/mod_allowmethods.so
#LoadModule file_cache_module lib/httpd/modules/mod_file_cache.so
#LoadModule cache_module lib/httpd/modules/mod_cache.so
#LoadModule cache_disk_module lib/httpd/modules/mod_cache_disk.so
#LoadModule cache_socache_module lib/httpd/modules/mod_cache_socache.so
LoadModule socache_shmcb_module lib/httpd/modules/mod_socache_shmcb.so
#LoadModule socache_dbm_module lib/httpd/modules/mod_socache_dbm.so
#LoadModule socache_memcache_module lib/httpd/modules/mod_socache_memcache.so
#LoadModule socache_redis_module lib/httpd/modules/mod_socache_redis.so
#LoadModule watchdog_module lib/httpd/modules/mod_watchdog.so
#LoadModule macro_module lib/httpd/modules/mod_macro.so
#LoadModule dbd_module lib/httpd/modules/mod_dbd.so
#LoadModule dumpio_module lib/httpd/modules/mod_dumpio.so
#LoadModule echo_module lib/httpd/modules/mod_echo.so
#LoadModule buffer_module lib/httpd/modules/mod_buffer.so
#LoadModule data_module lib/httpd/modules/mod_data.so
#LoadModule ratelimit_module lib/httpd/modules/mod_ratelimit.so
LoadModule reqtimeout_module lib/httpd/modules/mod_reqtimeout.so
#LoadModule ext_filter_module lib/httpd/modules/mod_ext_filter.so
#LoadModule request_module lib/httpd/modules/mod_request.so
#LoadModule include_module lib/httpd/modules/mod_include.so
LoadModule filter_module lib/httpd/modules/mod_filter.so
#LoadModule reflector_module lib/httpd/modules/mod_reflector.so
#LoadModule substitute_module lib/httpd/modules/mod_substitute.so
#LoadModule sed_module lib/httpd/modules/mod_sed.so
#LoadModule charset_lite_module lib/httpd/modules/mod_charset_lite.so
#LoadModule deflate_module lib/httpd/modules/mod_deflate.so
#LoadModule xml2enc_module lib/httpd/modules/mod_xml2enc.so
#LoadModule proxy_html_module lib/httpd/modules/mod_proxy_html.so
#LoadModule brotli_module lib/httpd/modules/mod_brotli.so
LoadModule mime_module lib/httpd/modules/mod_mime.so
LoadModule log_config_module lib/httpd/modules/mod_log_config.so
#LoadModule log_debug_module lib/httpd/modules/mod_log_debug.so
#LoadModule log_forensic_module lib/httpd/modules/mod_log_forensic.so
LoadModule logio_module lib/httpd/modules/mod_logio.so
LoadModule env_module lib/httpd/modules/mod_env.so
#LoadModule mime_magic_module lib/httpd/modules/mod_mime_magic.so
#LoadModule expires_module lib/httpd/modules/mod_expires.so
LoadModule headers_module lib/httpd/modules/mod_headers.so
#LoadModule usertrack_module lib/httpd/modules/mod_usertrack.so
LoadModule unique_id_module lib/httpd/modules/mod_unique_id.so
LoadModule setenvif_module lib/httpd/modules/mod_setenvif.so
LoadModule version_module lib/httpd/modules/mod_version.so
#LoadModule remoteip_module lib/httpd/modules/mod_remoteip.so
LoadModule proxy_module lib/httpd/modules/mod_proxy.so
#LoadModule proxy_connect_module lib/httpd/modules/mod_proxy_connect.so
#LoadModule proxy_ftp_module lib/httpd/modules/mod_proxy_ftp.so
#LoadModule proxy_http_module lib/httpd/modules/mod_proxy_http.so
LoadModule proxy_fcgi_module lib/httpd/modules/mod_proxy_fcgi.so
#LoadModule proxy_scgi_module lib/httpd/modules/mod_proxy_scgi.so
#LoadModule proxy_uwsgi_module lib/httpd/modules/mod_proxy_uwsgi.so
#LoadModule proxy_fdpass_module lib/httpd/modules/mod_proxy_fdpass.so
#LoadModule proxy_wstunnel_module lib/httpd/modules/mod_proxy_wstunnel.so
#LoadModule proxy_ajp_module lib/httpd/modules/mod_proxy_ajp.so
#LoadModule proxy_balancer_module lib/httpd/modules/mod_proxy_balancer.so
#LoadModule proxy_express_module lib/httpd/modules/mod_proxy_express.so
#LoadModule proxy_hcheck_module lib/httpd/modules/mod_proxy_hcheck.so
#LoadModule session_module lib/httpd/modules/mod_session.so
#LoadModule session_cookie_module lib/httpd/modules/mod_session_cookie.so
#LoadModule session_crypto_module lib/httpd/modules/mod_session_crypto.so
#LoadModule session_dbd_module lib/httpd/modules/mod_session_dbd.so
#LoadModule slotmem_shm_module lib/httpd/modules/mod_slotmem_shm.so
#LoadModule slotmem_plain_module lib/httpd/modules/mod_slotmem_plain.so
LoadModule ssl_module lib/httpd/modules/mod_ssl.so
#LoadModule dialup_module lib/httpd/modules/mod_dialup.so
#LoadModule http2_module lib/httpd/modules/mod_http2.so
#LoadModule lbmethod_byrequests_module lib/httpd/modules/mod_lbmethod_byrequests.so
#LoadModule lbmethod_bytraffic_module lib/httpd/modules/mod_lbmethod_bytraffic.so
#LoadModule lbmethod_bybusyness_module lib/httpd/modules/mod_lbmethod_bybusyness.so
#LoadModule lbmethod_heartbeat_module lib/httpd/modules/mod_lbmethod_heartbeat.so
LoadModule unixd_module lib/httpd/modules/mod_unixd.so
#LoadModule heartbeat_module lib/httpd/modules/mod_heartbeat.so
#LoadModule heartmonitor_module lib/httpd/modules/mod_heartmonitor.so
#LoadModule dav_module lib/httpd/modules/mod_dav.so
LoadModule status_module lib/httpd/modules/mod_status.so
LoadModule autoindex_module lib/httpd/modules/mod_autoindex.so
#LoadModule asis_module lib/httpd/modules/mod_asis.so
#LoadModule info_module lib/httpd/modules/mod_info.so
#LoadModule suexec_module lib/httpd/modules/mod_suexec.so
<IfModule !mpm_prefork_module>
	#LoadModule cgid_module lib/httpd/modules/mod_cgid.so
</IfModule>
<IfModule mpm_prefork_module>
	#LoadModule cgi_module lib/httpd/modules/mod_cgi.so
</IfModule>
#LoadModule dav_fs_module lib/httpd/modules/mod_dav_fs.so
#LoadModule dav_lock_module lib/httpd/modules/mod_dav_lock.so
LoadModule vhost_alias_module lib/httpd/modules/mod_vhost_alias.so
#LoadModule negotiation_module lib/httpd/modules/mod_negotiation.so
LoadModule dir_module lib/httpd/modules/mod_dir.so
#LoadModule actions_module lib/httpd/modules/mod_actions.so
#LoadModule speling_module lib/httpd/modules/mod_speling.so
LoadModule userdir_module lib/httpd/modules/mod_userdir.so
LoadModule alias_module lib/httpd/modules/mod_alias.so
LoadModule rewrite_module lib/httpd/modules/mod_rewrite.so

# PHP Module
LoadModule php_module /usr/local/opt/php@8.2/lib/httpd/modules/libphp.so

<IfModule unixd_module>
#
# If you wish httpd to run as a different user or group, you must run
# httpd as root initially and it will switch.
#
# User/Group: The name (or #number) of the user/group to run httpd as.
# It is usually good practice to create a dedicated user and group for
# running httpd, as with most system services.
#
User nykianderson
Group staff

</IfModule>

# 'Main' server configuration
#
# The directives in this section set up the values used by the 'main'
# server, which responds to any requests that aren't handled by a
# <VirtualHost> definition.  These values also provide defaults for
# any <VirtualHost> containers you may define later in the file.
#
# All of these directives may appear inside <VirtualHost> containers,
# in which case these default settings will be overridden for the
# virtual host being defined.
#

#
# ServerAdmin: Your address, where problems with the server should be
# e-mailed.  This address appears on some server-generated pages, such
# as error documents.  e.g. admin@your-domain.com
#
ServerAdmin nyki.l.anderson@gmail.com

#
# ServerName gives the name and port that the server uses to identify itself.
# This can often be determined automatically, but we recommend you specify
# it explicitly to prevent problems during startup.
#
# If your host doesn't have a registered DNS name, enter its IP address here.
#
ServerName localhost

#
# Deny access to the entirety of your server's filesystem. You must
# explicitly permit access to web content directories in other
# <Directory> blocks below.
#
<Directory />
    AllowOverride All
    Require all granted
</Directory>

#
# Note that from this point forward you must specifically allow
# particular features to be enabled - so if something's not working as
# you might expect, make sure that you have specifically enabled it
# below.
#

#
# DocumentRoot: The directory out of which you will serve your
# documents. By default, all requests are taken from this directory, but
# symbolic links and aliases may be used to point to other locations.
#
DocumentRoot "/Users/nykianderson/Sites"
<Directory "/Users/nykianderson/Sites">
    #
    # Possible values for the Options directive are "None", "All",
    # or any combination of:
    #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
    #
    # Note that "MultiViews" must be named *explicitly* --- "Options All"
    # doesn't give it to you.
    #
    # The Options directive is both complicated and important.  Please see
    # http://httpd.apache.org/docs/2.4/mod/core.html#options
    # for more information.
    #
    Options Indexes FollowSymLinks

    #
    # AllowOverride controls what directives may be placed in .htaccess files.
    # It can be "All", "None", or any combination of the keywords:
    #   AllowOverride FileInfo AuthConfig Limit
    #
    AllowOverride All

    #
    # Controls who can get stuff from this server.
    #
    Require all granted
</Directory>

#
# DirectoryIndex: sets the file that Apache will serve if a directory
# is requested.
#
<IfModule dir_module>
    DirectoryIndex index.php index.html
</IfModule>

<FilesMatch .php$>
    SetHandler application/x-httpd-php
</FilesMatch>

#
# The following lines prevent .htaccess and .htpasswd files from being
# viewed by Web clients.
#
<Files ".ht*">
    Require all denied
</Files>

#
# ErrorLog: The location of the error log file.
# If you do not specify an ErrorLog directive within a <VirtualHost>
# container, error messages relating to that virtual host will be
# logged here.  If you *do* define an error logfile for a <VirtualHost>
# container, that host's errors will be logged there and not here.
#
ErrorLog "/usr/local/var/log/httpd/httpd_error_log"

#
# LogLevel: Control the number of messages logged to the error_log.
# Possible values include: debug, info, notice, warn, error, crit,
# alert, emerg.
#
LogLevel debug

<IfModule log_config_module>
    #
    # The following directives define some format nicknames for use with
    # a CustomLog directive (see below).
    #
    LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\"" combined
    LogFormat "%h %l %u %t \"%r\" %>s %b" common

    <IfModule logio_module>
      # You need to enable mod_logio.c to use %I and %O
      LogFormat "%h %l %u %t \"%r\" %>s %b \"%{Referer}i\" \"%{User-Agent}i\" %I %O" combinedio
    </IfModule>

    #
    # The location and format of the access logfile (Common Logfile Format).
    # If you do not define any access logfiles within a <VirtualHost>
    # container, they will be logged here.  Contrariwise, if you *do*
    # define per-<VirtualHost> access logfiles, transactions will be
    # logged therein and *not* in this file.
    #
    CustomLog "/usr/local/var/log/httpd/httpd_access_log" common

    #
    # If you prefer a logfile with access, agent, and referer information
    # (Combined Logfile Format) you can use the following directive.
    #
    #CustomLog "/usr/local/var/log/httpd/access_log" combined
</IfModule>

<IfModule alias_module>
    #
    # Redirect: Allows you to tell clients about documents that used to
    # exist in your server's namespace, but do not anymore. The client
    # will make a new request for the document at its new location.
    # Example:
    # Redirect permanent /foo http://www.example.com/bar

    #
    # Alias: Maps web paths into filesystem paths and is used to
    # access content that does not live under the DocumentRoot.
    # Example:
    # Alias /webpath /full/filesystem/path
    #
    # If you include a trailing / on /webpath then the server will
    # require it to be present in the URL.  You will also likely
    # need to provide a <Directory> section to allow access to
    # the filesystem path.

    #
    # ScriptAlias: This controls which directories contain server scripts.
    # ScriptAliases are essentially the same as Aliases, except that
    # documents in the target directory are treated as applications and
    # run by the server when requested rather than as documents sent to the
    # client.  The same rules about trailing "/" apply to ScriptAlias
    # directives as to Alias.
    #
    ScriptAlias /cgi-bin/ "/usr/local/var/www/cgi-bin/"

</IfModule>

<IfModule cgid_module>
    #
    # ScriptSock: On threaded servers, designate the path to the UNIX
    # socket used to communicate with the CGI daemon of mod_cgid.
    #
    #Scriptsock cgisock
</IfModule>

#
# "/usr/local/var/www/cgi-bin" should be changed to whatever your ScriptAliased
# CGI directory exists, if you have that configured.
#
<Directory "/usr/local/var/www/cgi-bin">
    AllowOverride None
    Options None
    Require all granted
</Directory>

<IfModule headers_module>
    #
    # Avoid passing HTTP_PROXY environment to CGI's on this or any proxied
    # backend servers which have lingering "httpoxy" defects.
    # 'Proxy' request header is undefined by the IETF, not listed by IANA
    #
    RequestHeader unset Proxy early
</IfModule>

<IfModule mime_module>
    #
    # TypesConfig points to the file containing the list of mappings from
    # filename extension to MIME-type.
    #
    TypesConfig /usr/local/etc/httpd/mime.types

    #
    # AddType allows you to add to or override the MIME configuration
    # file specified in TypesConfig for specific file types.
    #
    #AddType application/x-gzip .tgz
    #
    # AddEncoding allows you to have certain browsers uncompress
    # information on the fly. Note: Not all browsers support this.
    #
    #AddEncoding x-compress .Z
    #AddEncoding x-gzip .gz .tgz
    #
    # If the AddEncoding directives above are commented-out, then you
    # probably should define those extensions to indicate media types:
    #
    AddType application/x-compress .Z
    AddType application/x-gzip .gz .tgz

    #
    # AddHandler allows you to map certain file extensions to "handlers":
    # actions unrelated to filetype. These can be either built into the server
    # or added with the Action directive (see below)
    #
    # To use CGI scripts outside of ScriptAliased directories:
    # (You will also need to add "ExecCGI" to the "Options" directive.)
    #
    #AddHandler cgi-script .cgi

    # For type maps (negotiated resources):
    #AddHandler type-map var

    #
    # Filters allow you to process content before it is sent to the client.
    #
    # To parse .shtml files for server-side includes (SSI):
    # (You will also need to add "Includes" to the "Options" directive.)
    #
    #AddType text/html .shtml
    #AddOutputFilter INCLUDES .shtml
</IfModule>

#
# The mod_mime_magic module allows the server to use various hints from the
# contents of the file itself to determine its type.  The MIMEMagicFile
# directive tells the module where the hint definitions are located.
#
#MIMEMagicFile /usr/local/etc/httpd/magic

#
# Customizable error responses come in three flavors:
# 1) plain text 2) local redirects 3) external redirects
#
# Some examples:
#ErrorDocument 500 "The server made a boo boo."
#ErrorDocument 404 /missing.html
#ErrorDocument 404 "/cgi-bin/missing_handler.pl"
#ErrorDocument 402 http://www.example.com/subscription_info.html
#

#
# MaxRanges: Maximum number of Ranges in a request before
# returning the entire resource, or one of the special
# values 'default', 'none' or 'unlimited'.
# Default setting is to accept 200 Ranges.
#MaxRanges unlimited

#
# EnableMMAP and EnableSendfile: On systems that support it,
# memory-mapping or the sendfile syscall may be used to deliver
# files.  This usually improves server performance, but must
# be turned off when serving from networked-mounted
# filesystems or if support for these functions is otherwise
# broken on your system.
# Defaults: EnableMMAP On, EnableSendfile Off
#
#EnableMMAP off
#EnableSendfile on

# Supplemental configuration
#
# The configuration files in the /usr/local/etc/httpd/extra/ directory can be
# included to add extra features or to modify the default configuration of
# the server, or you may simply copy their contents here and change as
# necessary.

# Server-pool management (MPM specific)
#Include /usr/local/etc/httpd/extra/httpd-mpm.conf

# Multi-language error messages
#Include /usr/local/etc/httpd/extra/httpd-multilang-errordoc.conf

# Fancy directory listings
#Include /usr/local/etc/httpd/extra/httpd-autoindex.conf

# Language settings
#Include /usr/local/etc/httpd/extra/httpd-languages.conf

# User home directories
Include /usr/local/etc/httpd/extra/httpd-userdir.conf

# Real-time info on requests and configuration
#Include /usr/local/etc/httpd/extra/httpd-info.conf

# Virtual hosts
#Include /usr/local/etc/httpd/extra/httpd-vhosts.conf
Include /usr/local/etc/httpd/vhosts/*.conf

# Local access to the Apache HTTP Server Manual
#Include /usr/local/etc/httpd/extra/httpd-manual.conf

# Distributed authoring and versioning (WebDAV)
#Include /usr/local/etc/httpd/extra/httpd-dav.conf

# Various default settings
#Include /usr/local/etc/httpd/extra/httpd-default.conf

# Configure mod_proxy_html to understand HTML4/XHTML1
<IfModule proxy_html_module>
    Include /usr/local/etc/httpd/extra/proxy-html.conf
</IfModule>

# Secure (SSL/TLS) connections
Include /usr/local/etc/httpd/extra/httpd-ssl.conf
```
## Installing and Configuring **PHP** 8.2.0 with **Homebrew**

Resources:
- [macOS 12.0 Monterey Apache Setup: Multiple PHP Versions](https://getgrav.org/blog/macos-monterey-apache-multiple-php-versions)
- [Install Pecl on Mac](https://blackdeerdev.com/install-pecl-pear-on-mac-osx/)
- [Install XDebug via Homebrew](https://github.com/shivammathur/homebrew-extensions)

Install **PHP** with **Homebrew**.  There are many versions to choose from but get the latest **PHP@8.2** as some earlier versions have been deprecated.

```shell
> brew tap shivammathur/php
> brew install shivammathur/php/php@8.2
```

Configure **PHP** 8.2.0 by editing the *php.ini* file.

#### /usr/local/etc/php/8.2/php.ini

```ini
; display_errors
   Default Value: On
   Development Value: On
;   Production Value: Off

; display_startup_errors
   Default Value: On
   Development Value: On
;   Production Value: Off

; error_reporting
   Default Value: E_ALL
   Development Value: E_ALL
;   Production Value: E_ALL & ~E_DEPRECATED & ~E_STRICT

; log_errors
   Default Value: Off
   Development Value: On
;   Production Value: On

; UNIX: "/path1:/path2"
;include_path = ".:/php/includes"
include_path=".:/usr/local/pear/share/pear"

[Date]
; Defines the default timezone used by the date functions
; https://php.net/date.timezone
date.timezone = 'America/New_York'
```

Close all terminal windows and restart terminal. Now link the **PHP@8.2** as our default **PHP** version. Then test that you've got the right version linked.

```shell
> brew unlink php && brew link --overwrite --force php@8.2
> php -v
```

<details><summary>output</summary>
<p>

```shell
PHP 8.2.0-dev (cli) (built: Jul 18 2022 00:36:14) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.0-dev, Copyright (c) Zend Technologies
    with Zend OPcache v8.2.0-dev, Copyright (c), by Zend Technologies
```
</p></details>

Verify that these lines are in the **HTTPD** config file (though we already should have completed this in the **HTTPD** section).

#### */usr/local/etc/httpd/httpd.conf*

```apacheconf
# PHP Module
LoadModule php_module /usr/local/opt/php@8.2/lib/httpd/modules/libphp.so

#<IfModule dir_module>
#    DirectoryIndex index.html
#</IfModule>

<IfModule dir_module>
    DirectoryIndex index.php index.html
</IfModule>

<FilesMatch \.php$>
    SetHandler application/x-httpd-php
</FilesMatch>
```

Install **PECL** globally for **PHP** modules.

```shell
> curl -O https://pear.php.net/go-pear.phar
> sudo php -d detect_unicode=0 go-pear.phar
```

Configure **PEAR** for installation by typing these commands.

```shell
> 1
> /usr/local/pear

> 4
> /usr/local/bin
```

In your *php.ini*, verify that these lines were added.

```ini
; UNIX: "/path1:/path2"
;include_path = ".:/php/includes"
include_path=".:/usr/local/pear/share/pear"
```

Install XDebug 3.2.0alpha2 for PHP 8.2 using Homebrew

```shell
> brew tap shivammathur/extensions
> brew install shivammathur/extensions/xdebug@8.2
```

Restart **HTTPD** server and verify that xdebug is enabled.

```shell
> sudo brew services restart httpd
> php -v
```

<details><summary>output</summary>
<p>

```shell
PHP 8.2.0-dev (cli) (built: Jul 18 2022 00:36:14) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.2.0-dev, Copyright (c) Zend Technologies
    with Xdebug v3.2.0alpha2, Copyright (c) 2002-2022, by Derick Rethans
    with Zend OPcache v8.2.0-dev, Copyright (c), by Zend Technologies
```
</p></details>

##  Using **mkcert** to Set Up Local **SSL** on **macOS** (HTTPS Certificates)

Resources:
- [MKCERT: VALID HTTPS CERTIFICATES FOR LOCALHOST](https://words.filippo.io/mkcert-valid-https-certificates-for-localhost/)
- [Set up a Self Signed Certificate on macOS's Built in Apache](https://donatstudios.com/Self-Signed-Certificate-On-macOS-Apache#apache-configuration)
- [Using mkcert to Set Up Local SSL on macOS's Built in Apache](https://donatstudios.com/Local-Certificate-On-macOS-Apache)

Install **mkcert** and set itself up as a signing authority on local machine. Also install **nss** to help Firefox resolve certificates.

```shell
> brew install mkcert nss
> mkcert -install
```

Creating the certificates for *local.shape-share.com*

```shell
> mkdir /tmp/crt && cd /tmp/crt
> mkcert local.shape-share.com
```

<details><summary>output</summary>
<p>

```shell
Created a new certificate valid for the following names 📜
 - "local.shape-share.com"

The certificate is at "./shape_search.local.pem" and the key at "./shape_search.local-key.pem" ✅

It will expire on 28 October 2024 🗓
```
</p></details>

Move the certificate and key to the desired directory.

```shell
> sudo mkdir /usr/local/etc/ssl/certs
> sudo mv *.pem /usr/local/etc/ssl/certs
```

Edit virtual host configuration to find both *.pem* files.

\* Note: more on virtual host full configuration coming up. Just keep the below directories in mind through the next section. \*

```apacheconf
SSLEngine on
SSLCertificateFile "/usr/local/etc/ssl/shape_search.local.pem"
SSLCertificateKeyFile "/usr/local/etc/ssl/shape_search.local-key.pem"
```

Add these lines to the *httpd-ssl.conf*

#### */usr/local/etc/httpd/extra/httpd-ssl.conf*

```apacheconf
SSLRandomSeed startup builtin
SSLRandomSeed connect builtin

Listen *:443

SSLCipherSuite HIGH:MEDIUM:!MD5:!RC4:!3DES
SSLProxyCipherSuite HIGH:MEDIUM:!MD5:!RC4:!3DES

SSLHonorCipherOrder on

SSLProtocol all -SSLv3
SSLProxyProtocol all -SSLv3

SSLPassPhraseDialog  builtin
```

## Configuring a virtual host for **Shape-Share** to be accessible at *https://local.shape-share.com*

Resources:
- [Configuring Apache Virtual Hosts on Mac OS X](https://jasonmccreary.me/articles/configure-apache-virtualhost-mac-os-x/)

Find the following lines in the *httpd.conf* and paste this underneath it. This allows you to create as many virtual hosts as you want and keep them in their own *.conf* file.

```apacheconf
# Virtual hosts
#Include /usr/local/etc/httpd/extras/httpd-vhosts.conf
Include /usr/local/etc/httpd/vhosts/*.conf
```

Create virtual host configuration file for **Shape-Share**.

#### /usr/local/etc/httpd/vhosts/shape-share.conf

```apacheconf
<VirtualHost *:443>

#   General setup for the virtual host
DocumentRoot "/Users/nykianderson/Sites/shape_search_/public_html"
ServerName shape_search.local
ServerAlias wwww.shape_search.local https://shape_search.local http://shape_search.local
ServerAdmin nyki.l.anderson@gmail.com
ErrorLog "/usr/local/var/log/httpd/share_error_log"
TransferLog "/usr/local/var/log/httpd/share_access_log"

<Directory /Users/nykianderson/Sites/shape-share>
    Options -Indexes +FollowSymLinks +MultiViews
    AllowOverride All
    Require all granted
</Directory>

#   SSL Engine Switch:
#   Enable/Disable SSL for this virtual host.
SSLEngine on

#   Server Certificate:
#   Point SSLCertificateFile at a PEM encoded certificate.  If
#   the certificate is encrypted, then you will be prompted for a
#   pass phrase.  Note that a kill -HUP will prompt again.  Keep
#   in mind that if you have both an RSA and a DSA certificate you
#   can configure both in parallel (to also allow the use of DSA
#   ciphers, etc.)
#   Some ECC cipher suites (http://www.ietf.org/rfc/rfc4492.txt)
#   require an ECC certificate which can also be configured in
#   parallel.
SSLCertificateFile "/usr/local/etc/ssl/certs/shape_search.local.pem"
#SSLCertificateFile "/usr/local/etc/httpd/server-dsa.crt"
#SSLCertificateFile "/usr/local/etc/httpd/server-ecc.crt"

#   Server Private Key:
#   If the key is not combined with the certificate, use this
#   directive to point at the key file.  Keep in mind that if
#   you've both a RSA and a DSA private key you can configure
#   both in parallel (to also allow the use of DSA ciphers, etc.)
#   ECC keys, when in use, can also be configured in parallel
SSLCertificateKeyFile "/usr/local/etc/ssl/certs/local.shape-share.com-key.pem"
#SSLCertificateKeyFile "/usr/local/etc/httpd/server-dsa.key"
#SSLCertificateKeyFile "/usr/local/etc/httpd/server-ecc.key"

#   Server Certificate Chain:
#   Point SSLCertificateChainFile at a file containing the
#   concatenation of PEM encoded CA certificates which form the
#   certificate chain for the server certificate. Alternatively
#   the referenced file can be the same as SSLCertificateFile
#   when the CA certificates are directly appended to the server
#   certificate for convenience.
#SSLCertificateChainFile "/usr/local/etc/httpd/server-ca.crt"

#   Certificate Authority (CA):
#   Set the CA certificate verification path where to find CA
#   certificates for client authentication or alternatively one
#   huge file containing all of them (file must be PEM encoded)
#   Note: Inside SSLCACertificatePath you need hash symlinks
#         to point to the certificate files. Use the provided
#         Makefile to update the hash symlinks after changes.
#SSLCACertificatePath "/usr/local/etc/httpd/ssl.crt"
#SSLCACertificateFile "/usr/local/etc/httpd/ssl.crt/ca-bundle.crt"

#   Certificate Revocation Lists (CRL):
#   Set the CA revocation path where to find CA CRLs for client
#   authentication or alternatively one huge file containing all
#   of them (file must be PEM encoded).
#   The CRL checking mode needs to be configured explicitly
#   through SSLCARevocationCheck (defaults to "none" otherwise).
#   Note: Inside SSLCARevocationPath you need hash symlinks
#         to point to the certificate files. Use the provided
#         Makefile to update the hash symlinks after changes.
#SSLCARevocationPath "/usr/local/etc/httpd/ssl.crl"
#SSLCARevocationFile "/usr/local/etc/httpd/ssl.crl/ca-bundle.crl"
#SSLCARevocationCheck chain

#   Client Authentication (Type):
#   Client certificate verification type and depth.  Types are
#   none, optional, require and optional_no_ca.  Depth is a
#   number which specifies how deeply to verify the certificate
#   issuer chain before deciding the certificate is not valid.
#SSLVerifyClient require
#SSLVerifyDepth  10

#   TLS-SRP mutual authentication:
#   Enable TLS-SRP and set the path to the OpenSSL SRP verifier
#   file (containing login information for SRP user accounts).
#   Requires OpenSSL 1.0.1 or newer. See the mod_ssl FAQ for
#   detailed instructions on creating this file. Example:
#   "openssl srp -srpvfile /usr/local/etc/httpd/passwd.srpv -add username"
#SSLSRPVerifierFile "/usr/local/etc/httpd/passwd.srpv"

#   Access Control:
#   With SSLRequire you can do per-directory access control based
#   on arbitrary complex boolean expressions containing server
#   variable checks and other lookup directives.  The syntax is a
#   mixture between C and Perl.  See the mod_ssl documentation
#   for more details.
#<Location />
#SSLRequire (    %{SSL_CIPHER} !~ m/^(EXP|NULL)/ \
#            and %{SSL_CLIENT_S_DN_O} eq "Snake Oil, Ltd." \
#            and %{SSL_CLIENT_S_DN_OU} in {"Staff", "CA", "Dev"} \
#            and %{TIME_WDAY} >= 1 and %{TIME_WDAY} <= 5 \
#            and %{TIME_HOUR} >= 8 and %{TIME_HOUR} <= 20       ) \
#           or %{REMOTE_ADDR} =~ m/^192\.76\.162\.[0-9]+$/
#</Location>

#   SSL Engine Options:
#   Set various options for the SSL engine.
#   o FakeBasicAuth:
#     Translate the client X.509 into a Basic Authorisation.  This means that
#     the standard Auth/DBMAuth methods can be used for access control.  The
#     user name is the `one line' version of the client's X.509 certificate.
#     Note that no password is obtained from the user. Every entry in the user
#     file needs this password: `xxj31ZMTZzkVA'.
#   o ExportCertData:
#     This exports two additional environment variables: SSL_CLIENT_CERT and
#     SSL_SERVER_CERT. These contain the PEM-encoded certificates of the
#     server (always existing) and the client (only existing when client
#     authentication is used). This can be used to import the certificates
#     into CGI scripts.
#   o StdEnvVars:
#     This exports the standard SSL/TLS related `SSL_*' environment variables.
#     Per default this exportation is switched off for performance reasons,
#     because the extraction step is an expensive operation and is usually
#     useless for serving static content. So one usually enables the
#     exportation for CGI and SSI requests only.
#   o StrictRequire:
#     This denies access when "SSLRequireSSL" or "SSLRequire" applied even
#     under a "Satisfy any" situation, i.e. when it applies access is denied
#     and no other module can change it.
#   o OptRenegotiate:
#     This enables optimized SSL connection renegotiation handling when SSL
#     directives are used in per-directory context.
#SSLOptions +FakeBasicAuth +ExportCertData +StrictRequire
<FilesMatch "\.(cgi|shtml|phtml|php)$">
    SSLOptions +StdEnvVars
</FilesMatch>
<Directory "/usr/local/var/www/cgi-bin">
    SSLOptions +StdEnvVars
</Directory>

#   SSL Protocol Adjustments:
#   The safe and default but still SSL/TLS standard compliant shutdown
#   approach is that mod_ssl sends the close notify alert but doesn't wait for
#   the close notify alert from client. When you need a different shutdown
#   approach you can use one of the following variables:
#   o ssl-unclean-shutdown:
#     This forces an unclean shutdown when the connection is closed, i.e. no
#     SSL close notify alert is sent or allowed to be received.  This violates
#     the SSL/TLS standard but is needed for some brain-dead browsers. Use
#     this when you receive I/O errors because of the standard approach where
#     mod_ssl sends the close notify alert.
#   o ssl-accurate-shutdown:
#     This forces an accurate shutdown when the connection is closed, i.e. a
#     SSL close notify alert is send and mod_ssl waits for the close notify
#     alert of the client. This is 100% SSL/TLS standard compliant, but in
#     practice often causes hanging connections with brain-dead browsers. Use
#     this only for browsers where you know that their SSL implementation
#     works correctly.
#   Notice: Most problems of broken clients are also related to the HTTP
#   keep-alive facility, so you usually additionally want to disable
#   keep-alive for those clients, too. Use variable "nokeepalive" for this.
#   Similarly, one has to force some clients to use HTTP/1.0 to workaround
#   their broken HTTP/1.1 implementation. Use variables "downgrade-1.0" and
#   "force-response-1.0" for this.
BrowserMatch "MSIE [2-5]" \
         nokeepalive ssl-unclean-shutdown \
         downgrade-1.0 force-response-1.0

#   Per-Server Logging:
#   The home of a custom SSL log file. Use this when you want a
#   compact non-error SSL logfile on a virtual host basis.
CustomLog "/usr/local/var/log/httpd/share_ssl_request_log" \
          "%t %h %{SSL_PROTOCOL}x %{SSL_CIPHER}x \"%r\" %b"

</VirtualHost>
```

Restart **HTTPD** server.

```shell
> sudo brew services restart httpd
```

Mapping the *local.shape-share.com* extension. In order to access site locally we must edit the *hosts* file.

#### */etc/hosts*

```apacheconf
127.0.0.1       shape_search.local www.shape_search.local
::1             shape_search.local www.shape_search.local
```

Clear the local DNS cache.

```shell
> dscacheutil -flushcache
```

# https://github.com/Nyki-Anderson/shape_search.git
