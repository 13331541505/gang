var a = getApp(), t = a.requirejs("core"), e = a.requirejs("biz/order");

Page({
    data: {
        code: !1,
        consume: !1,
        store: !1,
        cancel: e.cancelArray,
        cancelindex: 0,
        diyshow: {},
        city_express_state: 0
    },
    onLoad: function(t) {
        this.setData({
            options: t
        }), a.url(t);
    },
    onShow: function() {
        this.get_list(), a.getCache("isIpx") ? this.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : this.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        });
    },
    get_list: function() {
        var n = this;
        t.get("order/detail", n.data.options, function(a) {
            if (0 < a.error && (5e4 != a.error && t.toast(a.message, "loading"), wx.redirectTo({
                url: "/pages/order/index"
            })), null != a.nogift[0].fullbackgoods) {
                var e = a.nogift[0].fullbackgoods.fullbackratio, i = a.nogift[0].fullbackgoods.maxallfullbackallratio;
                e = Math.round(e), i = Math.round(i);
            }
            if (0 == a.error) {
                a.show = !0;
                var o = Array.isArray(a.ordervirtual);
                n.setData(a), n.setData({
                    ordervirtualtype: o,
                    fullbackgoods: a.nogift[0].fullbackgoods,
                    maxallfullbackallratio: i,
                    fullbackratio: e,
                    invoice: a.order.invoicename,
                    membercard_info: a.membercard_info
                });
            }
        });
    },
    more: function() {
        this.setData({
            all: !0
        });
    },
    code: function(a) {
        var e = this, i = t.data(a).orderid;
        t.post("verify/qrcode", {
            id: i
        }, function(a) {
            0 == a.error ? e.setData({
                code: !0,
                qrcode: a.url
            }) : t.alert(a.message);
        }, !0);
    },
    diyshow: function(a) {
        var e = this.data.diyshow, i = t.data(a).id;
        e[i] = !e[i], this.setData({
            diyshow: e
        });
    },
    close: function() {
        this.setData({
            code: !1
        });
    },
    toggle: function(a) {
        var e = t.pdata(a), i = e.id, o = {};
        o[e.type] = 0 == i || void 0 === i ? 1 : 0, this.setData(o);
    },
    phone: function(a) {
        t.phone(a);
    },
    cancel: function(t) {
        e.cancel(this.data.options.id, t.detail.value, "/pages/order/detail/index?id=" + this.data.options.id);
    },
    delete: function(a) {
        var i = t.data(a).type;
        e.delete(this.data.options.id, i, "/pages/order/index");
    },
    finish: function(t) {
        e.finish(this.data.options.id, "/pages/order/index");
    },
    refundcancel: function(t) {
        var a = this;
        e.refundcancel(this.data.options.id, function() {
            a.get_list();
        });
    },
    onShareAppMessage: function() {
        return t.onShareAppMessage();
    }
});