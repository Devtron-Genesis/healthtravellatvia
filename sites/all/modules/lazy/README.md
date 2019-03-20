This is a simple Drupal module to lazy-load all inline images and/or iframes
defined by content authors in entity content, usually the text-format-enabled
version of textarea fields. i.e. Node and Block body content.

The module currently depends on the [bLazy][1] image script.

There is another contributed module utilizing its namesake, [Blazy][2].
Make sure to check it out, especially if you need more advanced features and
support for many features out of the box.

This module focuses on the only area Blazy module lacks of; **inline-images**
and **inline-iframes**.

You can still use this module tandem with it, though that is not a requirement.

## Requirements

* **[Libraries API][4]** module
* **bLazy v1.8.2** script as a library item:  
  [Download bLazy][3] from https://github.com/dinbror/blazy  
  1) Extract the downloaded file,
  2) rename *blazy-master* directory to *blazy*,
  3) copy the folder into one of the following places that *Libraries API*
  module supports, `sites/all/libraries` (or site-specific libraries folder):
  i.e.: `sites/all/libraries/blazy/blazy.min.js`  

## Installation

Install the module as usual. More information can be found at
https://www.drupal.org/docs/7/extend/installing-modules

## Usage

This modules makes a new text filter available for the text-formats: *Lazy-load*

Enable the *Lazy-load* filter for the desired text-formats. i.e. *Full HTML* or
*Filtered HTML*

Check out the module configuration at `admin/config/content/lazy`. The default
settings should work for most developers. Incase they are not, change the
settings to suit your needs and submit the form.

This configuration is used globally for all the text-formats having *Lazy-load*
filter enabled.

## Use Case

If you have numerous images and/or iframes in your content, it could become
a challenge to update that content to make compatible for lazy-loading. In
most cases those updates needs to be handled manually, because most of the time
if not all, the body content (HTML) doesn't follow a pattern to update
them programmatically.

This is the main reason I created this module, to avoid a need for altering body
content manually while making them easy to lazy-load.

**The *Lazy-load* filter doesn't make any changes to existing content.** It only
rewrites the `<img>` and/or `<iframe>` tags in already rendered output to have
them compatible for bLazy script to lazy-load. Since the filtered output is
cached, there should not be any changes in performance.

  [1]: http://dinbror.dk/blazy/
  [2]: https://www.drupal.org/project/blazy
  [3]: https://github.com/dinbror/blazy/archive/master.zip
  [4]: https://www.drupal.org/project/libraries
