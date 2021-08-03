var t = require("../../../@babel/runtime/helpers/interopRequireDefault")(require("../../../@babel/runtime/helpers/typeof")), e = getApp(), a = e.requirejs("core"), i = e.requirejs("foxui"), s = e.requirejs("biz/diyform"), r = e.requirejs("jquery"), d = e.requirejs("biz/selectdate");

Page({
    data: {
        icons: e.requirejs("icons"),
        list: {},
        goodslist: {},
        data: {
            dispatchtype: 0,
            remark: ""
        },
        areaDetail: {
            detail: {
                realname: "",
                mobile: "",
                areas: "",
                street: "",
                address: ""
            }
        },
        merchid: 0,
        showPicker: !1,
        pvalOld: [ 0, 0, 0 ],
        pval: [ 0, 0, 0 ],
        areas: [],
        street: [],
        streetIndex: 0,
        noArea: !1,
        showaddressview: !1,
        city_express_state: !1,
        onFocus: !1,
        isShowText: !0,
        remark: "50字以内（选填）",
        currentDate: "",
        dayList: "",
        currentDayList: "",
        currentObj: "",
        currentDay: "",
        cycelbuy_showdate: "",
        receipttime: "",
        scope: "",
        bargainid: "",
        selectcard: ""
    },
    onShowTextarea: function() {
        "50字以内（选填）" == this.data.remark && this.setData({
            remark: ""
        }), this.setData({
            isShowText: !1,
            onFacus: !0
        });
    },
    onShowText: function(t) {
        var e = t.detail.value;
        "" == e && (e = "50字以内（选填）"), this.setData({
            isShowText: !0,
            onFacus: !1,
            remark: e
        });
    },
    onLoad: function(t) {
        var d = this, c = [];
        if (t.goods) {
            var i = JSON.parse(t.goods);
            t.goods = i, this.setData({
                ispackage: !0
            });
        }
        d.setData({
            options: t
        }), d.setData({
            bargainid: t.bargainid
        }), e.url(t), a.get("order/create", d.data.options, function(t) {
            if (0 == t.error) {
                c = d.getGoodsList(t.goods);
                var i = (d.data.originalprice - t.goodsprice).toFixed(2);
                d.setData({
                    list: t,
                    goods: t,
                    show: !0,
                    address: !0,
                    card_info: t.card_info || {},
                    cardid: t.card_info.cardid || "",
                    cardname: t.card_info.cardname || "",
                    carddiscountprice: t.card_info.carddiscountprice,
                    goodslist: c,
                    merchid: t.merchid,
                    comboprice: i,
                    diyform: {
                        f_data: t.f_data,
                        fields: t.fields
                    },
                    city_express_state: t.city_express_state,
                    cycelbuy_showdate: t.selectDate,
                    receipttime: t.receipttime,
                    iscycel: t.iscycel,
                    scope: t.scope,
                    fromquick: t.fromquick,
                    hasinvoice: t.hasinvoice,
                    credittext: t.sysset.texts.credit
                }), e.setCache("goodsInfo", {
                    goodslist: c,
                    merchs: t.merchs
                }, 1800);
            } else a.toast(t.message, "loading"), setTimeout(function() {
                wx.navigateBack();
            }, 1e3);
            if ("" != t.fullbackgoods) {
                if (null == t.fullbackgoods) return;
                var r = t.fullbackgoods.fullbackratio, s = t.fullbackgoods.maxallfullbackallratio;
                r = Math.round(r), s = Math.round(s), d.setData({
                    fullbackratio: r,
                    maxallfullbackallratio: s
                });
            }
            1 == t.iscycelbuy && d.show_cycelbuydate();
        }), this.getQuickAddressDetail(), e.setCache("coupon", ""), setTimeout(function() {
            d.setData({
                areas: e.getCache("cacheset").areas
            });
        }, 3e3);
    },
    show_cycelbuydate: function() {
        var t = d.getCurrentDayString(this, this.data.cycelbuy_showdate);
        this.setData({
            currentObj: t,
            currentDate: t.getFullYear() + "." + (t.getMonth() + 1) + "." + t.getDate() + " " + [ "周日", "周一", "周二", "周三", "周四", "周五", "周六" ][t.getDay()],
            currentYear: t.getFullYear(),
            currentMonth: t.getMonth() + 1,
            currentDay: t.getDate(),
            initDate: Date.parse(t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate()),
            checkedDate: Date.parse(t.getFullYear() + "/" + (t.getMonth() + 1) + "/" + t.getDate()),
            maxday: this.data.scope
        });
    },
    onShow: function() {
        var i = this, s = e.getCache("orderAddress"), d = e.getCache("orderShop");
        e.getCache("isIpx") ? i.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar",
            paddingb: "padding-b"
        }) : i.setData({
            isIpx: !1,
            iphonexnavbar: "",
            paddingb: ""
        }), s && (this.setData({
            "list.address": s
        }), i.caculate(i.data.list)), d && this.setData({
            "list.carrierInfo": d,
            "list.storeInfo": d
        });
        var c = e.getCache("coupon");
        "object" == (0, t.default)(c) && 0 != c.id ? (this.setData({
            "data.couponid": c.id,
            "data.couponname": c.name
        }), a.post("order/create/getcouponprice", {
            couponid: c.id,
            goods: this.data.goodslist,
            goodsprice: this.data.list.goodsprice,
            discountprice: this.data.list.discountprice,
            isdiscountprice: this.data.list.isdiscountprice
        }, function(t) {
            0 == t.error ? (delete t.$goodsarr, i.setData({
                coupon: t
            }), i.caculate(i.data.list)) : a.alert(t.message);
        }, !0)) : (this.setData({
            "data.couponid": 0,
            "data.couponname": null,
            coupon: null
        }), r.isEmptyObject(i.data.list) || i.caculate(i.data.list));
    },
    getGoodsList: function(t) {
        var a = [];
        r.each(t, function(t, e) {
            r.each(e.goods, function(t, e) {
                a.push(e);
            });
        });
        for (var e = 0, i = 0; i < a.length; i++) e += a[i].price;
        return this.setData({
            originalprice: e
        }), a;
    },
    toggle: function(t) {
        var e = a.pdata(t), i = e.id, r = {};
        r[e.type] = 0 == i || void 0 === i ? 1 : 0, this.setData(r);
    },
    phone: function(t) {
        a.phone(t);
    },
    dispatchtype: function(t) {
        var e = a.data(t).type;
        this.setData({
            "data.dispatchtype": e
        }), this.caculate(this.data.list);
    },
    number: function(t) {
        var e = a.pdata(t), s = i.number(this, t), d = e.id, c = this.data.list, o = 0, n = 0;
        r.each(c.goods, function(a, t) {
            r.each(t.goods, function(t, e) {
                e.id == d && (c.goods[a].goods[t].total = s), o += parseInt(c.goods[a].goods[t].total), 
                n += parseFloat(o * c.goods[a].goods[t].price);
            });
        }), c.total = o, c.goodsprice = r.toFixed(n, 2), this.setData({
            list: c,
            goodslist: this.getGoodsList(c.goods)
        }), this.caculate(c);
    },
    caculate: function(e) {
        var i = this, t = 0;
        i.data.data && 0 != i.data.data.couponid && (t = i.data.data.couponid), a.post("order/create/caculate", {
            goods: this.data.goodslist,
            dflag: this.data.data.dispatchtype,
            addressid: this.data.list.address ? this.data.list.address.id : 0,
            packageid: this.data.list.packageid,
            bargain_id: this.data.bargainid,
            discountprice: this.data.list.discountprice,
            cardid: this.data.cardid,
            couponid: t
        }, function(t) {
            e.dispatch_price = t.price, e.enoughdeduct = t.deductenough_money, e.enoughmoney = t.deductenough_enough, 
            e.taskdiscountprice = t.taskdiscountprice, e.discountprice = t.discountprice, e.isdiscountprice = t.isdiscountprice, 
            e.seckill_price = t.seckill_price, e.deductcredit2 = t.deductcredit2, e.deductmoney = t.deductmoney, 
            e.deductcredit = t.deductcredit, e.gifts = t.gifts, i.data.data.deduct && (t.realprice -= t.deductmoney), 
            i.data.data.deduct2 && (t.realprice -= t.deductcredit2), i.data.coupon && void 0 !== i.data.coupon.deductprice && (i.setData({
                "coupon.deductprice": t.coupon_deductprice
            }), t.realprice -= t.coupon_deductprice), t.card_info && (e.card_free_dispatch = t.card_free_dispatch), 
            0 == i.data.goods.giftid && i.setData({
                "goods.gifts": t.gifts
            }), e.realprice <= 0 && (e.realprice = 1e-6), e.realprice = r.toFixed(t.realprice, 2), 
            "-0.00" == e.realprice && (e.realprice = 0), i.setData({
                list: e,
                cardid: t.card_info.cardid,
                cardname: t.card_info.cardname,
                goodsprice: t.card_info.goodsprice ? t.card_info.goodsprice : 0,
                carddiscountprice: t.card_info.carddiscountprice,
                city_express_state: t.city_express_state
            });
        }, !0);
    },
    submit: function() {
        var t = this.data, e = this, i = this.data.diyform, d = t.goods.giftid || t.giftid;
        if (0 == this.data.goods.giftid && 1 == this.data.goods.gifts.length && (d = this.data.goods.gifts[0].id), 
        !t.submit && s.verify(this, i)) {
            t.list.carrierInfo = t.list.carrierInfo || {};
            var c = {
                id: t.options.id ? t.options.id : 0,
                goods: t.goodslist,
                gdid: t.options.gdid,
                dispatchtype: t.data.dispatchtype,
                fromcart: t.list.fromcart,
                carrierid: 1 == t.data.dispatchtype && t.list.carrierInfo ? t.list.carrierInfo.id : 0,
                addressid: t.list.address ? t.list.address.id : 0,
                carriers: 1 == t.data.dispatchtype || t.list.isvirtual || t.list.isverify ? {
                    carrier_realname: t.list.member.realname,
                    carrier_mobile: t.list.member.mobile,
                    realname: t.list.carrierInfo.realname,
                    mobile: t.list.carrierInfo.mobile,
                    storename: t.list.carrierInfo.storename,
                    address: t.list.carrierInfo.address
                } : "",
                remark: t.data.remark,
                deduct: t.data.deduct,
                deduct2: t.data.deduct2,
                couponid: t.data.couponid,
                cardid: t.cardid,
                invoicename: t.list.invoicename,
                submit: !0,
                packageid: t.list.packageid,
                giftid: d,
                diydata: t.diyform.f_data,
                receipttime: t.receipttime,
                bargain_id: e.data.options.bargainid,
                fromquick: t.fromquick
            };
            if (t.list.storeInfo && (c.carrierid = t.list.storeInfo.id), 1 == t.data.dispatchtype || t.list.isvirtual || t.list.isverify) {
                if ("" == r.trim(t.list.member.realname) && "0" == t.list.set_realname) return void a.alert("请填写联系人!");
                if ("" == r.trim(t.list.member.mobile) && "0" == t.list.set_mobile) return void a.alert("请填写联系方式!");
                if ("0" == t.list.set_mobile && !/^[1][3-9]\d{9}$|^([6|9])\d{7}$|^[0][9]\d{8}$|^[6]([8|6])\d{5}$/.test(r.trim(t.list.member.mobile))) return void a.alert("请填写正确联系电话!");
                if (t.list.isforceverifystore && !t.list.storeInfo) return void a.alert("请选择门店!");
                c.addressid = 0;
            } else if (!c.addressid && !t.list.isonlyverifygoods) return void a.alert("地址没有选择!");
            e.setData({
                submit: !0
            }), console.log(c), a.post("order/create/submit", c, function(t) {
                e.setData({
                    submit: !1
                }), 0 == t.error ? wx.navigateTo({
                    url: "/pages/order/pay/index?id=" + t.orderid
                }) : a.alert(t.message);
            }, !0);
        }
    },
    dataChange: function(t) {
        var e = this.data.data, a = this.data.list;
        switch (t.target.id) {
          case "remark":
            e.remark = t.detail.value;
            break;

          case "deduct":
            if (e.deduct = t.detail.value, e.deduct2) return;
            var i = parseFloat(a.realprice);
            i += e.deduct ? -parseFloat(a.deductmoney) : parseFloat(a.deductmoney), a.realprice = i;
            break;

          case "deduct2":
            if (e.deduct2 = t.detail.value, e.deduct) return;
            i = parseFloat(a.realprice), i += e.deduct2 ? -parseFloat(a.deductcredit2) : parseFloat(a.deductcredit2), 
            a.realprice = i;
        }
        a.realprice <= 0 && (a.realprice = 1e-6), a.realprice = r.toFixed(a.realprice, 2), 
        this.setData({
            data: e,
            list: a
        });
    },
    listChange: function(t) {
        var e = this.data.list;
        switch (t.target.id) {
          case "invoicename":
            e.invoicename = t.detail.value;
            break;

          case "realname":
            e.member.realname = t.detail.value;
            break;

          case "mobile":
            e.member.mobile = t.detail.value;
        }
        this.setData({
            list: e
        });
    },
    url: function(t) {
        var e = a.pdata(t).url;
        wx.redirectTo({
            url: e
        });
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
        s.onConfirm(this, t);
        var e = this.data.pval, a = this.data.areas, i = this.data.areaDetail.detail;
        i.province = a[e[0]].name, i.city = a[e[0]].city[e[1]].name, i.datavalue = a[e[0]].code + " " + a[e[0]].city[e[1]].code, 
        a[e[0]].city[e[1]].area && 0 < a[e[0]].city[e[1]].area.length ? (i.area = a[e[0]].city[e[1]].area[e[2]].name, 
        i.datavalue += " " + a[e[0]].city[e[1]].area[e[2]].code, this.getStreet(a, e)) : i.area = "", 
        i.street = "", this.setData({
            "areaDetail.detail": i,
            streetIndex: 0,
            showPicker: !1
        });
    },
    getIndex: function(t, e) {
        return s.getIndex(t, e);
    },
    showaddressview: function(t) {
        var e;
        e = "open" == t.target.dataset.type, this.setData({
            showaddressview: e
        });
    },
    onChange2: function(t) {
        var e = this.data.areaDetail.detail, a = t.currentTarget.dataset.type, i = r.trim(t.detail.value);
        "street" == a && (e.streetdatavalue = this.data.street[i].code, i = this.data.street[i].name), 
        e[a] = i, this.setData({
            "areaDetail.detail": e
        });
    },
    getStreet: function(t, e) {
        if (t && e) {
            var r = this;
            if (r.data.areaDetail.detail.province && r.data.areaDetail.detail.city && this.data.openstreet) {
                var i = t[e[0]].city[e[1]].code, s = t[e[0]].city[e[1]].area[e[2]].code;
                a.get("getstreet", {
                    city: i,
                    area: s
                }, function(t) {
                    var e = t.street, a = {
                        street: e
                    };
                    if (e && r.data.areaDetail.detail.streetdatavalue) for (var i in e) if (e[i].code == r.data.areaDetail.detail.streetdatavalue) {
                        a.streetIndex = i, r.setData({
                            "areaDetail.detail.street": e[i].name
                        });
                        break;
                    }
                    r.setData(a);
                });
            }
        }
    },
    getQuickAddressDetail: function() {
        var s = this, t = s.data.id;
        a.get("member/address/get_detail", {
            id: t
        }, function(t) {
            var e = {
                openstreet: t.openstreet,
                show: !0
            };
            if (!r.isEmptyObject(t.detail)) {
                var a = t.detail.province + " " + t.detail.city + " " + t.detail.area, i = s.getIndex(a, s.data.areas);
                e.pval = i, e.pvalOld = i, e.areaDetail.detail = t.detail;
            }
            s.setData(e), t.openstreet && i && s.getStreet(s.data.areas, i);
        });
    },
    submitaddress: function() {
        var e = this, r = e.data.areaDetail.detail;
        e.data.posting || ("" != r.realname && r.realname ? "" != r.mobile && r.mobile ? "" != r.city && r.city ? !(0 < e.data.street.length) || "" != r.street && r.street ? "" != r.address && r.address ? r.datavalue ? (r.id = 0, 
        e.setData({
            posting: !0
        }), a.post("member/address/submit", r, function(t) {
            if (0 != t.error) return e.setData({
                posting: !1
            }), void i.toast(e, t.message);
            r.id = t.addressid, e.setData({
                showaddressview: !1,
                "list.address": r
            }), a.toast("保存成功");
        })) : i.toast(e, "地址数据出错，请重新选择") : i.toast(e, "请填写详细地址") : i.toast(e, "请选择所在街道") : i.toast(e, "请选择所在地区") : i.toast(e, "请填写联系电话") : i.toast(e, "请填写收件人"));
    },
    giftPicker: function() {
        this.setData({
            active: "active",
            gift: !0
        });
    },
    emptyActive: function() {
        this.setData({
            active: "",
            slider: "out",
            tempname: "",
            showcoupon: !1,
            gift: !1
        });
    },
    radioChange: function(t) {
        this.setData({
            giftid: t.currentTarget.dataset.giftgoodsid,
            gift_title: t.currentTarget.dataset.title
        });
    },
    sendclick: function() {
        wx.navigateTo({
            url: "/pages/map/index"
        });
    },
    clearform: function() {
        var a = this.data.diyform, i = {};
        r.each(a, function(t, e) {
            r.each(e, function(t, e) {
                5 == e.data_type && (a.f_data[e.diy_type].count = 0, a.f_data[e.diy_type].images = [], 
                i[e.diy_type] = a.f_data[e.diy_type]);
            });
        }), a.f_data = i, this.setData({
            diyform: a
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
            cycledate: !0,
            create: !0
        });
    },
    doDay: function(t) {
        d.doDay(t, this);
    },
    selectDay: function(t) {
        d.selectDay(t, this), d.setSchedule(this);
    },
    showinvoicepicker: function() {
        var t = this.data.list;
        0 == t.invoice_type && (t.invoice_info.entity = !0), 1 == t.invoice_type && (t.invoice_info.entity = !1), 
        this.setData({
            invoicepicker: !0,
            list: t
        });
    },
    noinvoicepicker: function() {
        this.setData({
            invoicepicker: !1
        });
    },
    clearinvoice: function() {
        var t = this.data.list;
        t.invoicename = "", this.setData({
            invoicepicker: !1,
            list: t
        });
    },
    chaninvoice: function(t) {
        var e = this.data.list;
        "0" == t.currentTarget.dataset.type ? e.invoice_info.entity = !1 : e.invoice_info.entity = !0, 
        this.setData({
            list: e
        });
    },
    changeType: function(t) {
        var e = this.data.list;
        "0" == t.currentTarget.dataset.type ? e.invoice_info.company = !1 : e.invoice_info.company = !0, 
        this.setData({
            list: e
        });
    },
    invoicetitle: function(t) {
        var e = this.data.list;
        e.invoice_info.title = t.detail.value.replace(/\s+/g, ""), this.setData({
            list: e
        });
    },
    invoicenumber: function(t) {
        var e = this.data.list;
        e.invoice_info.number = t.detail.value.replace(/\s+/g, ""), this.setData({
            list: e
        });
    },
    confirminvoice: function() {
        var t = this.data.list;
        t.invoice_info.company || this.setData({
            invoicenumber: ""
        });
        var e = t.invoice_info.entity ? "[纸质] " : "[电子] ", a = t.invoice_info.title + " ", r = t.invoice_info.company ? "（单位: " + t.invoice_info.number + "）" : "（个人）";
        t.invoicename = e + a + r, t.invoice_info.title ? t.invoice_info.company && !t.invoice_info.number ? i.toast(this, "请填写税号") : this.setData({
            list: t,
            invoicepicker: !1
        }) : i.toast(this, "请填写发票抬头");
    },
    selectCard: function() {
        this.setData({
            selectcard: "in"
        });
    },
    cancalCard: function() {
        this.setData({
            cardid: ""
        });
    },
    changecard: function(t) {
        var d = this;
        d.data.card_info, d.setData({
            selectcard: "",
            cardid: t.currentTarget.dataset.id
        });
        var c = t.currentTarget.dataset.id, e = {
            cardid: c,
            goodsprice: this.data.list.goodsprice,
            dispatch_price: this.data.list.dispatch_price,
            discountprice: this.data.list.discountprice,
            goodslist: this.data.list.goods
        };
        a.post("order/create/getcardprice", e, function(t) {
            if ("" != c) if (0 == t.error) {
                var e = {
                    carddiscount_rate: t.carddiscount_rate,
                    carddiscountprice: t.carddiscountprice,
                    cardid: t.cardid,
                    cardname: t.name,
                    dispatch_price: t.dispatch_price,
                    totalprice: t.totalprice,
                    comboprice: 0
                };
                d.setData(e), d.caculate(d.data.list);
            } else a.alert(t.message); else {
                var i = {
                    cardid: "",
                    selectcard: "",
                    cardname: "",
                    carddiscountprice: 0,
                    ispackage: !1
                }, s = (d.data.originalprice - d.data.list.goodsprice).toFixed(2);
                d.data.options.goods && (i.ispackage = !0, i.comboprice = s), d.setData(i), r.isEmptyObject(d.data.list) || d.caculate(d.data.list);
            }
        }, !0);
    },
    closeCardModal: function() {
        this.setData({
            selectcard: ""
        });
    }
});