This app/View/Backbone folder holds view files for Backbone use.

The way it works: when changes are made to the views, 
they must be compiled by running the CompileBackboneViewsShell
from command line.

Examples:
`php lib/Cake/Console/cake.php CompileBackboneViews` will compile the views.
`php lib/Cake/Console/cake.php CompileBackboneViews true` will compile the views,
and keep doing so every couple of seconds (useful during development).