# Magento 2 CMI Payments

Based on the original module, this version work in magento 2.3 with some extra features and bug fix

* Developer: Taoufiq Ait Ali
* Website: http://asktaw.com
* Contact: <mailto:contact@asktaw.com>


### Manual Installation

 * Unzip the file
 * Create a folder {Magento root}/app/code/cmi/cmiecom
 * Copy the content from the unzip folder

## Enable extension

```
php bin/magento module:enable cmi_cmiecom
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
php bin/magento setup:static-content:deploy
```
