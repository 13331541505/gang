var t = getApp(), e = t.requirejs("core"), o = (t.requirejs("icons"), t.requirejs("foxui"));

t.requirejs("wxParse/wxParse"), t.requirejs("jquery");

Page({
    data: {
        options: [],
        log: [],
        logid: 0,
        store: [],
        stores: [],
        goods: [],
        verifynum: 0,
        replyset: [],
        ordercredit: 0,
        ordermoney: 0,
        address: [],
        carrier: [],
        shop: [],
        allmoney: [],
        togglestore: "",
        togglecode: "",
        verify: [],
        iswechat: !0,
        paymentmodal: !1
    },
    onLoad: function(t) {
        var e = this;
        t = t || {}, wx.getSystemInfo({
            success: function(t) {
                e.setData({
                    windowWidth: t.windowWidth,
                    windowHeight: t.windowHeight
                });
            }
        }), e.setData({
            options: t,
            logid: t.id
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this;
        t.getCache("isIpx") ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), e.getDetail(), wx.getSetting({
            success: function(t) {
                var o = t.authSetting["scope.userInfo"];
                e.setData({
                    limits: o
                });
            }
        });
    },
    getDetail: function() {
        var t = this, o = t.data.options;
        e.get("creditshop/log/detail", o, function(s) {
            if (0 == s.error) {
                var i = parseFloat(s.ordermoney) + parseFloat(s.log.dispatch);
                t.setData({
                    log: s.log,
                    store: s.store,
                    stores: s.stores,
                    goods: s.goods,
                    verifynum: s.verifynum,
                    log: s.log,
                    replyset: s.set,
                    ordercredit: s.ordercredit,
                    ordermoney: s.ordermoney,
                    address: s.address,
                    carrier: s.carrier,
                    shop: s.shop,
                    allmoney: i,
                    verify: s.verify,
                    credittext: s.sysset.texts.credit
                });
                var a = 0;
                0 == s.goods.isverify && s.address.lenght > 0 && e.get("creditshop/dispatch", {
                    goodsid: s.goods.id,
                    optionid: o.id
                }, function(e) {
                    a = e.dispatch, t.setData({
                        dispatchprice: a
                    });
                }), a = parseFloat(a) + parseFloat(s.goods.money), t.setData({
                    allprice: a
                });
            }
        });
    },
    toggle: function(t) {
        "" == this.data.togglestore ? this.setData({
            togglestore: "toggleSend-group"
        }) : this.setData({
            togglestore: ""
        });
    },
    togglecode: function(t) {
        var e = this.data.togglecode;
        "" == e ? this.setData({
            togglecode: "toggleSend-group"
        }) : this.setData({
            togglecode: ""
        });
    },
    finish: function() {
        var t = this;
        wx.showModal({
            title: "提示",
            content: "确认已收到货了吗？",
            success: function(s) {
                if (s.confirm) {
                    var i = t.data.log.id;
                    e.get("creditshop/log/finish", {
                        id: i
                    }, function(e) {
                        0 == e.error ? (o.toast(t, "确认收货"), t.onShow()) : o.toast(t, e.message);
                    });
                }
            }
        });
    },
    paydispatch: function(t) {
        var o = this, s = "";
        s = "dispatch" == t.currentTarget.dataset.paytype ? "确认兑换并支付运费吗" : "确认兑换吗", wx.showModal({
            title: "提示",
            content: s,
            success: function(t) {
                if (t.confirm) {
                    var s = o.data.log.id, i = o.data.goods.dispatch;
                    e.get("creditshop/log/paydispatch", {
                        id: s,
                        addressid: o.data.address.id,
                        dispatchprice: i
                    }, function(t) {
                        t.error > 0 ? fui.toast(o, t.message) : t.wechat && t.wechat.success && e.pay(t.wechat.payinfo, function(t) {
                            "requestPayment:ok" == t.errMsg && o.payResult();
                        });
                    });
                }
            }
        });
    },
    payResult: function() {
        var t = this;
        e.get("creditshop/log/paydispatchresult", {
            id: t.data.log.id
        }, function(e) {
            e.error > 0 ? fui.toast(t, e.message) : t.onShow();
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});