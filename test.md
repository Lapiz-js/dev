## Collections Helper

* [Lapiz.ArrayConverter](#Lapiz.ArrayConverter)
* [Lapiz.Map](#Lapiz.Map)
* [Lapiz.Map.copyProps](#Lapiz.Map.copyProps)
* [Lapiz.Map.getter](#Lapiz.Map.getter)
* [Lapiz.Map.method](#Lapiz.Map.method)
* [Lapiz.Map.prop](#Lapiz.Map.prop)
* [Lapiz.Map.setterGetter](#Lapiz.Map.setterGetter)
* [Lapiz.Map.setterMethod](#Lapiz.Map.setterMethod)
* [Lapiz.Namespace](#Lapiz.Namespace)
* [Lapiz.each](#Lapiz.each)
* [Lapiz.remove](#Lapiz.remove)
### <a name='Lapiz.ArrayConverter'></a>Lapiz.ArrayConverter
```javascript
Lapiz.ArrayConverter(accessor)
```
Takes an accessor and provides an array. The events on the accessor will be
used to keep the array up to date. However, if the array is modified, the
results can be unpredictable. This primarily provided as a tool for
interfacing with other libraries and frameworks. Use the accessor interface
whenever possible.

### <a name='Lapiz.Map'></a>Lapiz.Map
```javascript
Lapiz.Map()
```
Returns a key value store that inherits no properties or methods. Useful to
bypass calling "hasOwnProperty". This is just a wrapper around
Object.create(null);

Lapiz.Map also serves as a namespace for the following helper methods.
They can be called on any object. They all use Object.defineProperty to
create a proptery that cannot be overridden.

### <a name='Lapiz.Map.copyProps'></a>Lapiz.Map.copyProps
```javascript
Lapiz.Map.copyProps(copyTo, copyFrom, props...)
```
Copies the properties from the copyFrom object to the copyTo obj. The
properties should be strings. By default, the property will be copied with
basic assignment. If the property is preceeded by &, it will be copied by
reference.
```javascript
var A = {"x": 12, "y": "foo", z:[]};
var B = {};
Lapiz.Map.copyProps(B, A, "x", "&y");
A.x = 314;
console.log(B.x); // 12
B.y = "Test";
console.log(A.y); // Test
```

### <a name='Lapiz.Map.getter'></a>Lapiz.Map.getter
```javascript
Lapiz.Map.getter(object, namedGetterFunc)
```
Attaches a getter method to an object. The method must be a named function.
```javascript
var x = Lapiz.Map();
var ctr = 0;
Lapiz.Map.getter(x, function foo(){
  var c = ctr;
  ctr +=1;
  return c;
});
console.log(x.foo); //0
console.log(x.foo); //1
```

### <a name='Lapiz.Map.method'></a>Lapiz.Map.method
```javascript
Lapiz.Map.method(obj, namedFunc)
```
Attaches a method to an object. The method must be a named function.
```javascript
var x = Lapiz.Map();
Lapiz.Map.method(x, function foo(){...});
x.foo(); //calls foo
```

### <a name='Lapiz.Map.prop'></a>Lapiz.Map.prop
```javascript
Lapiz.Map.prop(obj, name, desc)
```
Just a wrapper around Object.defineProperty

### <a name='Lapiz.Map.setterGetter'></a>Lapiz.Map.setterGetter
```javascript
Lapiz.Map.setterGetter(obj, name, setterFunc, getterFunc)
Lapiz.Map.setterGetter(obj, name, setterFunc)
```
Creates a setter/getter property via a closure. A setter function is
required, if no getter is provided, the value will be returned. This is the
reason the method is named setterGetter rather than the more traditional
arrangement of "getterSetter" because the arguments are arranged so that
the first 3 are required and the last is optional.
```javascript
var x = Lapiz.Map();
Lapiz.Map.setterGetter(x, "foo", function(i){return parseInt(i);});

x.foo = "12";
console.log(x.foo); // will log 12 as an int
```
The value 'this' is always set to a special setterInterface for the setter
method. This can be used to cancel the set operation;
```javascript
var x = Lapiz.Map();
Lapiz.Map.setterGetter(x, "foo", function(i){
  i = parseInt(i);
  this.set = !isNaN(i);
  return i;
});

x.foo = "12";
console.log(x.foo); // will log 12 as an int
x.foo = "hello";
console.log(x.foo); // value will still be 12

```

### <a name='Lapiz.Map.setterMethod'></a>Lapiz.Map.setterMethod
```javascript
Lapiz.Map.setterMethod(obj, namedSetterFunc)
```
Attaches a setter method to an object. The method must be a named function.
```javascript
var x = Lapiz.Map();
Lapiz.Map.method(x, function foo(val){...});

//these two calls are equivalent
x.foo("bar");
x.foo = "bar";
```

### <a name='Lapiz.Namespace'></a>Lapiz.Namespace
```javascript
Lapiz.Namespace()
Lapiz.Namespace(constructor)
```
Namespace is a closure around all of the Map methods (plus Lapiz.set). It
provides syntactic sugar so that the obj argument doesn't need to be
supplied each time.

The constructor is optional. If not given the outer layer of the namespace
is returned.
```javascript
var x = Lapiz.Namespace();
x.set("foo", "bar");
x.method(function sayHello(name){
  console.log("Hello, "+name);
});
console.log(x.namespace.foo); // bar
x.namespace.sayHello("World"); // Hello, World
```
If a constructor is provided, it will be invoked with "this" as the outer
layer of the namespace and will return in the inner namespace.
```javascript
var x = Lapiz.Namespace(function(){
  this.set("foo", "bar");
  this.method(function sayHello(name){
    console.log("Hello, "+name);
  });
});

console.log(x.foo); // bar
x.sayHello("World"); // Hello, World
```
* namespace.set(name, value)
* namespace.prop(name, desc)
* namespace.method(namedFunc)
* namespace.setterMethod(namedSetterFunc)
* namespace.getter(namedGetterFunc)
* namespace.setterGetter(name, setter, getter)
* namespace.setterGetter(name, setter)

### <a name='Lapiz.each'></a>Lapiz.each
```javascript
Lapiz.each(collection, fn(key, val))
```
Iterates over the collection, calling func(key, val) for each item in the
collection. If the collection is an array, key will be the index. If func
returns true (or an equivalent value) the Lapiz.each will return the
current key allowing each to act as a search.
```javascript
var arr = [3,1,4,1,5,9];
Lapiz.each(arr, function(key,val){
  console.log(key, val);
});
var gt4 = Lapiz.each(arr, function(key,val){return val > 4;});

var kv = {
  "A":"apple",
  "B":"banana",
  "C":"cantaloupe"
};
Lapiz.each(kv, function(key,val){
  console.log(key, val);
});
```

### <a name='Lapiz.remove'></a>Lapiz.remove
```javascript
Lapiz.remove(arr, el, start)
Lapiz.remove(arr, el)
```
Removes the one instance of the given element from the array. If start is
not specified, it will be the first instance, otherwise it will be the
first instance at or after start.
```javascript
var arr = [3,1,4,1,5,9];
Lapiz.remove(arr,1);
console.log(arr); //[3,4,1,5,9]
```

