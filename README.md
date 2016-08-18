# invoke-helpers

Helper functions and aliases for WordPress.

A full list of helpers can be found in the documentation for the plugin.

You can find that in the [website for the plugin](http://invokemedia.github.io/invoke-helpers).

### Installation

Either install this as a
[mu_plugin](https://codex.wordpress.org/Must_Use_Plugins) or drop into
`wp-content/plugins/invoke-helpers`, then install as a normal plugin through the admin area.

### Reasoning

The functions in this plugin are mostly wrappers or aliases to other functions
in wordpress. The main idea is that instead of calling something like
`get_thepermalink` or `site_url('/some-uri/')`, you can call `url($post)` or
`url('/some-uri/')` and then the function figures out which URL you actually
wanted.

There are also some nice snippets for limiting words, limiting characters,
checking the template, rendering partials, and debugging/dumping variables.

### Improvements

Adding new functions is great. Be sure to include proper doc blocks for the functions so that the API documentator can figure out the information for the functions.

