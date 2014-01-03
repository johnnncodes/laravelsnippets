$echo               = "/bin/echo"
$mysql              = "/usr/bin/mysql"
$apt_get            = "/usr/bin/apt-get"
$add_apt_repository = "/usr/bin/add-apt-repository"
$a2enmod            = "/usr/sbin/a2enmod"
$mysqladmin         = "/usr/bin/mysqladmin"
$wget               = "/usr/bin/wget"
$dpkg               = "/usr/bin/dpkg"
$php                = "/usr/bin/php"

exec { "update apt":
  command => "${apt_get} update"
}

# Apache

exec { "install apache":
  command => "${apt_get} install -y apache2",
  require => Exec["update apt"]
}

exec { "enable rewrite module":
  command => "${a2enmod} rewrite",
  require => Exec["install apache"]
}

file { "/etc/apache2/sites-available/000-default.conf":
  ensure => file,
  content => "
    <VirtualHost *:80>
      DocumentRoot /var/www/public
      ErrorLog ${APACHE_LOG_DIR}/error.log
      CustomLog ${APACHE_LOG_DIR}/access.log combined
      SetEnv APPLICATION_ENVIRONMENT local
      <Directory '/var/www/public'>
        AllowOverride All
      </Directory>
    </VirtualHost>
  "
}

exec { "restart apache":
  command => "/etc/init.d/apache2 restart",
  require => [
    File["/etc/apache2/sites-available/000-default.conf"],
    Exec["install php"]
  ]
}

# MySQL

package { "mysql-server":
  ensure => present
}

service { "mysql":
  ensure => running,
  require => Package["mysql-server"]
}

exec { "set root password":
  command => "${mysqladmin} -uroot password vagrant",
  require => Service["mysql"]
}

exec { "create user":
  command => "${echo} \"CREATE USER 'dev'@'localhost' IDENTIFIED BY 'dev';\" | ${mysql} -uroot -pvagrant",
  unless  => "${mysql} -udev -pdev",
  require => Exec["set root password"]
}

exec { "create database":
  command => "${echo} \"CREATE DATABASE dev; GRANT ALL ON dev.* TO 'dev'@'localhost';\" | ${mysql} -uroot -pvagrant",
  unless  => "${mysql} -udev -pdev dev",
  require => Exec["create user"]
}

# PHP

exec { "install python software properties":
  command => "${apt_get} install -y python-software-properties",
  require => Exec["update apt"]
}

exec { "add php repository":
  command => "${add_apt_repository} -y ppa:ondrej/php5",
  require => Exec["install python software properties"]
}

exec { "update apt for php":
  command => "${apt_get} update -y",
  require => Exec["add php repository"]
}

exec { "install php":
  command => "${apt_get} install -y libapache2-mod-php5 php5-cli php5-common php5-mysql php5-gd php5-fpm php5-cgi php-pear php5-memcache php5-memcached php-apc php-soap php-xml-serializer php-xml-parser php5-geoip php5-mcrypt php5-curl php5-json php5-sqlite php5-redis",
  require => Exec["update apt for php"]
}

# Redis

exec { "install redis":
  command => "${apt_get} install -y redis-server",
  require => Exec["update apt"]
}

# Laravel

exec { "migrate laravel":
  command => "${php} /var/www/artisan migrate --seed --env=local",
  require => [
    Exec["install php"],
    Exec["create database"],
    Exec["restart apache"]
  ]
}