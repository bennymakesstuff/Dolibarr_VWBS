# WBS FOR DOLIBARR ERP CRM

## Features

### Integration with Project / Tasks (Workorders)
IMPORTANT: To make this module work with project tasks you must have the extra fields (Complimentary attributes) feature of Dolibarr enabled.

When the Module is activated it will create two database tables.
One for WBS Versions and one for WBS Items.
A version needs a Label, Description, RowID(Automatic) and a status (Active / Inactive).
Items need a RowID(Automatic), Label, Status, ParentID, VersionID, Level, WBS Code.

In the Module Settings of Projects/Leads select the Complimentary Fields (Projects) tab.
In here you will need to add an extra field with the following settings.
```
Title: VWBS Version
Code: vwbs_version
Type: integer
Length: 3
Required: True
Calculatable: No
Visible: True
```


Create an extra field for the tasks with a text or integer field. The attribute code for this needs to be placed into the settings of the VWBS Module to get it working correctly.

From here, on page load, VWBS module will inject the custom lists in place of the extra fields textbox.

<!--
![Screenshot wbs](img/screenshot_wbs.png?raw=true "WBS"){imgmd}
-->

Other modules are available on <a href="https://www.dolistore.com" target="_new">Dolistore.com</a>.



## Translations

Translations can be define manually by editing files into directories *langs*.

<!--
This module contains also a sample configuration for Transifex, under the hidden directory [.tx](.tx), so it is possible to manage translation using this service.

For more informations, see the [translator's documentation](https://wiki.dolibarr.org/index.php/Translator_documentation).

There is a [Transifex project](https://transifex.com/projects/p/dolibarr-module-template) for this module.
-->


<!--

## Installation

### From the ZIP file and GUI interface

- If you get the module in a zip file (like when downloading it from the market place [Dolistore](https://www.dolistore.com)), go into
menu ```Home - Setup - Modules - Deploy external module``` and upload the zip file.


Note: If this screen tell you there is no custom directory, check your setup is correct:

- In your Dolibarr installation directory, edit the ```htdocs/conf/conf.php``` file and check that following lines are not commented:

    ```php
    //$dolibarr_main_url_root_alt ...
    //$dolibarr_main_document_root_alt ...
    ```

- Uncomment them if necessary (delete the leading ```//```) and assign a sensible value according to your Dolibarr installation

    For example :

    - UNIX:
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = '/var/www/Dolibarr/htdocs/custom';
        ```

    - Windows:
        ```php
        $dolibarr_main_url_root_alt = '/custom';
        $dolibarr_main_document_root_alt = 'C:/My Web Sites/Dolibarr/htdocs/custom';
        ```

### From a GIT repository

- Clone the repository in ```$dolibarr_main_document_root_alt/wbs```

```sh
cd ....../custom
git clone git@github.com:gitlogin/wbs.git wbs
```

### <a name="final_steps"></a>Final steps

From your browser:

  - Log into Dolibarr as a super-administrator
  - Go to "Setup" -> "Modules"
  - You should now be able to find and enable the module


-->


## Licenses

**Main code**

GPLv3 or (at your option) any later version. See file COPYING for more information.

**Documentation**

All texts and readmes are licensed under GFDL.
