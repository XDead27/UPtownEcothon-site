'use strict';

/**
 * Gets computed translate values
 * @param {HTMLElement} element
 * @returns {Object}
 */
function getTranslateValues (element) {
    const style = window.getComputedStyle(element)
    const matrix = style['transform'] || style.webkitTransform || style.mozTransform

    // No transform property. Simply return 0 values.
    if (matrix === 'none') {
        return {
            x: 0,
            y: 0,
            z: 0
        }
    }

    // Can either be 2d or 3d transform
    const matrixType = matrix.includes('3d') ? '3d' : '2d'
    const matrixValues = matrix.match(/matrix.*\((.+)\)/)[1].split(', ')

    // 2d matrices have 6 values
    // Last 2 values are X and Y.
    // 2d matrices does not have Z value.
    if (matrixType === '2d') {
        return {
            x: matrixValues[4],
            y: matrixValues[5],
            z: 0
        }
    }

    // 3d matrices have 16 values
    // The 13th, 14th, and 15th values are X, Y, and Z
    if (matrixType === '3d') {
        return {
            x: matrixValues[12],
            y: matrixValues[13],
            z: matrixValues[14]
        }
    }
}

//elem - element to modify; func - function to change by; duration - total duration of transition;
var transitions = {
    slide2DPercentageParent: function(elem, func, duration, toX, toY){
        let start = Date.now();

        var fromX = parseInt(elem.style.left) || 0;
        var fromY = parseInt(elem.style.top) || 0;

        //Maybe they are not set as element properties
        if(!fromX || !fromY){
            fromX = (elem.offsetLeft/elem.parentElement.clientWidth)*100;
            fromY = (elem.offsetTop/elem.parentElement.clientHeight)*100;
        }

        function tick() {
            let now = Date.now();
            let elapsed = now - start;
            let valX = func(elapsed, fromX, toX, duration);
            let valY = func(elapsed, fromY, toY, duration);

            elem.style.left = valX + "%";
            elem.style.top = valY + "%";

            if (elapsed < duration) {
                requestAnimationFrame(tick);
            }
            
        }

        requestAnimationFrame(tick);
    },

    //toX/toY - final coordinates
    slide2DAbsoluteParent: function(elem, func, duration, toX, toY){
        let start = Date.now();
        var fromX = parseFloat(getTranslateValues(elem).x) || 0;
        var fromY = parseFloat(getTranslateValues(elem).y) || 0;

        toX = (toX/100) * elem.parentElement.clientWidth - elem.offsetLeft;
        toY = (toY/100) * elem.parentElement.clientHeight - elem.offsetTop;


        //alert(toX + ", " + toY);
        //alert(fromX + ", " + fromY);

        function tick() {
            let now = Date.now();
            let elapsed = now - start;
            let valX = func(elapsed, fromX, toX, duration);
            let valY = func(elapsed, fromY, toY, duration);

            var translate = "translate(" + valX + "px, " + valY + "px)";
            //var translate = "aa";

            elem.style.transform = translate;
            //alert(elem.style.transform);
            if (elapsed < duration) {
                requestAnimationFrame(tick);
            }
            
        }

        requestAnimationFrame(tick);
    },

    fadeIn: function(elem, func, duration){
        let start = Date.now();

        var from = parseFloat(elem.style.opacity) || 0;
        var to = 1.0;

        function tick() {
            let now = Date.now();
            let elapsed = now - start;
            let val = func(elapsed, from, to, duration);

            elem.style.opacity = val;

            if (elapsed < duration) {
                requestAnimationFrame(tick);
            }
        }

        requestAnimationFrame(tick);
    },

    fadeOut: function(elem, func, duration) {
        let start = Date.now();

        var from = parseFloat(elem.style.opacity) || 1;
        var to = 0;

        function tick() {
            let now = Date.now();
            let elapsed = now - start;
            let val = func(elapsed, from, to, duration);

            elem.style.opacity = val;

            if (elapsed < duration) {
                requestAnimationFrame(tick);
            }
        }

        requestAnimationFrame(tick);
    },

    scaleUniform: function(elem, func, to, duration) {
        let start = Date.now();

        var from = parseFloat(elem.style.scale) || 1.0;

        function tick() {
            let now = Date.now();
            let elapsed = now - start;
            let val = func(elapsed, from, to, duration);

            elem.style.scale = val;

            if (elapsed < duration) {
                requestAnimationFrame(tick);
            }
        }

        requestAnimationFrame(tick);
    },

    scale2D: function(elem, func, toX, toY, duration) {
        
    }
  
};

//module.exports = transitions;