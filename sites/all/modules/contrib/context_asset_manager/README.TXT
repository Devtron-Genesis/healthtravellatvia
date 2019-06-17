
-- SUMMARY --

An Advanced tool to attach purge unnecessary css/js files from your site and insert page specific assets as required. As it comes as a context plugin, you can use the flexibility what ever condition you like and accordingly dress up the pages. You can select the modules you need, scan custom pages for css/js.
While rendering pages, you can purge all exisitng css/js ( indluding drupal core) or only the assets injected by the contrib/custom modules before you inject css/js files for your own choice.

It can immensely help if page performance, specially removing unnecessary render blocking resources stuff.

For a full description of the module, visit the project page:
  http://drupal.org/project/context_asset_manager
To submit bug reports and feature suggestions, or to track changes:
  http://drupal.org/project/issues/context_asset_manager


-- REQUIREMENTS --

Context

-- INSTALLATION --

Standard installation


-- CONFIGURATION --

Visit /admin/structure/context/page-assets-settings and have the basic settings.

-- USAGE --

1) Set up the configurations, select the module you want to scan for css/js
2) Select te purge config ( full or partial )
3) Add new context, set the condition. In the reaction section, you would find options for injecting CSS/JS.
4) Select necessary  files
5) You can also set the other parameters like Async, Defer, Scope etc while loading the file.
6) Setting Critical for a css file would mean the css content would be copied and pasted in the DOM in stead of being injected as file. Required for performance
7) Once all done, save the context.

-- CONTACT --

Current maintainers:
* Pralay Bose - https://www.drupal.org/user/2736353


