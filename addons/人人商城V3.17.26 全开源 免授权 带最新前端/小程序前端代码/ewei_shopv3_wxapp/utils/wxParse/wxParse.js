var e = require("../../@babel/runtime/helpers/interopRequireDefault"), t = e(require("./showdown.js")), a = e(require("./html2json.js")), i = 0, r = 0;
function n(e) {
    var t = e.target.dataset.src, a = e.target.dataset.from;
    void 0 !== a && a.length > 0 && wx.previewImage({
        current: t,
        urls: this.data[a].imageUrls
    });
}

function d(e) {
    var t = e.target.dataset.from, a = e.target.dataset.idx;
    void 0 !== t && t.length > 0 && function(e, t, a, n) {
        var d = a.data[n];
        if (!d || 0 == d.images.length) return;
        var o = d.images, s = function(e, t, a, n) {
            var d = 0, o = 0, s = 0, g = {}, h = a.data[n].view.imagePadding;
            r, e > (d = i - 2 * h) ? (s = (o = d) * t / e, g.imageWidth = o, g.imageheight = s) : (g.imageWidth = e, 
            g.imageheight = t);
            (i <= 0 || r <= 0) && wx.getSystemInfo({
                success: function(t) {
                    i = t.windowWidth, r = t.windowHeight, g.imageWidth = e > i ? i - 2 * h : e;
                }
            });
            return g;
        }(e.detail.width, e.detail.height, a, n), g = o[t].index, h = "".concat(n), l = !0, m = !1, v = void 0;
        try {
            for (var u, w = g.split(".")[Symbol.iterator](); !(l = (u = w.next()).done); l = !0) {
                var f = u.value;
                h += ".nodes[".concat(f, "]");
            }
        } catch (e) {
            m = !0, v = e;
        } finally {
            try {
                l || null == w.return || w.return();
            } finally {
                if (m) throw v;
            }
        }
        var c = h + ".width", x = h + ".height";
        a.setData({
            [c]: s.imageWidth,
            [x]: s.imageheight
        });
    }(e, a, this, t);
}

wx.getSystemInfo({
    success: function(e) {
        i = e.windowWidth, r = e.windowHeight;
    }
}), module.exports = {
    wxParse: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "wxParseData", i = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "html", r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : '<div class="color:red;">数据不能为空</div>', o = arguments.length > 3 ? arguments[3] : void 0, s = arguments.length > 4 ? arguments[4] : void 0;
        if (r && "" != r) {
            var g = o, h = {};
            if ("html" == i) h = a.default.html2json(r, e); else if ("md" == i || "markdown" == i) {
                var l = new t.default.Converter().makeHtml(r);
                h = a.default.html2json(l, e);
            }
            h.view = {}, h.view.imagePadding = 0, void 0 !== s && (h.view.imagePadding = s);
            var m = {};
            m[e] = h, g.setData(m), g.wxParseImgLoad = d, g.wxParseImgTap = n;
        }
    },
    wxParseTemArray: function(e, t, a, i) {
        for (var r = [], n = i.data, d = null, o = 0; o < a; o++) {
            var s = n[t + o].nodes;
            r.push(s);
        }
        e = e || "wxParseTemArray", (d = JSON.parse('{"' + e + '":""}'))[e] = r, i.setData(d);
    },
    emojisInit: function() {
        var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "", t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "/wxParse/emojis/", i = arguments.length > 2 ? arguments[2] : void 0;
        a.default.emojisInit(e, t, i);
    }
};