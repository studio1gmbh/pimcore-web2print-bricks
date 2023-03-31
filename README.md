# Studio1® Web2Print Bricks

## Installation

### 1. Use this bundle

Run following command in PHP FPM docker container:

```shell
composer require studio1/web2print-bricks
```

This adds all dependencies, too.


### 2. Prepare docker containers

Run following command in **both** PHP FPM **and** supervisor:

* Soft-link Chromium browser (if not already exists)
  ````shell
  ln -s /usr/bin/chromium /usr/bin/chromium-browser
  ````
* Update `node` version from 12.x to newer one (version 14.1.x or above, so we use 18.x)
  ````shell
  # Change to vendor directory and uninstall node-sass
  cd vendor/spiritix/php-chrome-html2pdf
  npm uninstall node-sass

  # Download node.js in version 18 and install it (incl. dependencies)
  curl -sL https://deb.nodesource.com/setup_18.x | bash -
  apt-get install -y gcc g++ make
  apt install -y nodejs

  # Install npm and sass
  npm install -g npm
  npm install sass

  # Remove puppeteer and re-install it with correct information about chrmoium installaltion
  npm remove puppeteer
  PUPPETEER_EXECUTABLE_PATH=`which chromium-browser` PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true npm install puppeteer
  npm install
  ````

### 3. Enable/install Web-to-Print bundles

Run following command in PHP FPM docker container:

```shell
# ATTENTION: change to Pimcore folder *before* running following commands
bin/console pimcore:bundle:enable Web2PrintToolsBundle
bin/console pimcore:bundle:install Web2PrintToolsBundle
bin/console pimcore:bundle:enable Web2PrintBricksBundle
bin/console pimcore:bundle:install Web2PrintBricksBundle
```

### 4. Change Web-to-Print settings

![Web-to-Print Settings](doc/web-to-print-settings.png)

### 5. Set flag "PrintPage" `true` for desired perspectives

Take the following perspective configuration as example:
[default.yaml](doc/default.yaml)

Afterwards please reload Pimcore admin backend.

## Usage

Add _PrintPage_ document and choose controller, e.g.

| **Document type** | **Controller**                                                                  |
|-------------------|---------------------------------------------------------------------------------|
| Print container   | `Studio1\Web2PrintBricksBundle\Controller\Web2printController::containerAction` |
| Print page        | `Studio1\Web2PrintBricksBundle\Controller\Web2printController::defaultAction`   |

After choosing the right controller adding bricks of this bundle via editor is possible (maybe reload GUI). 