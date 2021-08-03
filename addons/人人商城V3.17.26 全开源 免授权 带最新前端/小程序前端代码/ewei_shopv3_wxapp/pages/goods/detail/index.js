var t = getApp(), e = t.requirejs("core"), a = (t.requirejs("icons"), t.requirejs("foxui")), o = t.requirejs("biz/diypage"), i = t.requirejs("biz/diyform"), s = t.requirejs("biz/goodspicker"), n = t.requirejs("jquery"), r = t.requirejs("wxParse/wxParse"), c = 0, d = t.requirejs("biz/selectdate");

Page({
    data: {
        diypages: {},
        usediypage: !1,
        specs: [],
        options: [],
        icons: t.requirejs("icons"),
        goods: {},
        indicatorDots: !0,
        autoplay: !0,
        interval: 5e3,
        duration: 500,
        circular: !0,
        play: "/static/images/video_play.png",
        mute: "/static/images/icon/mute.png",
        voice: "/static/images/icon/voice.png",
        active: "",
        slider: "",
        tempname: "",
        info: "active",
        preselltimeend: "",
        presellsendstatrttime: "",
        advWidth: 0,
        dispatchpriceObj: 0,
        now: parseInt(Date.now() / 1e3),
        day: 0,
        hour: 0,
        minute: 0,
        second: 0,
        timer: 0,
        discountTitle: "",
        istime: 1,
        istimeTitle: "",
        isSelected: !1,
        params: {},
        total: 1,
        optionid: 0,
        audios: {},
        audiosObj: {},
        defaults: {
            id: 0,
            merchid: 0
        },
        buyType: "",
        pickerOption: {},
        specsData: [],
        specsTitle: "",
        canBuy: "",
        diyform: {},
        showPicker: !1,
        showcoupon: !1,
        pvalOld: [ 0, 0, 0 ],
        pval: [ 0, 0, 0 ],
        areas: [],
        noArea: !0,
        commentObj: {},
        commentObjTab: 1,
        loading: !1,
        commentEmpty: !1,
        commentPage: 1,
        commentTotal: 1,
        commentLevel: "all",
        commentList: [],
        closeBtn: !1,
        soundpic: !0,
        animationData: {},
        uid: "",
        stararr: [ "all", "good", "normal", "bad", "pic" ],
        nav_mask: !1,
        nav_mask2: !1,
        nav: 0,
        giftid: "",
        limits: !0,
        modelShow: !1,
        showgoods: !0,
        timer: 0,
        lasttime: 0,
        hour: "-",
        min: "-",
        sec: "-",
        currentDate: "",
        dayList: "",
        currentDayList: "",
        currentObj: "",
        currentDay: "",
        checkedDate: "",
        showDate: "",
        scope: "",
        goods_hint_show: !1,
        presellisstart: 0,
        advHeight: 1,
        show_goods: !0,
        goodscircle: {
            can_share_goodscircle: !1
        }
    },
    imageLoad: function(t) {
        var e = t.detail.height, a = t.detail.width, o = Math.floor(750 * e / a);
        e == a ? this.setData({
            advHeight: 750
        }) : this.setData({
            advHeight: o
        });
    },
    favorite: function(a) {
        t.checkAuth();
        var o = this;
        if (o.data.limits) {
            var i = a.currentTarget.dataset.isfavorite ? 0 : 1;
            e.get("member/favorite/toggle", {
                id: o.data.options.id,
                isfavorite: i
            }, function(t) {
                t.isfavorite ? o.setData({
                    "goods.isfavorite": 1
                }) : o.setData({
                    "goods.isfavorite": 0
                });
            });
        }
    },
    goodsTab: function(t) {
        var a = this, o = t.currentTarget.dataset.tap;
        if ("info" == o) this.setData({
            info: "active",
            para: "",
            comment: ""
        }); else if ("para" == o) this.setData({
            info: "",
            para: "active",
            comment: ""
        }); else if ("comment" == o) {
            if (a.setData({
                info: "",
                para: "",
                comment: "active"
            }), a.data.commentList.length > 0) return void a.setData({
                loading: !1
            });
            a.setData({
                loading: !0
            }), e.get("goods/get_comment_list", {
                id: a.data.options.id,
                level: a.data.commentLevel,
                page: a.data.commentPage
            }, function(t) {
                t.list.length > 0 ? a.setData({
                    loading: !1,
                    commentList: t.list,
                    commentTotal: t.total,
                    commentPage: t.page
                }) : a.setData({
                    loading: !1,
                    commentEmpty: !0
                });
            });
        }
    },
    onReachBottom: function() {
        var t = this;
        if (t.data.commentTotal <= 10) return !1;
        var a = t.data.commentObjTab, o = "";
        1 == a ? o = "all" : 2 == a ? o = "good" : 3 == a ? o = "normal" : 4 == a ? o = "bad" : 5 == a && (o = "pic"), 
        t.setData({
            loading: !0
        }), e.get("goods/get_comment_list", {
            id: t.data.options.id,
            level: o,
            page: t.data.commentPage
        }, function(e) {
            0 == e.error && (t.setData({
                loading: !1
            }), e.list.length > 0 && t.setData({
                commentPage: t.data.commentPage + 1,
                commentTotal: e.total,
                commentList: t.data.commentList.concat(e.list)
            }));
        });
    },
    comentTap: function(t) {
        var a = this, o = t.currentTarget.dataset.type, i = "";
        1 == o ? (i = "all", a.data.commentPage = 1) : 2 == o ? (a.data.commentPage = 1, 
        i = "good") : 3 == o ? (a.data.commentPage = 1, i = "normal") : 4 == o ? (a.data.commentPage = 1, 
        i = "bad") : 5 == o && (a.data.commentPage = 1, i = "pic"), o != a.data.commentObjTab && e.get("goods/get_comment_list", {
            id: a.data.options.id,
            level: i,
            page: a.data.commentPage
        }, function(t) {
            t.list.length > 0 && a.setData({
                loading: !1,
                commentList: t.list,
                commentTotal: t.total,
                commentPage: t.page,
                commentObjTab: o,
                commentEmpty: !1
            });
        });
    },
    preview: function(t) {
        wx.previewImage({
            current: t.currentTarget.dataset.src,
            urls: t.currentTarget.dataset.urls
        });
    },
    getDetail: function(t) {
        var o = this, i = parseInt(Date.now() / 1e3);
        o.setData({
            loading: !0
        }), e.get("goods/get_detail", {
            id: t.id
        }, function(t) {
            if (0 != t.error) return o.setData({
                show: !0,
                showgoods: !1
            }), a.toast(o, t.message), void setTimeout(function() {
                wx.navigateBack();
            }, 1500);
            [ "marketprice", "productprice" ].forEach(function(e) {
                void 0 !== t.goods[e] && (t.goods[e] = parseFloat(t.goods[e]));
            });
            var s = t.goods.coupons, d = t.goods.thumbMaxHeight, l = (t.goods.thumbMaxWidth, 
            t.goods.goodscircle);
            if (o.setData({
                coupon: s,
                coupon_l: s.length,
                packagegoods: t.goods.packagegoods,
                packagegoodsid: t.goods.packagegoods.goodsid || 0,
                credittext: t.goods.credittext,
                activity: t.goods.activity,
                bottomFixedImageUrls: t.goods.bottomFixedImageUrls,
                phonenumber: t.goods.phonenumber || "",
                showDate: t.goods.showDate || "",
                scope: t.goods.scope || "",
                show_goods: t.goods.show_goods,
                goodscircle: l
            }), t.goods.packagegoods && o.package(), r.wxParse("wxParseData", "html", t.goods.content, o, "0"), 
            r.wxParse("wxParseData_buycontent", "html", t.goods.buycontent, o, "0"), o.setData({
                show: !0,
                goods: t.goods,
                minprice: t.goods.minprice,
                maxprice: t.goods.maxprice,
                preselltimeend: t.goods.preselltimeend,
                style: t.goods.labelstyle.style || "",
                navbar: t.goods.navbar,
                labels: t.goods.labels
            }), t.goods.gifts && 1 == t.goods.gifts.length && o.setData({
                giftid: t.goods.gifts[0].id
            }), wx.setNavigationBarTitle({
                title: t.goods.title || "商品详情"
            }), c = t.goods.hasoption, n.isEmptyObject(t.goods.dispatchprice) || "string" == typeof t.goods.dispatchprice ? o.setData({
                dispatchpriceObj: 0
            }) : o.setData({
                dispatchpriceObj: 1
            }), t.goods.isdiscount > 0 && t.goods.isdiscount_time >= i) {
                clearInterval(o.data.timer);
                var u = setInterval(function() {
                    o.countDown(0, t.goods.isdiscount_time);
                }, 1e3);
                o.setData({
                    timer: u
                });
            } else o.setData({
                discountTitle: "活动已结束"
            });
            if (t.goods.istime > 0) {
                clearInterval(o.data.timer);
                u = setInterval(function() {
                    o.countDown(t.goods.timestart, t.goods.timeend, "istime");
                }, 1e3);
                o.setData({
                    timer: u
                });
            }
            if (t.goods.ispresell > 0) {
                u = setInterval(function() {
                    0 == t.goods.canbuy ? o.countDown(i, t.goods.preselltimestart, "istime") : 1 == t.goods.canbuy && o.countDown(i, t.goods.preselltimeend, "istime");
                }, 1e3);
                o.setData({
                    timer: u,
                    presellisstart: t.goods.presellisstart
                }), o.setData({
                    preselltimeend: t.goods.preselltimeend || t.goods.preselltimeend.getMonth() + "月" + t.goods.preselltimeend || t.goods.preselltimeend.getDate() + "日 " + t.goods.preselltimeend || t.goods.preselltimeend.getHours() + ":" + t.goods.preselltimeend || t.goods.preselltimeend.getMinutes() + ":" + t.goods.preselltimeend || t.goods.preselltimeend.getSeconds(),
                    presellsendstatrttime: t.goods.presellsendstatrttime || t.goods.presellsendstatrttime.getMonth() + "月" + t.goods.presellsendstatrttime || t.goods.presellsendstatrttime.getDate() + "日"
                });
            }
            t.goods.getComments > 0 && e.get("goods/get_comments", {
                id: o.data.options.id
            }, function(t) {
                o.setData({
                    commentObj: t
                });
            }), t.goods.fullbackgoods && o.setData({
                fullbackgoods: t.goods.fullbackgoods
            });
            var g = o.data.fullbackgoods;
            if (null != g) {
                var m = g.maxfullbackratio, h = g.maxallfullbackallratio;
                m = Math.round(m), h = Math.round(h);
                o.setData({
                    maxfullbackratio: m,
                    maxallfullbackallratio: h
                });
            }
            9 == t.goods.type && (o.setData({
                checkedDate: t.goods.nowDate
            }), o.show_cycelbuydate()), t.goods.seckillinfo && o.initSeckill(t.goods);
        });
    },
    initSeckill: function(e) {
        var a = this, o = parseInt(e.seckillinfo.status), i = e.seckillinfo.starttime, s = e.seckillinfo.endtime;
        if (-1 != o) {
            var n = 0, r = 0, c = t.globalData.approot;
            wx.request({
                url: c + "map.json",
                success: function(t) {
                    var c = new Date(t.header.Date) / 1e3;
                    n = 0 == o ? s - c : i - c, a.setData({
                        lasttime: n
                    }), clearInterval(a.data.timer), a.setTimer(e.seckillinfo), r = a.setTimerInterval(e.seckillinfo), 
                    a.setData({
                        timer: r
                    });
                }
            });
        }
    },
    setTimer: function(e) {
        var a = this, o = 0;
        if (-1 != e.status && parseInt(a.data.lasttime) % 10 == 0) {
            var i = parseInt(e.status), s = e.starttime, n = e.endtime;
            if (-1 != i) {
                var r = t.globalData.approot;
                wx.request({
                    url: r + "map.json",
                    success: function(t) {
                        var e = new Date(t.header.Date) / 1e3;
                        o = 0 == i ? n - e : s - e, a.setData({
                            lasttime: o
                        });
                    }
                });
            }
        }
        o = parseInt(a.data.lasttime) - 1;
        var c = a.formatSeconds(o);
        a.setData({
            lasttime: o,
            hour: c.hour,
            min: c.min,
            sec: c.sec
        }), o <= 0 && a.onLoad();
    },
    setTimerInterval: function(t) {
        var e = this;
        return setInterval(function() {
            e.setTimer(t);
        }, 1e3);
    },
    formatSeconds: function(t) {
        var e = parseInt(t), a = 0, o = 0;
        return e > 60 && (a = parseInt(e / 60), e = parseInt(e % 60), a > 60 && (o = parseInt(a / 60), 
        a = parseInt(a % 60))), {
            hour: o < 10 ? "0" + o : o,
            min: a < 10 ? "0" + a : a,
            sec: e < 10 ? "0" + e : e
        };
    },
    countDown: function(t, e, a) {
        var o = parseInt(Date.now() / 1e3), i = parseInt((t > o ? t : e) - o), s = Math.floor(i / 86400), n = Math.floor((i - 24 * s * 60 * 60) / 3600), r = Math.floor((i - 24 * s * 60 * 60 - 3600 * n) / 60), c = [ s, n, r, Math.floor(i - 24 * s * 60 * 60 - 3600 * n - 60 * r) ];
        if (this.setData({
            time: c
        }), "istime") {
            var d = "";
            t > o ? d = "距离限时购开始" : t <= o && e > o ? d = "距离限时购结束" : (d = "活动已经结束，下次早点来~", 
            this.setData({
                istime: 0
            })), this.setData({
                istimeTitle: d
            });
        }
    },
    cityPicker: function(t) {
        t.currentTarget.dataset.tap;
        wx.navigateTo({
            url: "/pages/goods/region/index?id=" + this.data.goods.id + "&region=" + this.data.goods.citys.citys + "&onlysent=" + this.data.goods.citys.onlysent
        });
    },
    giftPicker: function() {
        this.setData({
            active: "active",
            gift: !0
        });
    },
    couponPicker: function() {
        this.setData({
            active: "active",
            showcoupon: !0
        });
    },
    couponrecived: function(t) {
        var o = t.currentTarget.dataset.id, i = this;
        e.post("goods.pay_coupon", {
            id: o
        }, function(t) {
            0 == t.error ? (i.setData({
                showcoupon: !1,
                active: ""
            }), a.toast(i, "已领取")) : a.toast(i, t.message);
        });
    },
    selectPicker: function(e) {
        t.checkAuth();
        var a = e.currentTarget.dataset.time, o = e.currentTarget.dataset.timeout;
        if (this.data.limits) {
            if ("timeout" == a || "access_time" == a) {
                if ("false" == o) return void this.setData({
                    goods_hint_show: !0
                });
                if ("true" == o) {
                    if ("access_time" == a) {
                        this.setData({
                            goods_hint_show: !1
                        });
                        var i = "goodsdetail";
                        return void s.selectpicker(e, this, i);
                    }
                    if ("timeout" == a) return void this.setData({
                        goods_hint_show: !1
                    });
                }
            }
            i = "goodsdetail";
            s.selectpicker(e, this, i);
        }
    },
    specsTap: function(t) {
        s.specsTap(t, this);
    },
    emptyActive: function() {
        this.setData({
            active: "",
            slider: "out",
            tempname: "",
            showcoupon: !1,
            gift: !1,
            cycledate: !1
        });
    },
    buyNow: function(t) {
        s.buyNow(t, this, "goods_detail");
    },
    getCart: function(t) {
        s.getCart(t, this);
    },
    select: function() {
        var t = this.data.optionid;
        this.data.diyform;
        c > 0 && 0 == t ? a.toast(this, "请选择规格") : this.setData({
            active: "",
            slider: "out",
            isSelected: !0,
            tempname: ""
        });
    },
    inputNumber: function(t) {
        s.inputNumber(t, this);
    },
    number: function(t) {
        s.number(t, this);
    },
    onLoad: function(a) {
        t.checkAuth();
        var i = this;
        i.setData({
            imgUrl: t.globalData.approot
        }), e.get("black", {}, function(t) {
            t.isblack && wx.showModal({
                title: "无法访问",
                content: "您在商城的黑名单中，无权访问！",
                success: function(t) {
                    t.confirm && this.close(), t.cancel && this.close();
                }
            });
        }), o.get(this, "goodsdetail", function(t) {
            var e = t.diypage.items;
            for (var a in e) "copyright" == e[a].id && i.setData({
                copyright: e[a]
            });
        }), a = a || {};
        var s = decodeURIComponent(a.scene);
        if (!a.id && s) {
            var n = e.str2Obj(s);
            a.id = n.id, n.mid && (a.mid = n.mid);
        }
        this.setData({
            id: a.id
        }), t.url(a), wx.getSystemInfo({
            success: function(t) {
                i.setData({
                    windowWidth: t.windowWidth,
                    windowHeight: t.windowHeight
                });
            }
        }), i.getDetail(a), i.setData({
            uid: a.id,
            options: a,
            success: !0,
            cover: !0,
            showvideo: !0
        }), wx.getSystemInfo({
            success: function(t) {
                i.setData({
                    advWidth: t.windowWidth
                });
            }
        }), setTimeout(function() {
            i.setData({
                areas: t.getCache("cacheset").areas
            });
        }, 3e3);
    },
    show_cycelbuydate: function() {
        var t = d.getCurrentDayString(this, this.data.showDate);
        this.setData({
            currentObj: t,
            currentDate: t.getFullYear() + "年" + (t.getMonth() + 1) + "月" + t.getDate() + "日 " + [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ][t.getDay()],
            currentYear: t.getFullYear(),
            currentMonth: t.getMonth() + 1,
            currentDay: t.getDate(),
            initDate: Date.parse(t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate()),
            checkedDate: Date.parse(t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate()),
            maxday: this.data.scope
        });
    },
    package: function() {
        var t = this;
        e.get("package.get_list", {
            goodsid: this.data.packagegoodsid
        }, function(e) {
            t.setData({
                packageList: e.list[0]
            });
        });
    },
    onShow: function() {
        this.setData({
            isgoods: t.globalData.isgoods
        });
        var e = this;
        t.getCache("isIpx") ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), wx.getStorage({
            key: "mydata",
            success: function(t) {
                wx.removeStorage({
                    key: "mydata",
                    success: function(t) {}
                }), e.getDetail(t.data), wx.pageScrollTo({
                    scrollTop: 0
                });
            }
        }), wx.getSetting({
            success: function(t) {
                var a = t.authSetting["scope.userInfo"];
                e.setData({
                    limits: a
                });
            }
        });
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
    getIndex: function(t, e) {
        return i.getIndex(t, e);
    },
    onShareAppMessage: function() {
        return this.setData({
            closeBtn: !1
        }), e.onShareAppMessage("/pages/goods/detail/index?id=" + this.data.options.id, this.data.goods.title);
    },
    showpic: function() {
        this.setData({
            showpic: !0,
            cover: !1,
            showvideo: !1
        }), this.videoContext = wx.createVideoContext("myVideo"), this.videoContext.pause();
    },
    showvideo: function() {
        this.setData({
            showpic: !1,
            showvideo: !0
        }), this.videoContext = wx.createVideoContext("myVideo"), this.videoContext.play();
    },
    startplay: function() {
        this.setData({
            cover: !1
        }), this.videoContext = wx.createVideoContext("myVideo"), this.videoContext.play();
    },
    bindfullscreenchange: function(t) {
        1 == t.detail.fullScreen ? this.setData({
            success: !1
        }) : this.setData({
            success: !0
        });
    },
    phone: function() {
        var t = this.data.phonenumber + "";
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    sharePoster: function() {
        wx.navigateTo({
            url: "/pages/goods/poster/poster?id=" + this.data.uid
        });
    },
    closeBtn: function() {
        this.setData({
            closeBtn: !1
        });
    },
    onHide: function() {
        this.setData({
            closeBtn: !1
        });
    },
    showshade: function() {
        t.checkAuth(), this.setData({
            closeBtn: !0
        });
    },
    nav: function() {
        this.setData({
            nav_mask: !this.data.nav_mask
        });
    },
    nav2: function() {
        this.setData({
            nav_mask2: !this.data.nav_mask2
        });
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
    radioChange: function(t) {
        this.setData({
            giftid: t.currentTarget.dataset.giftgoodsid,
            gift_title: t.currentTarget.dataset.title
        });
    },
    activityPicker: function() {
        this.setData({
            fadein: "in"
        });
    },
    actOutPicker: function() {
        this.setData({
            fadein: ""
        });
    },
    hintclick: function() {
        wx.openSetting({
            success: function(t) {}
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
    sendclick: function() {
        wx.navigateTo({
            url: "/pages/map/index"
        });
    },
    syclecancle: function() {
        this.setData({
            cycledate: !1
        });
    },
    sycleconfirm: function() {
        this.setData({
            cycledate: !1
        });
    },
    editdate: function(t) {
        d.setSchedule(this), this.setData({
            cycledate: !0
        });
    },
    doDay: function(t) {
        d.doDay(t, this);
    },
    selectDay: function(t) {
        d.selectDay(t, this), d.setSchedule(this);
    },
    play: function(t) {
        var e = t.target.dataset.id, a = this.data.audiosObj[e] || !1;
        if (!a) {
            a = wx.createInnerAudioContext("audio_" + e);
            var o = this.data.audiosObj;
            o[e] = a, this.setData({
                audiosObj: o
            });
        }
        var i = this;
        a.onPlay(function() {
            var t = setInterval(function() {
                var o = a.currentTime / a.duration * 100 + "%", s = Math.floor(Math.ceil(a.currentTime) / 60), n = (Math.ceil(a.currentTime) % 60 / 100).toFixed(2).slice(-2), r = Math.ceil(a.currentTime);
                s < 10 && (s = "0" + s);
                var c = s + ":" + n, d = i.data.audios;
                d[e].audiowidth = o, d[e].Time = t, d[e].audiotime = c, d[e].seconds = r, i.setData({
                    audios: d
                });
            }, 1e3);
        });
        var s = t.currentTarget.dataset.audio, n = t.currentTarget.dataset.time, r = t.currentTarget.dataset.pausestop, c = t.currentTarget.dataset.loopplay;
        0 == c && a.onEnded(function(t) {
            d[e].status = !1, i.setData({
                audios: d
            });
        });
        var d = i.data.audios;
        d[e] || (d[e] = {}), a.paused && 0 == n ? (a.src = s, a.play(), 1 == c && (a.loop = !0), 
        d[e].status = !0, i.pauseOther(e)) : a.paused && n > 0 ? (a.play(), 0 == r ? a.seek(n) : a.seek(0), 
        d[e].status = !0, i.pauseOther(e)) : (a.pause(), d[e].status = !1), i.setData({
            audios: d
        });
    },
    pauseOther: function(t) {
        var e = this;
        n.each(this.data.audiosObj, function(a, o) {
            if (a != t) {
                o.pause();
                var i = e.data.audios;
                i[a] && (i[a].status = !1, e.setData({
                    audios: i
                }));
            }
        });
    },
    onHide: function() {
        this.pauseOther();
    },
    onUnload: function() {
        this.pauseOther();
    },
    navigate: function(t) {
        var e = t.currentTarget.dataset.url, a = t.currentTarget.dataset.phone, o = t.currentTarget.dataset.appid, i = t.currentTarget.dataset.appurl;
        e && wx.navigateTo({
            url: e,
            fail: function() {
                wx.switchTab({
                    url: e
                });
            }
        }), a && wx.makePhoneCall({
            phoneNumber: a
        }), o && wx.navigateToMiniProgram({
            appId: o,
            path: i
        });
    },
    close: function() {
        t.globalData.flag = !0, wx.reLaunch({
            url: "../index/index"
        });
    },
    showtextarea: function(t) {
        var e = t.currentTarget.dataset.index;
        this.data.diyform.fields[e].texthide = !0, this.data.diyform.fields[e].textareashow = !0, 
        this.data.diyform.fields[e].black = "", this.setData({
            diyform: this.data.diyform
        });
    },
    bindTextAreaBlur: function(t) {
        var e = t.detail.value, a = t.currentTarget.dataset.index;
        this.data.diyform.fields[a].texthide = !1, this.data.diyform.fields[a].textareashow = !1, 
        this.data.diyform.fields[a].placeholder = e, this.data.diyform.fields[a].black = "color: #000", 
        this.setData({
            diyform: this.data.diyform
        });
    }
});