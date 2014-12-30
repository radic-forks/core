Core Codex Components
=====================

The following Laravel package contains the core components of Codex, a Markdown documentation application. Not only does this package power the Codex application, you may also load it within your existing application to bring in the power of Codex for your documentation needs.

**Currently in development**

Installation
------------
Simply install the package through Composer. The best way to do this is through your terminal via Composer itself:

```
composer require codexproject/core
```

### Publish assets
The Codex core package contains a set of assets that are required for the bundled view files. To publish these, simply run the following:

```
php artisan asset:publish codexproject/core
```

Once this operation is complete, add your documentation to the `public/docs` directory and visit http://yoursite.com/codex.