# Symfony 4 Vue SSR

Inspiring by [ChrisDBrown/symfony4-vuejs-ssr](https://github.com/ChrisDBrown/symfony4-vuejs-ssr)

There is my version of using symfony plus vue without vue-router, but old and familiar navigation.

## Features

* symfony 4
* encore, vue and babel (package.json, webpack.config.js) 
* vue store - [vuex](https://vuex.vuejs.org/ru/)
* vue validation - [vuelidate](https://monterail.github.io/vuelidate/)
* provide routes by [friendsofsymfony/jsrouting-bundle](https://github.com/FriendsOfSymfony/FOSJsRoutingBundle/tree/master)
* menu building by [knplabs/knp-menu-bundle](https://symfony.com/doc/master/bundles/KnpMenuBundle/index.html)
* auto inject state data by tagged service (in `src/VueState/` folder)

## Requirements

* PHP 7.2
* [php v8js extension](https://github.com/phpv8/v8js)
* node, npm, yarn

### How to install extension?

Check and change version. In my case autodetect does not work, so I put **/opt/libv8-6.6** during pecl installation.

```bash
add-apt-repository ppa:~pinepain/libv8
apt-get update -y
apt-get install libv8-6.6-dev -y
pecl install v8js-2.1.0
#/opt/libv8-6.6
echo 'extension=v8js.so' > /etc/php/7.2/mods-available/v8js.ini
phpenmod v8js
service php7.2-fpm restart
```

## Installation

* clone or download project
* ```composer install```
* ```yarn install```
* ```npm run dev```