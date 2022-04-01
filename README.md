# Zero Downtime Deployment #

## Magento 2.4.4 - @deprecated

On version 2.4.4, Magento is able to handle blue/green deployment, making this module no more required to handle Zero Downtime Deployment.<br>
To enable blue/green deployment you can add the config `deployment/blue_green/enabled` in your <b>app/etc/env.php</b>:
```php
'deployment' => [
    'blue_green' => [
        'enabled' => true
    ]
]
```

<b>magento/framework/Module/Plugin/DbStatusValidator.php</b>
![image](https://user-images.githubusercontent.com/16258478/161338149-52febed8-d9b9-4e95-ba9d-60b999627aa5.png)
<b>magento/module-deploy/Model/Plugin/ConfigChangeDetector.php</b>
![image](https://user-images.githubusercontent.com/16258478/161338272-f72b6d73-3763-42d4-a684-1450a47290b8.png)

Related commit is here: https://github.com/magento/magento2/commit/c241e11adf59baeca9d9e66cdbd726e4b0b88b21

&#9888; Consequently, this module is now deprecated and will not be maintained anymore.

## Purpose

Disable native change detection from Magento2 to allow Zero Downtime Deployment (ZDD).

Normal behavior:<br>
![zdd](https://user-images.githubusercontent.com/16258478/82318767-b361cd80-99d0-11ea-86f2-7b032ad29744.png)

With this module installed:<br>
![zdd_module](https://user-images.githubusercontent.com/16258478/82321492-32590500-99d5-11ea-9c84-53756715e8d7.png)

## Installation
```
composer require zepgram/module-zero-downtime-deployment
bin/magento module:enable Zepgram_ZeroDowntimeDeployment
bin/magento setup:upgrade
```

## Configuration

By default, Zero Downtime is enabled on production mode and disabled on Magento's developer and default modes.<br>
However, you can enable it for those modes from configuration path: `dev/zero_downtime_deployment/is_always_enabled`<br>
![418](https://user-images.githubusercontent.com/16258478/133935969-7b38f61f-67e2-486c-9dd6-a836688704d5.png)
> This section is only visible on developer mode from back-office

For example, it can be useful to display errors when you roll-back your code while your database is ahead.

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
1. You must set your blue pods to a dedicated redis database and keep the green pods on their own redis db (avoiding cache corrupting).
1. Run `bin/magento setup:upgrade --keep-generated` to upgrade your database.
1. Upgrading is done: now green pods must be killed and replaced by blue pods based on health check statement.

You can find a lot of articles detailling the procedure:
- https://inviqa.com/blog/how-achieve-zero-downtime-deployments-magento-2
- https://elogic.co/blog/how-to-achieve-zero-downtime-deployment-with-magento
