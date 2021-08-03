var t = getApp(), a = t.requirejs("core"), e = t.requirejs("wxParse/wxParse"), i = t.requirejs("biz/diypage"), s = t.requirejs("biz/diyform"), n = t.requirejs("biz/goodspicker"), o = (t.requirejs("foxui"), 
t.requirejs("jquery"));

Page({
    data: {
        imgUrls: [ "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1509963648306&di=1194f5980cccf9e5ad558dfb18e895ab&imgtype=0&src=http%3A%2F%2Fd.hiphotos.baidu.com%2Fzhidao%2Fpic%2Fitem%2F9c16fdfaaf51f3de87bbdad39ceef01f3a29797f.jpg", "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1509963737453&di=b1472a710a2c9ba30808fd6823b16feb&imgtype=0&src=http%3A%2F%2Fwww.qqzhi.com%2Fwenwen%2Fuploads%2Fpic.wenwen.soso.com%2Fp%2F20160830%2F20160830220016-586751007.jpg", "https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=3004162400,3684436606&fm=11&gp=0.jpg" ],
        indicatorDotss: !0,
        autoplays: !0,
        intervals: 2e3,
        durations: 500,
        circulars: !0,
        adveradmin: !0,
        clock: "",
        diypage: "true",
        route: "custom",
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
        soundpic: !0,
        modelShow: !1,
        limits: !0,
        result: {},
        audios: {},
        audiosObj: {},
        picture: {},
        result: {},
        pageid: 0
    },
    onShow: function() {
        var t = this, e = wx.getSystemInfoSync(), i = t.data.pageid;
        a.get("diypage&id=" + i, {}, function(a) {
            var e = {
                loading: !1,
                diypage: a.diypage
            };
            t.setData(e);
        }), t.setData({
            screenWidth: e.windowWidth
        });
    },
    onLoad: function(e) {
        e = e || {};
        var s = this;
        s.pauseOther();
        var n = e.pageid;
        if (null == n) {
            var o = getCurrentPages(), d = o[o.length - 1].route.split("/");
            n = d[d.length - 1];
        }
        s.setData({
            pageid: n,
            imgUrl: t.globalData.approot
        });
        var r = decodeURIComponent(e.scene);
        if (!e.id && r) {
            var u = a.str2Obj(r);
            e.id = u.id, u.mid && (e.mid = u.mid);
        }
        setTimeout(function() {
            s.setData({
                areas: t.getCache("cacheset").areas
            });
        }, 3e3), t.url(e), i.get(this, n, function(a) {
            if (null != s.data.startadv && "" != s.data.startadv) {
                0 != s.data.startadv.status && "" != s.data.startadv || wx.getSetting({
                    success: function(t) {
                        t.authSetting["scope.userInfo"];
                    }
                });
                var e = s.data.startadv.params;
                if ("default" == e.style) {
                    var i = e.autoclose;
                    !function t(a) {
                        s.setData({
                            clock: i
                        }), i <= 0 ? s.setData({
                            adveradmin: !1
                        }) : setTimeout(function() {
                            i -= 1, t(a);
                        }, 1e3);
                    }(s);
                }
                if (1 == e.showtype) {
                    var n = 1e3 * e.showtime * 60, o = t.getCache("startadvtime"), d = +new Date(), r = !0;
                    s.setData({
                        adveradmin: !0
                    }), o && d - o < n && (r = !1), s.setData({
                        adveradmin: r
                    }), r && t.setCache("startadvtime", d);
                }
                s.data.startadv.status;
            }
        }), s.setData({
            cover: !0,
            showvideo: !1
        }), wx.getSystemInfo({
            success: function(t) {
                var a = t.windowWidth / 1.7;
                s.setData({
                    swiperheight: a
                });
            }
        });
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
            url: a
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
            fail: function(t) {
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
    onReady: function(t) {},
    pauseOther: function(t) {
        var a = this;
        o.each(this.data.audiosObj, function(e, i) {
            if (e != t) {
                i.pause();
                var s = a.data.audios;
                s[e] && (s[e].status = !1, a.setData({
                    audios: s
                }));
            }
        });
    },
    play: function(t) {
        var a = t.target.dataset.id, e = this.data.audiosObj[a] || !1;
        if (!e) {
            e = wx.createInnerAudioContext("audio_" + a);
            var i = this.data.audiosObj;
            i[a] = e, this.setData({
                audiosObj: i
            });
        }
        var s = this;
        e.onPlay(function() {
            var t = setInterval(function() {
                var i = e.currentTime / e.duration * 100 + "%", n = Math.floor(Math.ceil(e.currentTime) / 60), o = (Math.ceil(e.currentTime) % 60 / 100).toFixed(2).slice(-2), d = Math.ceil(e.currentTime);
                n < 10 && (n = "0" + n);
                var r = n + ":" + o, u = s.data.audios;
                u[a].audiowidth = i, u[a].Time = t, u[a].audiotime = r, u[a].seconds = d, s.setData({
                    audios: u
                });
            }, 1e3);
        });
        var n = t.currentTarget.dataset.audio, o = t.currentTarget.dataset.time, d = t.currentTarget.dataset.pausestop, r = t.currentTarget.dataset.loopplay;
        0 == r && e.onEnded(function(t) {
            u[a].status = !1, s.setData({
                audios: u
            });
        });
        var u = s.data.audios;
        u[a] || (u[a] = {}), e.paused && 0 == o ? (e.src = n, e.play(), 1 == r && (e.loop = !0), 
        u[a].status = !0, s.pauseOther(a)) : e.paused && o > 0 ? (e.play(), 0 == d ? e.seek(o) : e.seek(0), 
        u[a].status = !0, s.pauseOther(a)) : (e.pause(), u[a].status = !1), s.setData({
            audios: u
        });
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
    onHide: function() {
        this.pauseOther();
    },
    onUnload: function() {
        this.pauseOther();
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return {
            title: this.data.diypages.page.title
        };
    },
    tabtopmenu: function(t) {
        var e = this, i = e.data.diypages, s = (i.items, t.currentTarget.dataset.id, t.currentTarget.dataset.url), n = t.currentTarget.dataset.type, d = e.data.topmenu, r = t.currentTarget.dataset.index;
        if (c = e.data.pageid, e.setData({
            topmenuindex: r
        }), "" != s && null != s) {
            if (1 == s.indexOf("pages")) {
                var u = s.lastIndexOf("="), c = s.substring(u + 1, s.length);
                a.get("diypage", {
                    id: c
                }, function(t) {
                    if (0 == t.error) {
                        var a = [];
                        for (var i in t.diypage.items) a.push(t.diypage.items[i]);
                        a.unshift(d);
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
                    type: c
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
            for (var a in i.items) a == s && (i.items[a].data[o].data = t.goods.list, i.items[a].data[o].type = t.type, 
            i.items[a].type = t.type, i.items[a].status = o, t.goods.list.length <= 8 && (i.items[a].data[o].showmore = !0), 
            e.setData({
                diypages: i
            }));
        });
    },
    getstoremore: function(t) {
        var e = this, i = t.currentTarget.dataset.id, s = e.data.diypages;
        o.each(s.items, function(t, n) {
            if (t == i) if (null == n.status || "" == n.status) {
                if (-1 != n.data[0].linkurl.indexOf("stores")) var o = "stores"; else o = "goods";
                var d = n.data[0].linkurl, r = n.data[0].data.length;
                a.get("diypage/getInfo", {
                    dataurl: d,
                    num: r,
                    paramsType: o
                }, function(t) {
                    n.data[0].data = t.goods.list, n.data[0].data.length == t.goods.count && (n.data[0].showmore = !0), 
                    e.setData({
                        diypages: s
                    });
                });
            } else {
                if (-1 != n.data[n.status].linkurl.indexOf("stores")) o = "stores"; else o = "goods";
                d = n.data[n.status].linkurl, r = n.data[n.status].data.length;
                a.get("diypage/getInfo", {
                    dataurl: d,
                    num: r,
                    paramsType: o
                }, function(t) {
                    n.data[n.status].data = t.goods.list, n.data[n.status].data.length == t.goods.count && (n.data[n.status].showmore = !0), 
                    e.setData({
                        diypages: s
                    });
                });
            }
        });
    }
});