# Zero Downtime Deployment #

Disable native change detection when Magento2 is on production mode to allow Zero Downtime Deployment (ZDD).

## Installation
```
composer require zepgram/module-zero-downtime-deployment
bin/magento module:enable Zepgram_ZeroDowntimeDeployment
bin/magento setup:upgrade
```

## Server

ZDD enables you to deploy your website without any downtime.
However, this module contains only necessary changes to make it possible on Magento2.

To be able to perform a complete ZDD you'll need a 
<a href="https://www.google.com/search?q=blue+green+deployment+strategy&oq=blue+green+deployment+strategy">blue/green deployment strategy</a>.
Which depends on your hosting provider.

For example:
- AWS: https://aws.amazon.com/fr/quickstart/architecture/blue-green-deployment/
- Kubernetes: https://kubernetes.io/blog/2018/04/30/zero-downtime-deployment-kubernetes-jenkins/

The mainly steps to reach the ZDD with Magento2:
1. Start the deployment: green pods are the old one, for now they must stay active while creating blue pods.
1. Run `bin/magento setup:upgrade --keep-generated` to upgrade your database.
1. Upgrading is done: now green pods must be killed and replaced by blue pods based on health check statement. 
1. Even if cache has been already cleared by `bin/magento setup:upgrade` you must clean it again with `bin/magento cache:flush` because old pods may corrupt your cache.
