## Lapiz.js
I've been naming my projects after Minecraft blocks lately (because I'm not very
creative in my naming). I realized I spelled Lapis wrong a little while after I
started the project but decided to keep it because it's a distinct name.

Lapiz is an event driven library. It allows you to easily build object that fire
events when their properties change. These objects can be stored in key/value
pairs. Creation, deletion and change events will fire for objects within the key
value stores. These stores can also be filtered and sortered. Finally, this data
can be rendered as HTML.

### Dev Repository

This is the development repo. I've included the other repos as submodules. This
is primarily so that users interested in using Lapiz but not in developing it
can pull the builds, docs or source separately.

For developers, pulling this repo sets up a structure to make development easy.
Running either build.php from a browser or "php tools/build.php" from the
command line will generate the files in build/ and docs/. This will also run
yui compressor against the code which may return some structural errors.

### Running Unit Tests
The unit test are intended to run in a browser. There are 4 variations that will
appear as links at the top. The main version 'src' is index.php. It will run the
unit tests against the source code. 'build' is test.php which will run against
the code in the build folder. 'min' is test.min.php and will run against the
code in build/min. The last is coverage which will run against source, but will
inject coverage markers to compute code coverage.

### Terminology Note
These terms can get confusing, and as of this moment, I'm using them
inconsistently.

A field is anything that can be accessed with the dot operator.

A property is a field that was defined with Object.defineProperty. It may have a
getter/setter or a value. It cannot be overridden.

An attribute is a field attached directly to the object (generally via
assignment).
