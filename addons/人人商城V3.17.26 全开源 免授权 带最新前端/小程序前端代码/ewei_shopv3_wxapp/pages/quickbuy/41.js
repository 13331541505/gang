var t = getApp(), a = t.requirejs("core"), e = t.requirejs("biz/goodspicker"), r = t.requirejs("foxui"), i = t.requirejs("biz/diyform");

Page({
    data: {
        arrLabel: [],
        num: [],
        clickCar: !1,
        num: 0,
        change: !1,
        div: !1,
        numtotal: {},
        clearcart: !0,
        canBuy: "",
        specs: [],
        options: [],
        diyform: {},
        specsTitle: "",
        total: 1,
        active: "",
        slider: "",
        tempname: "",
        buyType: "",
        areas: [],
        closeBtn: !1,
        soundpic: !0,
        closespecs: !1,
        buyType: "cart",
        quickbuy: !0,
        formdataval: {},
        showPicker: !1
    },
    onLoad: function(e) {
        wx.showLoading({
            title: "加载中..."
        });
        var r = e.id;
        if (null == r) {
            var i = getCurrentPages(), s = i[i.length - 1].route.split("/");
            r = s[s.length - 1];
        }
        var n = this, o = wx.getStorageSync("systemInfo");
        this.busPos = {}, this.busPos.x = 45, this.busPos.y = t.globalData.hh - 80, this.setData({
            goodsH: o.windowHeight - 245 - 48,
            pageid: r
        });
        for (var d = [ 1 ], c = 1; c < n.data.arrLabel.length; c++) d.push(0);
        n.setData({
            arrLab: d
        }), a.get("quick/index/main", {
            id: this.data.pageid
        }, function(t) {
            var e = [], r = "";
            r = 1 == t.style.shopstyle ? "changeCss2" : 2 == t.style.shopstyle ? "changeCss3" : "", 
            r += " " + t.style.logostyle, n.setData({
                main: t,
                group: t.group,
                goodsArr: t.goodsArr,
                arrCart: e,
                style: r
            });
            var i = 1 == n.data.main.cartdata && n.data.pageid;
            if (n.data.main.advs) {
                if (n.data.main.advs.length > 0) {
                    e = [ 198 ];
                    var s = 198;
                }
            } else e = [ 18 ], s = 18;
            for (var o = 0; o < n.data.main.group.length; o++) {
                if (n.data.main.goodsArr[n.data.main.group[o].type]) s = s + 106 * (n.data.main.goodsArr[n.data.main.group[o].type].length ? n.data.main.goodsArr[n.data.main.group[o].type].length : .6) + 66, 
                e.push(s), n.setData({
                    arrscroll: e
                });
            }
            i = 1 == n.data.main.cartdata ? n.data.pageid : "";
            a.get("quick/index/getCart", {
                quickid: i
            }, function(t) {
                var a = {};
                for (var e in t.simple_list) a[e] = t.simple_list[e];
                n.setData({
                    numtotal: a
                });
            }), wx.hideLoading(), wx.setNavigationBarTitle({
                title: t.pagetitle
            });
        });
    },
    menunavigage: function(t) {
        var a = t.currentTarget.dataset.url;
        wx.navigateTo({
            url: a,
            fail: function() {
                wx.switchTab({
                    url: a
                });
            }
        });
    },
    gobigimg: function(t) {
        wx.navigateTo({
            url: t.currentTarget.dataset.link
        });
    },
    clickLab: function(t) {
        for (var a = t.currentTarget.dataset.id, e = this.data.arrLab, r = 0; r < e.length; r++) e[r] = 0;
        e[a] = 1, this.setData({
            arrLab: e,
            id: t.currentTarget.dataset.id
        });
    },
    shopCarList: function() {
        var t = this;
        this.setData({
            clickCar: !0,
            cartcartArr: [],
            showPicker: !0
        });
        var e = 1 == this.data.main.cartdata ? this.data.pageid : "";
        a.get("quick/index/getCart", {
            quickid: e
        }, function(a) {
            var e = t.data.main;
            e.cartList = a, t.setData({
                main: e
            });
            for (var r = [], i = 0; i < a.list.length; i++) r[i] = a.list[i].goodsid;
            t.setData({
                tempcartid: r
            });
        });
    },
    shopCarHid: function() {
        this.setData({
            clickCar: !1,
            showPicker: !1
        });
    },
    selectPicker: function(t) {
        var a = this;
        wx.getSetting({
            success: function(r) {
                if (r.authSetting["scope.userInfo"]) {
                    e.selectpicker(t, a, "goodslist"), a.setData({
                        cover: "",
                        showvideo: !1
                    });
                } else a.setData({
                    modelShow: !0
                });
            }
        });
    },
    specsTap: function(t) {
        e.specsTap(t, this);
    },
    emptyActive: function() {
        this.setData({
            active: "",
            slider: "out",
            tempname: "",
            specsTitle: "",
            showPicker: !1
        });
    },
    buyNow: function(t) {
        e.buyNow(t, this);
    },
    getCart: function(t) {
        e.getCart(t, this);
    },
    select: function() {
        e.select(this);
    },
    inputNumber: function(t) {
        e.inputNumber(t, this);
    },
    number: function(t) {
        e.number(t, this);
    },
    onChange: function(t) {
        return i.onChange(this, t);
    },
    DiyFormHandler: function(t) {
        return i.DiyFormHandler(this, t);
    },
    selectArea: function(t) {
        return i.selectArea(this, t);
    },
    bindChange: function(t) {
        return i.bindChange(this, t);
    },
    onCancel: function(t) {
        return i.onCancel(this, t);
    },
    onConfirm: function(t) {
        return i.onConfirm(this, t);
    },
    getIndex: function(t, a) {
        return i.getIndex(t, a);
    },
    closespecs: function() {
        this.setData({
            closespecs: !1
        });
    },
    onPageScroll: function(t) {},
    onShow: function() {},
    onReachBottom: function() {},
    addCartquick: function(t, e) {
        var i = this, s = i.data.numtotal, n = 1 == this.data.main.cartdata ? this.data.pageid : "";
        a.get("quick/index/update", {
            quickid: n,
            goodsid: i.data.goodsid,
            optionid: t || "",
            update: "",
            total: "",
            type: i.data.addtype,
            typevalue: e || "",
            diyformdata: i.data.formdataval ? i.data.formdataval : ""
        }, function(t) {
            if (0 != t.error) i.setData({
                cantclick: !0
            }), r.toast(i, t.message), i.setData({
                active: "",
                slider: "out",
                isSelected: !0,
                tempname: "",
                showPicker: !1
            }); else {
                var a = i.data.main;
                a.cartList.total = t.total, a.cartList.totalprice = t.totalprice, a.cartList.list = [ 1 ], 
                s[i.data.goodsid] = t.goodstotal, i.setData({
                    numtotal: s,
                    main: a,
                    clearcart: !0,
                    active: "",
                    slider: "out",
                    isSelected: !0,
                    tempname: "",
                    showPicker: !1,
                    formdataval: {}
                }), i.data.addtype;
            }
        });
    },
    addGoodToCartFn: function(a) {
        t.checkAuth();
        var i = 1 == this.data.main.cartdata ? "takeoutmodel" : "shopmodel";
        if (a.currentTarget.dataset.canadd || (i = "cantaddcart"), this.setData({
            morechose: a.currentTarget.dataset.more
        }), this.setData({
            addtype: a.currentTarget.dataset.add,
            goodsid: a.currentTarget.dataset.id,
            mouse: a
        }), "reduce" == this.data.addtype && a.currentTarget.dataset.min == a.currentTarget.dataset.num && this.setData({
            addtype: "delete"
        }), "1" == a.currentTarget.dataset.more && "reduce" == this.data.addtype) r.toast(this, "请在购物车中修改多规格商品"); else if ("reduce" == this.data.addtype && a.currentTarget.dataset.min == a.currentTarget.dataset.num) r.toast(this, "不能少于" + a.currentTarget.dataset.min + "件商品"); else if ("1" == a.currentTarget.dataset.more || "0" != a.currentTarget.dataset.diyformtype || !a.currentTarget.dataset.canadd) if ("reduce" != this.data.addtype && "delete" != this.data.addtype) {
            this.setData({
                showPicker: !0,
                cycledate: !1
            }), e.selectpicker(a, this, "quickbuy", i);
        } else this.setData({
            storenum: a.currentTarget.dataset.store,
            maxnum: a.currentTarget.dataset.maxnum
        }), this.addCartquick("", 1);
        "1" != a.currentTarget.dataset.more && "0" == a.currentTarget.dataset.diyformtype && a.currentTarget.dataset.canadd && (this.setData({
            storenum: a.currentTarget.dataset.store,
            maxnum: a.currentTarget.dataset.maxnum
        }), "reduce" == this.data.addtype && a.currentTarget.dataset.min == a.currentTarget.dataset.num ? r.toast(this, "不能少于" + a.currentTarget.dataset.min + "件商品") : this.addCartquick("", 1));
    },
    animate: function(t) {
        this.finger = {};
        var a = {};
        this.finger.x = t.touches[0].clientX, this.finger.y = t.touches[0].clientY, this.finger.y < this.busPos.y ? a.y = this.finger.y - 150 : a.y = this.busPos.y - 150, 
        a.x = Math.abs(this.finger.x - this.busPos.x) / 2, this.finger.x > this.busPos.x ? a.x = (this.finger.x - this.busPos.x) / 2 + this.busPos.x : a.x = (this.busPos.x - this.finger.x) / 2 + this.finger.x, 
        this.linePos = this.bezier([ this.busPos, a, this.finger ], 30), this.startAnimation(t);
    },
    bezier: function(t, a) {
        for (var e, r, i, s = [], n = 0; n <= a; n++) {
            for (i = t.slice(0), r = []; e = i.shift(); ) if (i.length) r.push(o([ e, i[0] ], n / a)); else {
                if (!(r.length > 1)) break;
                i = r, r = [];
            }
            s.push(r[0]);
        }
        function o(t, a) {
            var e, r, i, s, n, o, d, c;
            return e = t[0], s = (r = t[1]).x - e.x, n = r.y - e.y, i = Math.pow(Math.pow(s, 2) + Math.pow(n, 2), .5), 
            o = n / s, d = Math.atan(o), c = i * a, {
                x: e.x + c * Math.cos(d),
                y: e.y + c * Math.sin(d)
            };
        }
        return {
            bezier_points: s
        };
    },
    startAnimation: function(t) {
        var a = 0, e = this, r = e.linePos.bezier_points;
        this.setData({
            hide_good_box: !1,
            bus_x: e.finger.x,
            bus_y: e.finger.y
        });
        var i = r.length;
        a = i, this.timer = setInterval(function() {
            a--, e.setData({
                bus_x: r[a].x,
                bus_y: r[a].y
            }), a < 1 && (clearInterval(e.timer), e.setData({
                hide_good_box: !0
            }));
        }, 13);
    },
    clearShopCartFn: function(t) {
        var e = this, r = 1 == this.data.main.cartdata ? this.data.pageid : "";
        a.get("quick/index/clearCart", {
            quickid: r
        }, function(t) {
            var a = e.data.main;
            a.cartList = {
                list: [],
                total: 0,
                totalprice: 0
            };
            for (var r = e.data.tempcartid, i = [], s = 0; s < r.length; s++) i[Number(r[s])] = -1;
            e.setData({
                main: a,
                clickCar: !1,
                numtotal: i,
                clearcart: !1,
                showPicker: !1
            });
        });
    },
    closemulti: function() {
        this.setData({
            showPicker: !1,
            clickCar: !1,
            cycledate: !0
        });
    },
    gopay: function() {
        var t = 1 == this.data.main.cartdata ? this.data.pageid : "";
        this.data.main.cartList.list.length ? wx.navigateTo({
            url: "/pages/order/create/index?fromquick=" + t
        }) : r.toast(this, "请先添加商品到购物车");
    },
    gotocart: function() {
        var t = "/pages/member/cart/index";
        wx.navigateTo({
            url: t,
            fail: function() {
                wx.switchTab({
                    url: t
                });
            }
        });
    },
    cartaddcart: function(t) {
        var e = this, i = 1 == this.data.main.cartdata ? this.data.pageid : "", s = "0" == t.currentTarget.dataset.id ? t.currentTarget.dataset.goodsid : t.currentTarget.dataset.id, n = t.currentTarget.dataset.add;
        t.currentTarget.dataset.min == t.currentTarget.dataset.num && "reduce" == n && (n = "delete"), 
        a.get("quick/index/update", {
            quickid: i,
            goodsid: t.currentTarget.dataset.goodsid,
            optionid: "0" == t.currentTarget.dataset.id ? "" : t.currentTarget.dataset.id,
            update: "",
            total: "",
            type: n,
            typevalue: 1
        }, function(a) {
            if (0 == a.error) {
                var i = e.data.cartcartArr;
                i[s] = a.goodsOptionTotal || 0 == a.goodsOptionTotal ? a.goodsOptionTotal : a.goodstotal;
                var n = e.data.main;
                n.cartList.total = a.total, n.cartList.totalprice = a.totalprice;
                var o = e.data.numtotal;
                o[t.currentTarget.dataset.goodsid] = a.goodstotal, e.setData({
                    cartcartArr: i,
                    main: n,
                    numtotal: o
                });
            } else r.toast(e, a.message);
        });
    },
    scrollfn: function(t) {
        for (var a = this.data.arrLab, e = 0; e < this.data.arrscroll.length; e++) if (a[e] = 0, 
        Math.abs(t.detail.scrollTop - this.data.arrscroll[e]) < 26) {
            a[e] = 1, this.setData({
                arrLab: a
            });
            break;
        }
    },
    onShareAppMessage: function(t) {}
});