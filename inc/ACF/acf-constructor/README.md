# acf-constructor
## Prerequisite
* Plugins:
    * [Advanced Custom Fields PRO](https://wordpress.org/plugins/advanced-custom-fields/)
    * [acf-acutosize](https://wordpress.org/plugins/acf-autosize/#description) for wysiwyg good look (optinal)

## Instalation
* Download and install WordPress
* In your theme create `ACF/` folder
* Clone repository there
* Set proper constants in `ACF/acf-constructor/constants.php`
* Copy `ACF/acf-constructor/example/class-my-acf` to `ACF/` and tune it.
* Paste in `functions.php` this code:

```php
    require 'path/to/ACF/class-my-acf.php';
    $ACF = new MY_ACF();
    $ACF->register();
```

## Usage
* Set ***$pluged_acf_templates*** in `ACF/class-my-acf.php` for use prepared templates.
* Create new php files (acf classes) in `ACF/` and register them in `ACF/class-my-acf.php` in  ***$this->acf_classes***

## Timeline
* 08.07.2020 - Project start.