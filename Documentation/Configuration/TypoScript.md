TypoScript Configuration
========================

## Setup
Include the static template _Persons (persons)_ in your template.
The plugin configuration can be found under `plugin.tx_persons`.

## View
The plugin view uses templates located in the extension folder `Resources/Private`.
The default view configuration setup points to paths in this folder defined in TypoScript constants:

```typo3_typoscript
plugin.tx_persons {
    view {
        templateRootPaths.0 = {$plugin.tx_persons.view.templateRootPath}
        partialRootPaths.0 =  {$plugin.tx_persons.view.partialRootPath}
        layoutRootPaths.0 = {$plugin.tx_persons.view.layoutRootPath}
    }
}
```
Add additional paths in order to change any template files:
```typo3_typoscript
plugin.tx_persons {
    view {
        templateRootPaths.10 = path/to/additional/templates
        partialRootPaths.10 =  path/to/additional/partials
        layoutRootPaths.10 = path/to/additional/layouts
    }
}
```
Any file which should replace an existing template file must be placed accordingly.
I.e. if you like to replace the file `EXT:persons/Resources/Private/Templates/Person/List.html`
the new file must be named `List.html` and be placed in a folder `Persons` in your additional template root path.

## Persistence
Configure a storage page where your person records are located by setting the constant plugin.tx_persons.persistence.storagePid:

```typo3_typoscript
plugin.tx_persons {    
    persistence {
        storagePid = {$plugin.tx_persons.persistence.storagePid}
        #recursive = 1
    }
}
```
Enable the _recursive_ option in order to include folder/pages recursively.

## Settings
Settings from TypoScript are passed to the controller. Any setting from TypoScript can be overwritten by plugin setting. That means on the other hand that any plugin option can be set to a default value by TypoScript.
```typo3_typoscript
plugin.tx_persons {    
    settings {
       foo = bar
    }
}
```
### Image Processing

Per default the plugin renders a very basic template which is then filled by JavaScript. Persons are fetches via Ajax and rendered as JSON by a JsonView.
This View can be configured to render image variants based on width, height, cropping and aspect ratio.
Since this rendering can be quite demanding, it is **disabled** per default.
It can be enabled by setting the key _imageProcessing_.
```typo3_typoscript
plugin.tx_persons {    
    settings {
        imageProcessing {
            # any key enables image processing!
            enable = foo
            # keys below are allowed, values are default
            # and should only be set if different from default.
            #    width = 200
            #    height = m200
            #    minWidth = 50
            #    minHeight = 50
            #    maxWidth = 300
            #    maxHeight = 300
            #    cropVariant = default
       }
    }
}
```
  
## TypoScript Controller / Page Type
