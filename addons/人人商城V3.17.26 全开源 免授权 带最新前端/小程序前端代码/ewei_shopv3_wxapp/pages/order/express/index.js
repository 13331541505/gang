var t = getApp(), s = t.requirejs("core");

Page({
    data: {},
    onLoad: function(s) {
        this.setData({
            options: s
        }), t.url(s), this.get_list();
    },
    get_list: function() {
        var e = this;
        s.get("order/express", e.data.options, function(t) {
            0 == t.error ? (t.show = !0, e.setData(t)) : s.toast(t.message, "loading");
        });
    }
});