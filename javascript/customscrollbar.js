/**
 * Creates a custom scrollbar from given classes
 * Usage:
 * 
 * window.onload = function() {
 *   ssb.scrollbar(container, scrollbar, scrollbar_over, scrollbar_down); 
 * }
 * 
 * @param {String} container - container Id
 * @param {Array} scrollbar - array of scrollbar classes {track_area, scrollbar, up_button, down_button}
 * @param {Array} scrollbar_over - array of scrollbar:hover classes in the same order
 * @param {Array} scrollbar_down - array of scrollbar:down classes in the same order
 */

var ssb = {
    aConts: [],
    mouseY: 0,
    N: 0,
    asd: 0,
    /*active scrollbar element*/
    sc: 0,
    sp: 0,
    to: 0,
    scrollbar_normal: [],
    scrollbar_over: [],
    scrollbar_down: [],

    // constructor
    scrollbar: function(cont_id, scrollbar, scrollbar_over, scrollbar_down) {
        var cont = document.getElementById(cont_id);

        // perform initialization
        if (!ssb.init()) return false;

        var cont_clone = cont.cloneNode(false);
        cont_clone.style.overflow = "hidden";
        cont.parentNode.appendChild(cont_clone);
        cont_clone.appendChild(cont);
        cont.style.position = 'absolute';
        cont.style.left = cont.style.top = '0px';
        cont.style.width = cont.style.height = '100%';

        // adding new container into array
        ssb.aConts[ssb.N++] = cont;

        cont.sg = false;


        ssb.scrollbar_normal = scrollbar;
        ssb.scrollbar_over = scrollbar_over;
        ssb.scrollbar_down = scrollbar_down;
        //creating scrollbar child elements
        cont.st = this.create_div(scrollbar[0], cont, cont_clone);
        cont.sb = this.create_div(scrollbar[1], cont, cont_clone);
        cont.su = this.create_div(scrollbar[2], cont, cont_clone);
        cont.sd = this.create_div(scrollbar[3], cont, cont_clone);

        // on mouse down processing
        cont.sb.onmousedown = function(e) {
                if (!this.cont.sg) {
                    if (!e) e = window.event;

                    ssb.asd = this.cont;
                    this.cont.yZ = e.screenY;
                    this.cont.sZ = cont.scrollTop;
                    this.cont.sg = true;

                    // new class name
                    this.className = scrollbar[1] + " " + scrollbar_down[1];
                }
                return false;
            }
            // on mouse down on free track area - move our scroll element too
        cont.st.onmousedown = function(e) {
            if (!e) e = window.event;
            ssb.asd = this.cont;

            ssb.mouseY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
            for (var o = this.cont, y = 0; o != null; o = o.offsetParent) y += o.offsetTop;
            this.cont.scrollTop = (ssb.mouseY - y - (this.cont.ratio * this.cont.offsetHeight / 2) - this.cont.sw) / this.cont.ratio;
            this.cont.sb.onmousedown(e);
        }

        // onmousedown events
        cont.su.onmousedown = cont.su.ondblclick = function(e) { ssb.mousedown(this, -1); return false; }
        cont.sd.onmousedown = cont.sd.ondblclick = function(e) { ssb.mousedown(this, 1); return false; }

        //onmouseout events
        cont.su.onmouseout = cont.su.onmouseup = ssb.clear;
        cont.sd.onmouseout = cont.sd.onmouseup = ssb.clear;

        // on mouse over - apply custom class name: ssb_sb_over
        cont.sb.onmouseover = function(e) {
            if (!this.cont.sg) this.className = scrollbar[1] + " " + scrollbar_over[1];
            return false;
        }

        // on mouse out - revert back our usual class name 'ssb_sb'
        cont.sb.onmouseout = function(e) {
            if (!this.cont.sg) this.className = scrollbar[1];
            return false;
        }

        // onscroll - change positions of scroll element
        cont.ssb_onscroll = function() {
            var style = window.getComputedStyle(this.sb);
            this.ratio = (this.offsetHeight - parseFloat(style.getPropertyValue('height'))) / (this.scrollHeight - this.offsetHeight);
            this.sb.style.top = Math.floor(this.scrollTop * this.ratio) + 'px';
        }

        // scrollbar width
        cont.sw = 12;

        // start scrolling
        cont.ssb_onscroll();
        ssb.refresh();

        // binding own onscroll event
        cont.onscroll = cont.ssb_onscroll;
        return cont;
    },

    // initialization
    init: function() {
        if (window.oper || (!window.addEventListener && !window.attachEvent)) { return false; }

        // temp inner function for event registration
        function addEvent(o, e, f) {
            if (window.addEventListener) {
                o.addEventListener(e, f, false);
                ssb.w3c = true;
                return true;
            }

            if (window.attachEvent)
                return o.attachEvent('on' + e, f);

            return false;
        }

        // binding events
        addEvent(window.document, 'mousemove', ssb.onmousemove);
        addEvent(window.document, 'mouseup', ssb.onmouseup);
        addEvent(window, 'resize', ssb.refresh);
        return true;
    },

    // create and append div finc
    create_div: function(c, cont, cont_clone) {
        var o = document.createElement('div');
        o.cont = cont;
        o.className = c;
        cont_clone.appendChild(o);
        return o;
    },
    // do clear of controls
    clear: function() {
        clearTimeout(ssb.to);
        ssb.sc = 0;
        return false;
    },
    // refresh scrollbar
    refresh: function() {
        for (var i = 0, N = ssb.N; i < N; i++) {
            var o = ssb.aConts[i];
            o.ssb_onscroll();
        }
    },
    // arrow scrolling
    arrow_scroll: function() {
        if (ssb.sc != 0) {
            ssb.asd.scrollTop += 6 * ssb.sc / ssb.asd.ratio;
            ssb.to = setTimeout(ssb.arrow_scroll, ssb.sp);
            ssb.sp = 32;
        }
    },

    /* event binded functions : */
    // scroll on mouse down
    mousedown: function(o, s) {
        if (ssb.sc == 0) {
            // new class name
            o.cont.sb.className = scrollbar[1] + " " + scrollbar_down[1];
            ssb.asd = o.cont;
            ssb.sc = s;
            ssb.sp = 400;
            ssb.arrow_scroll();
        }
    },
    // on mouseMove binded event
    onmousemove: function(e) {
        if (!e) e = window.event;
        // get vertical mouse position
        ssb.mouseY = e.screenY;
        if (ssb.asd.sg) ssb.asd.scrollTop = ssb.asd.sZ + (ssb.mouseY - ssb.asd.yZ) / ssb.asd.ratio;
    },
    // on mouseUp binded event
    onmouseup: function(e) {
        if (!e) e = window.event;
        var tg = (e.target) ? e.target : e.srcElement;
        if (ssb.asd && document.releaseCapture) ssb.asd.releaseCapture();


        // new class name
        if (ssb.asd)
            ssb.asd.sb.className = ssb.scrollbar_normal[1];
        document.onselectstart = '';
        ssb.clear();
        ssb.asd.sg = false;

    }
}

// window.onload = function() {
//   ssb.scrollbar('container'); // scrollbar initialization
// }