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
command line will generate the files in build/ and docs/. This will also run a
javascript compressor against the code which may return some structural errors.

### Running Unit Tests
The unit test are intended to run in a browser. There are 4 variations that will
appear as links at the top. The main version 'src' is index.php. It will run the
unit tests against the source code. 'build' is test.php which will run against
the code in the build folder. 'min' is test.min.php and will run against the
code in build/min. The last is coverage which will run against source, but will
inject coverage markers to compute code coverage.

### Documentation
Most of the code is documented at this point. Running the build will use the
autodoc project to generate the markdown versions of the documentation. A
helpful benefit of this is that finding something in the documentation will
provide a search string to help find that section in the code.

### Terminology Note
These terms can get confusing, and as of this moment, I'm using them
inconsistently.

A field is anything that can be accessed with the dot operator.

A property is a field that was defined with Object.defineProperty. It may have a
getter/setter or a value. It cannot be overridden.

An attribute is a field attached directly to the object (generally via
assignment).

### TODO: More Error trapping
Because there are so many layers of abstraction, often when something goes
wrong, it will go through many layers before actually causing an error. Better
error checking and trapping will help prevent this.

### TODO: Dev markers for build
There are a lot of lines that do type checking - which is great for development,
but just a waste of cycles once we're deployed. I'd like to add a way to mark
lines for removal during the build process.

It would also be nice to have a toggled debugger for console out.

### TODO: Demo Project: Lapiz Notes
I've gotten a start on this. Lapiz Notes will be a small, local notes program.
It uses localStorage for persistence. Each note will have one label and may have
many tags. This demo was chosen because it has a one-to-many and a man-to-many
relationship.

### TODO: Array Namespace
Move ArrayConverter and remove into a namespace, probably just A for
appreviation. Add these
- unique
- 

### TODO: Lapiz Cookbook
There are many features I've chosen not to include in Lapiz because building a
standard interface is more complex and abstract than having a dev write the code
themselves. For instance, I had originally wanted a standard way to do many-to-
many linking but there are so many slight variations that if it were to be
built, it would be more difficult to use than writing a many-to-many. However,
showing a few examples would be helpful

* relationships
    - many-to-many
    - one-to-many
    - null or 0 value
* adding constructor to Lapiz.parse
* UI
    - resolver (see currency example)
    - weakMap for attributes
* Objects
    - ViewModels via copyProps and on.create
    - var self = this; closure
    - serialize attr with JSON.stringify
    - upsert

### TODO: Tutorial
Core
- Events
- Errors
- typecheck
- parser
- Collections Helpers
- Collections (dict, accessor, filter, sorter)
- Namespace
- classes and objects
- indexing
- Modules

Components
- Templating
- UI
- Ajax
- DragNDrop
- Validator

Tools
- Testing
- AutoDoc