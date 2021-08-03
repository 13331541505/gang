var t = getApp(), a = t.requirejs("core"), e = t.requirejs("wxParse/wxParse"), i = t.requirejs("biz/diypage"), s = t.requirejs("biz/diyform"), n = t.requirejs("biz/goodspicker"), o = (t.requirejs("foxui"), 
t.requirejs("jquery"));

Page({
    onPullDownRefresh: function() {
        var t = this;
        i.get(this, "home", function(a) {
            t.getDiypage(a), 0 == a.error && wx.stopPullDownRefresh();
        });
    },
    data: {
        imgUrls: [ "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1509963648306&di=1194f5980cccf9e5ad558dfb18e895ab&imgtype=0&src=http%3A%2F%2Fd.hiphotos.baidu.com%2Fzhidao%2Fpic%2Fitem%2F9c16fdfaaf51f3de87bbdad39ceef01f3a29797f.jpg", "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1509963737453&di=b1472a710a2c9ba30808fd6823b16feb&imgtype=0&src=http%3A%2F%2Fwww.qqzhi.com%2Fwenwen%2Fuploads%2Fpic.wenwen.soso.com%2Fp%2F20160830%2F20160830220016-586751007.jpg", "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=3004162400,3684436606&fm=11&gp=0.jpg" ],
        indicatorDotss: !0,
        autoplays: !0,
        intervals: 2e3,
        durations: 500,
        circulars: !0,
        adveradmin: !0,
        current: 0,
        clock: "",
        diypage: "true",
        route: "home",
        icons: t.requirejs("icons"),
        shop: {},
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 500,
        circular: !0,
        storeRecommand: [],
        total: 1,
        page: 1,
        loaded: !1,
        loading: !0,
        indicatorDotsHot: !1,
        autoplayHot: !0,
        intervalHot: 5e3,
        durationHOt: 1e3,
        circularHot: !0,
        hotimg: "/static/images/hotdot.jpg",
        notification: "/static/images/notification.png",
        saleout1: "/static/images/saleout-1.png",
        saleout2: "/static/images/saleout-2.png",
        saleout3: "/static/images/saleout-3.png",
        play: "/static/images/video_play.png",
        mute: "/static/images/icon/mute.png",
        voice: "/static/images/icon/voice.png",
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
        soundpic: !1,
        sound: !0,
        modelShow: !1,
        limits: !0,
        result: {},
        showcoupon: !1,
        showcoupontips: !1,
        topmenu: {},
        topmenuDataType: "",
        tabbarData: {},
        tabbarDataType: "",
        istopmenu: !1,
        seckillinfo: {},
        timer: 0,
        lasttime: 0,
        hour: "-",
        min: "-",
        sec: "-"
    },
    getShop: function() {
        var t = this;
        a.get("shop/get_shopindex", {}, function(a) {
            e.wxParse("wxParseData", "html", a.copyright, t, "5"), t.setData({
                shop: a
            });
        });
    },
    onReachBottom: function() {
        this.data.loaded || this.data.storeRecommand.length == this.data.total || this.getRecommand();
    },
    getRecommand: function() {
        var t = this;
        "true" != t.data.diypage && a.get("shop/get_recommand", {
            page: t.data.page
        }, function(a) {
            var e = {
                loading: !1,
                total: a.total
            };
            t.setData({
                loading: !1,
                total: a.total,
                show: !0
            }), a.list || (a.list = []), a.list.length > 0 && (t.setData({
                storeRecommand: t.data.storeRecommand.concat(a.list),
                page: a.page + 1
            }), a.list.length < a.pagesize && (e.loaded = !0));
        });
    },
    onLoad: function(e) {
        wx.hideTabBar({}), e = e || {};
        var i = this;
        i.setData({
            imgUrl: t.globalData.approot
        }), a.get("black", {}, function(t) {
            t.isblack && wx.showModal({
                title: "无法访问",
                content: "您在商城的黑名单中，无权访问！",
                success: function(t) {
                    t.confirm && i.close(), t.cancel && i.close();
                }
            });
        });
        var s = decodeURIComponent(e.scene);
        if (!e.id && s) {
            var n = a.str2Obj(s);
            e.id = n.id, n.mid && (e.mid = n.mid, t.setCache("usermid", n));
        }
        setTimeout(function() {
            i.setData({
                areas: t.getCache("cacheset").areas
            });
        }, 3e3), t.url(e), wx.getSetting({
            success: function(t) {
                t.authSetting["scope.userInfo"] ? i.diypageGet() : a.get("wxAppSetting", {}, function(t) {
                    t.sysset.force_auth, i.diypageGet();
                });
            }
        }), i.setData({
            cover: !0,
            showvideo: !1
        }), wx.getSystemInfo({
            success: function(t) {
                var a = t.windowWidth / 1.7;
                i.setData({
                    swiperheight: a
                });
            }
        });
    },
    diypageGet: function() {
        var a = this;
        i.get(this, "home", function(e) {
            if (wx.showTabBar({}), a.getDiypage(e), null != a.data.startadv && "" != a.data.startadv) {
                0 != a.data.startadv.status && "" != a.data.startadv || wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userInfo"] && a.get_nopayorder();
                    }
                });
                var i = a.data.startadv.params;
                if ("default" == i.style) {
                    var s = i.autoclose;
                    !function t(e) {
                        a.setData({
                            clock: s
                        }), s <= 0 ? a.setData({
                            adveradmin: !1
                        }) : setTimeout(function() {
                            s -= 1, t(e);
                        }, 1e3);
                    }(a);
                }
                if (1 == i.showtype) {
                    var n = 1e3 * i.showtime * 60, o = t.getCache("startadvtime"), r = +new Date(), d = !0;
                    a.setData({
                        adveradmin: !0
                    }), o && r - o < n && (d = !1), a.setData({
                        adveradmin: d
                    }), d && t.setCache("startadvtime", r);
                }
                a.data.startadv.status;
            }
        });
    },
    onHide: function() {
        this.setData({
            adveradmin: !1,
            unpaid: !1
        });
    },
    onShow: function() {
        var a = this, e = wx.getSystemInfoSync(), i = t.getCache("sysset");
        a.getShop(), a.getRecommand(), a.get_hasnewcoupon(), a.get_cpinfos(), wx.getSetting({
            success: function(t) {
                var e = t.authSetting["scope.userInfo"];
                a.setData({
                    limits: e
                });
            }
        });
        var s = i.shopname || "商城首页";
        a.data.pages && "" != a.data.pages.title && (s = a.data.diytitle), wx.setNavigationBarTitle({
            title: s
        }), a.data.pages && wx.setNavigationBarColor({
            frontColor: a.data.pages.titlebarcolor,
            backgroundColor: a.data.pages.titlebarbg
        }), a.setData({
            screenWidth: e.windowWidth
        });
    },
    goodsicon: function(t) {
        this.setData({
            iconheight: t.detail.height,
            iconwidth: t.detail.width
        });
    },
    getDiypage: function(t) {
        var e = this;
        o.each(t.diypage.items, function(t, i) {
            if ("topmenu" == i.id) if (e.setData({
                topmenu: i
            }), null == i.data[0]) var s = ""; else {
                s = i.data[0].linkurl;
                a.get("diypage/getInfo", {
                    dataurl: s
                }, function(t) {
                    i.data[0].data = t.goods.list;
                });
            }
            if ("seckillgroup" == i.id) {
                var n = {};
                n.status = i.data.status, n.endtime = i.data.endtime, n.starttime = i.data.starttime, 
                e.initSeckill(n);
            }
        });
    },
    onShareAppMessage: function() {
        var t = null, e = null;
        return this.data.diytitle && (t = "/pages/index/index", e = this.data.diytitle), 
        a.onShareAppMessage(t, e);
    },
    imagesHeight: function(t) {
        var a = t.detail.width, e = t.detail.height, i = t.target.dataset.type, s = this;
        wx.getSystemInfo({
            success: function(t) {
                s.data.result[i] = t.windowWidth / a * e, (!s.data[i] || s.data[i] && result[i] < s.data[i]) && s.setData({
                    result: s.data.result
                });
            }
        });
    },
    bindInput: function(t) {
        this.setData({
            inputValue: t.detail.value
        });
    },
    t1: function(t) {
        i.fixedsearch(this, t);
    },
    startplay: function(t) {
        var a = t.target.dataset.cover;
        this.setData({
            cover: a,
            showvideo: !0
        }), this.videoContext = wx.createVideoContext("Video"), this.videoContext.play();
    },
    unpaidcolse: function(t) {
        var a = "";
        a = "open" == t.target.dataset.type, this.setData({
            unpaid: a
        });
    },
    unpaidcolse2: function(t) {
        this.setData({
            unpaidhide: !0
        });
    },
    get_nopayorder: function() {
        var t = this;
        a.get("shop/get_nopayorder", {}, function(a) {
            1 == a.hasinfo && t.setData({
                nopaygoods: a.goods,
                nopaygoodstotal: a.goodstotal,
                nopayorder: a.order,
                unpaid: !0
            });
        });
    },
    get_hasnewcoupon: function() {
        var t = this;
        a.get("shop/get_hasnewcoupon", {}, function(a) {
            1 == a.hasnewcoupon && t.setData({
                showcoupontips: !0
            });
        });
    },
    get_cpinfos: function() {
        var t = this;
        a.get("shop/get_cpinfos", {}, function(a) {
            1 == a.hascpinfos && t.setData({
                showcoupon: !0,
                cpinfos: a.cpinfos
            });
        });
    },
    adverclose: function() {
        this.setData({
            adveradmin: !1
        }), this.get_nopayorder();
    },
    indexChangebtn: function(t) {
        var a = t.currentTarget.dataset.type;
        wx.navigateTo({
            url: a,
            fail: function() {
                wx.switchTab({
                    url: a
                });
            }
        });
    },
    unpaidcolse: function(t) {
        var a = "";
        a = "open" == t.target.dataset.type, this.setData({
            unpaid: a
        });
    },
    unpaidcolse2: function(t) {
        this.setData({
            unpaidhide: !0
        });
    },
    selectPicker: function(a) {
        t.checkAuth();
        var e = this;
        wx.getSetting({
            success: function(t) {
                if (t.authSetting["scope.userInfo"]) {
                    n.selectpicker(a, e, "goodslist"), e.setData({
                        cover: "",
                        showvideo: !1
                    });
                }
            }
        });
    },
    chooseGift: function(t) {
        n.chooseGift(t, this);
    },
    specsTap: function(t) {
        n.specsTap(t, this);
    },
    emptyActive: function() {
        this.setData({
            active: "",
            slider: "out",
            tempname: "",
            specsTitle: ""
        });
    },
    buyNow: function(t) {
        n.buyNow(t, this);
    },
    getCart: function(t) {
        n.getCart(t, this);
    },
    select: function() {
        n.select(this);
    },
    inputNumber: function(t) {
        n.inputNumber(t, this);
    },
    number: function(t) {
        n.number(t, this);
    },
    onChange: function(t) {
        return s.onChange(this, t);
    },
    DiyFormHandler: function(t) {
        return s.DiyFormHandler(this, t);
    },
    selectArea: function(t) {
        return s.selectArea(this, t);
    },
    bindChange: function(t) {
        return s.bindChange(this, t);
    },
    onCancel: function(t) {
        return s.onCancel(this, t);
    },
    onConfirm: function(t) {
        return s.onConfirm(this, t);
    },
    getIndex: function(t, a) {
        return s.getIndex(t, a);
    },
    changevoice: function() {
        this.data.sound ? this.setData({
            sound: !1,
            soundpic: !0
        }) : this.setData({
            sound: !0,
            soundpic: !1
        });
    },
    phone: function() {
        var t = this.data.phonenumber + "";
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    cancelclick: function() {
        this.setData({
            modelShow: !1
        });
    },
    confirmclick: function() {
        this.setData({
            modelShow: !1
        }), wx.openSetting({
            success: function(t) {}
        });
    },
    navigate: function(t) {
        var a = t.currentTarget.dataset.url, e = t.currentTarget.dataset.phone, i = t.currentTarget.dataset.appid, s = t.currentTarget.dataset.appurl;
        a && wx.navigateTo({
            url: a,
            fail: function() {
                wx.switchTab({
                    url: a
                });
            }
        }), e && wx.makePhoneCall({
            phoneNumber: e
        }), i && wx.navigateToMiniProgram({
            appId: i,
            path: s
        });
    },
    closecoupon: function() {
        this.setData({
            showcoupon: !1
        });
    },
    closecoupontips: function() {
        this.setData({
            showcoupontips: !1
        });
    },
    tabtopmenu: function(t) {
        var e = this, i = e.data.diypages, s = (i.items, t.currentTarget.dataset.id, t.currentTarget.dataset.url), n = t.currentTarget.dataset.type, r = e.data.topmenu, d = t.currentTarget.dataset.index;
        if (e.setData({
            topmenuindex: d
        }), "m0" == t.currentTarget.id && "" == s && a.get("diypage", {
            type: "home"
        }, function(t) {
            var a = t.diypage;
            o.each(a.items, function(t, a) {
                "topmenu" == a.id && (a.status = n);
            }), 0 == t.error && e.setData({
                diypages: t.diypage
            });
        }), "" != s && null != s) {
            if (1 == s.indexOf("pages")) {
                var u = s.lastIndexOf("="), c = s.substring(u + 1, s.length);
                a.get("diypage", {
                    id: c
                }, function(t) {
                    if (0 == t.error) {
                        var a = [];
                        for (var i in t.diypage.items) a.push(t.diypage.items[i]);
                        a.unshift(r);
                        var s = new Object();
                        for (var o in a) s[o] = a[o], "topmenu" == a[o].id && (a[o].status = n);
                        t.diypage.items = s, e.setData({
                            diypages: t.diypage,
                            topmenuDataType: ""
                        });
                    }
                });
            } else a.get("diypage/getInfo", {
                dataurl: s
            }, function(t) {
                e.data.topmenu;
                a.get("diypage", {
                    type: "home"
                }, function(a) {
                    var i = a.diypage;
                    o.each(i.items, function(a, e) {
                        if ("topmenu" == e.id) for (var i in e.status = n, e.data) i == n && (e.data[i].data = t.goods.list, 
                        t.goods.list.length <= 8 && (e.data[i].showmore = !0));
                    }), 0 == a.error && e.setData({
                        diypages: a.diypage,
                        topmenuDataType: t.type
                    });
                });
            });
            e.setData({
                diypages: i
            });
        }
    },
    tabwidget: function(t) {
        var e = this, i = e.data.diypages, s = (i.items, t.currentTarget.dataset.id), n = t.currentTarget.dataset.url, o = t.currentTarget.dataset.type;
        "" != n && null != n && a.get("diypage/getInfo", {
            dataurl: n
        }, function(t) {
            for (var a in i.items) if (a == s) {
                i.items[a].data[o].data = t.goods.list, i.items[a].data[o].type = t.type, i.items[a].type = t.type, 
                i.items[a].status = o, t.goods.list.length <= 8 && (i.items[a].data[o].showmore = !0);
                e.setData({
                    diypages: i
                });
            }
        });
    },
    getstoremore: function(t) {
        var e = this, i = t.currentTarget.dataset.id, s = e.data.diypages;
        o.each(s.items, function(t, n) {
            if (t == i) if (null == n.status || "" == n.status) {
                if (-1 != n.data[0].linkurl.indexOf("stores")) var o = "stores"; else o = "goods";
                var r = n.data[0].linkurl, d = n.data[0].data.length;
                a.get("diypage/getInfo", {
                    dataurl: r,
                    num: d,
                    paramsType: o
                }, function(t) {
                    n.data[0].data = t.goods.list, n.data[0].data.length == t.goods.count && (n.data[0].showmore = !0), 
                    e.setData({
                        diypages: s
                    });
                });
            } else {
                if (-1 != n.data[n.status].linkurl.indexOf("stores")) o = "stores"; else o = "goods";
                r = n.data[n.status].linkurl, d = n.data[n.status].data.length;
                a.get("diypage/getInfo", {
                    dataurl: r,
                    num: d,
                    paramsType: o
                }, function(t) {
                    n.data[n.status].data = t.goods.list, n.data[n.status].data.length == t.goods.count && (n.data[n.status].showmore = !0), 
                    e.setData({
                        diypages: s
                    });
                });
            }
        });
    },
    close: function() {
        t.globalData.flag = !0, wx.reLaunch({
            url: "../index/index"
        });
    },
    initSeckill: function(a) {
        var e = this, i = parseInt(a.status), s = a.starttime, n = a.endtime;
        if (-1 != i) {
            var o = 0, r = 0, d = t.globalData.approot;
            wx.request({
                url: d + "timer.php",
                success: function(t) {
                    var d = t.data;
                    o = 0 == i ? n - d : s - d, e.setData({
                        lasttime: o
                    }), clearInterval(e.data.timer), e.setTimer(a), r = e.setTimerInterval(a), e.setData({
                        timer: r
                    });
                }
            });
        }
    },
    setTimer: function(a) {
        var e = this, i = 0;
        if (-1 != a.status && parseInt(e.data.lasttime) % 10 == 0) {
            var s = t.globalData.approot;
            wx.request({
                url: s + "timer.php",
                success: function(t) {
                    var s = t.data;
                    i = 0 == a.status ? a.endtime - s : a.starttime - s, e.setData({
                        lasttime: i
                    });
                }
            });
        }
        i = parseInt(e.data.lasttime) - 1;
        var n = e.formatSeconds(i);
        e.setData({
            lasttime: i,
            hour: n.hour,
            min: n.min,
            sec: n.sec
        }), i <= 0 && e.onLoad();
    },
    setTimerInterval: function(t) {
        var a = this;
        return setInterval(function() {
            a.setTimer(t);
        }, 1e3);
    },
    formatSeconds: function(t) {
        var a = parseInt(t), e = 0, i = 0;
        return a > 60 && (e = parseInt(a / 60), a = parseInt(a % 60), e > 60 && (i = parseInt(e / 60), 
        e = parseInt(e % 60))), {
            hour: i < 10 ? "0" + i : i,
            min: e < 10 ? "0" + e : e,
            sec: a < 10 ? "0" + a : a
        };
    },
    cutGoods: function(t) {
        var a = t.currentTarget.dataset.type, e = t.currentTarget.dataset.num, i = t.currentTarget.dataset.id, s = this.data.diypages;
        for (var n in s.items) if (n == i) {
            var o = s.items[n].current || 0;
            "advance" == a ? o < e - 1 ? (s.items[n].current = o + 1, this.setData({
                diypages: s
            })) : (s.items[n].current = 0, this.setData({
                diypages: s
            })) : o > 0 ? (s.items[n].current = o - 1, this.setData({
                diypages: s
            })) : (s.items[n].current = e - 1, this.setData({
                diypages: s
            }));
        }
    }
});