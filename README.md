# Magento 2 CMI Payments

Developer: cmi
Website: http://cmi.co.ma
Contact: <mailto:integration.ecom@cmi.co.ma>


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
