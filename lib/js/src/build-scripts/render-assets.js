'use strict';
const fs = require('fs');
const upath = require('upath');
const sh = require('shelljs');

module.exports = function renderAssets() {
    const sourcePath = upath.resolve(upath.dirname(__filename), '../assets');
    const destPath = upath.resolve(upath.dirname(__filename), '../build');

    sh.cp('-R', sourcePath, destPath)
};
