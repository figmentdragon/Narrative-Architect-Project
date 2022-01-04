var sass = require("sass");
var Fiber = require("fibers");

sass.render({
  file: "input.scss",
  importer: function(url, prev, done) {
    // ...
  },
  fiber: Fiber
}, function(err, result) {
  // ...
});


import 'node_modules/sass/sass.js';
import 'node_modules/sass/sass.dart.js';
import 'node_modules/sass/sass.default.dart.js';
