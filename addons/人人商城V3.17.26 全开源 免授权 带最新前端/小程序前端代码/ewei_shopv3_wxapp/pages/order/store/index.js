var t = getApp(), e = t.requirejs("core"), s = t.requirejs("jquery");

Page({
    data: {
        search: !1,
        show_distance: !1
    },
    onLoad: function(e) {
        this.setData({
            options: e
        }), t.url(e);
    },
    onReady: function() {},
    onShow: function() {
        this.get_list();
    },
    onHide: function() {},
    get_list: function() {
        var i = this, o = {
            ids: i.data.options.ids,
            type: i.data.options.type,
            merchid: i.data.options.merchid
        };
        wx.getSetting({
            success: function(s) {
                s.authSetting["scope.userLocation"] ? wx.getLocation({
                    type: "wgs84",
                    success: function(t) {
                        o.lat = t.latitude, o.lng = t.longitude, i.setData({
                            show_distance: !0
                        }), e.get("store/selector", o, function(t) {
                            i.setData({
                                list: t.list,
                                show: !0
                            });
                        });
                    },
                    fail: function(t) {
                        setTimeout(function() {
                            e.toast("位置获取失败");
                        }, 1e3), e.get("store/selector", o, function(t) {
                            i.setData({
                                list: t.list,
                                show: !0
                            });
                        });
                    }
                }) : wx.authorize({
                    scope: "scope.userLocation",
                    success: function() {
                        wx.getLocation({
                            type: "wgs84",
                            success: function(t) {
                                o.lat = t.latitude, o.lng = t.longitude, i.setData({
                                    show_distance: !0
                                }), e.get("store/selector", o, function(t) {
                                    i.setData({
                                        list: t.list,
                                        show: !0
                                    });
                                });
                            },
                            fail: function(t) {
                                setTimeout(function() {
                                    e.toast("位置获取失败");
                                }, 1e3), e.get("store/selector", o, function(t) {
                                    i.setData({
                                        list: t.list,
                                        show: !0
                                    });
                                });
                            }
                        });
                    },
                    fail: function(e) {
                        s.authSetting["scope.userLocation"] && wx.showModal({
                            title: "警告",
                            content: "位置信息获取受限，请点击确定打开授权页面,在打开的页面中开启位置信息授权",
                            success: function(e) {
                                e.confirm && wx.openSetting({
                                    success: function(t) {
                                        wx.navigateBack();
                                    }
                                }), e.cancel && t.close();
                            }
                        });
                    }
                });
            }
        });
    },
    bindSearch: function(t) {
        this.setData({
            search: !0
        });
    },
    phone: function(t) {
        e.phone(t);
    },
    select: function(s) {
        var i = e.pdata(s).index;
        t.setCache("orderShop", this.data.list[i], 30), wx.navigateBack();
    },
    search: function(t) {
        var i = t.detail.value, e = this.data.old_list, o = this.data.list, n = [];
        s.isEmptyObject(e) && (e = o), s.isEmptyObject(e) || s.each(e, function(t, e) {
            -1 != e.storename.indexOf(i) && n.push(e);
        }), this.setData({
            list: n,
            old_list: e
        });
    }
});