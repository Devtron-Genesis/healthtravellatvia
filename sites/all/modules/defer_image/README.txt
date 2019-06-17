OVERVIEW
----------
This module creates a formatter for image fields that will output placeholder
markup for an image that will then get turned into an img element via JavaScript
after other content and resources have finished loading. There are several
configuration options at /admin/config/media/defer-image.

USAGE - FORMATTER
----------
There are two ways to utilize the capabilities of this module. The main way is
to set the "Defer Image Load" formatter when outputting an image field. This can
be done, for example, via the Display Settings for a Content Type or Entity.
Another common use would be when outputting an image field in a view.

USAGE - MANUAL
----------
The capabilities can also be used for images in content by manually constructing
the markup for the placeholder. The placeholder consists of three elements, the
wrapper element, the <noscript> element and the original <img> element within
the <noscript> element for non-JS users. This would end up looking something
like this:

<span class="defer-image-load" data-defer-src="{URL OF IMAGE}" data-defer-alt="[ALTERNATE TEXT FOR IMAGE]">
  <noscript><img src='[URL OF IMAGE]' alt='[ALTERNATE TEXT FOR IMAGE]' /></noscript>
</span>

Note that you can add whatever attributes you need to the image by adding data
attributes in the form of data-defer-[ATTRIBUTE]="[VALUE]" to the wrapper
element. For example, to add a class to the image, you would add
data-defer-class="this-is-a-class" to the wrapper element.
